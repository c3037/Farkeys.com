<?php
/**
* @author Dmitry Porozhnyakov
*/
class Valid
{
    public static function name( $var )
    {
        $var = addslashes( $var );
        return ( !empty( $var ) and preg_match( "/^[a-z ]{1,255}$/i", $var ) ) ? true : false;
    }
    public static function email( $var )
    {
        $var = addslashes( $var );
        return ( !empty( $var ) and preg_match( "/^[.a-z0-9_-]+@(?:[a-z0-9-]+\.)+[a-z]{1,10}$/i", $var ) ) ? true : false;
    }
    public static function sha256( $var )
    {
        $var = addslashes( $var );
        return ( !empty( $var ) and preg_match( "/^[a-f0-9]{64}$/i", $var ) ) ? true : false;
    }
    public static function sha512( $var )
    {
        $var = addslashes( $var );
        return ( !empty( $var ) and preg_match( "/^[a-f0-9]{128}$/i", $var ) ) ? true : false;
    }
    public static function number_answer( $var )
    {
        $var = addslashes( $var );
        return ( !empty( $var ) and preg_match( "/^[0-9]{5}$/i", $var ) ) ? true : false;
    }
    public static function nameSite( $var )
    {
        $var = addslashes( $var );
        return ( !empty( $var ) and preg_match( "/^[-_.0-9a-z ]{1,255}$/i", $var ) ) ? true : false;
    }
    public static function SuccessAndFailURL( $var )
    {
        $site = Config::getVar( 'site_without_www' );
        $site = explode( '.', $site );
        $domen = $site[0];
        $domen2 = $site[1];
        unset( $site );
        return ( !empty( $var ) and preg_match( "#^(?:http\:\/\/|https\:\/\/)[^\\\/]{1}.*#i", $var ) and !preg_match( "/^(?:http\:\/\/|https\:\/\/)(?:www\.$domen\.$domen2|$domen\.$domen2)/i", $var ) ) ? true : false;
    }
    public static function number( $var )
    {
        $var = addslashes( $var );
        return ( !empty( $var ) and preg_match( "/^[0-9]+$/i", $var ) ) ? true : false;
    }
}
?>