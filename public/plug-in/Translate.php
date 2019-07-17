<?php

class Translate
{
    public static function Label($key, $Lang = null)
    {
        if ($Lang)
            $language = $Lang;
        else if(CURRENTLANGUAGE !== null)
            $language = CURRENTLANGUAGE;
        else
            $language = Config::DefaultLanguage;

        if ($language == "fa-ir")
            return $key;
    
        $dictionary = explode("\n", file_get_contents(BASEPATH . 'dictionary.yaml'));
        $keys = [];
        for( $i= 0 ; $i <= sizeof($dictionary) ; $i++ )
        {  
            if (
                Functionalities::IfExistsIndexInArray($dictionary, $i) &&
                substr($dictionary[$i], 0, 1) == "-")
            {
                if ($key == substr($dictionary[$i], 1, strlen($dictionary[$i]) - 1))
                {
                    $k = $i;
                    for ($j = $i + 1; $j <= sizeof($dictionary) ; $j++  )
                    {
                        if (substr($dictionary[$j], 0, 1) == "-")
                        {
                            $k = $j;
                            break;
                        }
                    }
                    if ($k > $i + 1)
                        for ($j = $i + 1; $j <= $k ; $j++  )
                            if (substr($dictionary[$j], 0, strlen($language)) == $language)
                                return substr($dictionary[$j], strlen($language) + 1, strlen($dictionary[$j]) - 1 - strlen($language));
                        return $key;
                }
            }
        }
        return $key;
    }
}