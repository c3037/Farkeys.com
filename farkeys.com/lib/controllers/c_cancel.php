<?php
/**
* @author Dmitry Porozhnyakov
*/
class Controller
{
    public function __construct()
    {
        $main = new Main( '/login/cancel' );
        
        //require_once( VIEW.'/'.SystemData::$folder.'/messages.php' );
        require_once( VIEW.'/'.SystemData::$folder.'/notices.php' );
        
        $data = $this->model();
        $this->view( $data );
    }
    public function model()
    {
        require_once( MODL.'/m_cancel.php' );
        $model = new Model();
        return $model->printdata();
    }
    public function view( $data )
    {
        require_once( VIEW.'/'.SystemData::$folder.'/v_cancel.php' );
    }
}
?>