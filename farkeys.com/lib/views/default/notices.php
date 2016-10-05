<?php
/**
* @author Dmitry Porozhnyakov
*/
class Notices
{
    public static function n_1()
    {
        return 'Ошибка: поле "Введите ваше имя" не заполнено или заполнено неверно';
    }
    public static function n_2()
    {
        return 'Ошибка: поле "Введите ваш e-mail адрес" не заполнено или заполнено неверно';
    }
    public static function n_3()
    {
        return 'Ошибка: указанный e-mail адрес уже используется';
    }
    public static function n_4()
    {
        return 'Неизвестная ошибка, попробуйте повторить операцию позднее';
    }
    public static function n_5()
    {
        return 'На указанный email адрес выслано письмо подтверждения.<br />Для завершения процедуры регистрации, перейдите по указанной в нём ссылке.';
    }
    public static function n_6()
    {
        return 'Ошибка: поле "Введите контрольный вопрос" не заполнено или заполнено неверно';
    }
    public static function n_7()
    {
        return 'Ошибка: поле "Введите ответ на контрольный вопрос" не заполнено или заполнено неверно';
    }
    public static function n_8()
    {
        return 'Регистрация успешно завершена. На ваш e-mail отправлен код активации.';
    }
    public static function n_9()
    {
        return 'Ошибка: введённый e-mail адрес в системе не зарегистрирован';
    }
    public static function n_10()
    {
        return 'На указанный email адрес выслано письмо подтверждения.<br />Для завершения процедуры изменения кода активации, перейдите по указанной в нём ссылке.';
    }
    public static function n_11()
    {
        return 'Операция успешно завершена. На ваш e-mail адрес отправлен новый код активации.';
    }
    public static function n_12()
    {
        return 'Ошибка в данных, попробуйте повторить операцию позднее';
    }
    public static function n_13()
    {
        return 'Время действия числа-вопроса истекло, повторите попытку';
    }
    public static function n_14()
    {
        return 'Поле "Число-ответ" не заполнено или заполнено неверно';
    }
    public static function n_15()
    {
        return 'Введенное число-ответ неверно';
    }
    public static function n_16()
    {
        return 'Полученные служебные данные не верны, либо устарели. Попробуйте повторить операцию позднее.';
    }
    public static function n_17()
    {
        return 'Ответ на контрольный вопрос не верен';
    }
    public static function n_18()
    {
        return 'Ошибка: поле "Введите новый e-mail адрес" не заполнено или заполнено неверно';
    }
    public static function n_19()
    {
        return 'На указанный email адрес выслано письмо подтверждения.<br />Для завершения процедуры изменения управляющего e-mail адреса, перейдите по указанной в нём ссылке.';
    }
    public static function n_20()
    {
        return 'Смена e-mail адреса произведена успешно.<br />Обратите внимание! Код активации не был изменён.<br /><a href="'.Data::$links['for_users_change_activation_code'].'"><button onclick="document.location=\''.Data::$links['for_users_change_activation_code'].'\'" class="m-top20">Сменить код активации</button></a> ';
    }
    public static function n_21()
    {
        return 'Данные успешно сохранены';
    }
    public static function n_22()
    {
        return 'Ошибка: поле "Имя сервиса" не заполнено или заполнено неверно';
    }
    public static function n_23()
    {
        return 'Ошибка: поле "E-mail адрес сервиса" не заполнено или заполнено неверно';
    }
    public static function n_24()
    {
        return 'Ошибка: поле "Success URL" не заполнено или заполнено неверно';
    }
    public static function n_25()
    {
        return 'Ошибка: поле "Fail URL" не заполнено или заполнено неверно';
    }
    public static function n_26()
    {
        return 'Регистрация успешно завершена. На ваш e-mail адрес высланы пароль и API ID.';
    }
    public static function n_27()
    {
        return 'На указанный email адрес выслано письмо подтверждения.<br />Для завершения процедуры изменения пароля, перейдите по указанной в нём ссылке.';
    }
    public static function n_28()
    {
        return 'Операция успешно завершена. На ваш e-mail адрес отправлен новый пароль для доступа к сервису.';
    }
    public static function n_29()
    {
        return 'На указанный email адрес выслано письмо, содержащее ваш API ID';
    }
    public static function n_30()
    {
        return 'Ошибка: поле "Введите e-mail адрес сервиса" не заполнено или заполнено неверно';
    }
    public static function n_31()
    {
        return 'Ошибка: поле "Введите пароль" не заполнено или заполнено неверно';
    }
    public static function n_32()
    {
        return 'Ошибка: введённый пароль не верен';
    }
    public static function n_33()
    {
        return 'Данные успешно изменены';
    }
    public static function n_34()
    {
        return 'Данные успешно изменены. На указанный новый e-mail адрес выслано письмо подтверждения.<br />Для завершения процедуры изменения e-mail адреса, перейдите по указанной в нём ссылке. ';
    }
    public static function n_35()
    {
        return 'Смена e-mail адреса произведена успешно';
    }
    public static function n_36()
    {
        return 'Ошибка: Неверно введено API ID';
    }
    public static function n_37()
    {
        return 'Ошибка: Введён несуществующий API ID';
    }
}
?>