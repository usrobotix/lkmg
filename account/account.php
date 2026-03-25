<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мой профиль");
// Проверка авторизации
if (!$USER->IsAuthorized()) {
    LocalRedirect('/login/');
    exit();
}

global $USER;
$userId = $USER->GetID();
?>

        <!-- .page-title -->
        <div class="page-title relative">
            <div class="paralaximg" data-parallax="scroll" data-image-src="/images/page-title/99400fb7d8ca34b9de28a63ba678cfba.jpg">
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="title">Личные данные</h3>
                            <ul class="breadcrumb">
                                <li><a href="/">Главная</a></li>
                                <li>Личные данные</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.page-title -->
    
        <section class="flat-spacing">
                <div class="container">
                    <div class="my-account-wrap">
                        <div class="my-account-content">
                            <div class="account-details">
                            <div class="row">

                            <div class="account-details">
                                <form action="#" class="form-account-details form-has-password">
                                    <div class="account-info">
                                        <h5 class="title">Основная информация</h5>
                                        <div class="cols mb_20">
                                            <fieldset class="">
                                                <input class="" type="text" placeholder="Имя*" name="text" tabindex="2" value="Тамби" aria-required="true" required="">
                                            </fieldset>
                                            <fieldset class="">
                                                <input class="" type="text" placeholder="Фамилия*" name="text" tabindex="2" value="Администратор" aria-required="true" required="">
                                            </fieldset>
                                        </div>
                                        <div class="cols mb_20">
                                            <fieldset class="">
                                                <input class="" type="email" placeholder="Логин или e-mail*" name="email" tabindex="2" value="mt-work@yandex.ru" aria-required="true" required="">
                                            </fieldset>
                                            <fieldset class="">
                                                <input class="" type="text" placeholder="Телефон*" name="text" tabindex="2" value="89280104008" aria-required="true" required="">
                                            </fieldset>
                                        </div>
                                        <div class="tf-select">
                                            <select class="text-title" id="country" name="address[country]" data-default="">
                                                <option value="Australia" data-provinces="[['Australian Capital Territory','Australian Capital Territory'],['New South Wales','New South Wales'],['Northern Territory','Northern Territory'],['Queensland','Queensland'],['South Australia','South Australia'],['Tasmania','Tasmania'],['Victoria','Victoria'],['Western Australia','Western Australia']]">
                                                   Санкт-Петербург</option>
                                                <option value="Austria" data-provinces="[]">Краснодар</option>
                                                <option value="Belgium" data-provinces="[]">Ростов-на-Дону</option>
                                                <option value="Canada" data-provinces="[['Alberta','Alberta'],['British Columbia','British Columbia'],['Manitoba','Manitoba'],['New Brunswick','New Brunswick'],['Newfoundland and Labrador','Newfoundland and Labrador'],['Northwest Territories','Northwest Territories'],['Nova Scotia','Nova Scotia'],['Nunavut','Nunavut'],['Ontario','Ontario'],['Prince Edward Island','Prince Edward Island'],['Quebec','Quebec'],['Saskatchewan','Saskatchewan'],['Yukon','Yukon']]">
                                                    Уфа</option>                                                
                                                <option selected="" value="United States" data-provinces="[['Alabama','Alabama'],['Alaska','Alaska'],['American Samoa','American Samoa'],['Arizona','Arizona'],['Arkansas','Arkansas'],['Armed Forces Americas','Armed Forces Americas'],['Armed Forces Europe','Armed Forces Europe'],['Armed Forces Pacific','Armed Forces Pacific'],['California','California'],['Colorado','Colorado'],['Connecticut','Connecticut'],['Delaware','Delaware'],['District of Columbia','Washington DC'],['Federated States of Micronesia','Micronesia'],['Florida','Florida'],['Georgia','Georgia'],['Guam','Guam'],['Hawaii','Hawaii'],['Idaho','Idaho'],['Illinois','Illinois'],['Indiana','Indiana'],['Iowa','Iowa'],['Kansas','Kansas'],['Kentucky','Kentucky'],['Louisiana','Louisiana'],['Maine','Maine'],['Marshall Islands','Marshall Islands'],['Maryland','Maryland'],['Massachusetts','Massachusetts'],['Michigan','Michigan'],['Minnesota','Minnesota'],['Mississippi','Mississippi'],['Missouri','Missouri'],['Montana','Montana'],['Nebraska','Nebraska'],['Nevada','Nevada'],['New Hampshire','New Hampshire'],['New Jersey','New Jersey'],['New Mexico','New Mexico'],['New York','New York'],['North Carolina','North Carolina'],['North Dakota','North Dakota'],['Northern Mariana Islands','Northern Mariana Islands'],['Ohio','Ohio'],['Oklahoma','Oklahoma'],['Oregon','Oregon'],['Palau','Palau'],['Pennsylvania','Pennsylvania'],['Puerto Rico','Puerto Rico'],['Rhode Island','Rhode Island'],['South Carolina','South Carolina'],['South Dakota','South Dakota'],['Tennessee','Tennessee'],['Texas','Texas'],['Utah','Utah'],['Vermont','Vermont'],['Virgin Islands','U.S. Virgin Islands'],['Virginia','Virginia'],['Washington','Washington'],['West Virginia','West Virginia'],['Wisconsin','Wisconsin'],['Wyoming','Wyoming']]">
                                                    Москва</option>
                                                <option value="Vietnam" data-provinces="[]">Чечня</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="account-password">
                                        <h5 class="title">Смена пароля</h5>
                                        <fieldset class="position-relative password-item mb_20">
                                            <input class="input-password" type="password" placeholder="Старый пароль*" name="password" tabindex="2" value="" aria-required="true" required="">
                                            <span class="toggle-password unshow">
                                                <i class="icon-eye-hide-line"></i>
                                            </span>
                                        </fieldset>
                                        <fieldset class="position-relative password-item mb_20">
                                            <input class="input-password" type="password" placeholder="Новый пароль" name="password" tabindex="2" value="" aria-required="true" required="">
                                            <span class="toggle-password unshow">
                                                <i class="icon-eye-hide-line"></i>
                                            </span>
                                        </fieldset>
                                        <fieldset class="position-relative password-item">
                                            <input class="input-password" type="password" placeholder="Подтвердить новый пароль*" name="password" tabindex="2" value="" aria-required="true" required="">
                                            <span class="toggle-password unshow">
                                                <i class="icon-eye-hide-line"></i>
                                            </span>
                                        </fieldset>
                                    </div>
                                    <div class="button-submit">
                                        <button class="tf-btn btn-onsurface" type="submit">
                                            Сохранить
                                        </button>
                                    </div>
                                </form>
                            </div>
				</div>
                            </div>
                        </div>
                        <div class="wrap-sidebar-account">
                            <div class="sidebar-account">
                                <div class="account-avatar">
                                    <div class="image">
                                        <img src="/images/avatar/22.jpg" alt="">
                                    </div>
                                    <h6 class="mb_4">Тамби Администратор</h6>
                                    <div class="body-text-1">mt-work@yandex.ru</div>
                                </div>
                                <ul class="my-account-nav">
                                    <li>
                                        <a href="./personal.php" class="my-account-nav-item">
                                           <img src="/images/icon/black/ac.png" alt="">
                                            Мой кабинет	

                                        </a>
                                    </li>
                                    <li>
                                        <a href="./account_order_detail.php" class="my-account-nav-item">
                                            <img src="/images/icon/black/onl.png" alt="">
                                            Мои заказы

                                        </a>
                                    </li>
                                    <li>
                                        <span class="my-account-nav-item active">
                                            <img src="/images/icon/black/id.png" alt="">
                                            Личные данные

                                        </span>
                                    </li>
                                    <li>
                                        <a href="./account_orders.php" class="my-account-nav-item">
                                            <img src="/images/icon/black/his.png" alt="">
                                            История заказов

                                        </a>
                                    </li>
                                    <li>
                                        <a href="./profile_list.php" class="my-account-nav-item">
                                            <img src="/images/icon/black/del.png" alt="">
                                            Профили заказов

                                        </a>
                                    </li>
                                    <li>
                                        <a href="./price_types.php" class="my-account-nav-item">
                                            <img src="/images/icon/black/mon.png" alt="">
                                            Прайсы и типы цен

                                        </a>
                                    </li>
                                    <li>
                                        <a href="./subscriptions.php" class="my-account-nav-item">
                                            <img src="/images/icon/black/sub.png" alt="">
                                            Подписки

                                        </a>
                                    </li>
                                    <li>
                                        <a href="/contacts/" class="my-account-nav-item">
                                            <img src="/images/icon/black/cont.png" alt="">
                                            Контакты

                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="my-account-nav-item">
                                            <img src="/images/icon/black/ex.png" alt="">

                                            Выход

                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="bx-sidebar-block hidden-xs">
	<div class="mb-5 mt-3">
	<h3 class="sale_lbl_top">Рассылка</h3>
	<div class="bx-subscribe" id="sender-subscribe">


	<form id="bx_subscribe_subform_sljzMT" role="form" method="post" action="/personal/">
		<input type="hidden" name="sessid" id="sessid" value="3968a046dc979c891d953adb25defdda">		<input type="hidden" name="sender_subscription" value="add">

		<div class="bx-input-group">
			<input class="bx-form-control" type="email" name="SENDER_SUBSCRIBE_EMAIL" value="" title="Введите ваш e-mail" placeholder="Введите ваш e-mail">
		</div>

		<div style="">
								</div>

		
		<div class=" mb-5 mt-3" style="color:white;">
			<button disabled="" class="tf-btn btn-onsurface">Подписаться</button>
		</div>
	</form>
