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
    $result = $db->sql_6( $id );
    setcookie( 'key', '', time() - 3600 );
    setcookie( 'id', '', time() - 3600 );
    header( 'Location: index.php' );
    exit;
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