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
        //$this->db = new DataBase();
        //$db =& $this->db;
        //Valid::n();
    }
    public function printdata()
    {
        return new xData;
    }
}
?>