</div></div></div>
                        </div>
                      
                    </div>
                </div>
            </section>



<style>
.sale-personal-section-index-block:hover { opacity: 1; }

.sale-personal-section-index-block-link,
.sale-personal-section-index-block-link:hover,
.sale-personal-section-index-block-link:active,
.sale-personal-section-index-block-link:focus,
.sale-personal-section-index-block-link:visited {
	display: block;
	padding: 25px 5px;
	width: 100%;
	color: #fff;
	text-decoration: none;
}

.sale-personal-section-index-block-link { color: #fff; }

.sale-personal-section-index-block-ico { font-size: 64px; }

.sale-personal-section-index-block-name {
	color: #fff;
	font-size: 15px;
	margin: 0;
	padding: 0;
}
.fa {
    display: inline-block;
    font: normal normal normal 14px / 1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    transform: translate(0, 0);
}
.fa-calculator:before {
    content: "\f1ec";
}

.sale-personal-section-index-block {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    margin: 15px 0;
    padding: 0;
    height: 87%;
    border-radius: 3px;
    background-size: cover;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    opacity: .8;
    transition: all 0.3s;
    justify-content: space-around;
    background-color: #212529;
}
.delivery_main_panel {
    padding: 30px;
    height: 100%;
    border: 1px solid #E0E0E0;
    border-radius: 16px;
}
.sale_lbl_top {
    margin-bottom: 10px;
    font-weight: 500;
    font-size: 22px;
    line-height: 28px;
    color: #1C1C1C;
}
.pers_item:last-child {
    margin-bottom: 0;
}
.pers_item {
    position: relative;
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #E0E0E0;
    border-radius: 8px;
    display: flex;
    align-items: flex-start;
    padding-right: 35px;
}
.pers_item > span {
    width: 200px;
    font-size: 15px;
    line-height: 1.25;
    color: rgba(28, 28, 28, 0.4);
    flex: none;
}
.pers_item > p {
    font-size: 16px;
    line-height: 1.2;
    color: #1C1C1C;
    margin-bottom: 0;
}
.pers_item > a {
    position: absolute;
    right: 10px;
    top: calc(50% - 13px);
}
a.address_control {
    display: inline-block;
    margin-left: 6px;
    border: none!important;
    vertical-align: middle;
    position: relative;
    top: -2px;
}
.address_control img {
    transition: 0.3s;
}
.notification_checker {
    margin: 30px 0;
    display: flex;
    align-content: flex-end;
    justify-content: space-between;
}
.delivery_adres .button_yellow {
    display: inline-block;
    vertical-align: middle;
    margin-right: 20px;
    height: 45px;
    max-width: 244px;
    width: 100%;
    font-size: 17px;
    margin-top: 8px;
}
.button_yellow {
    border: none;
    font-size: 16px;
    line-height: 26px;
    -webkit-transition: 0.3s;
    transition: 0.3s;
    background-color: #FFF282;
    border-radius: 8px;
    color: #1C1C1C;
}
.notification_checker > p {
    margin-bottom: 0;
    font-size: 16px;
    line-height: 20px;
    color: #1C1C1C;
}
.switch {
    position: relative;
    display: inline-block;
    width: 34px;
    height: 14px;
    margin: 0;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
    margin: 0;
}
input:checked + .slider {
    background-color: rgb(227 6 21 / 24%);
}
.slider.round {
    border-radius: 34px;
}
.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgb(204 204 204 / 25%);
    -webkit-transition: .4s;
    transition: .4s;
    border-radius: 34px;
}
input:checked + .slider:before {
    -webkit-transform: translateX(22px);
    -ms-transform: translateX(22px);
    transform: translateX(22px);
}
input:checked + .slider::before {
    background: #E30615;
    box-shadow: 0px 1px 2px rgb(28 28 28 / 34%);
}
.slider.round:before {
    border-radius: 50%;
}
.slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: -3px;
    bottom: -3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
    background: #E0E0E0;
    box-shadow: 0px 1px 2px rgb(28 28 28 / 34%);
    border-radius: 20px;
}









    </style>
      <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>