<?php
/**
* @author Dmitry Porozhnyakov
*/
( isset( $_SERVER["REDIRECT_STATUS"] ) ) ? $HttpStatus = $_SERVER["REDIRECT_STATUS"] : $HttpStatus = '000';

    switch($HttpStatus) {

case '404':
echo <<<HERE
<!DOCTYPE html><html><head><title>404 Page Not Found</title></head><body><div style="text-align:center;">
<h1>404 Page Not Found</h1><p>The page you requested was not found.</p><p><a href="/" title="">Home page</a></p>
</div></body></html>
HERE;
break;

default:
echo <<<HERE
<!DOCTYPE html><html><head><title>Error $HttpStatus</title></head><body><div style="text-align:center;">
<h1>Sorry</h1><p>The error $HttpStatus occurred while performing an operation, try again later.</p>
<p><a href="/" title="">Home page</a></p></div></body></html>
HERE;
break;
    
    }
?>