<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/config.php' );
require_once( __DIR__.'/farkeys.com.php' );
$link = $farkeys->getRedirectLink( '<from>/demo</from>' );


if( isset( $_COOKIE['id'] ) and !empty( $_COOKIE['id'] ) )
{
    $id = (int) $_COOKIE['id'];
}
else
    goto a;
if( isset( $_COOKIE['key'] ) and !empty( $_COOKIE['key'] ) )
{
    $key = (int) $_COOKIE['key'];
}
else
    goto a;
$hash = sha1( $key.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
$db = new DataBase();
$result = $db->sql_4( $id );
if( $result->fetchColumn() > 0 )
{
    $result = $db->sql_5( $id );
    $row = $result->fetchObject();
    if( $hash == $row->hash and $row->hashdate + 3600 > time() )
    {
        header( 'Location: cabinet.php' );
        exit;
    }
}
a:
?>
<?php require_once( __DIR__.'/blocks/head.php' );?>
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