<?php
/**
 * Initialize class script
 * Sets global variables
 *
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */


require_once 'Xei.php';


define("DATETIMENOW", date('Y-m-d h:i:s.u', time()));
define("APIRESULTTYPE", "application/json");
define("BASEPATH", str_replace('\\','/',realpath(dirname(__FILE__) . '/..') .'/'));
if (session_status() == PHP_SESSION_NONE) 
    session_start();

// function __autoload($class_name) {
// // spl_autoload_register(function($class) {



/**
 * Custom Exceptions
 */


require_once BASEPATH."core/Exception.php";
// TODO:
// set_error_handler(function($errno, $errstr, $errfile, $errline ){
//     throw new MyException($errstr, $errno);
// });


/**
 * Cofiguration variables
 * These variables are defined by user
 */
require_once BASEPATH."Config.php";
/**
 * Set time zone
 */
date_default_timezone_set(Config::TimeZone);
/**
 * Optimized functions
 */
require_once BASEPATH."core/Functionalities.php";
require_once BASEPATH."core/Text.php";
require_once BASEPATH."core/File.php";
?>