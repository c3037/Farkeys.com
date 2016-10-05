<?php
/**
* @author Dmitry Porozhnyakov
*/
class Messages
{
    public static $headers;
    public static $signature;
    public static function setVars()
    {
        $from = Data::$service_name;
        $fromMail = Config::getVar( 'service_mail' );
        
        self::$headers = "Content-type: text/html; charset=utf-8\r\nFrom: $from <$fromMail >";
        self::$signature = '<br><br>С уважением, команда проекта '.Data::$second_service_name;
    }
    public static function send_1( $email, $key )
    {
        self::setVars();
        $type = 'reg_temp';
        
        $subject = Data::$service_name.' : подтверждение регистрации';
        $message = 'Здравствуйте!<br><br>'.
        'Для завершения процесса регистрации перейдите по ссылке:<br><br>'.
        '<a href="'.SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key\" title=\"\">".
        SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key</a><br><br>".
        "Эта ссылка будет работать в течение 2-х суток. ".
        "Если вы не регистрировались на нашем сервисе, просто проигнорируйте это сообщение.".
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_2( $email, $activationCode, $id )
    {
        self::setVars();
        
        $subject = Data::$service_name.' : код активации';
        $message = 'Здравствуйте!<br><br>'.
        'Вы успешно зарегистрировались в системе '.Data::$service_name.'.<br><br>'.
        "Ваш код активации: $activationCode<br><br>".
        "Ваш FARKeys ID (идентификатор, присвоенный вам в проекте): $id<br><br>".
        '<strong>Внимание!!!</strong><br><br>'.
        'Никому не сообщайте эти данные, так как от них зависит безопасность вашего аккаунта.<br>'.
        'Мы рекомендуем сразу после ввода кода активации в мобильное приложение удалить это сообщение.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_3( $email, $key )
    {
        self::setVars();
        $type = 'change_ac_temp';
        
        $subject = Data::$service_name.' : изменение кода активации';
        $message = 'Здравствуйте!<br><br>'.
        'Для вашего e-mail адреса была подана заявка на смену кода активации.<br><br>'.
        'Для продолжения процедуры изменения, перейдите по ссылке:<br><br>'.
        '<a href="'.SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key\" title=\"\">".
        SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key</a><br><br>".
        "Эта ссылка будет работать в течение 2-х суток. ".
        "Если вы не запрашивали изменение кода активации, просто проигнорируйте это сообщение.".
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_4( $email, $activationCode, $id )
    {
        self::setVars();
        
        $subject = Data::$service_name.' : новый код активации';
        $message = 'Здравствуйте!<br><br>'.
        'Код активации в проекте '.Data::$second_service_name.' успешно изменён.<br><br>'.
        "Ваш <strong>новый</strong> код активации: $activationCode<br><br>".
        "Ваш FARKeys ID (идентификатор, присвоенный вам в проекте): $id<br><br>".
        '<strong>Внимание!!!</strong><br><br>'.
        'Никому не сообщайте эти данные, так как от них зависит безопасность вашего аккаунта.<br>'.
        'Мы рекомендуем сразу после ввода кода активации в мобильное приложение удалить это сообщение.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_5( $email, $key, $new_email )
    {
        self::setVars();
        $type = 'change_email';
        
        $subject = Data::$service_name.' : изменение управляющего e-mail адреса';
        $message = 'Здравствуйте!<br><br>'.
        'Для завершения процесса изменения управляющего e-mail адреса перейдите по ссылке:<br><br>'.
        '<a href="'.SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key&new=$new_email\" title=\"\">".
        SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key&new=$new_email</a><br><br>".
        "Эта ссылка будет работать в течение 2-х суток. ".
        "Если вы не инициировали процедуру изменения управляющего e-mail адреса, просто проигнорируйте это сообщение.".
        self::$signature;
        
        $m = mail( $new_email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_6( $email, $service = 'FARKeys.com' )
    {
        self::setVars();
        
        $subject = Data::$service_name.' : успешная авторизация';
        $message = Data::$service_name.' оповещает вас об успешной авторизации.<br><br>'.
        "E-mail: ".$email.'<br>'.
        "Сервис: ".$service.'<br>'.
        "IP-адрес: ".$_SERVER['REMOTE_ADDR'].'<br>'.
        "Дата и время: ".date( 'M-d-Y H:i:s', time()).' UTC<br><br>'.
        'Изменить настройки оповещений вы можете на сайте проекта.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_7( $email, $service = 'FARKeys.com' )
    {
        self::setVars();
        
        $subject = Data::$service_name.' : НЕУДАЧНАЯ попытка авторизации';
        $message = 'Внимание! '.Data::$service_name.' оповещает вас о НЕУДАЧНОЙ попытке авторизации!<br><br>'.
        "E-mail: ".$email.'<br>'.
        "Сервис: ".$service.'<br>'.
        "IP-адрес: ".$_SERVER['REMOTE_ADDR'].'<br>'.
        "Дата и время: ".date( 'M-d-Y H:i:s', time()).' UTC<br><br>'.
        'Изменить настройки оповещений вы можете на сайте проекта.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_8( $email, $key )
    {
        self::setVars();
        $type = 'reg_partners_temp';
        
        $subject = Data::$service_name.' API : подтверждение регистрации';
        $message = 'Здравствуйте!<br><br>'.
        'Для завершения процесса регистрации перейдите по ссылке:<br><br>'.
        '<a href="'.SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key\" title=\"\">".
        SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key</a><br><br>".
        "Эта ссылка будет работать в течение 2-х суток. ".
        "Если вы не регистрировались на нашем сервисе, просто проигнорируйте это сообщение.".
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_9( $email, $password, $id )
    {
        self::setVars();
        
        $subject = Data::$service_name.' API : пароль для доступа к сервису';
        $message = 'Здравствуйте!<br><br>'.
        'Вы успешно зарегистрировались в системе '.Data::$service_name.'.<br><br>'.
        "Ваш пароль для входа: $password<br><br>".
        "Ваш API ID (идентификатор, присвоенный вам в проекте): $id<br><br>".
        '<strong>Внимание!!!</strong><br><br>'.
        'Никому не сообщайте эти данные, так как от них зависит безопасность вашего аккаунта.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_10( $email, $key )
    {
        self::setVars();
        $type = 'change_password';
        
        $subject = Data::$service_name.' API : изменение пароля';
        $message = 'Здравствуйте!<br><br>'.
        'Для вашего e-mail адреса была подана заявка на смену пароля.<br><br>'.
        'Для продолжения процедуры изменения, перейдите по ссылке:<br><br>'.
        '<a href="'.SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key\" title=\"\">".
        SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key</a><br><br>".
        "Эта ссылка будет работать в течение 2-х суток. ".
        "Если вы не запрашивали процедуру изменения пароля, просто проигнорируйте это сообщение.".
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_11( $email, $password, $id )
    {
        self::setVars();
        
        $subject = Data::$service_name.' : новый пароль для доступа к сервису';
        $message = 'Здравствуйте!<br><br>'.
        'Ваш пароль в проекте '.Data::$second_service_name.' успешно изменён.<br><br>'.
        "Ваш <strong>новый</strong> пароль: $password<br><br>".
        "Ваш API ID (идентификатор, присвоенный вам в проекте): $id<br><br>".
        '<strong>Внимание!!!</strong><br><br>'.
        'Никому не сообщайте эти данные, так как от них зависит безопасность вашего аккаунта.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_12( $email, $id )
    {
        self::setVars();
        
        $subject = Data::$service_name.' API : восстановление API ID';
        $message = 'Здравствуйте!<br><br>'.
        'Для вашего e-mail адреса была запрошена процедура восстановления API ID.<br><br>'.
        "Ваш API ID (идентификатор, присвоенный вам в проекте): $id".
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_13( $email, $key, $new_email )
    {
        self::setVars();
        $type = 'change_info_email_temp';
        
        $subject = Data::$service_name.' API : изменение e-mail адреса';
        $message = 'Здравствуйте!<br><br>'.
        'Для завершения процесса изменения управляющего e-mail адреса перейдите по ссылке:<br><br>'.
        '<a href="'.SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key&new=$new_email\" title=\"\">".
        SystemData::$site."/int/confirm".SystemData::$slash."?type=$type&mail=$email&key=$key&new=$new_email</a><br><br>".
        "Эта ссылка будет работать в течение 2-х суток. ".
        "Если вы не инициировали процедуру изменения управляющего e-mail адреса, просто проигнорируйте это сообщение.".
        self::$signature;
        
        $m = mail( $new_email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_14( $email )
    {
        self::setVars();
        
        $subject = Data::$service_name.' API : изменение данных';
        $message = 'Здравствуйте!<br><br>'.
        'Ваши данные в проекте '.Data::$second_service_name.' были успешно изменены.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
    public static function send_15( $email )
    {
        Data::$service_name = Config::getVar( 'service_name' );
        Data::$second_service_name = Config::getVar( 'second_service_name' );
        
        self::setVars();
        
        $subject = Data::$service_name.' API';
        $message = 'Your account has been deleted.'.
        self::$signature;
        
        $m = mail( $email, $subject, $message, self::$headers );
        return $m;
    }
}
?>