<?php
/* TODO: Remove me */ $parent = realpath(dirname(__FILE__) . '/..');
require_once  $parent . '/core/functionalities.php';
require_once  $parent . '/plug-in/Parsedown.php';
use core\functionalities;
$functionalitiesInstance = new functionalities();
$Parsedown = new Parsedown();
switch ($_GET['type'])
{
    case "POST":
        include($parent . '/views/POST.php');
        break;
    case "COMT":
        include($parent . '/views/COMT.php');
        break;
    case "KWRD":
        include($parent . '/views/KWRD.php');
        break;
    case "FILE":
        include($parent . '/views/FILE.php');
        break;
    case "QUST":
        include($parent . '/views/QUST.php');
        break;
    case "ANSR":
        include($parent . '/views/ANSR.php');
        break;
}
?>