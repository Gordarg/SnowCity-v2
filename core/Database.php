<?php
require_once 'Initialize.php';

class Db
{
	function Open()
	{
		return
		new mysqli(Config::ConnectionString_SERVER,Config::ConnectionString_USERNAME,Config::ConnectionString_PASSWORD,Config::ConnectionString_DATABASE);
	}
	function Close()
	{
		try {
		    mysqli_close($conn);
		}
		catch (Exception $exp) { }
	}
}
?>
