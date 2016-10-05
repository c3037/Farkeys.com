<?php
/**
* @author Dmitry Porozhnyakov
*/
class xData extends Data
{
    
}
class Model
{
    //private $db;
    public function __construct()
    {
        $db = new DataBase();
        $email = strtolower( trim( $_GET['email'] ) );
        $result = $db->sql_1( $email );
        if( $result->fetchColumn() > 0 )
        {
            $result = $db->sql_14( $email );
            $result = $result->fetchObject();
            exit( "$result->id" );
        }
        else
            exit( '-1' );
        //$db =& $this->db;
        //Valid::n();
    }
    public function printdata()
    {
        return new xData;
    }
}
?>