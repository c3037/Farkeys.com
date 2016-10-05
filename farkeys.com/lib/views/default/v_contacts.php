<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Контакты</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page secondary">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1>Контакты<small class="upper"></small></h1>
                        <a href="<?=$data::$links['home'];?>" class="back-button big page-back"></a>
                    </div>
                </div>
                <div class="page-region">
                    <div class="page-region-content">
                        <div class="grid no-margin">
                            <div class="row">
                                <div class="span3">
                                    <p class="text-justify">
                                        <address>
                                            <strong>Администратор проекта</strong><br />
                                            Дмитрий Порожняков<br />
                                            <a href="mailto:admin&#64;farkeys.com" title="">admin&#64;farkeys.com</a>
                                        </address>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="span10">
                                    <p>
                                        Будем рады выслушать любой вопрос или предложение.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_secondary_pages.php' );?>