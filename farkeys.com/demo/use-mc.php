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

if( isset( $_POST['usemc'] ) and $_POST['usemc'] == 1 )
{
    $usemc = 1;
}
else
{
     $usemc = 0;
}
if( isset( $_POST['master'] ) )
{
    $master = sha1($_POST['master']);
}
else
{
    header( 'Location: cabinet.php' );
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
if(empty($_POST['master']) and $usemc == 1)
{
   $error = 2;
   goto c;
}
$result = $db->sql_11 ( $id, $usemc, $master );
if( $result->rowCount() != 1 )
        exit( 'Неизвестная ошибка' );
else 
	$success = 1;
$result = $db->sql_5( $id );
    $row = $result->fetchObject();
if( 1 == 2 )
{
    b:
    $error = 1;
}
c:
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
<form action="use-mc.php" method="post" style="margin-bottom: 5px;">
                                <div style="margin-bottom: 15px;">
                                    <strong>Мастер-код</strong>
                                </div>
                                <?if( isset( $error ) and $error != 2 ):?>
                                <div style="margin-bottom: 15px;" class="fg-color-red">
                                    <strong>Пароль не верен</strong>
                                </div>
                                <?endif;?>
                                <?if( isset( $error ) and $error == 2 ):?>
                                <div style="margin-bottom: 15px;" class="fg-color-red">
                                    <strong>Мастер-код не указан</strong>
                                </div>
                                <?endif;?>
                                <?if( isset( $success ) ):?>
                                <div style="margin-bottom: 15px;" class="fg-color-greenDark">
                                    <strong>Данные успешно изменены</strong>
                                </div>
                                <?endif;?>

                                   <label class="input-control checkbox">
                                        <input type="checkbox" value="1" name="usemc"<?=( $row->usemc == 1 )? ' checked="checked"' : '';?> />
                                        <span class="helper">Использовать Мастер-код</span>
                                    </label>

                                <div class="input-control text">
                                    <div class="fg-color-darken" style="margin:0 0 5px 0;">Установить новый Мастер-код</div>
                                    <input type="text" maxlength="255" name="master" value="" />
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