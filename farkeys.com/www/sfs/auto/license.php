<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/../../set.php' );
require_once( SETP.'/main.php' );
if( Config::getVar( 'check_license' ) != 'yes' )
    exit;
$db = new DataBase();
$result = $db->sql_81();
if( $result->fetchColumn() == 0 )
    exit;
$result = $db->sql_82();
$array = $result->fetchAll();
require_once( VIEW.'/default/messages.php' );
foreach( $array as $val )
{
    if( $db->sql_83( $val[0] ) )
    {
        Messages::send_15( $val[0] );
        $db->sql_84( $val[0] );
    }
}
?>