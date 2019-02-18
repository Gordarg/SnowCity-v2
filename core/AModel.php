<?php

/**
 * Abstract Model class script
 * Models must extend this class
 *
 * @author        MohammadReza Tayyebi <rexa@gordarg.com>
 * @since         1.0
 */

// Improve Data Structure to support validation messages and more complicated Data Types

include_once 'Initialize.php';
include_once BASEPATH . 'core/Database.php';

abstract class AModel
{
	private $props = []; // props [0] = key, props [1] = value
	private $operands = []; // props that will go for update
	private $table = ''; // table name in db
	private $pk = 'Id'; // pk in table
	private $pkType = 'Int'; // pk in table
	private $propscount = ''; // how many props passed to methods?
	private $readonly = false; // commonly used for views
	private $disableencoding = false; // used to optimize cpu in download.php

	function IsReserved($Field, $IgnoreAggregate = false)
	{
		return
			(
			($Field == $this->pk && !$IgnoreAggregate) ||
			(substr($Field, 0, 2) == "Is" && !$IgnoreAggregate ) ||
			substr($Field, 0, 3) == "Bin" ||
			substr($Field, 0, 4) == "Hash");
	}
	function DoHash($InputString)
	{
		return password_hash($InputString, PASSWORD_DEFAULT);
	}
	function SetReadOnly($ReadOnly){
		$this->readonly = $ReadOnly;
	}
	function SetValue($Key, $Value){
		$this->props[$Key] = $Value;
	}
	function SetOperand($Key) {
		array_push($this->operands, $Key);
	}
	function IsOperand($Key){
		return in_array($Key,$this->operands);
	}
	function ClearOperands($Key = null) {
		if ($Key == null)
			$this->operands = [];
		else
			unset($this->operands[$Key]);
	}
	function SetProperties($Properties){
		$this->props = $Properties;
		$this->propscount = sizeof($Properties);
	}
	function GetProperties(){
		return $this->props;
	}
	function DisableEncoding($Disable)
	{
		$this->disableencoding = $Disable;
	}
	function SetTable($Table)
	{
		$this->table = $Table;
	}
	function SetPrimaryKey($PrimaryKey)
	{
		$this->pk = $PrimaryKey;
	}
	function SetPrimaryKeyType($PrimaryKeyType)
	{
		$this->pkType = $PrimaryKeyType;
	}

	function Select($Skip = -1 , $Take = -1, $OrderField = 'Id', $OrderArrange = 'ASC', $Clause = '')
	{
		$fields = '';

		foreach($this->GetProperties() as $key => $value)
		{
			if (!$this->IsReserved($key, true))
				$fields .= '`' . $key . '`, ';
			
			if ($value != null)
			{
				if (($key != $this->pk && $value == "✓")
					|| $key == $this->pk)
				{
					if (substr($key, 0, 3) == "Bin" && !$this->disableencoding)
						$fields .= "TO_BASE64(`" . $key . "`) as " . $key . ", ";
					else
						$fields .= '`' . $key . '`, ';
				}
			}
		}
		$fields = substr($fields, 0, -2);
		$query  = "SELECT " . $fields . " FROM `" . $this->table . "`";
		if ($this->GetProperties()[$this->pk] != null) // TODO: Any parameter that wasn't null
		{
			if ($this->pkType == 'String')
				$this->SetValue($this->pk, "'" .  $this->GetProperties()[$this->pk] . "'" );
			$query .= " WHERE `" . $this->pk . "` = " . $this->GetProperties()[$this->pk] . ";";
		}
		else
		{
			$query .= " " . $Clause . " ORDER BY " . $OrderField . " " . $OrderArrange .
			(($Take == -1)? "" : " LIMIT " . $Take) .
			(($Skip == -1)? "" : " OFFSET " . $Skip)
			. ";";
		}
		$db = new Db();
		$conn = $db->Open();
		$result = mysqli_query($conn, $query);
		if (!$result)
		{
			header("HTTP/1.0 404 Not Found");
			return;
		}
		$rows = array();
		while(($row = mysqli_fetch_assoc($result))) {
			$rows[] = $row;
		}
		return $rows;
	}
	function Delete()
	{
		if ($this->readonly) return;
		$this->Select();
		$db = new Db();
		$conn = $db->Open();
		$query  = "DELETE FROM `" . $this->table . "` WHERE " . $this->pk . "=" . $this->GetProperties()[$this->pk];
		mysqli_query($conn, $query);
	}
	function Update()
	{
		if ($this->readonly) return;
		$db = new Db();
		$conn = $db->Open();
		$query  = "UPDATE `" . $this->table . "` SET ";
		$i=0;

		foreach($this->GetProperties() as $key => $value)
		{
			if (!$this->IsOperand($key))
				continue;
			
			if ($this->IsReserved($key)
				&& substr($key, 0, 2) == "Is")
			{
				if ($value == "on")
					$value = "1";
				else if ($value == "off")
					$value = "0";
			}		
			else if ($this->IsReserved($key)
				&& substr($key, 0, 4) == "Hash")
			{
				$value = "'" . $this->DoHash($value) . "'";
			}
			else if ($this->IsReserved($key)
				&& substr($key, 0, 3) == "Bin")
			{
				$value = "FROM_BASE64('" . explode(',', urldecode($value))[1] . "')";
			}
			if (isset($value))
				if ($this->IsReserved($key))
					$query .= '`' . $key . "` = " . $value . ", ";
				else
					$query .= '`' . $key . "` = '" . $value . "', ";
		}
		$query = substr($query, 0, -2); // Delete last ,
		$query .=" WHERE " . $this->pk . "=" . $this->GetProperties()[$this->pk];
		mysqli_query($conn, $query);
		$this->Select();
	}
	function Insert()
	{
		if ($this->readonly) return;
		$db = new Db();
		$conn = $db->Open();
		$query  = "INSERT INTO `" . $this->table . "` (";
		$i=0;
		foreach($this->GetProperties() as $key => $value){
			$query .= '`' . $key . '`'. ((++$i === $this->propscount) ? "" : ", " );
		}
		$query = $query . ") VALUES (";
		$i=0;
		foreach($this->GetProperties() as $key => $value){
			if ($this->IsReserved($key)
				&& substr($key, 0, 2) == "Is")
			{
				if ($value == "on")
					$value = "1";
				else if ($value == "off")
					$value = "0";
			}		
			else if ($this->IsReserved($key)
				&& substr($key, 0, 4) == "Hash")
			{
				$value = "'" . $this->DoHash($value) . "'";
			}
			else if ($this->IsReserved($key)
				&& substr($key, 0, 3) == "Bin")
			{
				if ($value != null)
					$value = "FROM_BASE64('" . explode(',', $value)[1] . "')";
			}
			if (isset($value))
				if ($this->IsReserved($key) and $this->pkType != "String")
					$query .=  $value;
				else
					$query .= "'" . $value . "'";
			else $query .= "NULL";

			$query .=  ", ";
		}
		$query = substr($query, 0, -2); // Delete last ,
		$query = $query . ");";
		mysqli_query($conn, $query);
		$this->SetValue($this->pk, mysqli_insert_id($conn));
	}
}
?>