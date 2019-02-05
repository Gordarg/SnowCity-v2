<?php
namespace core;
include_once 'variable/config.php';
use core\config;

class database_connection
{
    function open()
    {        
        $conn = new \mysqli(
            config::ConnectionString_SERVER,
            config::ConnectionString_USERNAME,
            config::ConnectionString_PASSWORD,
            config::ConnectionString_DATABASE
        );
        
        if ($conn->connect_error) {
            die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
        }
        return $conn;
    }

}
?>