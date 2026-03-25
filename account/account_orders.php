<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("История заказов");
?>

        <!-- .page-title -->
        <div class="page-title relative">
            <div class="paralaximg" data-parallax="scroll" data-image-src="/images/page-title/99400fb7d8ca34b9de28a63ba678cfba.jpg">
            </div>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="title">История заказов</h3>
                            <ul class="breadcrumb">
                                <li><a href="#">Главное</a></li>
                                <li>История заказов</li>
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
                            <div class="order-history-container">
    <h2 class="order-history-title">История заказов</h2>
    <div class="order-status-tabs">
        <button class="tab-button active">Все</button>
        <button class="tab-button">Ожидает оплаты</button>
        <button class="tab-button">В работе</button>
        <button class="tab-button">Выполненный</button>
        <button class="tab-button">Отмененный</button>
    </div>
    <table class="order-history-table">
        <thead>
            <tr>
                <th>№ заказа</th>
                <th>Сумма, ₽</th>
                <th>Дата</th>
                <th>Статус</th>
                <th>Доставка</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2417</td>
                <td>45345</td>
                <td>18.08.2025</td>
                <td class="status pending">Ожидает оплаты</td>
                <td>Курьером</td>
                <td><button class="tf-btn btn-onsurface">Повторить</button></td>
            </tr>
            <tr>
                <td>2418</td>
                <td>5435</td>
                <td>19.08.2025</td>
                <td class="status in-progress">В работе</td>
                <td>Курьером</td>
                <td><button class="tf-btn btn-onsurface">Повторить</button></td>
            </tr>
            <tr>
                <td>2419</td>
                <td>54353</td>
                <td>20.08.2025</td>
                <td class="status completed">Выполненный</td>
                <td>Курьером</td>
                <td><button class="tf-btn btn-onsurface">Повторить</button></td>
            </tr>
            <tr>
                <td>2420</td>
                <td>545</td>
                <td>21.08.2025</td>
                <td class="status canceled">Отмененный</td>
                <td>Курьером</td>
                <td><button class="tf-btn btn-onsurface">Повторить</button></td>
            </tr>
            <tr>
                <td>2421</td>
                <td>5435</td>
                <td>22.08.2025</td>
                <td class="status pending">Ожидает оплаты</td>
                <td>Курьером</td>
                <td><button class="tf-btn btn-onsurface">Повторить</button></td>
            </tr>
            <tr>
                <td>2422</td>
                <td>5435</td>
                <td>23.08.2025</td>
                <td class="status pending">Ожидает оплаты</td>
                <td>Курьером</td>
                <td><button class="tf-btn btn-onsurface">Повторить</button></td>
            </tr>
        </tbody>
    </table>
</div>

                       
				</div>
                            </div>
                        </div>
<div class="wrap-sidebar-account">
   <div class="sidebar-account">
      <div class="account-avatar">
         <div class="image">
            <img src="/images/avatar/22.jpg" alt="" />
         </div>
         <h6 class="mb_4">Тамби Администратор</h6>
         <div class="body-text-1">mt-work@yandex.ru</div>
      </div>
      <ul class="my-account-nav">
         <li>
            <a href="./personal.php" class="my-account-nav-item">
               <img src="/images/icon/black/ac.png" alt="" />
               Мой кабинет
            </a>
         </li>
         <li>
            <a href="./account_order_detail.php" class="my-account-nav-item">
               <img src="/images/icon/black/onl.png" alt="" />
               Мои заказы
            </a>
         </li>
         <li>
            <a href="./account.php" class="my-account-nav-item">
               <img src="/images/icon/black/id.png" alt="" />
               Личные данные
            </a>
         </li>
         <li>
            <span class="my-account-nav-item active">
               <img src="/images/icon/black/his.png" alt="" />
               История заказов
            </span>
         </li>
         <li>
            <a href="./profile_list.php" class="my-account-nav-item">
               <img src="/images/icon/black/del.png" alt="" />
               Профили заказов
            </a>
         </li>
         <li>
            <a href="./price_types.php" class="my-account-nav-item">
               <img src="/images/icon/black/mon.png" alt="" />
               Прайсы и типы цен
            </a>
         </li>
         <li>
            <a href="./subscriptions.php" class="my-account-nav-item">
               <img src="/images/icon/black/sub.png" alt="" />
               Подписки
            </a>
         </li>
         <li>
            <a href="/contacts/" class="my-account-nav-item">
               <img src="/images/icon/black/cont.png" alt="" />
               Контакты
            </a>
         </li>
         <li>
            <a href="#" class="my-account-nav-item">
               <img src="/images/icon/black/ex.png" alt="" />

               Выход
            </a>
         </li>
      </ul>
   </div>
   <div class="bx-sidebar-block hidden-xs">
      <div class="mb-5 mt-3">
         <h3 class="sale_lbl_top">Рассылка</h3>
         <div class="bx-subscribe" id="sender-subscribe">
            <form
               id="bx_subscribe_subform_sljzMT"
               role="form"
               method="post"
               action="/personal/"
            >
               <input
                  type="hidden"
                  name="sessid"
                  id="sessid"
                  value="3968a046dc979c891d953adb25defdda"
               />
               <input type="hidden" name="sender_subscription" value="add" />

               <div class="bx-input-group">
                  <input
                     class="bx-form-control"
                     type="email"
                     name="SENDER_SUBSCRIBE_EMAIL"
                     value=""
                     title="Введите ваш e-mail"
                     placeholder="Введите ваш e-mail"
                  />
               </div>

               <div style=""></div>

               <div class="mb-5 mt-3" style="color: white">
                  <button disabled="" class="tf-btn btn-onsurface">
                     Подписаться
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
                      
                    </div>
                </div>
            </section>




<style>
/* Общие стили для контейнера истории заказов */
.order-history-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Заголовок */
.order-history-title {
    font-size: 2em;
    margin-bottom: 20px;
    color: #2c3e50;
    text-align: center;
}

/* Стили для вкладок статусов заказов */
.order-status-tabs {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.tab-button {
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px 20px;
    margin: 0 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.tab-button.active {
    background-color: #827460;
    color: #ffffff;
    border-color: #827460;
}

.tab-button:hover {
color: #080808ff;
    background-color: #fff9f1
}

/* Стили для таблицы истории заказов */
.order-history-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.order-history-table th,
.order-history-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.order-history-table th {
    background-color: #f9f9f9;
    color: #333;
}

.order-history-table tr:hover {
    background-color: #fff9f1;
}

/* Стили для статусов заказов */
.status {
    font-weight: bold;
}

.status.pending {
    color: #ff9800; /* Ожидает оплаты */
}

.status.in-progress {
    color: #2196f3; /* В работе */
}

.status.completed {
    color: #4caf50; /* Выполненный */
}

.status.canceled {
    color: #f44336; /* Отмененный */
}

/* Кнопка "Повторить" */
.repeat-button {
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    padding: 8px 12px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.repeat-button:hover {
    background-color: #0056b3;
}



    </style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>