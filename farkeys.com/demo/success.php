<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/config.php' );
require_once( __DIR__.'/farkeys.com.php' );
$link = $farkeys->getRedirectLink( '<from>/demo</from>' );

if( isset( $_GET['oi'] ) and !empty( $_GET['oi'] ) )
{
    $oi = (int) $_GET['oi'];
}
else
    goto a;
    
if( isset( $_GET['sk'] ) and !empty( $_GET['sk'] ) )
{
    $sk = (int) $_GET['sk'];
}
else
    goto a;
$val = $farkeys->getAuthenticationData( $oi, $sk );
if( $val->errors != 0 or $val->data->status != 'verified' )
    goto a;
$fkid = $val->data->user;
$db = new DataBase();
$result = $db->sql_9( $fkid );
if ( $result->fetchColumn() > 0 )
{
	$result = $db->sql_5( $fkid );
	$row = $result->fetchObject();
	if($row->usemc == 1 and (!isset($_POST['mc']) or empty($_POST['mc']) ))
		goto b;
	elseif (isset($_POST['mc']) and sha1($_POST['mc']) != $row->mc ){
		$ery = 1;
		goto b;
	}
    $result = $db->sql_10( $fkid );
    $login = $result->fetchColumn();
    $a = rand( 0, 9999999999 );
    $hash = sha1( $a.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
    $result = $db->sql_3( $login, $hash );
    if( $result->rowCount() != 1 )
        exit( 'Неизвестная ошибка' );
    setcookie( 'key', $a );
    setcookie( 'id', $login );
    header( 'Location: cabinet.php' );
    exit;
}
else
    $error1 = 'Не найден привязанный аккаунт';
a:
?>
<?require_once( __DIR__.'/blocks/head.php' );?>
    <title>FARKeys - Демонстрация</title>
</head>
<body>
    <div id="wrapper" style="width: 940px;margin:0 auto;">
        <div class="bg-color-red fg-color-white padding20 text-center">
            <?=( !isset( $error1 ) ) ? 'Ошибка в данных' : $error1;?>
        </div>
        <div class="grid">
            <div class="row">
                <div class="span4">
                    <div class="row">
                        <div style="margin: 15px 0;">
                            <strong>Регистрация у сервис-партнёра</strong>
                        </div>
                        <div>
<?require_once( __DIR__.'/blocks/reg.php' );?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="margin: 15px 0;">
                            <strong>Авторизация у сервис-партнёра</strong>
                        </div>
                        <div>
<?require_once( __DIR__.'/blocks/log_in.php' );?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="margin-top: 5px;">
                            <a href="<?=$link;?>" title=""><button onClick="document.location='<?=$link;?>';" class="command-button bg-color-darken fg-color-white span4">FARKeys Авторизация</button></a>
                        </div>
                    </div>
                </div>
<?require_once( __DIR__.'/blocks/text1.php' );?>
            </div>
<?require_once( __DIR__.'/blocks/footer1.php' );?>
        </div>
    </div>
</body>
</html>
<?
if (1 == 2){
	b:
	?>
<?require_once( __DIR__.'/blocks/head.php' );?>
<?require_once( __DIR__.'/blocks/header3.php' );?>
<div style="width: 250px;margin:15px auto;">
<form method="post">
<? if (isset($ery) and $ery == 1){?>
<div style="margin-bottom: 15px;" class="fg-color-red">
                                    <strong>Мастер-код не верен</strong>
                                </div>
                                <?
                                }
								?>
                                <div class="input-control password">
                                    <div class="fg-color-darken" style="margin:0 0 5px 0;">Ваш мастер-код:</div>
                                    <input type="password" maxlength="255" name="mc" value="" />
                                </div>
                                <div class="span5">
                                    <input type="hidden" name="query" value="1" />
                                    <input type="submit" value="Отправить" />
                                </div>
                            </form></div>
                            <?require_once( __DIR__.'/blocks/footer1.php' );?>
<?
}
?>