<?
class SQL
{

	function config($fieldSelect='configYear')
	{
		global $connect;	// Database Connection ID
		$sql		= "SELECT ".$fieldSelect." FROM config";
		$result	= sql_query($sql,$connect);
		$row		= sql_fetch_row($result);
		return $row[0];
	}

	function deleteField($tableName, $fieldRef, $fieldValue)
	{
		global $connect;	// Database Connection ID
		$sql = "DELETE FROM ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";
		$result	= sql_query($sql,$connect);
		return $result;
	}

	function deleteFieldAndFile($tableName, $fieldRef, $fieldValue) 
	{
		global $connect;	// Database Connection ID
		removeFiles($tableName, $fieldRef, $fieldValue);     // Remove imagee file and pdf
		$sql = "DELETE FROM ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";
		$result	= sql_query($sql,$connect);
		return $result;
	}
	function deleteFieldAndFileFromUserdoc($tableName, $fieldRef, $fieldValue, $field1='',  $field2='',  $field3='',  $field4='') 
	{
		global $connect;	// Database Connection ID
		removeDocFiles($tableName, $fieldRef, $fieldValue, $field1,$field2,$field3,$field4);     // Remove imagee file and pdf
		$sql = "DELETE FROM ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";
		$result	= sql_query($sql,$connect);
		return $result;
	}
	function countField($fieldSelect, $tableName, $fieldRef, $fieldValue)
	{
		global $connect;	// Database Connection ID
		$sql		= "SELECT count(".$fieldSelect.") FROM ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";
		$result	= sql_query($sql,$connect);
		$row		= sql_fetch_row($result);
		return $row[0];
	}

	function getValueFromRef($fieldSelect, $tableName, $fieldRef, $fieldValue)
	{
		global $connect;	// Database Connection ID
		$sql		= "SELECT ".$fieldSelect." FROM ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";
		$result	= sql_query($sql,$connect);
		$row		= sql_fetch_row($result);
		return $row;
	}
}
function removeFiles($tableName, $fieldRef, $fieldValue) {

	global $connect;        // Database Connection ID
	$sql = "select bookImg, bookContent from ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";	
	$result = sql_query($sql,$connect);
	$rows = sql_fetch_row($result);
	if( file_exists($rows[0])) 
		unlink($rows[0]);
	if( file_exists($rows[1])) 
		unlink($rows[1]);	
}
function removeDocFiles($tableName, $fieldRef, $fieldValue,$field1='',  $field2='',  $field3='',  $field4='') {

	global $connect;        // Database Connection ID
	$sql = "select $field1, $field2,$field3,$field4  from ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";
	$result = sql_query($sql,$connect);
	$rows = sql_fetch_row($result);
	if( file_exists($rows[0])) 
		unlink($rows[0]);
	if( file_exists($rows[1])) 
		unlink($rows[1]);	
	if( file_exists($rows[2])) 
		unlink($rows[2]);	
	if( file_exists($rows[3])) 
		unlink($rows[3]);
}

?>
