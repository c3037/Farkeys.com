<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice = false;
    public static $notice_status = 'error';
    public static $notice_text = 'Данные неверны, либо устарели';
    public static $use_reg_form = false;
    public static $use_reg_form_for_partners = false;
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
    public function check_mail_and_key()
    {
        /* Проверяем введённые переменные */
        if ( isset( $_GET['mail'] ) and Valid::email( trim( $_GET['mail'] ) ) )
            $email = trim( $_GET['mail'] );
        else
            return false;
        
        if ( isset( $_GET['key'] ) and Valid::sha256( trim( $_GET['key'] ) ) )
            $key = trim( $_GET['key'] );
        else
            return false;
        
        return array( $email, $key );
    }        
    public function registration_for_users() ////////////////////////////////////////////////////////////////////////
    {
        /* Проверяем введённые переменные */
        $arr = $this->check_mail_and_key();
        if( $arr !== false )
        {
            $email = $arr[0];
            $key = $arr[1];
        }
        else
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Соединяемся с БД */
        $db = new DataBase();
        
        /* Проверяем соответсвие кода - e-mail'у */
        $result = $db->sql_5( $email, $key );
        if( $result === 'noValues' )
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Извлекаем данные из БД */
        $row = $result->fetchObject();
        
        /* Проверяем используется ли уже этот адрес */
        $result = $db->sql_1( $email );
        if( $result->fetchColumn() > 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_3();
            return;
        }
        
        xData::$use_reg_form = true;
            
        /* Если есть отправка формы */
        if ( isset( $_POST['query'] ) and !empty( $_POST['query'] ) )
        {
            /* Проверяем введённые переменные - question */
            if( isset( $_POST['question'] ) )
            {
                $_POST['question'] = trim( $_POST['question'] );
                
                if( !empty( $_POST['question'] ) )
                {
                    $question = base64_encode( htmlspecialchars( strip_tags( $_POST['question'] ), ENT_QUOTES, 'UTF-8' ) );
                }
                else
                {
                    goto question;
                }
            }
            else
            {
                question:
                xData::$use_notice = true;
                xData::$notice_text = Notices::n_6();
                return;
            }
            
            /* Проверяем введённые переменные - answer */
            if( isset( $_POST['answer'] ))
            {
                $_POST['answer'] = mb_strtolower( trim( $_POST['answer'] ), 'UTF-8');
                
                if( !empty( $_POST['answer'] ) )
                {
                    $answer = hash( 'sha512', $_POST['answer'] );
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
        }
        else
            return;
        
        /* Генерируем код активации и его хеш */
        $activationCode = Library::generateActivationCode( 20 );
        $HashOfActivationCode = Library::generateHashOfActivationCode( $activationCode );
        
        /* Создание строки в таблице users */
        $id = $db->sql_6( $row->field2, $row->field3, Library::enCode( $HashOfActivationCode ), $question, $answer );
        if( $id === false )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка cоздание строки в таблице users: $row->field2, $row->field3, 
            Library::enCode( $HashOfActivationCode ), $question, $answer, $id", '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Удаление строки в таблице cache  */
        $result = $db->sql_7( $row->field3 );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка удаления строки в таблице cache: $row->field3, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Разъединение с базой */
        $db = null;
        
        //Отправляем почту
        $mail = Messages::send_2( $row->field3, $activationCode, $id );
        
        if( $mail )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_8();
            xData::$use_reg_form = false;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма с кодом активации: $row->field3 , $activationCode, $id, $mail", 
            '701', __FILE__, __LINE__ );
        }
    }
    public function change_activation_code() ////////////////////////////////////////////////////////////////////////
    {
        /* Проверяем введённые переменные */
        $arr = $this->check_mail_and_key();
        if( $arr !== false )
        {
            $email = $arr[0];
            $key = $arr[1];
        }
        else
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Соединяемся с БД */
        $db = new DataBase();
        
        /* Проверяем соответсвие кода - e-mail'у */
        $result = $db->sql_11( $email, $key );
        if( $result === 'noValues' )
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Извлекаем данные из БД */
        $row = $result->fetchObject();
        
        /* Генерируем код активации и его хеш */
        $activationCode = Library::generateActivationCode( 20 );
        $HashOfActivationCode = Library::generateHashOfActivationCode( $activationCode );
        
        /* Обновление строки в таблице users */
        $id = $db->sql_12( $row->field3, Library::enCode( $HashOfActivationCode ) );
        if( $id === false )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления строки в таблице users: $row->field3, Library::enCode( $HashOfActivationCode ), 
            $id", '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Удаление строки в таблице cache */
        $result = $db->sql_13( $row->field3 );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка удаления строки в таблице cache: $row->field3, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Разъединение с базой */
        $db = null;
        
        //Отправляем почту
        $mail = Messages::send_4( $row->field3, $activationCode, $id );
        
        if( $mail )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_11();
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма с новым кодом активации: $row->field3 , $activationCode, $id, $mail", 
            '701', __FILE__, __LINE__ );
        }
    }
    public function change_email() ////////////////////////////////////////////////////////////////////////
    {
        /* Проверяем введённые переменные */
        $arr = $this->check_mail_and_key();
        
        if ( isset( $_GET['new'] ) and Valid::email( trim( $_GET['new'] ) ) )
            $newMail = trim( $_GET['new'] );
        else
            $newMail = false;
            
        if( $arr !== false and $newMail != false )
        {
            $email = $arr[0];
            $key = $arr[1];
        }
        else
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Соединяемся с БД */
        $db = new DataBase();
        
        /* Проверяем соответсвие кода - e-mail'у */
        $result = $db->sql_27( $email, $key, $newMail );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Проверяем используется ли уже этот адрес */
        $result = $db->sql_1( $newMail );
        if( $result->fetchColumn() > 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_3();
            return;
        }
        
        xData::$use_reg_form = true;
            
        /* Если есть отправка формы */
        if ( isset( $_POST['query'] ) and !empty( $_POST['query'] ) )
        {
            /* Проверяем введённые переменные - question */
            if( isset( $_POST['question'] ) )
            {
                $_POST['question'] = trim( $_POST['question'] );
                
                if( !empty( $_POST['question'] ) )
                {
                    $question = base64_encode( htmlspecialchars( strip_tags( $_POST['question'] ), ENT_QUOTES, 'UTF-8' ) );
                }
                else
                {
                    goto question;
                }
            }
            else
            {
                question:
                xData::$use_notice = true;
                xData::$notice_text = Notices::n_6();
                return;
            }
            
            /* Проверяем введённые переменные - answer */
            if( isset( $_POST['answer'] )  )
            {
                $_POST['answer'] = mb_strtolower( trim( $_POST['answer'] ), 'UTF-8');
                
                if( !empty( $_POST['answer'] ) )
                {
                    $answer = hash( 'sha512', $_POST['answer'] );
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
        }
        else
            return;
        
        /* Обновление строки в таблице users  */
        $result = $db->sql_29( $email, $newMail, $question, $answer );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            xData::$use_reg_form = false;
            errorsInFile( "Ошибка обновления строки в таблице users: $email, $newMail, $question, $answer, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Удаление строк в таблице cache  */
        $result = $db->sql_28( $email );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            xData::$use_reg_form = false;
            errorsInFile( "Ошибка удаления строки в таблице cache: $email, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Разъединение с базой */
        $db = null;
        
        xData::$use_notice = true;
        xData::$notice_status = 'success';
        xData::$notice_text = Notices::n_20();
        xData::$use_reg_form = false;
    }
    public function registration_for_partners() /////////////////////////////////////////////////////////////////////
    {
        /* Проверяем введённые переменные */
        $arr = $this->check_mail_and_key();
        if( $arr !== false )
        {
            $email = $arr[0];
            $key = $arr[1];
        }
        else
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Соединяемся с БД */
        $db = new DataBase();
        
        /* Проверяем соответсвие кода - e-mail'у */
        $result = $db->sql_40( $email, $key );
        if( $result === 'noValues' )
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Извлекаем данные из БД */
        $row = $result->fetchObject();
        
        /* Проверяем используется ли уже этот адрес */
        $result = $db->sql_36( $email );
        if( $result->fetchColumn() > 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_3();
            return;
        }
        
        xData::$use_reg_form_for_partners = true;
        
        if ( isset( $_POST['query'] ) and !empty( $_POST['query'] ) )
        {
            $notice = 0;
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
                $notice = ( $notice == 0 ) ? 1 : $notice;
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
                $notice = ( $notice == 0 ) ? 2 : $notice;
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
                xData::$notice_text = Notices::n_24();
                return;
            }
            elseif( $notice == 2 )
            {
                xData::$use_notice = true;
                xData::$notice_status = 'error';
                xData::$notice_text = Notices::n_25();
                return;
            }
        }
        else
            return;
        
        /* Генерируем пароль и его хеш */
        $password = Library::generateActivationCode( 128 );
        $HashOfPassword = Library::generateHashOfActivationCode( $password );
        
        /* Создание строки в таблице api */
        $id = $db->sql_41( Library::enCode( $HashOfPassword ), $row->field2, $row->field3, $success, $fail , $use_amp );
        if( $id === false )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка cоздание строки в таблице api: Library::enCode( $HashOfPassword ), $row->field2, 
            $row->field3, $success, $fail , $use_amp, $id", '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Удаление строки в таблице cache  */
        $result = $db->sql_42( $row->field3 );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка удаления строки в таблице cache: $row->field3, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Разъединение с базой */
        $db = null;
        
        //Отправляем почту
        $mail = Messages::send_9( $row->field3, $password, $id );
        
        if( $mail )
        {
            xData::$use_amp = '';
            xData::$success = '';
            xData::$fail = '';
            xData::$use_reg_form_for_partners = false;
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_26();
            xData::$use_reg_form = false;
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма с кодом активации: $row->field3, $password, $id, $mail", 
            '701', __FILE__, __LINE__ );
        }
    }
    public function change_password() ////////////////////////////////////////////////////////////////////
    {
        /* Проверяем введённые переменные */
        $arr = $this->check_mail_and_key();
        if( $arr !== false )
        {
            $email = $arr[0];
            $key = $arr[1];
        }
        else
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Соединяемся с БД */
        $db = new DataBase();
        
        /* Проверяем, есть ли такой e-mail в системе */
        $result = $db->sql_36( $email );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Проверяем соответсвие кода - e-mail'у */
        $result = $db->sql_46( $email, $key );
        if( $result === 'noValues' )
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Извлекаем данные из БД */
        $row = $result->fetchObject();
        
        /* Генерируем код активации и его хеш */
        $password = Library::generateActivationCode( 128 );
        $HashOfPassword = Library::generateHashOfActivationCode( $password );
        
        /* Обновление строки в таблице users */
        $id = $db->sql_47( $row->field3, Library::enCode( $HashOfPassword ) );
        if( $id === false )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления строки в таблице api: $row->field3, Library::enCode( $HashOfPassword ), 
            $id", '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Удаление строки в таблице cache */
        $result = $db->sql_48( $row->field3 );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка удаления строки в таблице cache: $row->field3, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Разъединение с базой */
        $db = null;
        
        //Отправляем почту
        $mail = Messages::send_11( $row->field3, $password, $id );
        
        if( $mail )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'success';
            xData::$notice_text = Notices::n_28();
        }
        else
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка отправки письма с новым кодом активации: $row->field3 , $password, $id, $mail", 
            '701', __FILE__, __LINE__ );
        }
    }
    public function change_info_email()
    {
        /* Проверяем введённые переменные */
        $arr = $this->check_mail_and_key();
        
        if ( isset( $_GET['new'] ) and Valid::email( trim( $_GET['new'] ) ) )
            $newMail = trim( $_GET['new'] );
        else
            $newMail = false;
            
        if( $arr !== false and $newMail != false )
        {
            $email = $arr[0];
            $key = $arr[1];
        }
        else
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Соединяемся с БД */
        $db = new DataBase();
        
        /* Проверяем соответсвие кода - e-mail'у */
        $result = $db->sql_59( $email, $key, $newMail );
        if( $result->fetchColumn() == 0 )
        {
            xData::$use_notice = true;
            return;
        }
        
        /* Проверяем используется ли уже этот адрес */
        $result = $db->sql_36( $newMail );
        if( $result->fetchColumn() > 0 )
        {
            xData::$use_notice = true;
            xData::$notice_status = 'error';
            xData::$notice_text = Notices::n_3();
            return;
        }
        
        /* Обновление строки в таблице api  */
        $result = $db->sql_60( $email, $newMail );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления строки в таблице users: $email, $newMail, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Удаление строк в таблице cache  */
        $result = $db->sql_84( $email );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка удаления строки в таблице cache: $email, ".$result->rowCount(), 
            '701', __FILE__, __LINE__ );
            return;
        }
        
        /* Разъединение с базой */
        $db = null;
        
        xData::$use_notice = true;
        xData::$notice_status = 'success';
        xData::$notice_text = Notices::n_35();
    }
    public function printdata()
    {
        return new xData;
    }
}
?>