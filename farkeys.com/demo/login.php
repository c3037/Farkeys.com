<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/config.php' );
require_once( __DIR__.'/farkeys.com.php' );
$link = $farkeys->getRedirectLink( '<from>/demo</from>' );

if( isset( $_POST['login'] ) and !empty( $_POST['login'] ) )
{
    $login = (int) $_POST['login'];
}
else
    header( 'Location: index.php' );
    
if( isset( $_POST['password'] ) and !empty( $_POST['password'] ) )
{
    $password = sha1( $_POST['password'] );
}
else
    header( 'Location: index.php' );

$db = new DataBase();
$result = $db->sql_2( $login, $password );
if( $result->fetchColumn() > 0 )
{
    $a = rand( 0, 9999999999 );
    $hash = sha1( $a.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
    $result = $db->sql_3( $login, $hash );
    if( $result->rowCount() != 1 )
        exit( 'Неизвестная ошибка' );
    if( setcookie( 'key', $a, 0, '/' ) and setcookie( 'id', $login, 0, '/' ) )
        header( 'Location: cabinet.php' );
    else
        exit( 'Unknown Error' );
    exit( 'Redirecting' );
}
?>
<?require_once( __DIR__.'/blocks/head.php' );?>
<?require_once( __DIR__.'/blocks/header1.php' );?>
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
                        <div style="margin-bottom: 15px;" class="fg-color-red">
                            <strong>Неверный логин или пароль</strong>
                        </div>
<?require_once( __DIR__.'/blocks/log_in.php' );?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="margin-top: 5px;">
                            <a href="<?=$link;?>" title=""><button onclick="document.location='<?=$link;?>';" class="command-button bg-color-darken fg-color-white span4">FARKeys Авторизация</button></a>
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