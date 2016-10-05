<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice = false;
    public static $notice_status;
    public static $notice_text;
}
class Model
{
    //private $db;
    public function __construct()
    {
        //$this->db = new DataBase();
        //$db =& $this->db;
        //Valid::n();
        
        /* Проверяем введённые переменные */
        if( !isset( $_GET['oi'] ) or !Valid::number( trim( $_GET['oi'] ) ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            return;
        }
        else
        {
            $id = trim( $_GET['oi'] );
            $this->oi =& $id;
        }
        
        $db = new DataBase();
        
        /* Проверяем OpID */
        $result = $db->sql_68( $id );
        if( $result === 'noValues' )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            return;
        }
        else
            $row = $result->fetchObject();
            
        /* Выводим API Name */
        $result = $db->sql_64( $row->api );
        $row_api = $result->fetchObject();
        
        if( $row->hash == strtoupper( hash( 'sha512', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] ) ) )
        {
            $result = $db->sql_69( $row->id );
        }
        
        header( 'Location: '.base64_decode( $row_api->fail ) );
        exit;
    }
    public function printdata()
    {
        return new xData;
    }
}
?>