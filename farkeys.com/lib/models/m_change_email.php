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
    public static $text_Question;
    public static $new_email;
}
class Model
{
    //private $db;
    public function __construct()
    {
        Header("Pragma: no-cache");
        Header("Last-Modified: ".gmdate("D, d M Y H:i:s")."GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Expires: " . date("r"));
        //$this->db = new DataBase();
        //$db =& $this->db;
        //Valid::n();
    }
    public function sendDataStep1()////////////////////////////////////////////////////////////////////
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
    public function sendDataStep2()////////////////////////////////////////////////////////////////////
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
        setcookie( 'change_email_key', $key1, 0, '/', '', $https );
        
        /* Проверяем, не было ли заявок на смену e-mail'a */
        $result = $db->sql_17( $email );
        if( $result->fetchColumn() > 0 )
        {
            $result = $db->sql_19( $email, $key2 );
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
            $result = $db->sql_18( $email, $key2 );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка вставки новой строки в таблицу cache: $email , $key2 ".$result->rowCount(), '701', __FILE__, __LINE__ );
                xData::$page_view = 'none';
                return;
            }
        }
        xData::$text_Question = base64_decode( $row->question );
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
        
        /* Текст вопроса */
        xData::$text_Question = base64_decode( $row->question );
        
        /* Проверяем наличие кук */
        if( !isset( $_COOKIE['change_email_key'] ) or empty( $_COOKIE['change_email_key'] ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Генерируем временный код */
        $key = sha1( $_COOKIE['change_email_key'].'/11-'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        
        /* Проверяем наличие записи в БД соответствующей email'y и кукам' */
        $result = $db->sql_20( $email, $key );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Проверяем введённые переменные - answer */
        if( isset( $_POST['answer_on_question'] ))
        {
            $_POST['answer_on_question'] = mb_strtolower( trim( $_POST['answer_on_question'] ), 'UTF-8');
        
            if( !empty( $_POST['answer_on_question'] ) )
            {
                $answer = hash( 'sha512', $_POST['answer_on_question'] );
            }
            else
            {
                goto answer;
            }
        }
        else
        {
            answer:
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_7();
            return;
        }
        
        /* Проверяем соотвествие */
        if( strtolower( $answer ) != strtolower( $row->answer ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_17();
            return;
        }
        
        /* Формируем временные коды */
        $key1 = rand( 0, 999999999999 );
        $key2 = sha1( $key1.'/11-'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        
        /* Ставим куку с кодом */
        $https = ( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' ) ? true : false;
        setcookie( 'change_email_key', '-0', time() - 300, '/', '', $https );
        setcookie( 'change_email_key_2', $key1, 0, '/', '', $https );
        
        /* Шаг выполнен */
        $result = $db->sql_21( $email, $key, $key2 );
        if ( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления таблицы cache: $email , $key ".$result->rowCount(), '701', __FILE__, __LINE__ );
            xData::$page_view = 'none';
            return;
        }
        
        xData::$page_view = 'fourth';
    }
    public function sendDataStep4()////////////////////////////////////////////////////////////////////
    {
        xData::$page_view = 'fourth';
        
        /* Проверяем старый e-mail адрес */
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
        
        /* Проверяем наличие кук */
        if( !isset( $_COOKIE['change_email_key_2'] ) or empty( $_COOKIE['change_email_key_2'] ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Генерируем временный код */
        $key = sha1( $_COOKIE['change_email_key_2'].'/11-'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        
        /* Проверяем наличие записи в БД соответствующей email'y и кукам' */
        $result = $db->sql_22( $email, $key );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Проверяем новый e-mail адрес */
        if( isset( $_POST['new_email'] ) and Valid::email( trim( $_POST['new_email'] ) ) )
        {
            $new_email = strtolower( trim( $_POST['new_email'] ) );
            xData::$new_email =& $new_email;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_18();
            return;
        }
        
        /* Проверяем, не используется ли уже этот e-mail*/
        $result = $db->sql_1( $new_email );
        if( $result->fetchColumn() > 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_3();
            return;
        }
        
        /* Генерируем код подтверждения */
        $key = hash( 'sha256', '<3nm>'.rand( 1, 999999999999999 ).'</nm>' );
        
        /* Проверяем, не было ли заявок на смену с этого e-mail'a */
        $result = $db->sql_23( $email );
        if( $result->fetchColumn() > 0 )
        {
            $result = $db->sql_24( $email, $key, $new_email );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                xData::$page_view = 'none';
                errorsInFile( "Ошибка обновления таблицы cache: $email , $key , $new_email, ".$result->rowCount(), '701', __FILE__, __LINE__ );
                return;
            }
        }
        else
        {
            $result = $db->sql_25( $email, $key, $new_email );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                xData::$page_view = 'none';
                errorsInFile( "Ошибка вставки новой строки в таблицу cache: $email , $key , $new_email, ".$result->rowCount(), '701', __FILE__, __LINE__ );
                return;
            }
        }
        
        /* Удаляем запись из таблицы cache */
        $result = $db->sql_26( $email );
        if ( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_4();
            xData::$page_view = 'none';
            errorsInFile( "Ошибка удаления строки из таблицы cache: $email ".$result->rowCount(), '701', __FILE__, __LINE__ );
            return;
        }
        $https = ( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' ) ? true : false;
        setcookie( 'change_email_key_2', '-0', time() - 300, '/', '', $https );
        
        /* Отправляем почту */
        $mail = Messages::send_5( $email, $key, $new_email );
        
        if( $mail )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_19();
            xData::$page_view = 'none';
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма регистрации: $email, $key, $new_email, $mail ", '701', __FILE__, __LINE__ );
            xData::$page_view = 'none';
        }
    }
    public function printdata()
    {
        return new xData;
    }
}
?>