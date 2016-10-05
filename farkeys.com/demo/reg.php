<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/config.php' );
require_once( __DIR__.'/farkeys.com.php' );
$link = $farkeys->getRedirectLink( '<from>/demo</from>' );
if( isset( $_POST['email'] ) and !empty( $_POST['email'] ) )
{
    $email = base64_encode( trim( $_POST['email'] ) );
    $password = gen( 10 );
    $db = new DataBase();
    $result = $db->sql_1( $email, sha1( $password ) );
    if( $result > 0 )
    {
        $login = $result;
    }
    else
        exit( 'Неизвестная ошибка' );
}
else
    header( 'Location: index.php' );
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
                            <div class="fg-color-darken" style="margin:0 0 15px 0;"><strong>Ваш логин:</strong> <?=$login;?></div>
                            <div class="fg-color-darken" style="margin:0 0 15px 0;"><strong>Ваш пароль:</strong> <?=$password;?></div>
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