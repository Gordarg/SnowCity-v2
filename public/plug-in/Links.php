<?php

class Links
{
    public static function GenerateCssLinks($URL, $CURRENTLANGUAGE, $BASEURL)
    {
        $items = explode('/',preg_replace("/[^a-zA-Z0-9_\-\/اآبپتثجچحخدذرزسشصضطظعغفقکگلمنوهی]/","-",$URL));
        $output = '
<link rel="stylesheet" href="' . $BASEURL . 'public/css/' . $CURRENTLANGUAGE . '.css" crossorigin="anonymous">
<link rel="stylesheet" href="' . $BASEURL . 'public/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="' . $BASEURL . 'public/css/master.css">
';
        for ($i = 1 ; $i < count($items); $i++ )
        {
            $folders = '';
            for ($j = 0 ; $j < $i ; $j ++)
                $folders = $folders . $items[$j] . '/' ;
            $output = $output . '<link rel="stylesheet" type="text/css" href="' . $BASEURL . 'public/css' . $folders . $items[$i] . '.css">';
        }
        return $output;
    }

    public static function GenerateJsLinks($URL, $CURRENTLANGUAGE, $BASEURL)
    {
        $items = explode('/',preg_replace("/[^a-zA-Z0-9_\-\/اآبپتثجچحخدذرزسشصضطظعغفقکگلمنوهی]/","-",$URL));
        $output = '
<script src="' . $BASEURL . 'public/js/jquery.min.js"></script>
<script src="' . $BASEURL . 'public/js/jquery.cookie.js"></script>
<script src="' . $BASEURL . 'public/js/jquery.tayyebi.js"></script>
<script src="' . $BASEURL . 'public/js/persianDatepicker.js"></script>
<script src="' . $BASEURL . 'public/js/bootstrap.min.js"></script>
<script src="' . $BASEURL . 'public/js/Hi.js"></script>
';
        for ($i = 1 ; $i < count($items); $i++ )
        {
            $folders = '';
            for ($j = 0 ; $j < $i ; $j ++)
            $folders = $folders . $items[$j] . '/' ;
            $output = $output . '<script src="' . $BASEURL . 'public/js' . $folders . $items[$i] . '.js"></script>';
        }
        return $output;
    }
    public static function GenerateMeta($META_DESCRIPTION, $META_AUTHOR)
    {

        return $output = '
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="' . $META_DESCRIPTION . '">
        <meta name="keywords" content="' . Config::META_KEYWORDS . '">
        <meta name="author" content="' . $META_AUTHOR . '">
        <meta name="generator" content="SnowKMS ' . (new Xei())::THEVERSION . '">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8">
        <meta name="language" content="'. Config::LANGUAGE . '" />
        <meta name="geo.region" CONTENT="'. Config::REGION . '" />
        <meta name="googlebot" content="INDEX, follow" />
        <meta name="robots" content="index, follow"/>
        <meta itemprop="name" content="'. Config::META_DESCRIPTION . '">
        ';
    }
}