<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Для сервис-партнёров - Изменение базовой информации</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page secondary">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1>Для сервис-партнёров<small class="upper">Изменение данных</small></h1>
                        <a href="<?=$data::$links['for_partners'];?>" class="back-button big page-back"></a>
                    </div>
                </div>
                <div class="page-region">
                    <div class="page-region-content">
                        <div class="grid no-margin">
                            <div class="row">
                                <div class="span10">
                                    <div class="progress-bar">
                                        <div class="bar bg-color-darken" style="width: 100%"></div>
                                    </div>
<?                                  if( $data::$use_notice == true )
                                    {
                                        if( $data::$notice_status == 'success' )
                                        {
                                    ?>
                                    <div class="bg-color-green fg-color-white padding20 notice">
                                        <?=$data::$notice_text,"\r\n";?>
                                    </div>
<?                                      }
                                        elseif( $data::$notice_status == 'error' )
                                        {
                                    ?>
                                    <div class="bg-color-orangeDark fg-color-white padding20 notice">
                                        <?=$data::$notice_text,"\r\n";?>
                                    </div>
<?                                      }
                                    }
                                    ?>
                                </div>
                            </div>
<?                          if ( $data::$page_view == 'first' ):
                            ?>
                            <form method="post" action="?send">
                                <div class="row">
                                    <div class="span4">
                                        <div>Введите e-mail адрес сервиса:</div>
                                        <div class="input-control text">
                                            <input type="text" name="email" value="<?=$data::$email;?>" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( доступны домены только на латинице, к прим.: my-mail@site.web )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span4">
                                        <div>Введите пароль:</div>
                                        <div class="input-control password">
                                            <input type="password" name="password" value="" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( 128 символов )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span5">
                                        <input type="hidden" name="query" value="1" />
                                        <input type="submit" value="Отправить" />
                                    </div>
                                </div>
                            </form>
<?                          elseif ( $data::$page_view == 'second' ):
                            ?>
                            <form method="post" action="?send">
                                <div class="row">
                                    <div class="span4">
                                        <div>Название сервиса:</div>
                                        <div class="input-control text">
                                            <input type="text" name="name" value="<?=$data::$name;?>" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( доступны латинские буквы, цифры, пробелы и 3 спец.символа &laquo; - _ . &raquo; )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span4">
                                        <div>E-mail адрес сервиса:</div>
                                        <div class="input-control text">
                                            <input type="text" name="email" value="<?=$data::$email;?>" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( доступны домены только на латинице, к прим.: my-mail@site.web )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span4">
                                        <div>Success URL:</div>
                                        <div class="input-control text">
                                            <input type="text" name="success_url" value="<?=$data::$success;?>" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( указывать вместе с протоколом, к прим.: https://site.com/success.php )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span4">
                                        <div>Fail URL:</div>
                                        <div class="input-control text">
                                            <input type="text" name="fail_url" value="<?=$data::$fail;?>" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( указывать вместе с протоколом, к прим.: http://site.com/fail.php )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="input-control checkbox">
                                        <input type="checkbox" value="1" name="use_amp"<?=( $data::$use_amp == 1 )? ' checked="checked"' : '';?> />
                                        <span class="helper">Использовать символ &laquo; &amp; &raquo; вместо &laquo; ? &raquo; при перенаправлении ( Status URL ( &amp; | ? ) data ) </span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="span5">
                                        <input type="hidden" name="query" value="2" />
                                        <input type="hidden" name="id" value="<?=$data::$id;?>" />
                                        <input type="submit" value="Отправить" />
                                    </div>
                                </div>
                            </form>
<?                          endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_secondary_pages.php' );?>