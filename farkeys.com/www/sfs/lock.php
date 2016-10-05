<?php
$login = '12';
$password = '13';
if ( !isset( $_SERVER['PHP_AUTH_USER'] ) or !isset( $_SERVER['PHP_AUTH_PW'] ) )
{
    Header ("WWW-Authenticate: Basic realm=\"S Zone\"");
    Header ("HTTP/1.0 401 Unauthorized");
    exit();
}
else
{
    if ( md5( $_SERVER['PHP_AUTH_USER'] ) !=  md5( $login ) and md5( $_SERVER['PHP_AUTH_PW'] ) !=  md5( $password ) )
    {
        Header ("WWW-Authenticate: Basic realm=\"S Zone\"");
        Header ("HTTP/1.0 401 Unauthorized");
        exit();
    }
}
?>