<?php
/**
* @author Dmitry Porozhnyakov
*/
class Library
{
    public static function inArray( Array $a, $b ){
        foreach($a as $key => $val){
            if ($val == $b)
                return $key;
        }
        return -1;
    }
    public static function generateActivationCode( $length ) //+генерация API пароля
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
    public static function generateHashOfActivationCode( $activationCode ) //+генерация API пароля
    {
        $hash = hash( 'sha512', strtoupper( $activationCode ) );
        $a = substr( $hash, 0, 17 );
        $b = substr( $hash, 17, 69 );
        $c = substr( $hash, 86, 42 );
        $hash = $b.$a.$c;
        return $hash;
    }
    public static function enCode( $string, $password = '1724Nmesfg::kk87' )
    {
        $salt = 'BCVeJJsbtDyjPn581';
        $strLen = strlen( $string );
        $gamma = '';
        $seq = $password;
        while ( strlen( $gamma ) < $strLen )
        {
            $seq = pack( "H*", sha1( $gamma.$seq.$salt ) ); 
            $gamma .= substr( $seq, 0, 8 );
        }
        return base64_encode( $string^$gamma );
    }
    public static function deCode( $string, $password = '1724Nmesfg::kk87' )
    {
        $string = base64_decode( $string );
        $salt = 'BCVeJJsbtDyjPn581';
        $strLen = strlen( $string );
        $gamma = '';
        $seq = $password;
        while ( strlen( $gamma ) < $strLen )
        {
            $seq = pack( "H*", sha1( $gamma.$seq.$salt ) ); 
            $gamma .= substr( $seq, 0, 8 );
        }
        return $string^$gamma;
    }
    public static function generateNumberCode( $num_of_chars )
    {
        $_IN = '';
        
        for( $i = 1; $i <= $num_of_chars; $i++ )
        {
            $_IN .= mt_rand( 0, 9 );
        }
        
        return $_IN;
    }
    public static function generateNumber_Answer( $_IN, $activationCode )
    {
        $a = substr( $activationCode, 0, 43 );
        $b = substr( $activationCode, 43, 43 );
        $c = substr( $activationCode, 86, 42 );
        
        $hash = strtolower( hash( 'sha512', $c.hash( 'sha512', $b.hash( 'sha512', $_IN.$a ) ) ) );
        $code = '';
        $buffer = 0;
        
        for( $i = 1; $i <= 128; $i++ )
        {
            $b = substr( $hash, $i-1, 1 );
            if( $b == 'a' )
            {
                $b = 10;
            }
            elseif( $b == 'b' )
            {
                $b = 11;
            }
            elseif( $b == 'c' )
            {
                $b = 12;
            }
            elseif( $b == 'd' )
            {
                $b = 13;
            }
            elseif( $b == 'e' )
            {
                $b = 14;
            }
            elseif( $b == 'f' )
            {
                $b = 15;
            }
            $buffer = $buffer + $b;
                    
            if( $i == 25 or $i == 50 or $i == 75 or $i == 100 or $i == 128 )
            {
                $aux = $buffer;
                
                while( strlen( $aux ) > 1 )
                {
                    $aux1 = substr( $aux, 0, 1 );
                    $aux2 = substr( $aux, 1 );
                    $aux = $aux1 + $aux2;
                }
                $code .= $aux;
            }
        }
        return $code;
    }
}
?>