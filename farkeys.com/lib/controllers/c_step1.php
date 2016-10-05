<?php
/**
* @author Dmitry Porozhnyakov
*/
class Controller
{
    public function __construct()
    {
        $main = new Main( '/login/step-one' );
        
        //require_once( VIEW.'/'.SystemData::$folder.'/messages.php' );
        require_once( VIEW.'/'.SystemData::$folder.'/notices.php' );
        
        $data = $this->model();
        $this->view( $data );
    }
    public function model()
    {
        require_once( MODL.'/m_step1.php' );
        $model = new Model();
        if( isset( $_POST['query'] ) and !empty( $_POST['query'] ) )
        {
            $model->sendData();
        }
        return $model->printdata();
    }
    public function view( $data )
    {
        require_once( VIEW.'/'.SystemData::$folder.'/v_step1.php' );
    }
}
?>