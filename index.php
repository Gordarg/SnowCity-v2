<?php
// Translation
include_once 'public/plug-in/Language.php';

// Initialize app
include_once 'core/Initialize.php';

// Authentication and authorization
include_once 'core/Authentication.php';

// Override error_handler()
set_error_handler(function($errno, $errstr, $errfile, $errline ){
    $exp = new MyException(
    $errstr .
    "\nfile" . $errfile .
    "\nline:" . $errline
    , $errno);
    $exp -> s_print();

    // TODO: Handle all header() functions globally
    header("HTTP/1.0 500 Internal Server Error");
    return;
});


// Get request info
$BASEURL = Config::BASEURL;
$URL = strtolower(Functionalities::IfExistsIndexInArray($_SERVER, "PATH_INFO"));
$URL = '/'.trim($URL, '/');
if ($URL == '/')
    $URL = "/home";
$PATHINFO = explode('/', $URL);

//  Allow partial Ajax Requests
$AJAX = false;
if ($PATHINFO[1] == 'ajax')
{
    unset($PATHINFO[1]);
    $PATHINFO = array_values($PATHINFO);
    $AJAX = true;
}

// Check if requested page exists already
else if (!file_exists(BASEPATH.'public/'.$PATHINFO[1].'.php'))
{
    header("HTTP/1.0 404 Not Found");
    return;
}

// Current User Info
$USERID = Functionalities::IfExistsIndexInArray($_COOKIE, 'USERID');
$USERNAME = Functionalities::IfExistsIndexInArray($_COOKIE, 'USERNAME');
$USERTOKEN = Functionalities::IfExistsIndexInArray($_COOKIE, 'USERTOKEN');
$USERROLE = Functionalities::IfExistsIndexInArray($_COOKIE, 'ROLE');

// Multi-Language Plug-In
include_once BASEPATH.'public/plug-in/Translate.php';
$CURRENTLANGUAGE = Functionalities::IfExistsIndexInArray($_COOKIE, 'LANG');
define("CURRENTLANGUAGE", $CURRENTLANGUAGE ? $CURRENTLANGUAGE : Config::DefaultLanguage);
$Translate = new Translate();
// Load Post Class
include_once BASEPATH.'model/Post.php';
$Post = new Post();
$Post->AuthConstruct($USERNAME, $USERTOKEN);

// Load Markdown to Markup Converter Plug-In
require_once BASEPATH.'public/plug-in/Parsedown.php';
$Parsedown = new Parsedown();

// Page Meta and Links
include_once BASEPATH.'public/plug-in/Links.php';
// Read meta from config file
$META_DESCRIPTION = Config::META_DESCRIPTION;
$META_AUTHOR = Config::META_AUTHOR;
if ($PATHINFO[1] == 'view')
{
    $Language = $PATHINFO[2];
    $Id = $PATHINFO[3];
    $row = $Post->Select(-1, 1, 'MasterID', 'ASC', "WHERE `Language`='" . $Language . "' AND `MasterID`='" . $Id . "'")[0];

    // Generate custom meta
    $META_DESCRIPTION = Text::GenerateAbstractForPost($Parsedown->text($row['Body']), 500);
    $META_AUTHOR = $row['Username'];
}
else if ($PATHINFO[1] == 'say')
{
    $Language = Functionalities::IfExistsIndexInArray($PATHINFO, 2);
    $MasterID = Functionalities::IfExistsIndexInArray($PATHINFO, 3);
    $row = 
        Functionalities::IfExistsIndexInArray(
            $Post->Select(-1, 1, 'MasterID', 'ASC', "WHERE `Language`='" . $Language . "' AND `MasterID`='" . $MasterID . "'"),
        0);
}
else if ($PATHINFO[1] == 'rss' && $AJAX)
{
    header("Content-Type: application/xml; charset=utf-8");
    header('Access-Control-Allow-Origin: *'); 
}


// Generate meta global variables
$META = Links::GenerateMeta($META_DESCRIPTION, $META_AUTHOR);
$CSSLINKS = Links::GenerateCssLinks($URL, CURRENTLANGUAGE, $BASEURL);
$JSLINKS = Links::GenerateJsLinks($URL, CURRENTLANGUAGE, $BASEURL);

// Handle ajax requests
if (!$AJAX)
{
    // Compress output
    // TODO: Disable compresion from config
    ob_start();
    // Include header
    include_once BASEPATH.'public/master/public-header.php';
    // Include content
    include_once BASEPATH.'public/'.$PATHINFO[1].'.php';
    // Include footer
    include_once BASEPATH.'public/master/public-footer.php';
    // Minifier Plug-In
    include_once BASEPATH.'public/plug-in/tiny-html-minifier.php';
    $result = TinyMinify::html(ob_get_contents());
    ob_end_clean();
    echo $result;
}
else
{
    include_once BASEPATH.'public/'.$PATHINFO[1].'.php';
}
?>