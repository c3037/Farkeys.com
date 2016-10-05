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
if( isset( $_POST['password'] ) and !empty( $_POST['password'] ) )
{
    $password = sha1( $_POST['password'] );
    if ( $row->password != $password )
        goto b;
}
else
{
    header( 'Location: cabinet.php' );
    exit;
}
if( isset( $_POST['email'] ) and !empty( $_POST['email'] ) )
{
    $email = $_POST['email'];
}
else
{
    header( 'Location: cabinet.php' );
    exit;
}
$fkid = $farkeys->getUserId( $email );
if( $fkid == 0 )
{
    $error2 = 'E-mail адрес указан не верно';
}
elseif( $fkid == -1 )
{
    $error2 = 'Указанный e-mail адрес в системе FARKeys не зарегистрирован';
}
else
{
    $result = $db->sql_9( $fkid );
    if( $result->fetchColumn() > 0 )
    {
         $error2 = 'Указанный e-mail адрес уже привязан к другому аккаунту';
    }
    else
    {
        $result = $db->sql_7( $id, $fkid );
        $result = $db->sql_5( $id );
        $row = $result->fetchObject();
        $success = 1;
    }
}
if( 1 == 2 )
{
    b:
    $error = 1;
}
?>
<?require_once( __DIR__.'/blocks/head.php' );?>
<?require_once( __DIR__.'/blocks/header3.php' );?>
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
                            <form action="new_fk_id.php" method="post" style="margin-bottom: 5px;">
                                <div style="margin-bottom: 15px;">
                                    <strong>Привязать новый FARKeys ID</strong>
                                </div>
                                <?if( isset( $error ) ):?>
                                <div style="margin-bottom: 15px;" class="fg-color-red">
                                    <strong>Пароль не верен</strong>
                                </div>
                                <?endif;?>
                                <?if( isset( $error2 ) ):?>
                                <div style="margin-bottom: 15px;" class="fg-color-red">
                                    <strong><?=$error2;?></strong>
                                </div>
                                <?endif;?>
                                <?if( isset( $success ) ):?>
                                <div style="margin-bottom: 15px;" class="fg-color-greenDark">
                                    <strong>Привязанный FARKeys ID успешно обновлён</strong>
                                </div>
                                <?endif;?>
                                <div class="input-control text">
                                    <div class="fg-color-darken" style="margin:0 0 5px 0;">E-mail адрес в системе FARKeys:</div>
                                    <input type="text" maxlength="255" name="email" value="" />
                                </div>
                                <div class="input-control password">
                                    <div class="fg-color-darken" style="margin:0 0 5px 0;">Текущий пароль:</div>
                                    <input type="password" maxlength="255" name="password" value="" />
                                </div>
                                <div>
                                    <input type="hidden" name="query" value="1" />
                                    <input type="submit" value="Отправить" />
                                </div>
                            </form>
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