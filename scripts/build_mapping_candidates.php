<?php
/**
 * Usage:
 *   php scripts/build_mapping_candidates.php
 *
 * Inputs:
 *   - xml/import0_1.xml
 *   - csv/result.csv
 *
 * Outputs:
 *   - csv/mapping_candidates.csv
 *   - csv/unmatched_bitrix.csv
 *   - csv/unmatched_1c.csv
 */

declare(strict_types=1);

mb_internal_encoding('UTF-8');

$root = realpath(__DIR__ . '/..');
if ($root === false) {
    fwrite(STDERR, "Cannot resolve repo root.\n");
    exit(1);
}

$importXmlPath = $root . '/xml/import0_1.xml';
$bitrixCsvPath = $root . '/csv/result.csv';

$outMappingPath = $root . '/csv/mapping_candidates.csv';
$outUnmatchedBitrixPath = $root . '/csv/unmatched_bitrix.csv';
$outUnmatched1cPath = $root . '/csv/unmatched_1c.csv';

if (!file_exists($importXmlPath)) {
    fwrite(STDERR, "Missing file: $importXmlPath\n");
    exit(1);
}
if (!file_exists($bitrixCsvPath)) {
    fwrite(STDERR, "Missing file: $bitrixCsvPath\n");
    exit(1);
}

function stripBom(string $s): string {
    // UTF-8 BOM
    if (strncmp($s, "\xEF\xBB\xBF", 3) === 0) return substr($s, 3);
    // UTF-16 LE/BE BOM (we don't fully convert here; assume UTF-8 input)
    return $s;
}

function normalizeName(string $s): string {
    $s = trim($s);
    $s = strip_tags($s);
    $s = str_replace(["\xC2\xA0", " "], " ", $s); // nbsp variants
    $s = mb_strtoupper($s);

    // Replace common punctuation with spaces
    $s = preg_replace('/[(){}\[\],.;:"\'!?]+/u', ' ', $s) ?? $s;
    $s = preg_replace('/\s+/u', ' ', $s) ?? $s;

    // Remove size patterns like 30X90, 60X120, 30*60
    $s = preg_replace('/\b\d{2,3}\s*[XХ\*]\s*\d{2,3}\b/u', ' ', $s) ?? $s;

    // Remove pack info like "6 ШТ / 1.62 М²" etc
    $s = preg_replace('/\b\d+(\.\d+)?\s*(ШТ|ШТ\.|PCS)\b/u', ' ', $s) ?? $s;
    $s = preg_replace('/\b\d+(\.\d+)?\s*(М2|М²|M2|M²)\b/u', ' ', $s) ?? $s;
    $s = preg_replace('/\b(ШТ|ШТ\.|М2|М²|M2|M²|УП|УП\.|УПАК|УПАК\.)\b/u', ' ', $s) ?? $s;

    // Remove extra words often present in 1C names
    $drop = [
        'КЕРАМОГРАНИТ', 'ПЛИТКА', 'МАТОВАЯ', 'ГЛЯНЦЕВАЯ',
        'ПОЛНОЕ', 'НАИМЕНОВАНИЕ',
        'ЗА', 'РУБ', 'RUB',
    ];
    $s = ' ' . $s . ' ';
    foreach ($drop as $w) {
        $s = str_replace(' ' . $w . ' ', ' ', $s);
    }
    $s = preg_replace('/\s+/u', ' ', $s) ?? $s;
    $s = trim($s);

    // Synonyms / translit-ish mapping for key product families
    $map = [
        'КИРПИЧ' => 'BRICK',
        'АТЛАН' => 'ATLAN',
        'ПРОЕКТ' => 'PROJECT',
        'СТУПЕНЬ' => 'STEP',

        'СВЕТЛО' => 'LIGHT',
        'ТЕМНО' => 'DARK',
        'СЕРЫЙ' => 'GRAY',
        'БЕЖЕВЫЙ' => 'BEIGE',
        'КРЕМОВЫЙ' => 'CREAM',
        'ЧЕРНЫЙ' => 'BLACK',
        'БЕЛЫЙ' => 'WHITE',
        'ЗОЛОТОЙ' => 'GOLD',
        'СИНИЙ' => 'BLUE',
        'КОРИЧНЕВЫЙ' => 'BROWN',
        'АНТРАЦИТОВЫЙ' => 'ANTRACIT',

        // common "МТ" written in Cyrillic
        'МТ' => 'MT',
        'RSМТ' => 'RSMT',
        'RSМТ' => 'RSMT',
    ];

    $tokens = preg_split('/\s+/u', $s) ?: [];
    $out = [];
    foreach ($tokens as $t) {
        $t = trim($t);
        if ($t === '') continue;
        if (isset($map[$t])) $t = $map[$t];
        // unify variants like RsMT / RSMT
        $t = str_replace(['RSMT', 'RSMT'], 'RSMT', $t);
        $out[] = $t;
    }

    // Deduplicate consecutive duplicates
    $dedup = [];
    $prev = null;
    foreach ($out as $t) {
        if ($t === $prev) continue;
        $dedup[] = $t;
        $prev = $t;
    }

    return implode(' ', $dedup);
}

