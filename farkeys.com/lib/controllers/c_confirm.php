<?php
/**
* @author Dmitry Porozhnyakov
*/
class Controller
{
    public function __construct()
    {
        $main = new Main( '/int/confirm' );
        
        /* Проверяем есть ли указание типа проверки */
        if( !isset( $_GET['type'] ) or empty( $_GET['type'] ) )
        {
            header( 'Location: /?redirect' );
            exit;
        }
        
        require_once( VIEW.'/'.SystemData::$folder.'/messages.php' );
        require_once( VIEW.'/'.SystemData::$folder.'/notices.php' );
        
        $data = $this->model();
        $this->view( $data );
    }
    public function model()
    {
        require_once( MODL.'/m_confirm.php' );
        $model = new Model();
        switch ( $_GET['type'] )
        {
            case 'reg_temp':
                $model->registration_for_users();
            break;
            case 'change_ac_temp':
                $model->change_activation_code();
            break;
            case 'change_email':
                $model->change_email();
            break;
            case 'reg_partners_temp':
                $model->registration_for_partners();
            break;
            case 'change_password':
                $model->change_password();
            break;
            case 'change_info_email_temp':
                $model->change_info_email();
            break;
            default:
                header( 'Location: /?redirect' );
                exit;
            break;
        }
        return $model->printdata();
    }
    public function view( $data )
    {
        require_once( VIEW.'/'.SystemData::$folder.'/v_confirm.php' );
    }
}
?>