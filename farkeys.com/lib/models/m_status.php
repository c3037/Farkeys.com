<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $user;
    public static $status;
    public static $aux;
    public static $date;
    public static $errors = 0;
}
class Model
{
    //private $db;
    public function __construct()
    {
        /* Operation ID */
        if( !isset( $_GET['oi'] ) or !Valid::number( trim( $_GET['oi'] ) ) )
        {
            xData::$errors = 101;
            return;
        }
        else
        {
            $oi = trim( $_GET['oi'] );
        }
        
        /* Secret Key  */
        if( !isset( $_GET['sk'] ) or !Valid::number_answer( trim( $_GET['sk'] ) ) )
        {
            xData::$errors = 102;
            return;
        }
        else
        {
            $sk = trim( $_GET['sk'] );
        }
        
        /* API ID  */
        if( !isset( $_GET['api'] ) or !Valid::number( trim( $_GET['api'] ) ) )
        {
            xData::$errors = 103;
            return;
        }
        else
        {
            $api = trim( $_GET['api'] );
        }
        
        /* API Password */
        if( !isset( $_GET['password'] ) )
        {
            password:
            xData::$errors = 104;
            return;
        }
        else
        {
            $_GET['password'] = trim( $_GET['password'] );
            
            if( empty( $_GET['password'] ) )
            {
                goto password;
            }
            else
            {
                $password = Library::generateHashOfActivationCode( $_GET['password'] );
            }
        }
        
        /* HASH( IP + Browser) */
        if( !isset( $_GET['hash'] ) or !Valid::sha512( trim( $_GET['hash'] ) ) )
        {
            xData::$errors = 105;
            return;
        }
        else
        {
            $hash = strtoupper( trim( $_GET['hash'] ) );
        }
        
        /* Соответствие API ID - API Password */
        $db = new DataBase();
        $result = $db->sql_70( $api, Library::enCode( $password ) );
        if( $result->fetchColumn() == 0 )
        {
            xData::$errors = 106;
            return;
        }
        
        /* Извлекаем информацию о статусе авторизации */
        $result = $db->sql_71( $oi );
        if( $result == 'noValues' )
        {
            xData::$errors = 107;
            return;
        }
        else
        {
            $row = $result->fetchObject();
        }
        
        if( $row->sk != $sk )
        {
            xData::$errors = 108;
            return;
        }
        
        if( $row->hash != $hash )
        {
            xData::$errors = 109;
            return;
        }
        
        if( $row->api != $api )
        {
            xData::$errors = 110;
            return;
        }
        
        xData::$user = $row->user;
        xData::$status = ( $row->status == 1 ) ? 'verified' : 'not verified';
        xData::$date = date( 'd-m-Y H:i:s', $row->date );
        xData::$aux = base64_decode( $row->aux );
        
        //$result = $db->sql_69( $oi );
    }
    public function printdata()
    {
        return new xData;
    }
}
?>