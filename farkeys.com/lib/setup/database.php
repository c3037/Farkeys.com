<?php
/**
* @author Dmitry Porozhnyakov
*/
class DataBase extends Config
{
    protected $conn;
    public function __construct()
    {
        $this->conn = new PDO( "mysql:host=$this->db_host;dbname=$this->db_base", $this->db_user, $this->db_password );
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $this->conn->query( 'SET NAMES utf8' );
    }
    public function sql_1( $email )
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_2( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_temp' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_3( $email, $key, $name )
    {
        $sql = "UPDATE cache SET field2 = :name , field4 = :tempKey, field9 = :date WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":name", $name );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_4( $email, $key, $name )
    {
        $sql = "INSERT INTO cache ( field1, field2, field3, field4, field9 ) VALUES ( :type, :name, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":name", $name );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_5( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->execute();
        if( $sql->fetchColumn() == 0 )
            return 'noValues';
        else
        {
            $sql = "SELECT * FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":type", 'reg_temp' );
            $sql->bindValue( ":email", $email );
            $sql->bindValue( ":key", $key );
            $sql->execute();
            return $sql;
        }
    }
    public function sql_6( $name, $email, $code, $question, $answer )
    {
        $sql = "INSERT INTO users ( name, email, regdate, code, lastnum, lastdate, question, answer, noticetrue, noticefalse ) 
                VALUES ( :name, :email, :regdate, :code, :lastnum, :lastdate, :question, :answer, :noticetrue, :noticefalse )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":name", $name );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":regdate", time() );
        $sql->bindValue( ":code", $code );
        $sql->bindValue( ":lastnum", '011' );
        $sql->bindValue( ":lastdate", '0' );
        $sql->bindValue( ":question", $question );
        $sql->bindValue( ":answer", $answer );
        $sql->bindValue( ":noticetrue", 1 );
        $sql->bindValue( ":noticefalse", 1 );
        $sql->execute();
        if( $sql->rowCount() == 1 )
            return $this->conn->lastInsertId();
        else
            return false;
    }
    public function sql_7( $email )
    {
        $sql = "DELETE FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":type", 'reg_temp' );
        $sql->execute();
        return $sql;
    }
    public function sql_8( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_ac_temp' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_9( $email, $key )
    {
        $sql = "UPDATE cache SET field4 = :tempKey, field9 = :date WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_ac_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_10( $email, $key )
    {
        $sql = "INSERT INTO cache ( field1, field3, field4, field9 ) VALUES ( :type, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_ac_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_11( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_ac_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->execute();
        if( $sql->fetchColumn() == 0 )
            return 'noValues';
        else
        {
            $sql = "SELECT * FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":type", 'change_ac_temp' );
            $sql->bindValue( ":email", $email );
            $sql->bindValue( ":key", $key );
            $sql->execute();
            return $sql;
        }
    }
    public function sql_12( $email, $key )
    {
        $sql = "UPDATE users SET code = :code , lastnum = :lastnum, lastdate = :lastdate WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":code", $key );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":lastnum", '011' );
        $sql->bindValue( ":lastdate", 0 );
        $sql->execute();
        if( $sql->rowCount() == 1 )
        {
            $sql = "SELECT id FROM users WHERE email = :email";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":email", $email );
            $sql->execute();
            $sql = (int) $sql->fetchColumn();
            return $sql;
        }
        else
            return false;
    }
    public function sql_13( $email )
    {
        $sql = "DELETE FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":type", 'change_ac_temp' );
        $sql->execute();
        return $sql;
    }
    public function sql_14( $email )
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_15( $email, $newNumber )
    {
        $sql = "UPDATE users SET lastnum = :newNumber, lastdate = :date WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":newNumber", $newNumber );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_16( $email )
    {
        $sql = "UPDATE users SET lastdate = :date WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":date", 0 );
        $sql->execute();
        return $sql;
    }
    public function sql_17( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email_key' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_18( $email, $key )
    {
        $sql = "INSERT INTO cache ( field1, field3, field4, field9 ) VALUES ( :type, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email_key' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_19( $email, $key )
    {
        $sql = "UPDATE cache SET field4 = :tempKey, field9 = :date, field8 = :bool 
        WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email_key' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->bindValue( ":bool", 0 );
        $sql->execute();
        return $sql;
    }
    public function sql_20( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email_key' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->execute();
        return $sql;
    }
    public function sql_21( $email, $key, $key2 )
    {
        $sql = "UPDATE cache SET field4 = :keyOther, field8 = :bool, field9 = :date 
        WHERE field1 = :type and field3 = :email and field4 = :tempKey";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":keyOther", $key2 );
        $sql->bindValue( ":bool", 1 );
        $sql->bindValue( ":date", time() );
        $sql->bindValue( ":type", 'change_email_key' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->execute();
        return $sql;
    }
    public function sql_22( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key and field8 = :bool";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email_key' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->bindValue( ":bool", 1 );
        $sql->execute();
        return $sql;
    }
    public function sql_23( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_24( $email, $key, $new_email )
    {
        $sql = "UPDATE cache SET field6 = :new_email , field4 = :tempKey, field9 = :date 
        WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":new_email", $new_email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_25( $email, $key, $new_email )
    {
        $sql = "INSERT INTO cache ( field1, field6, field3, field4, field9 ) 
        VALUES ( :type, :new_email, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":new_email", $new_email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_26( $email )
    {
        $sql = "DELETE FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":type", 'change_email_key' );
        $sql->execute();
        return $sql;
    }
    public function sql_27( $email, $key, $newMail )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key and field6 = :newMail";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_email' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->bindValue( ":newMail", $newMail );
        $sql->execute();
        return $sql;
    }
    public function sql_28( $email )
    {
        $sql = "DELETE FROM cache WHERE field3 = :email and field1 IN ( :val1, :val2, :val3, :val4, :val5 )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":val1", 'reg_temp' );
        $sql->bindValue( ":val2", 'change_ac_temp' );
        $sql->bindValue( ":val3", 'change_email_key' );
        $sql->bindValue( ":val4", 'change_email' );
        $sql->bindValue( ":val5", 'setting_alerts' );
        $sql->execute();
        return $sql;
    }
    public function sql_29( $email, $newMail, $question, $answer )
    {
        $sql = "UPDATE users SET email = :newEmail, question = :question, answer = :answer WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":newEmail", $newMail );
        $sql->bindValue( ":question", $question );
        $sql->bindValue( ":answer", $answer );
        $sql->execute();
        return $sql;
    }
    public function sql_30( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'setting_alerts' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_31( $email, $key )
    {
        $sql = "INSERT INTO cache ( field1, field3, field4, field9 ) VALUES ( :type, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'setting_alerts' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_32( $email, $key )
    {
        $sql = "UPDATE cache SET field4 = :tempKey, field9 = :date WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'setting_alerts' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_33( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'setting_alerts' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->execute();
        return $sql;
    }
    public function sql_34( $email, $use_true, $use_false )
    {
        $sql = "UPDATE users SET noticetrue = :noticetrue, noticefalse = :noticefalse WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":noticetrue", $use_true );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":noticefalse", $use_false );
        $sql->execute();
        return $sql;
    }
    public function sql_35( $email )
    {
        $sql = "DELETE FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":type", 'setting_alerts' );
        $sql->execute();
        return $sql;
    }
    public function sql_36( $email )
    {
        $sql = "SELECT COUNT(*) FROM api WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_37( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_partners_temp' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_38( $email, $key, $name )
    {
        $sql = "UPDATE cache SET field2 = :name , field4 = :tempKey, 
        field9 = :date WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_partners_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":name", $name );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_39( $email, $key, $name )
    {
        $sql = "INSERT INTO cache ( field1, field2, field3, field4, field9 ) 
        VALUES ( :type, :name, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_partners_temp' );
        $sql->bindValue( ":name", $name );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_40( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'reg_partners_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->execute();
        if( $sql->fetchColumn() == 0 )
            return 'noValues';
        else
        {
            $sql = "SELECT * FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":type", 'reg_partners_temp' );
            $sql->bindValue( ":email", $email );
            $sql->bindValue( ":key", $key );
            $sql->execute();
            return $sql;
        }
    }
    public function sql_41( $password, $name, $email, $success, $fail, $amp )
    {
        $sql = "INSERT INTO api ( password, name, email, regdate, success, fail, amp ) 
                VALUES ( :password, :name, :email, :regdate, :success, :fail, :amp )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":password", $password );
        $sql->bindValue( ":name", $name );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":regdate", time() );
        $sql->bindValue( ":success", $success );
        $sql->bindValue( ":fail", $fail );
        $sql->bindValue( ":amp", $amp );
        $sql->execute();
        if( $sql->rowCount() == 1 )
            return $this->conn->lastInsertId();
        else
            return false;
    }
    public function sql_42( $email )
    {
        $sql = "DELETE FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":type", 'reg_partners_temp' );
        $sql->execute();
        return $sql;
    }
    public function sql_43( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_password' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_44( $email, $key )
    {
        $sql = "UPDATE cache SET field4 = :tempKey, field9 = :date WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_password' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_45( $email, $key )
    {
        $sql = "INSERT INTO cache ( field1, field3, field4, field9 ) VALUES ( :type, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_password' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_46( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_password' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->execute();
        if( $sql->fetchColumn() == 0 )
            return 'noValues';
        else
        {
            $sql = "SELECT * FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":type", 'change_password' );
            $sql->bindValue( ":email", $email );
            $sql->bindValue( ":key", $key );
            $sql->execute();
            return $sql;
        }
    }
    public function sql_47( $email, $key )
    {
        $sql = "UPDATE api SET password = :code WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":code", $key );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        if( $sql->rowCount() == 1 )
        {
            $sql = "SELECT id FROM api WHERE email = :email";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":email", $email );
            $sql->execute();
            $sql = (int) $sql->fetchColumn();
            return $sql;
        }
        else
            return false;
    }
    public function sql_48( $email )
    {
        $sql = "DELETE FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":type", 'change_password' );
        $sql->execute();
        return $sql;
    }
    public function sql_49( $email )
    {
        $sql = "SELECT * FROM api WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_50( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_51( $email, $key )
    {
        $sql = "INSERT INTO cache ( field1, field3, field4, field9 ) VALUES ( :type, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_52( $email, $key )
    {
        $sql = "UPDATE cache SET field4 = :tempKey, field9 = :date WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_53( $email, $key )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->execute();
        return $sql;
    }
    public function sql_54( $email, $name, $success, $fail, $amp )
    {
        $sql = "UPDATE api SET name = :name, success = :success, fail = :fail, amp = :amp WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":name", $name );
        $sql->bindValue( ":success", $success );
        $sql->bindValue( ":fail", $fail );
        $sql->bindValue( ":amp", $amp );
        $sql->execute();
        return $sql;
    }
    public function sql_55( $email )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info_email_temp' );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_56( $email, $key, $new_email )
    {
        $sql = "UPDATE cache SET field6 = :new_email , field4 = :tempKey, field9 = :date 
        WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info_email_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":new_email", $new_email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_57( $email, $key, $new_email )
    {
        $sql = "INSERT INTO cache ( field1, field6, field3, field4, field9 ) 
        VALUES ( :type, :new_email, :email, :tempKey, :date )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info_email_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":new_email", $new_email );
        $sql->bindValue( ":tempKey", $key );
        $sql->bindValue( ":date", time() );
        $sql->execute();
        return $sql;
    }
    public function sql_58( $email )
    {
        $sql = "DELETE FROM cache WHERE field1 = :type and field3 = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":type", 'change_info' );
        $sql->execute();
        return $sql;
    }
    public function sql_59( $email, $key, $newMail )
    {
        $sql = "SELECT COUNT(*) FROM cache WHERE  field1 = :type and field3 = :email and field4 = :key and field6 = :newMail";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":type", 'change_info_email_temp' );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":key", $key );
        $sql->bindValue( ":newMail", $newMail );
        $sql->execute();
        return $sql;
    }
    public function sql_60( $email, $newMail )
    {
        $sql = "UPDATE api SET email = :newEmail WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":newEmail", $newMail );
        $sql->execute();
        return $sql;
    }
    public function sql_61( $id )
    {
        $sql = "SELECT COUNT(*) FROM api WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        return $sql;
    }
    public function sql_62( $api, $aux )
    {
        $sql = "INSERT INTO status ( api, aux, date, hash ) 
                VALUES ( :api, :aux, :date, :hash )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":api", $api );
        $sql->bindValue( ":aux", $aux );
        $sql->bindValue( ":date", time() );
        $sql->bindValue( ":hash", strtoupper( hash( 'sha512', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] ) ) );
        $sql->execute();
        if( $sql->rowCount() == 1 )
            return $this->conn->lastInsertId();
        else
            return false;
    }
    public function sql_63( $id )
    {
        $sql = "SELECT COUNT(*) FROM status WHERE id = :id and hash = :hash";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":hash", strtoupper( hash( 'sha512', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] ) ) );
        $sql->execute();
        if( $sql->fetchColumn() == 0 )
            return 'noValues';
        else
        {
            $sql = "SELECT * FROM status WHERE id = :id and hash = :hash";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":id", $id );
            $sql->bindValue( ":hash", strtoupper( hash( 'sha512', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] ) ) );
            $sql->execute();
            return $sql;
        }
    }
    public function sql_64( $id )
    {
        $sql = "SELECT * FROM api WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        return $sql;
    }
    public function sql_65( $user, $id )
    {
        $sql = "UPDATE status SET user = :user, date =:date WHERE id = :id and hash = :hash";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":user", $user );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":date", time() );
        $sql->bindValue( ":hash", strtoupper( hash( 'sha512', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] ) ) );
        $sql->execute();
        return $sql;
    }
    public function sql_66( $id )
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        return $sql;
    }
    
    public function sql_67( $id, $sk )
    {
        $sql = "UPDATE status SET status = :status, date =:date, sk = :sk WHERE id = :id and hash = :hash";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":status", 1 );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":sk", $sk );
        $sql->bindValue( ":date", time() );
        $sql->bindValue( ":hash", strtoupper( hash( 'sha512', $_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'] ) ) );
        $sql->execute();
        return $sql;
    }
    public function sql_68( $id )
    {
        $sql = "SELECT COUNT(*) FROM status WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        if( $sql->fetchColumn() == 0 )
            return 'noValues';
        else
        {
            $sql = "SELECT * FROM status WHERE id = :id";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":id", $id );
            $sql->execute();
            return $sql;
        }
    }
    public function sql_69( $id )
    {
        $sql = "DELETE FROM status WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        return $sql;
    }
    public function sql_70( $id, $password )
    {
        $sql = "SELECT COUNT(*) FROM api WHERE id = :id and password = :password";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->bindValue( ":password", $password );
        $sql->execute();
        return $sql;
    }
    public function sql_71( $id )
    {
        $sql = "SELECT COUNT(*) FROM status WHERE id = :id";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":id", $id );
        $sql->execute();
        if( $sql->fetchColumn() == 0 )
            return 'noValues';
        else
        {
            $sql = "SELECT * FROM status WHERE id = :id";
            $sql = $this->conn->prepare( $sql );
            $sql->bindValue( ":id", $id );
            $sql->execute();
            return $sql;
        }
    }
    public function sql_72()
    {
        $sql = "DELETE FROM cache WHERE field9 < :date";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":date", time() - 172800 );  // 2 дня
        $sql->execute();
        return $sql;
    }
    public function sql_73()
    {
        $sql = "DELETE FROM cache WHERE field9 < :date and field1 IN ( :val1, :val2, :val3 )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":date", time() - 1800 ); // 30 минут
        $sql->bindValue( ":val1", 'change_email_key' );
        $sql->bindValue( ":val2", 'setting_alerts' );
        $sql->bindValue( ":val3", 'change_info' );
        $sql->execute();
        return $sql;
    }
    public function sql_74()
    {
        $sql = "DELETE FROM status WHERE date < :date";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":date", time() - 43200 ); // 12 часов
        $sql->execute();
        return $sql;
    }
    public function sql_75()
    {
        $sql = "DELETE FROM status WHERE date < :date and user != 0";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":date", time() - 7200 ); // 2 часа
        $sql->execute();
        return $sql;
    }
    public function sql_76()
    {
        $sql = "DELETE FROM status WHERE date < :date and status != 0";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":date", time() - 1200 );  // 20 минут
        $sql->execute();
        return $sql;
    }
    public function sql_77()
    {
        $sql = "SELECT email FROM users";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
        return $sql;
    }
    public function sql_78()
    {
        $sql = "SELECT DISTINCT email FROM users";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
        return $sql;
    }
    public function sql_79()
    {
        $sql = "SELECT email FROM api";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
        return $sql;
    }
    public function sql_80()
    {
        $sql = "SELECT DISTINCT email FROM api";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
        return $sql;
    }
    public function sql_81()
    {
        $sql = "SELECT COUNT(*) FROM api WHERE regdate < :date and licensed != 1";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":date", time() - 2592000 );  // 30 дней
        $sql->execute();
        return $sql;
    }
    public function sql_82()
    {
        $sql = "SELECT email FROM api WHERE regdate < :date and licensed != 1";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":date", time() - 2592000 );  // 30 дней
        $sql->execute();
        return $sql;
    }
    public function sql_83( $email )
    {
        $sql = "DELETE FROM api WHERE email = :email";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->execute();
        return $sql;
    }
    public function sql_84( $email )
    {
        $sql = "DELETE FROM cache WHERE field3 = :email and field1 IN ( :val1, :val2, :val3, :val4 )";
        $sql = $this->conn->prepare( $sql );
        $sql->bindValue( ":email", $email );
        $sql->bindValue( ":val1", 'reg_partners_temp' );
        $sql->bindValue( ":val2", 'change_password' );
        $sql->bindValue( ":val3", 'change_info' );
        $sql->bindValue( ":val4", 'change_info_email_temp' );
        $sql->execute();
        return $sql;
    }
    public function sql_85()
    {
        $sql = "OPTIMIZE TABLE `api`";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
        $sql = "OPTIMIZE TABLE `cache`";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
        $sql = "OPTIMIZE TABLE `status`";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
        $sql = "OPTIMIZE TABLE `users`";
        $sql = $this->conn->prepare( $sql );
        $sql->execute();
    }
}
?>