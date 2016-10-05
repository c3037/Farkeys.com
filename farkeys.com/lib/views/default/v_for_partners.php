<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Для сервис-партнёров</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page secondary">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1>Для сервис-партнёров<small class="upper"></small></h1>
                        <a href="<?=$data::$links['home'];?>" class="back-button big page-back"></a>
                    </div>
                </div>
                <div class="page-region">
                    <div class="page-region-content">
                        <div class="grid no-margin">
                            <div class="row">
                                <div class="span9">
                                    <a href="<?=$data::$links['for_partners_registration'];?>" title=""><button onclick="document.location='<?=$data::$links['for_partners_registration'];?>';" class="command-button default">Регистрация</button></a> 
                                    <a href="<?=$data::$links['for_partners_change_password'];?>" title=""><button onclick="document.location='<?=$data::$links['for_partners_change_password'];?>';" class="command-button bg-color-darken fg-color-white">Сменить пароль</button></a> 
                                    <a href="<?=$data::$links['for_partners_change_info'];?>" title=""><button onclick="document.location='<?=$data::$links['for_partners_change_info'];?>';" class="command-button bg-color-darken fg-color-white">Изменение базовой информации</button></a> 
                                    <a href="<?=$data::$links['for_partners_restore_id'];?>" title=""><button onclick="document.location='<?=$data::$links['for_partners_restore_id'];?>';" class="command-button bg-color-darken fg-color-white">Восстановление API ID</button></a>  
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
                                        1. Зарегистрируйтесь в проекте FARKeys, указав название сервиса, e-mail адрес, Success URL ( адрес, на который пользователь будет перенаправлен в случае успешной идентификации ), Fail URL ( адрес, на который пользователь будет перенаправлен в случае отказа от прохождения идентификации ) и выберите каким способом служебные данные будут добавлены к адресу Success URL в случае перенаправления ( «?» | «&amp;» ).
                                    </p>
                                    <p class="indent text-justify">
                                        2. После регистрации на указанный Вами e-mail адрес придёт письмо, содержащее API ID и API Password. Эти данные необходимы для программного взаимодействия Вашего сервера с сервером FARKeys.
                                    </p>
                                    <p>
                                        <strong>«Привязка» аккаунта пользователя к аккаунту в системе FARKeys</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Для того, чтобы Ваши пользователи могли проходить идентификацию с помощью сервиса FARKeys, им необходимо сначала «привязать» свой аккаунт в Вашем проекте к аккаунту в системе FARKeys.
                                    </p>
                                    <p class="indent text-justify">
                                        Мы рекомендуем организовать это следующим образом:
                                    </p>
                                    <p class="indent text-justify">
                                        1. Вначале пользователь идентифицируется в Вашем проекте стандартным способом ( с использованием пароля ).
                                    </p>
                                    <p class="indent text-justify">
                                        2. Затем, в клиентской зоне он заходит на заранее Вами созданную страницу «связать с аккаунтом FARKeys», на которой пользователь может управлять текущей «связью». Минимальный функционал для этой страницы: информация о текущей «связи» + форма для её смены/удаления.
                                    </p>
                                    <p class="indent text-justify">
                                        3. На странице «привязки» пользователь вводит свой e-mail адрес в системе FARKeys. Ваш сервер проверяет его и сохраняет идентификатор FARKeys ID, полученный на основе введённого e-mail адреса, как псевдоним для входа через FARKeys Авторизацию.
                                    </p>
                                    <p class="indent text-justify">
                                        Здесь стоит объяснить один нюанс. Пользователь вводит для «привязки» свой e-mail адрес в системе, но на деле «привязка» должна осуществляться к его FARKeys ID, т.к. этот параметр постоянен и не изменяется в случае смены e-mail адреса. Такой способ «привязки» позволит пользователю входить в свой аккаунт в Вашем проекте даже в случае смены управляющего e-mail адреса в системе FARKeys.
                                    </p>
                                    <p class="indent text-justify">
                                        Чтобы получить FARKeys ID пользователя на основе введённого им e-mail адреса Ваш сервер должен направить запрос по адресу:
                                    </p>
                                    <p class="indent text-justify">
                                         <?=$data::$links['email_to_id'];?>?email={ e-mail адрес, введённый пользователем }
                                    </p>
                                    <p class="indent text-justify">
                                        Ответом на такой запрос будет число:
                                    </p>
                                    <p class="indent text-justify">
                                        - если число == 0, то это значит, что переданный e-mail адрес указан не верно;
                                    </p>
                                    <p class="indent text-justify">
                                        - если число == -1, то это значит, что переданный e-mail адрес в системе не зарегистрирован; 
                                    </p>
                                    <p class="indent text-justify">
                                        - если число &gt; 0, то это FARKeys ID, соответствующий введённому e-mail адресу.
                                    </p>
                                    <p class="indent text-justify">
                                        Также мы рекомендуем при смене/установке «связи» запросить у пользователя текущий основной пароль. Это позволит увеличить безопасность метода авторизации при помощи системы FARKeys.
                                    </p>
                                    <p class="indent text-justify">
                                        В итоге, после шага «привязки» у Вас на сервере должна сохраниться пара:
                                    </p>
                                    <p class="indent text-justify">
                                        { Имя пользователя в Вашем проекте } - { FARKeys ID пользователя }.
                                    </p>
                                    <p>
                                        <strong>Идентификация пользователя</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Чтобы пользователь мог проходить идентификацию в Вашем проекте, Вам необходимо создать две служебные страницы ( Success URL, Fail URL ) и разместить кнопку «FARKeys Авторизация».
                                    </p>
                                    <p class="indent text-justify">
                                        Порядок идентификации:
                                    </p><p class="indent text-justify">
                                        1. На Вашем сайте пользователь нажимает кнопку «FARKeys Авторизация», которая перенаправляет его на сервер FARKeys;
                                    </p>
                                    <p class="indent text-justify">
                                        2. В случае успешной идентификации мы перенаправляем пользователя обратно на Ваш сайт по адресу Success URL, добавив при этом служебные переменные. В случае отказа от прохождения идентификации мы направляем пользователя по адресу Fail URL.
                                    </p>
                                    <p class="indent text-justify">
                                        Кнопка «FARKeys Авторизация» должна перенаправлять пользователя на сайт:
                                    </p>
                                    <p class="indent text-justify">
                                         <?=$data::$links['api'];?>?id={ ваш API ID }[ &amp;aux={ Дополнительные переменные } ]
                                    </p>
                                    <p class="indent text-justify">
                                        В представленном адресе переменная «id» - это полученный Вами при регистрации идентификатор API ID. По этому параметру мы определим, у какого сервис-партнёра пользователь желает пройти идентификацию.
                                    </p>
                                    <p class="indent text-justify">
                                        Переменная «aux» является необязательной и предназначена для передачи дополнительных переменных, которые Вы желаете получить назад в случае успешной идентификации пользователя. Мы рекомендуем передавать эти данные в формате XML, к прим.:
                                    </p>
                                    <p class="indent text-justify">
                                        <?=$data::$links['api'];?>?id=154&amp;aux=&lt;var&gt;tempValue&lt;/var&gt;
                                    </p>
                                    <p class="indent text-justify">
                                        Fail URL - это адрес, на который пользователь будет перенаправлен в случае отказа от прохождения идентификации. При таком перенаправлении не передаётся никаких служебных переменых, а выполняется лишь простое перенаправление, на указанный Вами адрес.
                                    </p>
                                    <p class="indent text-justify">
                                        Success URL - это адрес, на который пользователь будет перенаправлен в случае успешной идентификации. При таком перенаправлении к адресу добавляются служебные переменные ( «oi», «sk» ), которые помогут Вам получить информацию о прошедшем процессе идентификации ( Success URL ( «?» | «&amp;» ) oi=xxxxx&amp;sk=xxxxx  ). 
                                    </p>
                                    <p class="indent text-justify">
                                        Скрипту, расположенному по адресу Success URL, необходимо обратиться к нашему серверу по адресу:
                                    </p>
                                    <p class="indent text-justify">
                                        <?=$data::$links['status'];?>?oi=xxxxx&amp;sk=xxxxx&amp;api=xxxxx&amp;password=xxxxx&amp;hash=xxxxx
                                    </p>
                                    <p class="indent text-justify">
                                        При этом переменные «oi» и «sk» - это переменные полученные от пользователя;
                                    </p>
                                    <p class="indent text-justify">
                                        переменная «api» - это Ваш API ID;
                                    </p>
                                    <p class="indent text-justify">
                                        переменная «password» - Ваш API Password
                                    </p>
                                    <p class="indent text-justify">
                                        переменная «hash» - это хэш-сумма с применением алгоритма SHA-512 от Ip-адреса пользователя и данных о его браузере, к примеру для php этот параметр рассчитывается так:
                                    </p>
                                    <p class="indent text-justify">
                                        hash( 'sha512', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] )
                                    </p>
                                    <p class="indent text-justify">
                                        Ответом на запрос будет XML документ следующего формата:
                                    </p>
                                    <p class="text-justify">
                                    &lt;?xml version="1.0" encoding="utf-8"?&gt;<br />
                                    &lt;root&gt;<br />
                                    &lt;errors&gt; xxx &lt;/errors&gt;<br />
                                    &lt;data&gt;<br />
                                    &lt;user&gt; xxx &lt;/user&gt;<br />
                                    &lt;status&gt; ( verified / not verified ) &lt;/status&gt;<br />
                                    &lt;aux&gt; xxx &lt;/aux&gt;<br />
                                    &lt;date&gt; xxx &lt;/date&gt;<br />
                                    &lt;/data&gt;<br />
                                    &lt;/root&gt;
                                    </p>
                                    <p class="indent text-justify">
                                        Внутри тега &lt;errors&gt; содержится код ошибки, возникшей при обработке запроса. Расшифровка номеров:
                                    </p>
                                    <p class="indent text-justify">
                                        101 - переменная «oi» не заполнена или заполнена неверно;
                                    </p>
                                    <p class="indent text-justify">
                                        102 - переменная «sk» не заполнена или заполнена неверно;
                                    </p>
                                    <p class="indent text-justify">
                                        103 - переменная «api» не заполнена или заполнена неверно;
                                    </p>
                                    <p class="indent text-justify">
                                        104 - переменная «password» не заполнена или заполнена неверно;
                                    </p>
                                    <p class="indent text-justify">
                                        105 - переменная «hash» не заполнена или заполнена неверно;
                                    </p>
                                    <p class="indent text-justify">
                                        106 - указанный API Password не соответствует API ID;
                                    </p>
                                    <p class="indent text-justify">
                                        107 - переменная «oi» передаёт несуществующий параметр;
                                    </p>
                                    <p class="indent text-justify">
                                        108 - переменная «sk» передаёт несуществующий параметр;
                                    </p>
                                    <p class="indent text-justify">
                                        109 - переменная «hash» передаёт несуществующий параметр;
                                    </p>
                                    <p class="indent text-justify">
                                        110 - указанный API ID не соответствует инициировавшему процесс авторизации;
                                    </p>
                                    <p class="indent text-justify">
                                        0 - ошибок при выполненнии запроса не возникло.
                                    </p>
                                    <p class="indent text-justify">
                                        Тег &lt;user&gt; содержит FARKeys ID идентифицируемого пользователя.
                                    </p>
                                    <p class="indent text-justify">
                                        Тег &lt;status&gt; показывает идентифицирован пользователь или нет.
                                    </p>
                                    <p class="indent text-justify">
                                        Тег &lt;aux&gt; содержит внутри себя дополнительные переменные, которые Вы передавали вначале процесса идентификации.
                                    </p>
                                    <p class="indent text-justify">
                                        Тег &lt;date&gt; показывает время идентификации пользователя ( UTC ) в формате dd-mm-YYYY HH:mm:ss.
                                    </p>
                                    <p class="indent text-justify">
                                        После того, как ответ на запрос будет получен и обработан, Вам необходимо найти соответствие между полученным FARKeys ID и сохранённым ранее в процессе «привязки». Если соответствие будет найдено, то это значит, что пользователь к аккаунту которого «привязан» полученный FARKeys ID успешно идентифицирован.
                                    </p>
                                    <p>
                                        <strong>Тестирование</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Вы можете протестировать работу проекта на <a href="<?=$data::$links['demo'];?>" title="" class="fg-color-purple">демонстрационном сайте</a>.
                                    </p>
                                    <p>
                                        <strong>Лицензирование</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Уважаемые сервис-партнёры, обратите внимание, что созданный аккаунт в проекте FARKeys является по умолчанию нелицензированным и будет удалён через 30 дней с момента регистрации. Чтобы пройти процедуру лицензирования, необходимо обратиться к нам ( <a href="<?=$data::$links['contacts'];?>" class="fg-color-purple">Контакты</a> ) и оплатить его стоимость ( 600 руб. ).
                                    </p>
                                    <p class="indent text-justify">
                                        Лицензирование проходится один раз для одного аккаунта.
                                    </p>
                                    <p>
                                        <strong>Дополнительные функции</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        <ins>Сменить пароль</ins> - функция позволяет сменить используемый Вами пароль.
                                    </p>
                                    <p class="indent text-justify">
                                        <ins>Изменение базовой информации</ins> - воспользуйтесь этой функцией, если Вы желаете сменить название сервиса, e-mail адрес сервиса или другие параметры.
                                    </p>
                                    <p class="indent text-justify">
                                        <ins>Восстановление API ID</ins> - здесь Вы можете отправить себе на почту API ID Вашего проекта, в случае его утраты.
                                    </p>
                                    <p>
                                        <strong>Если возникли вопросы</strong>
                                    </p>
                                    <p class="indent text-justify">
                                        Обратитесь к нам любым из способов, представленных на странице <a href="<?=$data::$links['contacts'];?>" class="fg-color-purple">контактов</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_secondary_pages.php' );?>