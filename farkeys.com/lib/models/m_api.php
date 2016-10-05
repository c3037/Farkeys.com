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
        /* Проверяем существование API ID */
        if( !isset( $_GET['id'] ) or !Valid::number( $_GET['id'] ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_36();
            return;
        }
        
        $id = $_GET['id'];
        
        /* Проверяем, есть ли такой API ID*/
        $db = new DataBase();
        $result = $db->sql_61( $id );
        if ( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_37();
            return;
        }
        
        if( isset( $_GET['aux'] ) and !empty( $_GET['aux'] ) )
        {
            $aux = base64_encode( $_GET['aux'] );
        }
        else
        {
            $aux = '';
        }
        
        $result = $db->sql_62( $id, $aux );
        if ( $result )
        {
            Header( "Pragma: no-cache" );
            Header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
            header( "Cache-Control: no-store, no-cache, must-revalidate" );
            header( "Expires: " . date( "r" ) );
            header( 'Location: '.Data::$links['login_step1'].'?oi='.$result );
            exit;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка вставки новой строки в таблицу status: $id, $aux ".$result, '701', __FILE__, __LINE__ );
            return;
        }
    }
    public function printdata()
    {
        return new xData;
    }
}
?>