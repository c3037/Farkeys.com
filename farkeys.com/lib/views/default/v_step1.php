<?php
/**
* @author Dmitry Porozhnyakov
*/
?>
<?require_once( __DIR__.'/head.php' );?>

    <title><?=$data::$second_service_name;?> - Авторизация - Шаг 1</title>
<?require_once( __DIR__.'/header_secondary_pages.php' );?>

        <div id="cntnt">
            <div class="page secondary">
                <div class="page-header">
                    <div class="page-header-content">
                        <h1>Авторизация<small class="upper">Шаг 1</small></h1>
                        <a href="<?=$data::$links['login_cancel'];?>" class="back-button big page-back"></a>
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
                                    <div class="bg-color-green fg-color-white padding20">
                                        <?=$data::$notice_text,"\r\n";?>
                                    </div>
<?                                      }
                                        elseif( $data::$notice_status == 'error' )
                                        {
                                    ?>
                                    <div class="bg-color-orangeDark fg-color-white padding20">
                                        <?=$data::$notice_text,"\r\n";?>
                                    </div>
<?                                      }
                                    }
                                    ?>
                                    
                                </div>
                            </div>
<?                          if( $data::$step == 'first' )
                            {
                            ?>
                            <form method="post" action="">
<?                              if( $data::$license == 'no' ):
                                ?>
                                <div class="span10 bg-color-red fg-color-white padding20">
                                    Внимание! Нелицензированный сервис-партнёр.
                                </div>
<?                              endif;
                                ?>
                                <div class="span10 bg-color-blueDark fg-color-white padding20">
                                    Авторизация в сервисе: { <?=$data::$api;?> }
                                </div>
                                <div class="row">
                                    <div class="span4">
                                        <div class="top5">Введите ваш e-mail адрес:</div>
                                        <div class="input-control text top5">
                                            <input type="text" name="email" value="<?=$data::$email;?>" />
                                            <span class="helper"></span>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <label class="input-control checkbox top35">
                                            <input type="checkbox" value="1" name="save"<?=( $data::$save == 1 )? ' checked="checked"' : '';?> />
                                            <span class="helper">Запомнить e-mail адрес</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="span5">
                                        <input type="hidden" name="query" value="1" />
                                        <input type="submit" value="Далее" />
                                        <a href="<?=$data::$links['login_cancel'];?>" class="fg-color-darken pos-rel cancel" title="">Отмена</a>
                                    </div>
                                </div>
                            </form>
<?                          }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?require_once( __DIR__.'/footer_secondary_pages.php' );?>