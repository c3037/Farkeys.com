<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?php require_once( __DIR__.'/head.php' ); ?>

    <title><?=$data::$second_service_name;?> - Главная</title>
<?require_once( __DIR__.'/header_index.php' );?>

        <div id="cntnt">
            <div id="logo">
                <a href="<?=$data::$links['home'];?>" title=""><img src="/media/img/logo.png" width="134" height="25" /></a>
            </div>
            <div class="cont">
                <div id="left">
                    <img src="/media/img/homeimg.png" width="570" height="250" />
                </div>
                <div id="right">
                    <ul class="listview">
                        <li onclick="document.location='<?=$data::$links['for_users'];?>';">
                            <a href="<?=$data::$links['for_users'];?>" title="">
                                <div class="icon">
                                    <img src="/media/img/for-users.png" width="50" height="51" />
                                </div>
                                <div class="data">
                                    <h4>Для пользователей</h4>
                                    <div class="progress-bar">
                                        <div class="bar" style="width: 90%"></div>
                                    </div>
                                    <p>Управление учётной записью ...</p>
                                </div>
                            </a>
                        </li>
                        <li onclick="document.location='<?=$data::$links['for_partners'];?>';">
                            <a href="<?=$data::$links['for_partners'];?>" title="">
                                <div class="icon">
                                   <img src="/media/img/for-partners.png" width="128" height="128" />
                                </div>
                                <div class="data">
                                    <h4>Для сервис-партнёров</h4>
                                    <div class="progress-bar">
                                        <div class="bar" style="width: 90%"></div>
                                    </div>
                                    <p>Настройка взаимодействия ...</p>
                                </div>
                            </a>
                        </li>
                        <li onclick="document.location='<?=$data::$links['download'];?>';">
                            <a href="<?=$data::$links['download'];?>" title="">
                                <div class="icon">
                                    <img src="/media/img/download.png" width="48" height="48" />
                                </div>
                                <div class="data">
                                    <h4>Скачать мобильное приложение</h4>
                                    <div class="progress-bar">
                                        <div class="bar" style="width: 90%"></div>
                                    </div>
                                    <p>Android ...</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_index.php' );?>