function tokenSet(string $norm): array {
    if ($norm === '') return [];
    $tokens = preg_split('/\s+/u', $norm) ?: [];
    $set = [];
    foreach ($tokens as $t) {
        $t = trim($t);
        if ($t === '') continue;
        // ignore very short tokens except MT/GL/PL/MRP/RSMT
        if (mb_strlen($t) <= 2 && !in_array($t, ['MT','GL','PL'], true)) continue;
        $set[$t] = true;
    }
    return array_keys($set);
}

function jaccardScore(array $a, array $b): int {
    $sa = array_fill_keys($a, true);
    $sb = array_fill_keys($b, true);
    $inter = 0;
    foreach ($sa as $k => $_) {
        if (isset($sb[$k])) $inter++;
    }
    $union = count($sa) + count($sb) - $inter;
    if ($union === 0) return 0;
    return (int)round(($inter / $union) * 100);
}

function bonusForKeyTokens(string $bitrixNorm, string $cmlNorm): int {
    // Extra weight when number tokens like 101/104/119 match
    $bonus = 0;
    preg_match_all('/\b\d{2,4}\b/u', $bitrixNorm, $m1);
    preg_match_all('/\b\d{2,4}\b/u', $cmlNorm, $m2);
    $n1 = array_unique($m1[0] ?? []);
    $n2 = array_unique($m2[0] ?? []);
    $common = array_intersect($n1, $n2);
    if (count($common) > 0) $bonus += 15;

    // If both contain BRICK/ATLAN/PROJECT keywords
    $keys = ['BRICK','ATLAN','PROJECT','STEP'];
    foreach ($keys as $k) {
        $b = str_contains(' ' . $bitrixNorm . ' ', ' ' . $k . ' ');
        $c = str_contains(' ' . $cmlNorm . ' ', ' ' . $k . ' ');
        if ($b && $c) $bonus += 10;
    }

    return min(30, $bonus);
}

function computeScore(string $bitrixName, string $cmlName): int {
    $bn = normalizeName($bitrixName);
    $cn = normalizeName($cmlName);

    $a = tokenSet($bn);
    $b = tokenSet($cn);

    $base = jaccardScore($a, $b);
    $bonus = bonusForKeyTokens($bn, $cn);

    return min(100, $base + $bonus);
}

function readBitrixCsv(string $path): array {
    $fh = fopen($path, 'rb');
    if (!$fh) throw new RuntimeException("Cannot open CSV: $path");

    $header = fgetcsv($fh);
    if (!$header) throw new RuntimeException("Empty CSV: $path");
    $header[0] = stripBom((string)$header[0]);

    $idx = array_flip($header);

    foreach (['ID','NAME','CODE'] as $required) {
        if (!isset($idx[$required])) {
            throw new RuntimeException("CSV missing column $required. Got: " . implode(',', $header));
        }
    }

    $rows = [];
    while (($row = fgetcsv($fh)) !== false) {
        $id = (int)$row[$idx['ID']];
        $rows[] = [
            'bitrix_id' => $id,
            'bitrix_name' => $row[$idx['NAME']] ?? '',
            'bitrix_code' => $row[$idx['CODE']] ?? '',
        ];
    }
    fclose($fh);
    return $rows;
}

function read1cImportXml(string $path): array {
    $xmlRaw = file_get_contents($path);
    if ($xmlRaw === false) throw new RuntimeException("Cannot read XML: $path");
    $xmlRaw = stripBom($xmlRaw);

    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($xmlRaw);
    if ($xml === false) {
        $errs = array_map(fn($e) => $e->message, libxml_get_errors());
        throw new RuntimeException("XML parse error: " . implode("; ", $errs));
    }

    $ns = $xml->getNamespaces(true);
    // root uses default namespace urn:1C.ru:commerceml_2
    $defaultNs = $ns[''] ?? null;
    if ($defaultNs) {
        $xml->registerXPathNamespace('c', $defaultNs);
        $items = $xml->xpath('//c:Каталог/c:Товары/c:Товар') ?: [];
    } else {
        $items = $xml->xpath('//Каталог/Товары/Товар') ?: [];
    }

    $out = [];
    foreach ($items as $t) {
        $id = (string)($t->Ид ?? '');
        $article = (string)($t->Артикул ?? '');
        $name = (string)($t->Наименование ?? '');
        if ($id === '' || $name === '') continue;
        $out[] = [
            'cml2_id' => $id,
            'article' => $article,
            'cml_name' => $name,
        ];
    }
    return $out;
}

