<?php
include_once 'public/plug-in/Language.php';
include_once 'core/Initialize.php';

include_once 'core/Authentication.php';
include_once 'core/Authorization.php';

// Override error_handler()
set_error_handler(function($errno, $errstr, $errfile, $errline ){
    $exp = new MyException(
    $errstr .
    "\nfile" . $errfile .
    "\nline:" . $errline
    , $errno);
    $exp -> print();

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
$LOGINTOKEN = Functionalities::IfExistsIndexInArray($_COOKIE, 'LOGINTOKEN');
$ROLE = Functionalities::IfExistsIndexInArray($_COOKIE, 'ROLE');
if ($USERID)
{
    // TODO: Validate Token
    // I mean: Check if Role and Username and Token are valid
}
if (!Authorization::ValidatePath($ROLE, 
        ($PATHINFO[1] == 'say')
        ? 'say|' . Functionalities::IfExistsIndexInArray($PATHINFO,2)
        : $PATHINFO[1]
    )
)
{
    header("HTTP/1.0 401 Unauthorized");
    return;   
}

// Choose Language
if(!isset($_COOKIE["LANG"]))   
    header('Location:language/' . Config::DefaultLanguage);
// Multi-Language Plug-In
include_once BASEPATH.'public/plug-in/Translate.php';
$Translate = new Translate();
$CURRENTLANGUAGE = Functionalities::IfExistsIndexInArray($_COOKIE, 'LANG');
// Load PostDetail Class
include_once BASEPATH.'model/PostDetail.php';
$PostDetail = new PostDetail();
// Load Markdown to Markup Converter Plug-In
require_once BASEPATH.'public/plug-in/Parsedown.php';
$Parsedown = new Parsedown();

// Page Meta and Links
include_once BASEPATH.'public/plug-in/Links.php';
// Change meta for View/...
if ($PATHINFO[1] == 'view')
{
    $Language = $PATHINFO[2];
    $Id = $PATHINFO[3];
    $row = $PostDetail->Select(-1, 1, 'MasterID', 'ASC', "WHERE `Language`='" . $Language . "' AND `MasterID`='" . $Id . "'")[0];
    $META_DESCRIPTION = Text::GenerateAbstractForPost($Parsedown->text($row['Body']), 500);
    $META_AUTHOR = $row['Username'];
}
else
{
    $META_DESCRIPTION = Config::META_DESCRIPTION;
    $META_AUTHOR = Config::META_AUTHOR;
}
$META = Links::GenerateMeta($META_DESCRIPTION, $META_AUTHOR);
$CSSLINKS = Links::GenerateCssLinks($URL, $CURRENTLANGUAGE, $BASEURL);
$JSLINKS = Links::GenerateJsLinks($URL, $CURRENTLANGUAGE, $BASEURL);

ob_start();
if (!$AJAX)
    include_once BASEPATH.'public/master/public-header.php';
include_once BASEPATH.'public/'.$PATHINFO[1].'.php';
if (!$AJAX)
    include_once BASEPATH.'public/master/public-footer.php';

include_once BASEPATH.'public/plug-in/tiny-html-minifier.php';
$result = TinyMinify::html(ob_get_contents());
ob_end_clean();
echo $result;
?>