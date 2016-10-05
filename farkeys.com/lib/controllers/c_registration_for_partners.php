<?php
/**
* @author Dmitry Porozhnyakov
*/
class Controller
{
    public function __construct()
    {
        $main = new Main( '/for-partners/registration' );
        
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
        require_once( MODL.'/m_registration_for_partners.php' );
        $model = new Model();
        if( isset( $_POST['query'] ) and !empty( $_POST['query'] ) )
        {
            $model->sendData();
        }
        return $model->printdata();
    }
    public function view( $data )
    {
        require_once( VIEW.'/'.SystemData::$folder.'/v_registration_for_partners.php' );
    }
}
?>