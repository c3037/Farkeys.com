<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice;
    public static $notice_status = 'error';
    public static $notice_text;
    public static $email;
}
class Model
{
    //private $db;
    public function __construct()
    {
        //$this->db = new DataBase();
        //$db =& $this->db;
        //Valid::n();
    }
    public function sendData()
    {
        if( isset( $_POST['email'] ) and Valid::email( trim( $_POST['email'] ) ) )
        {
            $email = strtolower( trim( $_POST['email'] ) );
            xData::$email =& $email;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_2();
            return;
        }
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем, есть ли такой e-mail в системе */
        $result = $db->sql_36( $email );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_9();
            return;
        }
        $row = $db->sql_49( $email )->fetchObject();
        
        //Отправляем почту
        $mail = Messages::send_12( $email, $row->id );
        
        if( $mail )
        {
            xData::$use_notice = true;
            xData::$email = null;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_29();
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма API ID: $email, $row->id, $mail", 
            '701', __FILE__, __LINE__ );
        }
    }
    public function printdata()
    {
        return new xData;
    }
}
?>