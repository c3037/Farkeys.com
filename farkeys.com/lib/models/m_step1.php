<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice = false;
    public static $notice_status = 'error';
    public static $notice_text;
    public static $email;
    public static $step = 'first';
    public static $save = 1;
    public static $api = 'none';
    public static $license;
}
class Model
{
    private $db;
    private $oi;
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
            xData::$step = false;
            return;
        }
        else
        {
            $id = trim( $_GET['oi'] );
            $this->oi =& $id;
        }
        
        /* Подключаемся к БД */
        $this->db = new DataBase();
        $db =& $this->db;
        
        /* Проверяем OpID */
        $result = $db->sql_63( $id );
        if( $result === 'noValues' )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            xData::$step = false;
            return;
        }
        else
            $row = $result->fetchObject();
        
        /* Если есть запомненный E-MAIL */
        if( isset( $_COOKIE['email'] ) and Valid::email( trim( $_COOKIE['email'] ) ) )
        {
            xData::$email = trim( $_COOKIE['email'] );
        }
        
        /* Выводим API Name */
        $result = $db->sql_64( $row->api );
        $row = $result->fetchObject();
        xData::$api = $row->name;
        
        /* Лицензия */
        if( Config::getVar( 'check_license' ) == 'yes' )
            xData::$license = ( $row->licensed == 0 ) ? 'no' : 'yes';
        
        xData::$links['login_cancel'] .= '?oi='.$id;
        xData::$links['login_step1'] .= '?oi='.$id;
        xData::$links['login_step2'] .= '?oi='.$id;
    }
    public function sendData()
    {
        if( isset( $_POST['save'] ) and $_POST['save'] == 1 )
        {
            xData::$save = 1;
        }
        else
        {
            xData::$save = 0;
        }
        
        /* Проверяем e-mail */
        if( isset( $_POST['email'] ) and Valid::email( trim( $_POST['email'] ) ) )
        {
            $email = strtolower( trim( $_POST['email'] ) );
            xData::$email =& $email;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_2();
            return;
        }
        
        /* Проверяем есть ли такой ID */
        $db =& $this->db;
        $result = $db->sql_1( $email );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_9();
            return;
        }
        else
        {
            $result = $db->sql_14( $email );
            $row = $result->fetchObject();
        }
        
        if( xData::$save == 1 )
        {
            setcookie( 'email', $email, time()+31536000, '/', '' );
        }
        else
        {
            setcookie( 'email', $email, time()-100, '/', '' );
        }
        
        $result = $db->sql_65( $row->id, $this->oi );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления строки в таблице status: $row->id, $this->oi, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            xData::$step = false;
            return;
        }
        else
        {
            header( 'Location: '.Data::$links['login_step2'] );
            exit;
        }
    }
    public function printdata()
    {
        return new xData;
    }
}
?>