function writeCsv(string $path, array $header, array $rows): void {
    $dir = dirname($path);
    if (!is_dir($dir)) mkdir($dir, 0775, true);

    $fh = fopen($path, 'wb');
    if (!$fh) throw new RuntimeException("Cannot write CSV: $path");

    // UTF-8 BOM to make Excel open correctly
    fwrite($fh, "\xEF\xBB\xBF");
    fputcsv($fh, $header);
    foreach ($rows as $r) {
        $line = [];
        foreach ($header as $h) $line[] = $r[$h] ?? '';
        fputcsv($fh, $line);
    }
    fclose($fh);
}

$bitrix = readBitrixCsv($bitrixCsvPath);
$cml = read1cImportXml($importXmlPath);

// Precompute CML normalized tokens to speed up
$cmlPrepared = [];
foreach ($cml as $i => $c) {
    $norm = normalizeName($c['cml_name']);
    $cmlPrepared[] = $c + ['_norm' => $norm, '_tokens' => tokenSet($norm)];
}

$mappingRows = [];
$usedCmlIds = []; // keep track of already auto-matched to prevent duplicates
$bitrixMatched = [];

foreach ($bitrix as $b) {
    $best = null;

    foreach ($cmlPrepared as $c) {
        // if already used in a strong AUTO_OK match, still allow but lower score? We'll handle by status.
        $score = computeScore($b['bitrix_name'], $c['cml_name']);

        if ($best === null || $score > $best['score']) {
            $best = [
                'cml2_id' => $c['cml2_id'],
                'article' => $c['article'],
                'cml_name' => $c['cml_name'],
                'score' => $score,
            ];
        }
    }

    $status = 'NO_MATCH';
    if ($best !== null) {
        if ($best['score'] >= 90) $status = 'AUTO_OK';
        elseif ($best['score'] >= 70) $status = 'NEEDS_REVIEW';
        else $status = 'NO_MATCH';

        // If best candidate is already assigned by another AUTO_OK, mark as NEEDS_REVIEW to avoid wrong auto-fill
        if ($status === 'AUTO_OK') {
            if (isset($usedCmlIds[$best['cml2_id']])) {
                $status = 'NEEDS_REVIEW';
            } else {
                $usedCmlIds[$best['cml2_id']] = $b['bitrix_id'];
            }
        }
    }

    $mappingRows[] = [
        'bitrix_id' => $b['bitrix_id'],
        'bitrix_name' => $b['bitrix_name'],
        'bitrix_code' => $b['bitrix_code'],
        'cml2_id' => $best['cml2_id'] ?? '',
        'article' => $best['article'] ?? '',
        'cml_name' => $best['cml_name'] ?? '',
        'score' => $best['score'] ?? 0,
        'status' => $status,
    ];

    if ($status === 'AUTO_OK') {
        $bitrixMatched[$b['bitrix_id']] = true;
    }
}

// Unmatched Bitrix = rows with status NO_MATCH
$unmatchedBitrix = [];
foreach ($mappingRows as $r) {
    if (($r['status'] ?? '') === 'NO_MATCH') {
        $unmatchedBitrix[] = [
            'bitrix_id' => $r['bitrix_id'],
            'bitrix_name' => $r['bitrix_name'],
            'bitrix_code' => $r['bitrix_code'],
            'best_score' => $r['score'],
            'best_cml_name' => $r['cml_name'],
        ];
    }
}

// Unmatched 1C = those not used in any AUTO_OK match
$unmatched1c = [];
$usedCmlSet = array_fill_keys(array_keys($usedCmlIds), true);
foreach ($cmlPrepared as $c) {
    if (!isset($usedCmlSet[$c['cml2_id']])) {
        $unmatched1c[] = [
            'cml2_id' => $c['cml2_id'],
            'article' => $c['article'],
            'cml_name' => $c['cml_name'],
        ];
    }
}

// Write outputs
writeCsv(
    $outMappingPath,
    ['bitrix_id','bitrix_name','bitrix_code','cml2_id','article','cml_name','score','status'],
    $mappingRows
);

writeCsv(
    $outUnmatchedBitrixPath,
    ['bitrix_id','bitrix_name','bitrix_code','best_score','best_cml_name'],
    $unmatchedBitrix
);

writeCsv(
    $outUnmatched1cPath,
    ['cml2_id','article','cml_name'],
    $unmatched1c
);

echo "Done.\n";
echo "Wrote:\n";
echo " - $outMappingPath\n";
echo " - $outUnmatchedBitrixPath\n";
echo " - $outUnmatched1cPath\n";