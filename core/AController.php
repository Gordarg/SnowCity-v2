<?php

/**
 * Abstract Controller class script
 * Controllers must extend this class
 * 
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

// TODO: Every controller must have in-app output (Integration) and parsed output (Web API)

error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, HEAD, VIEW');
ini_set('display_errors', '1');

include_once 'Initialize.php';
include_once BASEPATH . 'core/Authentication.php';

require '../lib/json_encoder_itspriddle.php';

abstract class AController
{
	private $data = '' ;
	private $httpstatus ;
	private $request = [];
	
	function __construct(){
		$this->{$_SERVER['REQUEST_METHOD']}();
		$this->httpstatus = 'HTTP/1.1 200 Ok';
	}
	function __destruct(){
		// TODO: What to do. What not to do? -Arastoo Amel!
	}
	function setStatus($code)
	{
		// TODO: Set message anf tother details based on passed $code
		$this->httpstatus = 'HTTP/1.1 401 Unauthorized';
	}
	function setData($data){
		if ($data instanceof Exception)
		{
			$this->data = $data->getMessage();
			$this->setStatus('HTTP/1.1 500 Internal Server Error');
		}
		else
			$this->data = $data;
	}
	function setRequest($request){
		$this->request = $request;
	}
	function getAllRequests(){
		return $this->request;
	}
	function getRequest($index){
		return (isset($this->request[$index])?$this->request[$index]:null);
	}
	function returnData (){
		header($this->httpstatus);
		if (APIRESULTTYPE=='application/json')
		{
			header("Content-Type: " . APIRESULTTYPE);
			// TODO: cannot convert heavy resutls to json!
			// echo json_encode($this->data);
			$json = new Services_JSON();
			echo $json->encode($this->data);
		}
		else echo $this->data;
		return $this->data;
	}
	function ValidateAutomatic($Role)
	{
		switch ($Role) {
            case 'ADMIN':
                $Role = 3;
                break;

            case 'EDTOR':
                $Role = 2;
                break;
			
			case 'USER':
				$Role = 1;
				break;

            default:
                $Role = 0;
                break;
		}
		if ($Role == 0)
			return true;
			
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		parse_str(
			Functionalities::IfExistsIndexInArray(parse_url($actual_link), 'query')
			,$params);

		$Username = Functionalities::IfExistsIndexInArray($params, 'Userlogin');
		$Token = Functionalities::IfExistsIndexInArray($params, 'Token');

		$result = Authentication::ValidateToken($Username, $Token)
			&& Authentication::ValidateRole($Username, $Role);
		
		$UserID = null;
		$UserRole = null;
		if (!$result)
			$this->httpstatus = "HTTP/1.0 401 Unauthorized";
		else
		{
			// TODO: SQL INJECTION BUG ON $Username and $Token
			// Functionalities::SQLINJECTIOENCODE
			$user = (new User())->Select(0 , 1, 'Id' ,'ASC', "WHERE `Username`='" . $Username . "'")[0];
			$UserID = $user['Id'];
			$UserRole = $user['Role'];
		}

		return array(
			"Username" => $Username,
			"UserID" => $UserID,
			"UserRole" => $UserRole,
			"Result" => $result);
	}

	function VIEW(){
		// TODO: Show hint about this controller 
	}
	function GET(){
		$this->setRequest($_GET);
	}
	function POST(){
		$this->setRequest($_POST);
	}
	function DELETE(){
		$raw_data = file_get_contents('php://input');
		$_DELETE = array();
		$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
		if ($boundary == null && $raw_data != 'null') // x-www-form-urlencoded
		{
			$split_parameters = explode('&', $raw_data);

			for($i = 0; $i < count($split_parameters); $i++) {
				$final_split = explode('=', $split_parameters[$i]);
				$_DELETE[$final_split[0]] = $final_split[1];
			}
		}
		else if ($raw_data != 'null')
		{
			$parts = array_slice(explode($boundary, $raw_data), 1);
			foreach ($parts as $part) {
				if ($part == "--\r\n") break; 
				$part = ltrim($part, "\r\n");
				list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);
				$raw_headers = explode("\r\n", $raw_headers);
				$headers = array();
				foreach ($raw_headers as $header) {
					list($name, $value) = explode(':', $header);
					$headers[strtolower($name)] = ltrim($value, ' '); 
				}
				if (isset($headers['content-disposition'])) {
					$filename = null;
					preg_match(
						'/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/', 
						$headers['content-disposition'], 
						$matches
					);
					list(, $type, $name) = $matches;
					isset($matches[4]) and $filename = $matches[4]; 
					switch ($name) {
						case 'userfile':
							file_put_contents($filename, $body);
							break;
						default: 
							$_DELETE[$name] = substr($body, 0, strlen($body) - 2);
							break;
					} 
				}

			}
		}
		else
		{
			$url = $_SERVER['REQUEST_URI'];

			$split_parameters = explode('&', $url);

			for($i = 0; $i < count($split_parameters); $i++) {
				$final_split = explode('=', $split_parameters[$i]);
				$_DELETE[$final_split[0]] = $final_split[1];
			}
		}
		$this->setRequest($_DELETE);
	}
	function PUT(){
		$raw_data = file_get_contents('php://input');
		$_PUT = array();
		$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));
		if ($boundary == null) // x-www-form-urlencoded
		{
			$split_parameters = explode('&', $raw_data);

			for($i = 0; $i < count($split_parameters); $i++) {
				$final_split = explode('=', $split_parameters[$i]);
				$_PUT[$final_split[0]] = $final_split[1];
			}
		}
		else // form-data
		{
			$parts = array_slice(explode($boundary, $raw_data), 1);
			foreach ($parts as $part) {
				if ($part == "--\r\n") break; 
				$part = ltrim($part, "\r\n");
				list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);
				$raw_headers = explode("\r\n", $raw_headers);
				$headers = array();
				foreach ($raw_headers as $header) {
					list($name, $value) = explode(':', $header);
					$headers[strtolower($name)] = ltrim($value, ' '); 
				}
				if (isset($headers['content-disposition'])) {
					$filename = null;
					preg_match(
						'/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/', 
						$headers['content-disposition'], 
						$matches
					);
					list(, $type, $name) = $matches;
					isset($matches[4]) and $filename = $matches[4]; 
					switch ($name) {
						case 'userfile':
							file_put_contents($filename, $body);
							break;
						default: 
							$_PUT[$name] = substr($body, 0, strlen($body) - 2);
							break;
					} 
				}

			}
		}
		$this->setRequest($_PUT);
	}
}
?>