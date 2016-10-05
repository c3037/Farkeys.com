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
    public static $page_view = 'first';
    public static $number_Question;
    public static $use_true;
    public static $use_false;
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
    public function sendDataStep1() ////////////////////////////////////////////////////////////////////
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
            xData::$notice_text = Notices::n_2();
            return;
        }
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем, есть ли такой e-mail в системе, если есть то извлекаем информацию */
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
        
        /* Формируем новое значение числа-вопроса */
        $newNumber = ( substr( $row->lastnum, 0, -2 ) + 1 ).Library::generateNumberCode( 2 );
        xData::$number_Question =& $newNumber;
        
        /* Заносим число в БД */
        $result = $db->sql_15( $email, $newNumber );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления строки в таблице users: $email, $newNumber, ",$result->rowCount(), '701', __FILE__, __LINE__ );
            return;
        }
        
        xData::$page_view = 'second';
    }
    public function sendDataStep2() ////////////////////////////////////////////////////////////////////
    {
        xData::$page_view = 'second';
        
        /* Проверяем введённый e-mail адрес */
        if( isset( $_POST['email'] ) and Valid::email( trim( $_POST['email'] ) ) )
        {
            $email = strtolower( trim( $_POST['email'] ) );
            xData::$email =& $email;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            xData::$page_view = 'none';
            return;
        }
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем, есть ли такой e-mail в системе, если есть то извлекаем информацию */
        $result = $db->sql_1( $email );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            xData::$page_view = 'none';
            return;
        }
        else
        {
            $result = $db->sql_14( $email );
            $row = $result->fetchObject();
        }
        
        /* Формируем новое значение числа-вопроса */
        $newNumber = ( substr( $row->lastnum, 0, -2 ) + 1 ).Library::generateNumberCode( 2 );
        xData::$number_Question =& $newNumber;
        
        /* Проверяем не истекло ли время действия числа-вопроса */
        if( ( $row->lastdate + 300 ) < time() or $row->lastdate == 0 )
        {
            $result = $db->sql_15( $email, $newNumber );
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_13();
            return;
        }
        
        /* Проверяем введённое число-ответ */
        if( isset( $_POST['answer'] ) and Valid::number_answer( trim( $_POST['answer'] ) ) )
        {
            $answer_from_user = (int) trim( $_POST['answer'] );
        }
        else
        {
            $result = $db->sql_15( $email, $newNumber );
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_14();
            return;
        }
        
        /* Рассчитываем верное число-ответ */
        $answer_from_system = (int) Library::generateNumber_Answer( $row->lastnum, Library::deCode( $row->code ) ) ;
        
        /* Проверяем соотвествие */
        if( $answer_from_system != $answer_from_user )
        {
            $result = $db->sql_15( $email, $newNumber );
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_15();
            if( $row->noticefalse == 1 )
            {
                Messages::send_7( $email );
            }
            return;
        }
        else
        {
            if( $row->noticetrue == 1 )
            {
                Messages::send_6( $email );
            }
        }
        
        /* Говорим, что код использовали */
        $result = $db->sql_16( $email );
        
        /* Формируем временные коды */
        $key1 = rand( 0, 999999999999 );
        $key2 = sha1( $key1.'/11-'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        
        /* Ставим куку с кодом */
        $https = ( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' ) ? true : false;
        setcookie( 'setting_alerts', $key1, 0, '/', '', $https );
        
        /* Проверяем, не было ли заявок на смену e-mail'a */
        $result = $db->sql_30( $email );
        if( $result->fetchColumn() > 0 )
        {
            $result = $db->sql_32( $email, $key2 );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка обновления таблицы cache: $email , $key2 ".$result->rowCount(), '701', __FILE__, __LINE__ );
                xData::$page_view = 'none';
                return;
            }
        }
        else
        {
            $result = $db->sql_31( $email, $key2 );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка вставки новой строки в таблицу cache: $email , $key2 ".$result->rowCount(), '701', __FILE__, __LINE__ );
                xData::$page_view = 'none';
                return;
            }
        }
        xData::$use_true = $row->noticetrue;
        xData::$use_false = $row->noticefalse;
        xData::$page_view = 'third';
    }
    public function sendDataStep3()////////////////////////////////////////////////////////////////////
    {
        xData::$page_view = 'third';
        
        /* Проверяем введённый e-mail адрес */
        if( isset( $_POST['email'] ) and Valid::email( trim( $_POST['email'] ) ) )
        {
            $email = strtolower( trim( $_POST['email'] ) );
            xData::$email =& $email;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            xData::$page_view = 'none';
            return;
        }
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем, есть ли такой e-mail в системе, если есть то извлекаем информацию */
        $result = $db->sql_1( $email );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            xData::$page_view = 'none';
            return;
        }
        else
        {
            $result = $db->sql_14( $email );
            $row = $result->fetchObject();
        }
        
        xData::$use_true = $row->noticetrue;
        xData::$use_false = $row->noticefalse;
        
        /* Проверяем наличие кук */
        if( !isset( $_COOKIE['setting_alerts'] ) or empty( $_COOKIE['setting_alerts'] ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Генерируем временный код */
        $key = sha1( $_COOKIE['setting_alerts'].'/11-'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        
        /* Проверяем наличие записи в БД соответствующей email'y и кукам' */
        $result = $db->sql_33( $email, $key );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        if( isset( $_POST['use_true'] ) and $_POST['use_true'] == 1 )
        {
            $use_true = 1;
        }
        else
        {
            $use_true = 0;
        }
        
        if( isset( $_POST['use_false'] ) and $_POST['use_false'] == 1 )
        {
            $use_false = 1;
        }
        else
        {
            $use_false = 0;
        }
        
        $result = $db->sql_34( $email, $use_true, $use_false );
        if ( $result->rowCount() != 1 and !( $row->noticetrue == $use_true and $row->noticefalse == $use_false ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления таблицы cache: $email, $use_true, $use_false, ".$result->rowCount(), '701', __FILE__, __LINE__ );
            xData::$page_view = 'none';
            return;
        }
        
        /* Удаляем запись из таблицы cache */
        $result = $db->sql_35( $email );
        if ( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_4();
            xData::$page_view = 'none';
            errorsInFile( "Ошибка удаления строки из таблицы cache: $email ".$result->rowCount(), '701', __FILE__, __LINE__ );
            return;
        }
        /* Ставим куку с кодом */
        $https = ( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' ) ? true : false;
        setcookie( 'setting_alerts', '-0', time() - 300, '/', '', $https );
        
        xData::$use_notice = true;
        xData::$notice_status = 'success';
        xData::$notice_text = Notices::n_21();
        xData::$page_view = 'none';
    }
    public function printdata()
    {
        return new xData;
    }
}
?>