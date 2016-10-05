<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/config.php' );
require_once( __DIR__.'/farkeys.com.php' );

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
    if( $hash != $row->hash or $row->hashdate + 3600 < time() )
        goto a;
}
else
    goto a;
if( 1 == 2 )
{
    a:
    header( 'Location: index.php' );
    exit;
}
?>
<?require_once( __DIR__.'/blocks/head.php' );?>
<?require_once( __DIR__.'/blocks/header4.php' );?>
        <div class="grid">
            <div class="row">
                <div class="span4">
                    <div class="row">
                        <div style="margin: 15px 0;">
                            <strong>Ваш логин: <?=$row->id;?></strong>
                        </div>
                        <div style="margin: 15px 0;">
                            <strong>Сменить пароль</strong>
                        </div>
                        <div>
<?require_once( __DIR__.'/blocks/chpas.php' );?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="margin: 10px 0 15px 0;">
                            <strong>Cвязать с аккаунтом FARKeys</strong>
                        </div>
                        <div>
                            <div style="margin-bottom: 15px;" class="border-color-blue padding10">
                                Привязанный FARKeys ID: <?=( $row->fkid == 0) ? 'нет' : $row->fkid;?>
                            </div>
<?require_once( __DIR__.'/blocks/new.php' );?>
<?require_once( __DIR__.'/blocks/mc.php' );?>

<?require_once( __DIR__.'/blocks/delete.php' );?>
                        </div>
                    </div>
                    <div class="row">
                        <div style="margin-top: 5px;">
                            <a href="logout.php" title=""><button onclick="document.location='logout.php';" class="command-button bg-color-darken fg-color-white span4">Выход</button></a>
                        </div>
                    </div>
                </div>
<?require_once( __DIR__.'/blocks/text2.php' );?>
            </div>
<?require_once( __DIR__.'/blocks/footer1.php' );?>
        </div>
    </div>
</body>
</html>