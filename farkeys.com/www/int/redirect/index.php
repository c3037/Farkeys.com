<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/../../set.php' );
require_once( SETP.'/main.php' );
$path = Config::getVar( 'redirect' );
if( !empty( $path ) )
    header( 'Location: '.$path );
else
    header( 'Location: /' );
?>