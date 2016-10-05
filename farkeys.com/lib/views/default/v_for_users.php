<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Для пользователей</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page secondary">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1>Для пользователей<small class="upper"></small></h1>
                        <a href="<?=$data::$links['home'];?>" class="back-button big page-back"></a>
                    </div>
                </div>
                <div class="page-region">
                    <div class="page-region-content">
                        <div class="grid no-margin">
                            <div class="row">
                                <div class="span9">
                                    <a href="<?=$data::$links['for_users_registration'];?>" title=""><button onclick="document.location='<?=$data::$links['for_users_registration'];?>';" class="command-button default">Регистрация</button></a> 
                                    <a href="<?=$data::$links['for_users_change_activation_code'];?>" title=""><button onclick="document.location='<?=$data::$links['for_users_change_activation_code'];?>';" class="command-button bg-color-darken fg-color-white">Сменить код активации</button></a> 
                                    <a href="<?=$data::$links['for_users_change_email'];?>" title=""><button onclick="document.location='<?=$data::$links['for_users_change_email'];?>';" class="command-button bg-color-darken fg-color-white">Сменить управляющий e-mail адрес</button></a> 
                                    <a href="<?=$data::$links['for_users_setting_alerts'];?>" title=""><button onclick="document.location='<?=$data::$links['for_users_setting_alerts'];?>';" class="command-button bg-color-darken fg-color-white">Настройка оповещений</button></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span10">
                                    <h2>Порядок работы с проектом</h2>
                                    <p class="indent text-justify">
                                        Перед прочтением представленной ниже информации рекомендуем ознакомится с информацией <a href="<?=$data::$links['about'];?>" class="fg-color-purple">о сервисе</a>.
                                    </p>
                                    <p>
                                        <strong>Регистрация</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        1. Скачайте на свой мобильный телефон <a href="<?=$data::$links['download'];?>" title="" class="fg-color-purple">приложение</a>, необходимое для генерации ключевой информации.
                                    </p>
                                    <p class="indent text-justify">
                                        2. Зарегистрируйтесь в проекте FARKeys, указав своё имя, e-mail адрес, контрольный вопрос и ответ.
                                    </p>
                                    <p class="indent text-justify">
                                        3. После регистрации на Ваш почтовый ящик придёт сообщение, содержащее код активации. Этот код необходимо ввести в мобильное приложение, чтобы оно могло генерировать уникальные числа-ответы.
                                    </p>
                                    <p>
                                        <strong>«Привязка»</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        1. Войдите в свой аккаунт на сайте сервис-партнёра.
                                    </p>
                                    <p class="indent text-justify">
                                        2. Найдите и выберите пункт «связать с аккаунтом FARKeys».
                                    </p>
                                    <p class="indent text-justify">
                                        3. На странице «привязки» укажите Ваш e-mail адрес в системе FARKeys, после чего Ваш аккаунт у сервис-партнёра будет привязан к FARKeys аккаунту и Вы сможете проходить идентификацию, используя сервис одноразовых паролей.
                                    </p>
                                    <p class="indent text-justify">
                                        *. Обратите внимание, что на некоторый сайтах порядок «привязки» может отличаться. Более подробную информацию уточняйте у сервис-партнёра.
                                    </p>
                                    <p>
                                        <strong>Идентификация</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Чтобы проходить идентификацию с помощью системы FARKeys у сервис-партнёра, необходимо сначала выполнить шаг «привязки» для Вашего аккаунта у этого сервис-партнёра. Если шаг «привязки» не был выполнен, то идентифицироваться с помощью сервиса FARKeys в данной ситуации будет невозможно.
                                    </p>
                                    <p class="indent text-justify">
                                        1. Если Вы хотите пройти идентификацию с помощью сервиса FARKeys, то Вам необходимо на сайте сервис-партнёра выбрать и нажать кнопку «FARKeys Авторизация».
                                    </p>
                                    <p class="indent text-justify">
                                        2. Далее на первом шаге авторизации укажите Ваш управляющий e-mail адрес.
                                    </p>
                                    <p class="indent text-justify">
                                        3. На втором шаге авторизации вам будет предложено число-вопрос, которое необходимо ввести в мобильное приложение, и на основании которого будет рассчитано число-ответ.
                                    </p>
                                    <p class="indent text-justify">
                                        4. В случае, если введённое число-ответ совпадает с рассчитанным системой, Вы будете успешно авторизированны и направлены на сайт сервис-партнёра.
                                    </p>
                                    <p>
                                        <strong>Тестирование</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Вы можете протестировать работу проекта на <a href="<?=$data::$links['demo'];?>" title="" class="fg-color-purple">демонстрационном сайте</a>.
                                    </p>
                                    <p>
                                        <strong>Дополнительные функции</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        <ins>Сменить код активации</ins> - воспользуйтесь этой функцией, если Вы желает восстановить или сменить код активации. Обратите внимание, что после смены кода активации Вам будет необходимо изменить его и в мобильном приложении, иначе оно будет генерировать неверные числа-ответы.
                                    </p>
                                    <p class="indent text-justify">
                                        <ins>Сменить управляющий e-mail адрес</ins> - эта функция позволяет сменить e-mail адрес, используемый Вам в системе FARKeys. Также важно, что при смене управляющего e-mail адреса все «привязанные» аккаунты будут сохранены и Вы сможете входить в них при помощи нового e-mail адреса.
                                    </p>
                                    <p class="indent text-justify">
                                        <ins>Настройка оповещений</ins> - функция позволяет изменить параметры, определяющие будет ли в случае успешной и/или неуспешной идентификации выслано письмо оповещения на Ваш электронный адрес. Такой механизм позволит Вам оперативно отслеживать активность аккаунта и в случае подозрительной активности принять незамедлительные меры.
                                    </p>
                                    <div id="recom">
                                        <p>
                                            <strong>Рекомендации по безопасности</strong>
                                        </p>
                                    </div>
                                    <p class="indent text-justify">
                                        1. Рекомендуется в качестве управляющего e-mail адреса использовать адрес, не используемый для других целей;
                                    </p>
                                    <p class="indent text-justify">
                                        2. Рекомендуется менять код активации не реже одного раза в месяц;
                                    </p>
                                    <p class="indent text-justify">
                                        3. Рекомендуется в качестве контрольного вопроса при регистрации и смене e-mail адреса указывать вопрос, ответ на который не известен посторонним лицам;
                                    </p>
                                    <p class="indent text-justify">
                                        4. <strong>Важно!</strong> Никому не сообщайте свой код активации, в противном случае Ваш аккаунт подвергнется риску взлома;
                                    </p>
                                    <p class="indent text-justify">
                                        5. Рекомендуется установить пароль на сайте сервис-партнёра длиной не менее 32 символов, сохранить этот пароль в безопасном месте, «привязать» учётную запись сервис-партнёра к своему аккаунту в системе FARKeys и использовать FARKeys авторизацию в качестве основного способа идентификации. Такая схема позволит Вам повысить безопасность и удобство процесса авторизации, также при этом всегда остаётся возможность пройти идентификацию обычным способом ( с использованием пароля ).
                                    </p>
                                    <p>
                                        <strong>Если возникли вопросы</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Обратитесь к нам любым из способов, представленных на странице <a href="<?=$data::$links['contacts'];?>" class="fg-color-purple">контактов</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_secondary_pages.php' );?>