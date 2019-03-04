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
}

?>