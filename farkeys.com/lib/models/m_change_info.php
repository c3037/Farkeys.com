<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice;
    public static $notice_status = 'error';
    public static $notice_text;
    public static $id;
    public static $page_view = 'first';
    public static $email;
    public static $name;
    public static $success;
    public static $fail;
    public static $use_amp;
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
    public function sendDataStep1()
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
            xData::$notice_text = Notices::n_30();
            return;
        }
        
        /* Проверяем введённые переменные - пароль */
        if( isset( $_POST['password'] ) )
        {
            $_POST['password'] = trim( $_POST['password'] );
            
            if( !empty( $_POST['password'] ) )
            {
                $password = Library::generateHashOfActivationCode( $_POST['password'] );
            }
            else
            {
                goto password;
            }
        }
        else
        {
            password:
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_31();
            return;
        }
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем, есть ли такой ID, если есть, то извлекаем информацию */
        $result = $db->sql_36( $email );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_9();
            return;
        }
        else
        {
            $row = $db->sql_49( $email )->fetchObject();
        }
        
        /* Сравнение паролей */
        if( $row->password != Library::enCode( $password ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_32();
            return;
        }
        
        /* Формируем временные коды */
        $key1 = rand( 0, 999999999999 );
        $key2 = sha1( $key1.'/13*-'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        
        /* Ставим куку с кодом */
        $https = ( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' ) ? true : false;
        setcookie( 'change_info', $key1, 0, '/', '', $https );
        
        /* Проверяем, не было ли заявок на смену */
        $result = $db->sql_50( $email );
        if( $result->fetchColumn() > 0 )
        {
            $result = $db->sql_52( $email, $key2 );
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
            $result = $db->sql_51( $email, $key2 );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка вставки новой строки в таблицу cache: $email , $key2 ".$result->rowCount(), '701', __FILE__, __LINE__ );
                xData::$page_view = 'none';
                return;
            }
        }
        
        xData::$name = $row->name;
        xData::$id = $row->email;
        xData::$success = base64_decode( $row->success );
        xData::$fail = base64_decode( $row->fail );
        xData::$use_amp = $row->amp;
        xData::$page_view = 'second';
    }
    public function sendDataStep2()
    {
        xData::$page_view = 'second';
        /* Проверяем введённый e-mail адрес */
        if( isset( $_POST['id'] ) and Valid::email( trim( $_POST['id'] ) ) )
        {
            $id = strtolower( trim( $_POST['id'] ) );
            xData::$id =& $id;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Проверяем наличие кук */
        if( !isset( $_COOKIE['change_info'] ) or empty( $_COOKIE['change_info'] ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Генерируем временный код */
        $key = sha1( $_COOKIE['change_info'].'/13*-'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] );
        
        /* Подключаемся к базе данных */
        $db = new DataBase();
        
        /* Проверяем наличие записи в БД соответствующей email'y и кукам' */
        $result = $db->sql_53( $id, $key );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_16();
            xData::$page_view = 'first';
            return;
        }
        
        /* Извлекаем информацию из базы */
        $row = $db->sql_49( $id )->fetchObject();
        
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
            if( $email != $row->email )
            {
                $result = $db->sql_36( $email );
                if( $result->fetchColumn() != 0 )
                {
                    $notice = ( $notice == 0 ) ? 3 : $notice;
                }
            }
        }
        else
        {
            $notice = ( $notice == 0 ) ? 2 : $notice;
        }
        
        if( isset( $_POST['success_url'] ) )
        {
            $_POST['success_url'] = trim( $_POST['success_url'] );
            if( Valid::SuccessAndFailURL( $_POST['success_url'] ) )
            {
                $success = htmlentities( $_POST['success_url'] , ENT_QUOTES, 'UTF-8' );
                xData::$success = $success;
                $success = base64_encode( $success );
            }
            else
            {
                goto success_url;
            }
        }
        else
        {
            success_url:
            $notice = ( $notice == 0 ) ? 4 : $notice;
        }
            
        if( isset( $_POST['fail_url'] ) )
        {
            $_POST['fail_url'] = trim( $_POST['fail_url'] );
            if( Valid::SuccessAndFailURL( $_POST['fail_url'] ) )
            {
                $fail = htmlentities( $_POST['fail_url'] , ENT_QUOTES, 'UTF-8' );
                xData::$fail = $fail;
                $fail = base64_encode( $fail );
            }
            else
            {
                goto fail_url;
            }
        }
        else
        {
            fail_url:
            $notice = ( $notice == 0 ) ? 5 : $notice;
        }
            
        if( isset( $_POST['use_amp'] ) and $_POST['use_amp'] == 1 )
        {
            $use_amp = 1;
            xData::$use_amp =& $use_amp;
        }
        else
        {
            $use_amp = 0;
            xData::$use_amp =& $use_amp;
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
        elseif( $notice == 3 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_3();
            return;
        }
        elseif( $notice == 4 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_24();
            return;
        }
        elseif( $notice == 5 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_25();
            return;
        }
        
        if( $name != $row->name or $success != $row->success or $fail != $row->fail or  $use_amp != $row->amp )
        {
            $result = $db->sql_54( $id, $name, $success, $fail, $use_amp );
            if ( $result->rowCount() != 1 )
            {
                xData::$use_notice = true;
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка обновления таблицы cache: $id, $name, base64_encode( $success ), base64_encode( $fail ), $use_amp ".$result->rowCount(), '701', __FILE__, __LINE__ );
                xData::$page_view = 'none';
                return;
            }
            
            /* Отправляем почту */
            $mail = Messages::send_14( $id );
                
            if( !$mail )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка отправки письма : $id, $mail ", '701', __FILE__, __LINE__ );
            }
        }
        
        if( $email != $row->email )
        {
            /* Генерируем код подтверждения */
            $key = hash('sha256', "<nm>".rand(1,999999999999999)."</nm>");
            
            /* Проверяем, не было ли заявок на смену с этого e-mail'a */
            $result = $db->sql_55( $id );
            if( $result->fetchColumn() > 0 )
            {
                $result = $db->sql_56( $id, $key, $email );
                if ( $result->rowCount() != 1 )
                {
                    xData::$use_notice = true;
                    xData::$notice_status = 'error';
                    xData::$notice_text = Notices::n_4();
                    errorsInFile( "Ошибка обновления таблицы cache: $id, $key, $email, ".$result->rowCount(), '701', __FILE__, __LINE__ );
                    return;
                }
            }
            else
            {
                $result = $db->sql_57( $id, $key, $email );
                if ( $result->rowCount() != 1 )
                {
                    xData::$use_notice = true;
                    xData::$notice_status = 'error';
                    xData::$notice_text = Notices::n_4();
                    errorsInFile( "Ошибка вставки новой строки в таблицу cache: $id, $key, $email, ".$result->rowCount(), '701', __FILE__, __LINE__ );
                    return;
                }
            }
            
            /* Отправляем почту */
            $mail = Messages::send_13( $id, $key, $email );
            
            if( !$mail )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_4();
                errorsInFile( "Ошибка отправки письма : $id, $key, $email, $mail ", '701', __FILE__, __LINE__ );
            }
        }
        
        $result = $db->sql_58( $id );
        if ( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления таблицы cache: $id, $key, $email, ".$result->rowCount(), '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Ставим куку с кодом */
        $https = ( isset( $_SERVER['HTTPS'] ) and $_SERVER['HTTPS'] != 'off' ) ? true : false;
        setcookie( 'change_info', '-0', time() - 300, '/', '', $https );
        
        
        if( $email != $row->email )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_34();
            xData::$page_view = 'none';
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_33();
            xData::$page_view = 'none';
        }
    }
    public function printdata()
    {
        return new xData;
    }
}
?>