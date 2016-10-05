<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Для пользователей - Настройка оповещений</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page secondary">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1>Для пользователей<small class="upper">Настройка оповещений</small></h1>
                        <a href="<?=$data::$links['for_users'];?>" class="back-button big page-back"></a>
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
                            <form method="post" action="?step2">
                                <div class="row">
                                    <div class="span4">
                                        <div>Введите ваш e-mail адрес:</div>
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
                                    <div class="span5">
                                        <input type="hidden" name="query" value="1" />
                                        <input type="submit" value="Отправить" />
                                    </div>
                                </div>
                            </form>
<?                          elseif ( $data::$page_view == 'second' ):
                            ?>
                            <form method="post" action="?step3">
                                <div class="row">
                                    <div class="span4">
                                        <div>Число-вопрос:</div>
                                        <div class="input-control text">
                                            <input type="text" value="<?=$data::$number_Question;?>" disabled="disabled" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( Введите это число в мобильное приложение )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span4">
                                        <div>Число-ответ:</div>
                                        <div class="input-control password">
                                            <input type="password" name="answer" value="" maxlength="5" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div><br /></div>
                                        <p class="tertiary-text fg-color-red">
                                            ( Введите здесь число, сгенерированное мобильным приложением )
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span5">
                                        <input type="hidden" name="email" value="<?=$data::$email;?>" />
                                        <input type="hidden" name="query" value="2" />
                                        <input type="submit" value="Отправить" />
                                    </div>
                                </div>
                            </form>
<?                          elseif ( $data::$page_view == 'third' ):
                            ?>
                            <form method="post" action="?step4">
                                <div class="row">
                                    <label class="input-control checkbox">
                                        <input type="checkbox" value="1" name="use_true"<?=( $data::$use_true == 1 )? ' checked="checked"' : '';?> />
                                        <span class="helper">Оповещать об удачных авторизациях</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <label class="input-control checkbox">
                                        <input type="checkbox" value="1" name="use_false"<?=( $data::$use_false == 1 )? ' checked="checked"' : '';?> />
                                        <span class="helper">Оповещать о неудачных авторизациях	</span>
                                    </label>
                                </div>
                                <div class="row">
                                    <div class="span5">
                                        <br />
                                        <input type="hidden" name="email" value="<?=$data::$email;?>" />
                                        <input type="hidden" name="query" value="3" />
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