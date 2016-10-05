<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Мобильное приложение</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page secondary">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1>Мобильное приложение<small class="upper"></small></h1>
                        <a href="<?=$data::$links['home'];?>" class="back-button big page-back"></a>
                    </div>
                </div>
                <div class="page-region">
                    <div class="page-region-content">
                        <div class="grid no-margin">
                            <div class="row">
                                <div class="span9">
                                    <a href="<?=$data::$links['download_android'];?>" title=""><button onclick="document.location='<?=$data::$links['download_android'];?>';" class="command-button default">Скачать приложение для Android</button></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span10">
                                    <p class="indent text-justify">
                                        Здесь Вы можете скачать приложение для Вашего мобильного телефона, необходимое для генерации ключевой информации.
                                    </p>
                                    <p class="indent text-justify">
                                        Пожалуйста обратите внимание на текущую версию мобильного приложения ( <span class="fg-color-blueDark"><?=$data::$mobile_version;?></span> ). Если на Вашем телефоне установлена другая версия, рекомендуем немедленно обновиться. 
                                    </p>
                                    <p class="indent text-justify">
                                        В случае, если текущая версия отличается от используемой Вами основным номером ( <strong>X</strong>.xx ), то число-ответ, генерируемое Вашим приложением будет не совпадать с ожидаемым системой, т.е. пройти авторизацию, используя устаревшее приложение, будет невозможно. Решение - обновить мобильное приложение и запросить новый код активации. 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_secondary_pages.php' );?>