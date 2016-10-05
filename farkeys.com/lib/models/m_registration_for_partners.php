<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice;
    public static $notice_status;
    public static $notice_text;
    public static $name;
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
        /* Проверяем введённые переменные */
        $notice = 0;
        
        if( isset( $_POST['name'] ) and Valid::nameSite( trim( $_POST['name'] ) ) )
        {
            $name = trim( $_POST['name'] );
            xData::$name =& $name;
        }
        else
        {
            $notice = 1;
        }
        
        if( isset( $_POST['email'] ) and Valid::email( trim( $_POST['email'] ) ) )
        {
            $email = strtolower( trim( $_POST['email'] ) );
            xData::$email =& $email;
        }
        else
        {
            $notice = ( $notice == 0 ) ? 2 : $notice;
        }
        
        if( $notice == 1 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_22();
            return;
        }
        elseif( $notice == 2 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_23();
            return;
        }
        
        /* Генерируем код подтверждения */
        $key = hash( 'sha256', '<3nm>'.rand( 1, 999999999999999 ).'</nm>' );
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем, не используется ли уже этот e-mail*/
        $result = $db->sql_36( $email );
        if( $result->fetchColumn() > 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_3();
            return;
        }
        
        /* Проверяем, не было ли заявок на регистрацию с этого e-mail'a */
        $result = $db->sql_37( $email );
        if( $result->fetchColumn() > 0 )
        {
            $result = $db->sql_38( $email, $key, $name );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка обновления таблицы cache: $email, $key, $name, ".$result->rowCount(), '701', __FILE__, __LINE__ );
                return;
            }
        }
        else
        {
            $result = $db->sql_39( $email, $key, $name );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка вставки новой строки в таблицу cache: $email, $key, $name, ".$result->rowCount(), '701', __FILE__, __LINE__ );
                return;
            }
        }
        
        /* Отправляем почту */
        $mail = Messages::send_8( $email, $key );
        
        if( $mail )
        {
            xData::$name = '';
            xData::$email = '';                                  
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_5();
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма регистрации: $email , $key, $mail ", '701', __FILE__, __LINE__ );
        }                
    }
    public function printdata()
    {
        return new xData;
    }
}
?>