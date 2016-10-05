<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
</head>
<body>
    <div class="place-center span12" id="wrapper">
        <div id="menu" class="nav-bar bg-color-darken">
            <div class="nav-bar-inner padding10">
                <span class="pull-menu"></span>
                <a href="<?=$data::$links['home'];?>"><span class="element brand">
                   <span class="icon-key pos-rel icon1"></span>
                   <span class="pos-rel text1"> <?=$data::$second_service_name;?> <small> &nbsp; <?=$data::$mobile_version;?></small></span>
                </span></a>
                <div class="divider"></div>
                <ul class="menu">
                    <li data-role="dropdown">
                        <a href="<?=$data::$links['for_users'];?>">Для пользователей</a>
<?/*<ul class="dropdown-menu" style="overflow: hidden;">
                            <li><a href="<?=$data::$links['for_users'];?>">Для пользователей</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=$data::$links['for_users_registration'];?>">Регистрация</a></li>
                            <li><a href="<?=$data::$links['for_users_change_activation_code'];?>">Сменить код активации</a></li>
                            <li><a href="<?=$data::$links['for_users_change_email'];?>">Сменить управляющий e-mail адрес</a></li>
                            <li><a href="<?=$data::$links['for_users_setting_alerts'];?>">Настройка оповещений</a></li>
                        </ul>*/
                        ?>
                    </li>
                    <li data-role="dropdown">
                        <a href="<?=$data::$links['for_partners'];?>">Для сервис-партнёров</a>
<?/*<ul class="dropdown-menu" style="overflow: hidden;">
                            <li><a href="<?=$data::$links['for_partners'];?>">Для сервис-партнёров</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=$data::$links['for_partners_registration'];?>">Регистрация</a></li>
                            <li><a href="<?=$data::$links['for_partners_change_password'];?>">Сменить пароль</a></li>
                            <li><a href="<?=$data::$links['for_partners_change_info'];?>">Изменение базовой информации</a></li>
                            <li><a href="<?=$data::$links['for_partners_restore_id'];?>">Восстановление API ID</a></li>
                        </ul>
                        */?>
                    </li>
                    <li data-role="dropdown">
                        <a href="<?=$data::$links['download'];?>">Мобильное приложение</a>
<?/*<ul class="dropdown-menu" style="overflow: hidden;">
                            <li><a href="<?=$data::$links['download'];?>">Скачать мобильное приложение</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=$data::$links['download_android'];?>">Android</a></li>
                        </ul>
                        */?>
                    </li>
                    <li><a href="<?=$data::$links['about'];?>">О сервисе</a></li>
                    <li><a href="<?=$data::$links['contacts'];?>">Контакты</a></li>
                </ul>
            </div>
        </div>
<?require_once( __DIR__.'/top_publications.php' );?>