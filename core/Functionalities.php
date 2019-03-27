<?php
class Functionalities
{
    public static function IfExists($varname)
    {
        return(isset($$varname)?$varname:null);
    }
    public static function IfExistsIndexInArray($var,$index)
    {
        return(isset($var[$index])?$var[$index]:null);
    }
    public static function IfStringStartsWith($key, $query)
    {
        $query_lenght = strlen($query);
        $key_lenght = strlen($key);
        if (substr($key, 0, $query_lenght) === $query)
          return substr($key, $query_lenght, $key_lenght);
        return false;
    }
    public static function GenerateGUID()
    {
        return
        sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));
    }
    public static function GenerateToken(){
        return bin2hex(random_bytes(78));
    }
}

?>