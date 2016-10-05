<?php
/**
* @author Dmitry Porozhnyakov
*/
class Controller
{
    public function __construct()
    {
        $main = new Main( '/int/email-to-id' );
        
        //require_once( VIEW.'/'.SystemData::$folder.'/messages.php' );
        //require_once( VIEW.'/'.SystemData::$folder.'/notices.php' );
        
        if( !isset( $_GET['email'] ) or !Valid::email( trim( $_GET['email'] ) ) )
        {
            exit( '0' );
        }
        
        $data = $this->model();
        //$this->view( $data );
    }
    public function model()
    {
        require_once( MODL.'/m_email_to_id.php' );
        $model = new Model();
        return $model->printdata();
    }
    public function view( $data )
    {
        require_once( VIEW.'/'.SystemData::$folder.'/v_email_to_id.php' );
    }
}
?>