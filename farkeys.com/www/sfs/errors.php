<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( __DIR__.'/lock.php' );
define( 'DIR', /*dirname( */ dirname( dirname( __FILE__ ) ) )/* )*/;
date_default_timezone_set( "UTC" );
if( isset( $_GET['clear'] ) )
{
    $fp = fopen( DIR."/../lib/log/log.php", 'w' );
    flock( $fp, LOCK_EX );
    fwrite( $fp, '' );
    flock( $fp, LOCK_UN );
    fclose( $fp );
    $fp = fopen( DIR."/../lib/log/error.log", 'w' );
    flock( $fp, LOCK_EX );
    fwrite( $fp, '' );
    flock( $fp, LOCK_UN );
    fclose( $fp );
    echo '<meta http-equiv="refresh" content="0; URL=errors.php">';
    exit( '<center><h2>Files has been cleaned</h2><a href="errors.php"><h1>Back</h1></a></center>' );
}
echo date( 'd-M-Y H:i:s' ),' &nbsp; &nbsp; ',DIR,' &nbsp; &nbsp;  <a href="errors.php?clear">Clear files</a><hr style="width:100%" /><pre>';
    include ( DIR.'/../lib/log/log.php' );
echo '</pre><hr style="width:100%" /><pre>';
    include ( DIR.'/../lib/log/error.log' );
echo '</pre>';
echo '<hr style="width:100%" /><div id="end"></div><br />';
echo phpinfo();
?>