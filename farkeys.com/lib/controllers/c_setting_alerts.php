<?php
/**
* @author Dmitry Porozhnyakov
*/
class Controller
{
    public function __construct()
    {
        $main = new Main( '/for-users/setting-alerts' );
        
        if( isset( $_POST['query'] ) and !empty( $_POST['query'] ) )
        {
            require_once( VIEW.'/'.SystemData::$folder.'/messages.php' );
            require_once( VIEW.'/'.SystemData::$folder.'/notices.php' );
        }
        
        $data = $this->model();
        $this->view( $data );
    }
    public function model()
    {
        require_once( MODL.'/m_setting_alerts.php' );
        $model = new Model();
        if( isset( $_POST['query'] ) and !empty( $_POST['query'] ) and $_POST['query'] == 1 )
        {
            $model->sendDataStep1();
        }
        elseif( isset( $_POST['query'] ) and !empty( $_POST['query'] ) and $_POST['query'] == 2 )
        {
            $model->sendDataStep2();
        }
        elseif( isset( $_POST['query'] ) and !empty( $_POST['query'] ) and $_POST['query'] == 3 )
        {
            $model->sendDataStep3();
        }
        return $model->printdata();
    }
    public function view( $data )
    {
        require_once( VIEW.'/'.SystemData::$folder.'/v_setting_alerts.php' );
    }
}
?>