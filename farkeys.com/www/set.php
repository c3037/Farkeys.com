<?php
/**
* @author Dmitry Porozhnyakov
*/
ini_set( "display_errors", false );
error_reporting( E_ALL | E_STRICT );
date_default_timezone_set( "UTC" );

define( 'DIR', dirname( dirname( __FILE__ ) ) );
define( 'PUBLIC', dirname( __FILE__ ) );
define( 'LIB', DIR.'/lib' );
define( 'CONT', LIB.'/controllers' );
define( 'MODL', LIB.'/models' );
define( 'VIEW', LIB.'/views' );
define( 'SETP', LIB.'/setup' );

function errorsInFile(  $errMessage, $errCode, $errFile, $errLine )
{
    $file = LIB.'/log/log.php';
    switch( $errCode )
    {
        case E_ERROR: $errCode = 'E_ERROR';break;
        case E_WARNING: $errCode = 'E_WARNING';break;
        case E_PARSE: $errCode = 'E_PARSE';break;
        case E_NOTICE: $errCode = 'E_NOTICE';break;
        case E_CORE_ERROR: $errCode = 'E_CORE_ERROR';break;
        case E_CORE_WARNING: $errCode = 'E_CORE_WARNING';break;
        case E_COMPILE_ERROR: $errCode = 'E_COMPILE_ERROR';break;
        case E_COMPILE_WARNING: $errCode = 'E_COMPILE_WARNING';break;
        case E_USER_ERROR: $errCode = 'E_USER_ERROR';break;
        case E_USER_WARNING: $errCode = 'E_USER_WARNING';break;
        case E_USER_NOTICE: $errCode = 'E_USER_NOTICE';break;
        case E_STRICT: $errCode = 'E_STRICT';break;
        case E_RECOVERABLE_ERROR: $errCode = 'E_RECOVERABLE_ERROR';break;
        case E_DEPRECATED: $errCode = 'E_DEPRECATED';break;
        case E_USER_DEPRECATED: $errCode = 'E_USER_DEPRECATED';break;
        default: $errCode = 'ERROR: '.$errCode;break;
    }
    error_log( '{<span style="color:#f00;"> '.date('d-M-Y H:i:s').' </span>} - { '.$errCode.' } - { '.$errMessage.' } - { '.$errFile.' } - { '.$errLine." } \r\n\r\n", 3, $file );
}

function exception_handler( $exception ) {
    echo 'Sorry, a problem occurred. Please try later.';
    errorsInFile( $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine() );
    exit;
}
function error_handler( $errno, $errstr, $errfile, $errline ) {
    throw new ErrorException( $errstr, $errno, 0, $errfile, $errline );
}

set_exception_handler( 'exception_handler' );
set_error_handler( 'error_handler' );
?>