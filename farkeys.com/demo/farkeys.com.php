<?php
class FARKeys
{
    private $api_id;
    private $api_password;
    private $host = 'www.farkeys.com';
    public function __construct( $id, $password )
    {
        $this->api_id = (int) $id;
        $this->api_password = $password;
    }
    public function getUserId( $email )
    {
        $url = 'http://'.$this->host.'/int/email-to-id/?email='.$email;
        $context = stream_context_create( array(
        'http' => array(
                'header' => "Connection: close",
                'method' => 'GET',
                'timeout' => 10
                )
        ) );
        $contents = file_get_contents( $url, false, $context );
        if( $contents === false )
        {
    		exit( 'Connection error' );
        }
        else
        {
            return $contents;
        }
    }
    public function getRedirectLink( $aux = '' )
    {
        return 'http://'.$this->host.'/int/api/?id='.$this->api_id.'&aux='.urlencode( $aux );
    }
    public function getAuthenticationData( $oi, $sk )
    {
        $url = 'http://'.$this->host.'/int/status/?oi='.$oi.'&sk='.$sk.'&api='.$this->api_id.
        '&password='.$this->api_password.'&hash='.hash( 'sha512', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        $context = stream_context_create( array(
        'http' => array(
                'header' => "Connection: close",
                'method' => 'GET',
                'timeout' => 10
                )
        ) );
        $contents = file_get_contents( $url, false, $context );
        if( $contents === false )
        {
    		exit( 'Connection error' );
        }
        else
        {
            return simplexml_load_string( $contents );
        }
    }
}

$farkeys = new FARKeys( 1, 'fkmh562plxnudyg10eqokxk75oe3hn1cn1kejz3u5yb84xxe98m14vw1qtuoj4i5f0ds8n9gqhzw4n5ylojrpz02o4uua2vt4pqni41an0169g3jl5yn5bplonnj0q86' );
/* demo 
$id = $farkeys->getUserId( 'email' );
$link = $farkeys->getRedirectLink( 'Vars' );
$data = $farkeys->getAuthenticationData( oi, sk );
*/
?>