<?php
/**
* @author Dmitry Porozhnyakov
*/
function gen( $length )
{
    $array = array( 'a','b','c','d','e','f',
                    'g','h','i','j','k','l',
                    'm','n','o','p','q','r',
                    's','t','u','v','w','x',
                    'y','z','1','2','3','4',
                    '5','6','7','8','9','0' );

    $password = '';
    $count = count( $array ) - 1;
    
    for( $i = 0; $i < $length; $i++ )
    {
        $index = rand( 0, $count );
        $password .= $array[$index];
    }
    return $password;
}
class Config
{
    public $db_host = 'localhost';
    public $db_base = 'dmitryqr_base2';
    public $db_user = 'dmitryqr_base2';
    public $db_password = '4GJa5}$[h.~M';
}
class DataBase extends Config
{
    protected $conn;
    public function __construct()
    {
        $this->conn = new PDO( "mysql:host=$this->db_host;dbname=$this->db_base", $this->db_user, $this->db_password );
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $this->conn->query( 'SET NAMES utf8' );
    }
    public function sql_1( $email, $password )
    {
        $sql = "INSERT INTO users ( email, password, date ) VALUES ( :email, :password, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":password", $password );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        if( $sql->rowCount() == 1 )
            return $this->conn->lastInsertId();
        else
            return false;
    }
    public function sql_2( $id, $password )
    {
        $sql = "SELECT COUNT(*) FROM users WHERE id = :id and password = :password";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":password", $password );
        $sql->execute();
        return $sql;
    }
    public function sql_3( $id, $hash )
    {
        $sql = "UPDATE users SET hash = :hash, hashdate = :date WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":hash", $hash );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_4( $id )
    {
        $sql = "SELECT COUNT(*) FROM users WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        return $sql;
    }
    public function sql_5( $id )
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        return $sql;
    }
    public function sql_6( $id )
    {
        $sql = "UPDATE users SET hash = :hash, hashdate = :date WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":hash", '' );
        $sql->bindValue( ":date", 0 );
        $sql->execute();
        return $sql;
    }
    public function sql_7( $id, $fk = 0 )
    {
        $sql = "UPDATE users SET fkid = :fkid WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":fkid", $fk );
        $sql->execute();
        return $sql;
    }
    public function sql_8( $id, $password )
    {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":password", $password );
        $sql->execute();
        return $sql;
    }
    public function sql_9( $fkid )
    {
        $sql = "SELECT COUNT(*) FROM users WHERE fkid = :fkid";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":fkid", $fkid );
        $sql->execute();
        return $sql;
    }
    public function sql_10( $fkid )
    {
        $sql = "SELECT id FROM users WHERE fkid = :fkid";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":fkid", $fkid );
        $sql->execute();
        return $sql;
    }
	public function sql_11( $id, $use, $master )
    {
        $sql = "UPDATE users SET usemc = :usemc, mc = :mc, date= :date WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":usemc", $use );
		$sql->bindValue( ":mc", $master );
		$sql->bindValue( ":date", $date );
        $sql->execute();
        return $sql;
    }
}
?>