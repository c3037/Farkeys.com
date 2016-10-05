<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice;
    public static $notice_status;
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
        /* Проверяем введённый e-mail адрес */
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
        
        /* Генерируем код подтверждения */
        $key = hash( 'sha256', "<nm>1".rand( 1, 999999999999999 )."</nm>" );
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем, есть ли такой e-mail в системе */
        $result = $db->sql_1( $email );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_9();
            return;
        }
        
        /* Проверяем, не было ли заявок на смену кода активации с этого e-mail'a */
        $result = $db->sql_8( $email );
        if( $result->fetchColumn() > 0 )
        {
            $result = $db->sql_9( $email, $key );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка обновления таблицы cache: $email , $key ".$result->rowCount(), '701', __FILE__, __LINE__ );
                return;
            }
        }
        else
        {
            $result = $db->sql_10( $email, $key );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка вставки новой строки в таблицу cache: $email , $key ".$result->rowCount(), '701', __FILE__, __LINE__ );
                return;
            }
        }
        
        /* Отправляем почту */
        $mail = Messages::send_3( $email, $key );
        
        if( $mail )
        {
            xData::$email = null;
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_10();
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма регистрации: $email , $key", '701', __FILE__, __LINE__ );
        }
    }
    public function printdata()
    {
        return new xData;
    }
}
?>