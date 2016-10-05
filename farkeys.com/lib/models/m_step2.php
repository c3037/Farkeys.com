<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    public static $use_notice = false;
    public static $notice_status = 'error';
    public static $notice_text;
    public static $step = 'first';
    public static $api = 'none';
    public static $user = 'none';
    public static $number_Question;
    public static $license;
}
class Model
{
    private $db;
    private $oi;
    private $user;
    private $api;
    private $err = 0;
    public function __construct()
    {
        //$this->db = new DataBase();
        //$db =& $this->db;
        //Valid::n();
        
         Header( "Pragma: no-cache" );
         Header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )."GMT" );
         header( "Cache-Control: no-store, no-cache, must-revalidate" );
         header( "Expires: " . date( "r" ) );
        
        /* Проверяем введённые переменные */
        if( !isset( $_GET['oi'] ) or !Valid::number( trim( $_GET['oi'] ) ) )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            xData::$step = false;
            $this->err = 1;
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
        if( $result == 'noValues' )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_12();
            xData::$step = false;
            $this->err = 1;
            return;
        }
        else
            $row = $result->fetchObject();
        
        xData::$links['login_cancel'] .= '?oi='.$id;
        xData::$links['login_step1'] .= '?oi='.$id;
        xData::$links['login_step2'] .= '?oi='.$id;
        
        if ( $row->user == 0 )
        {
            header( 'Location: '.Data::$links['login_step1'] );
            exit;
        }
        
        /* Выводим API Name */
        $result = $db->sql_64( $row->api );
        $row_api = $result->fetchObject();
        $this->api =& $row_api;
        xData::$api = $row_api->name;
        
        /* Лицензия */
        if( Config::getVar( 'check_license' ) == 'yes' )
            xData::$license = ( $row_api->licensed == 0 ) ? 'no' : 'yes';
        
        /* Информация о пользователе */
        $result = $db->sql_66( $row->user );
        $row_user = $result->fetchObject();
        $this->user =& $row_user;
        xData::$user = $row_user->email;
        
        /* Формируем новое значение числа-вопроса */
        xData::$number_Question = ( substr( $row_user->lastnum, 0, -2 ) + 1 ).Library::generateNumberCode( 2 );
    }
    public function start()
    {
        if( $this->err == 1 )
            return;
        $db =& $this->db;
        /* Заносим число в БД */
        $result = $db->sql_15( xData::$user, xData::$number_Question );
        if( $result->rowCount() != 1 )
        {
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_4();
            errorsInFile( "Ошибка обновления строки в таблице users: ",$result->rowCount(), '701', __FILE__, __LINE__ );
            return;
        }
    }
    public function sendData()
    {
        if( $this->err == 1 )
            return;
        $row =& $this->user;
        $db =& $this->db; 
        /* Проверяем не истекло ли время действия числа-вопроса */
        if( ( $row->lastdate + 300 ) < time() or $row->lastdate == 0 )
        {
            $result = $db->sql_15( xData::$user, xData::$number_Question );
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
            $result = $db->sql_15( xData::$user, xData::$number_Question );
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_14();
            return;
        }
        
        /* Рассчитываем верное число-ответ */
        $answer_from_system = (int) Library::generateNumber_Answer( $row->lastnum, Library::deCode( $row->code ) ) ;
        
        /* Проверяем соотвествие */
        if( $answer_from_system != $answer_from_user )
        {
            $result = $db->sql_15( xData::$user, xData::$number_Question );
            xData::$use_notice = true;
            xData::$notice_text = Notices::n_15();
            if( $row->noticefalse == 1 )
            {
                Messages::send_7( $row->email, xData::$api );
            }
            return;
        }
        else
        {
            if( $row->noticetrue == 1 )
            {
                Messages::send_6( $row->email, xData::$api );
            }
        }
        
        /* Говорим, что код использовали */
        $result = $db->sql_16( $row->email );
        
        $sk = rand( 1, 9 ).rand( 1, 9 ).rand( 1, 9 ).rand( 1, 9 ).rand( 1, 9 );
        
        /* Изменяем статус заявки */
        $result = $db->sql_67( $this->oi, $sk );
        
        $api =& $this->api;
        if( $api->amp == 1 )
        {
            header( 'Location: '.base64_decode( $api->success ).'&oi='.$this->oi.'&sk='.$sk );
        }
        else
        {
            header( 'Location: '.base64_decode( $api->success ).'?oi='.$this->oi.'&sk='.$sk );
        }
        exit;
    }
    public function printdata()
    {
        return new xData;
    }
}
?>