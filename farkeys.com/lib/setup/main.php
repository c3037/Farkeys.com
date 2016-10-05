<?php
/**
* @author Dmitry Porozhnyakov
*/
require_once( SETP.'/data.php' );
require_once( SETP.'/systemdata.php' );
require_once( SETP.'/config.php' );
require_once( SETP.'/database.php' );
require_once( SETP.'/valid.php' );
require_once( SETP.'/library.php' );
class Main extends Config
{
    public function __construct( $page )
    {
        $_SERVER['HTTP_HOST'] = ( md5( $_SERVER['HTTP_HOST'] ) == md5( $this->site_without_www ) ) ? $this->site_without_www : $this->site;
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];
        if( time() >= mktime( 0, 0, 0, $this->ssl_month, $this->ssl_day, $this->ssl_year ) )
        {
            $this->use_https = 'without';
        }
        $this->www_check( $page );
        $this->slash_check( $page );
        $this->https_check( $page );
        SystemData::$page = $this->setPage( $page );
        SystemData::$site = $this->setSite();
        Data::$time = time();
        Data::$mobile_version = $this->mobile_version;
        Data::$service_name = $this->service_name;
        SystemData::$folder = $this->langSelect();
        SystemData::$host = $_SERVER['HTTP_HOST'];
        Data::$links = $this->setLinks();
        Data::$second_service_name = $this->second_service_name;
        Data::$top_publication = $this->top_publication;
    }
    public function www_check( $page )
    {
        $uri = preg_replace( "/\?.*/i",'', $_SERVER['REQUEST_URI'] );
        $not_use = 'no';
        if ( strlen( $uri ) < 2 and $this->check_slash_on_homepage == 'no' ){ $not_use = 'yes'; }
        $s = ( $this->use_https == 'yes' and $this->https_only == 'yes' ) ? 's' : '';
        if( substr( $_SERVER['HTTP_HOST'], 0, 3 ) != 'www' and $this->use_www_only == 'yes' )
        {
            header( 'HTTP/1.1 301 Moved Permanently' );
            if ( $this->use_slash == 'yes' and rtrim( $uri, '/' )."/" != $uri and $not_use == 'no' )
                header( "Location: http{$s}://".$this->site.str_replace( $uri, $uri.'/', $_SERVER['REQUEST_URI'] ) );
            elseif ( $this->use_slash == 'without' and rtrim( $uri, '/' ) != $uri and $not_use == 'no' )
                header( "Location: http{$s}://".$this->site.str_replace( $uri, rtrim( $uri, '/' ), $_SERVER['REQUEST_URI'] ) );
            else
                header( "Location: http{$s}://".$this->site.$_SERVER['REQUEST_URI'] );
            
            exit;
        }
        elseif( substr( $_SERVER['HTTP_HOST'], 0, 3 ) == 'www' and $this->use_www_only == 'without' )
        {
            header( 'HTTP/1.1 301 Moved Permanently' );
            if ( $this->use_slash == 'yes' and rtrim( $uri, '/' )."/" != $uri and $not_use == 'no' )
                header( "Location: http{$s}://".$this->site_without_www.str_replace( $uri, $uri.'/', $_SERVER['REQUEST_URI'] ) );
            elseif ( $this->use_slash == 'without' and rtrim( $uri, '/' ) != $uri and $not_use == 'no' )
                header( "Location: http{$s}://".$this->site_without_www.str_replace( $uri, rtrim( $uri, '/' ), $_SERVER['REQUEST_URI'] ) );
            else
                header( "Location: http{$s}://".$this->site_without_www.$_SERVER['REQUEST_URI'] );
            exit;
                    
        }                        
    }
    public function slash_check( $page )
    {
        if ( $this->use_slash == 'yes' )
            SystemData::$slash = '/';
        $uri = preg_replace( "/\?.*/i",'', $_SERVER['REQUEST_URI'] );
        $not_use = 'no';
        if ( strlen( $uri ) < 2 and $this->check_slash_on_homepage == 'no' ){ $not_use = 'yes'; }        
        $s = ( $this->use_https == 'yes' and $this->https_only == 'yes' ) ? 's' : '';
        if ( $this->use_slash == 'yes' and rtrim( $uri, '/' )."/" != $uri and $not_use == 'no' )
        {
            header( "HTTP/1.1 301 Moved Permanently" );
            header( "Location: http{$s}://".$_SERVER['SERVER_NAME'].str_replace( $uri, $uri.'/', $_SERVER['REQUEST_URI'] ) );
            exit;    
        }
        elseif ( $this->use_slash == 'without' and rtrim( $uri, '/' ) != $uri and $not_use == 'no' )
        {
            header( "HTTP/1.1 301 Moved Permanently" );
            header( "Location: http{$s}://".$_SERVER['SERVER_NAME'].str_replace( $uri, rtrim( $uri, '/' ), $_SERVER['REQUEST_URI'] ) );
            exit;    
        }
    }
    public function https_check( $page = '/' )
    {
        function https()
        {
            if( !isset( $_SERVER['HTTPS'] ) or $_SERVER['HTTPS'] == 'off' )
            {
                header( 'Status-Code: 301' );
                header( 'Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );
                exit;
            }
        }
        function no_https()
        {
            if( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' )
            {
                header( 'Status-Code: 301' );
                header( 'Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );
                exit;
            }
        }
        if( $this->use_https == 'yes' )
        {
            if( $this->https_only == 'yes' )
                https();
            elseif( !empty( $this->no_https_pages ) )
            {
                if ( Library::inArray( $this->no_https_pages, $page ) == -1 )
                    https();
                else
                    no_https();
            }
            elseif( !empty( $this->no_https_pages ) )
            {
                if ( Library::inArray( $this->https_pages, $page ) != -1 )
                    https();
                else
                    no_https();
            }
        }
        elseif( $this->use_https == 'without' )
        {
            if( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' )
            {
                header( 'Status-Code: 301' );
                header( 'Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );
                exit;
            }
        }
    }
    public function setPage( $page )
    {
        if( $this->use_slash == 'yes' and strlen( $page ) > 1 )
            $page .= '/';
        return $page;
    }
    public function setSite()
    {
        $site = ( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' ) ? 'https://' : 'http://';
        $site .= $_SERVER['HTTP_HOST'];
        return $site;
    }
    public function langSelect()
    {
        return 'default';
    }
    public function setLinks()
    {
        $arr = array();
        $arr['home'] = SystemData::$site.SystemData::$slash;
        $arr['for_users'] = SystemData::$site.'/for-users'.SystemData::$slash;
        $arr['for_users_registration'] = SystemData::$site.'/for-users/registration'.SystemData::$slash;
        $arr['for_users_change_activation_code'] = SystemData::$site.'/for-users/change-activation-code'.SystemData::$slash;
        $arr['for_users_change_email'] = SystemData::$site.'/for-users/change-email'.SystemData::$slash;
        $arr['for_users_setting_alerts'] = SystemData::$site.'/for-users/setting-alerts'.SystemData::$slash;
        $arr['for_partners'] = SystemData::$site.'/for-partners'.SystemData::$slash;
        $arr['for_partners_registration'] = SystemData::$site.'/for-partners/registration'.SystemData::$slash;
        $arr['for_partners_change_password'] = SystemData::$site.'/for-partners/change-password'.SystemData::$slash;
        $arr['for_partners_change_info'] = SystemData::$site.'/for-partners/change-info'.SystemData::$slash;
        $arr['for_partners_restore_id'] = SystemData::$site.'/for-partners/restore-id'.SystemData::$slash;
        $arr['download'] = SystemData::$site.'/download'.SystemData::$slash;
        $arr['download_android'] = SystemData::$site.'/FARKeys.apk';
        $arr['about'] = SystemData::$site.'/about'.SystemData::$slash;
        $arr['contacts'] = SystemData::$site.'/contacts'.SystemData::$slash;
        $arr['language'] = '#lang';//SystemData::$site.'/language/?p='.SystemData::$page;
        $arr['login_step1'] = SystemData::$site.'/login/step-one'.SystemData::$slash;
        $arr['login_step2'] = SystemData::$site.'/login/step-two'.SystemData::$slash;
        $arr['login_cancel'] = SystemData::$site.'/login/cancel'.SystemData::$slash;
        $arr['email_to_id'] = 'http://'.SystemData::$host.'/int/email-to-id'.SystemData::$slash;
        $arr['api'] = 'http://'.SystemData::$host.'/int/api'.SystemData::$slash;
        $arr['status'] = 'http://'.SystemData::$host.'/int/status'.SystemData::$slash;
        $arr['redirect'] = SystemData::$site.'/int/redirect'.SystemData::$slash;
        $arr['m_version'] = SystemData::$site.'/int/m-version'.SystemData::$slash;
        $arr['demo'] = 'http://demo.farkeys.com';
        return $arr;
    }
}
?>