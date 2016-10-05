<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/../../set.php' );
require_once( SETP.'/main.php' );
$db = new DataBase();
$result = $db->sql_77();
$r1 = $result->fetchAll();
$result = $db->sql_78();
$r2 = $result->fetchAll();
if ( count( $r1 ) != count( $r2 ) )
    errorsInFile( 'Ошибка: одинаковые e-mail адреса в таблице users', 701, __FILE__, __LINE__ );

$result = $db->sql_79();
$r1 = $result->fetchAll();
$result = $db->sql_80();
$r2 = $result->fetchAll();
if ( count( $r1 ) != count( $r2 ) )
    errorsInFile( 'Ошибка: одинаковые e-mail адреса в таблице api', 701, __FILE__, __LINE__ );
?>