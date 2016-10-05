<?php
/**
* @author Dmitry Porozhnyakov
*/
class Config
{
    public $use_https = 'no'; //yes, no, without
    public $https_only = 'no'; //yes, no
    public $no_https_pages = array( '/int/status', '/int/email-to-id' );  // if https_only = no
    public $https_pages = array();  // if https_only = no
    
    public $ssl_day = 10; //expiration
    public $ssl_month = 01;
    public $ssl_year = 2014;
    
    public $use_www_only = 'yes'; //yes, no, without
        
    public $use_slash = 'yes'; //yes, no, without
    public $check_slash_on_homepage = 'no';  //yes, no
        
    public $mobile_version = '1.00 beta';
    public $service_name = 'FARKeys';
    public $second_service_name = 'FARKeys.com';
    public $site = 'www.farkeys.com';
    public $site_without_www = 'farkeys.com';
    public $service_mail = 'noreply@farkeys.com';
    public $db_host = 'localhost';
    public $db_base = 'dmitryqr_base1';
    public $db_user = 'dmitryqr_base1';
    public $db_password = '4GJa5}$[h.~T';
    
    public $check_license = 'yes'; //yes,no
    public $redirect = '';// Редирект 0
    
    public $top_publication;/* = "Уважаемые пользователи! Просьба обратить внимание на обновление мобильного приложения.<br />
             Версии ниже 2.00 более не поддерживаются и будут генерировать неверные числа-ответы.";*/
        
    public static function getVar( $var )
    {
        $arr = get_class_vars( 'Config' );
        return $arr[$var];
    }
}
?>