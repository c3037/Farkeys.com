<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Подтверждение операций</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page">
                <div class="page-region">
                    <div class="top20 page-region-content">
<?                      if( $data::$use_notice == true )
                        {
                            if( $data::$notice_status == 'success' )
                            {
                        ?>
                        <div class="bg-color-green fg-color-white padding20 text-center">
                            <?=$data::$notice_text,"\r\n";?>
                        </div>
<?                          }
                            elseif( $data::$notice_status == 'error' )
                            {
                        ?>
                        <div class="bg-color-orangeDark fg-color-white padding20 text-center">
                            <?=$data::$notice_text,"\r\n";?>
                        </div>
<?                          }
                        }
                        if ( $data::$use_reg_form == true ):
                        ?>
                        <form method="post">
                            <div class="row<?=( $data::$use_notice == true ) ? ' top20' : '';?>">
                                <div class="span10 place-center">
                                    <h2 class="button20">
                                        Регистрация пользователя: завершающий этап
                                    </h2>
                                    <div class="progress-bar">
                                        <div class="bar" style="width: 100%"></div>
                                    </div>
                                    <div>Введите контрольный вопрос:</div>
                                    <div class="input-control text">
                                        <input type="text" maxlength="255" name="question" value="" />
                                        <span class="helper"></span>
                                    </div>
                                    <div>Введите ответ на контрольный вопрос:</div>
                                    <div class="input-control text">
                                        <input type="text" maxlength="255" name="answer" value="" />
                                        <span class="helper"></span>
                                    </div>
                                    <div>
                                        <input type="hidden" name="query" value="1" />
                                        <input type="submit" value="Отправить" />
                                    </div>
                                    <div>
                                        <blockquote class="tertiary-text fg-color-blueDark">
                                            <strong>Пожалуйста, запомните введённые данные!</strong><br />
                                            Ответ на контрольный вопрос будет запрошен в случае смены управляющего e-mail адреса.<br />
                                            Если ответ утрачен, то e-mail адрес сменить будет невозможно.
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </form>
<?                      elseif ( $data::$use_reg_form_for_partners == true ):
                        ?>
                        <form method="post">
                            <div class="row<?=( $data::$use_notice == true ) ? ' top20' : '';?>">
                                <div class="grid no-margin">
                                    <div class="span10 place-center">
                                        <h2 class="button20">
                                            Регистрация сервис-партнёра: завершающий этап
                                        </h2>
                                        <div class="progress-bar">
                                            <div class="bar" style="width: 100%"></div>
                                        </div>
                                        <div class="row">
                                            <div class="span4">
                                                <div>Введите Success URL:</div>
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
                                                <div>Введите Fail URL:</div>
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
                                                <span class="helper">Использовать символ &laquo; &amp; &raquo; вместо &laquo; ? &raquo; при перенаправлении ( Success URL ( &amp; | ? ) data ) </span>
                                            </label>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="bar" style="width: 100%"></div>
                                        </div>
                                        <div>
                                            <input type="hidden" name="query" value="1" />
                                            <input type="submit" value="Отправить" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
<?                      endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_secondary_pages.php' );?>