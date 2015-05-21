<?
class InputForm
{

	function viewText($text)
	{
		$text	= stripslashes(nl2br($text));
		return $text;
	}

	function inputText($text)
	{
		$text	= addslashes(strip_tags($text));
		return $text;
	}


	function searchText($text)
	{
		$text	=  addslashes(addslashes(strip_tags($text)));
		return $text;
	}

	function editText($text)
	{
		$text	= stripslashes($text);
		return $text;
	}

	function viewNumber($number)
	{
		$number = number_format($number,'',$number_decimal_separator,$number_thousands_separator);
		return $number;
	}

	function selectNumber($startNumber, $endNumber, $inputName, $titleName, $comparedVal='', $order='asc')
	{
		if($order == "desc") 
		{
			print "<select  name='".$inputName."'><option value=''>".$titleName."</option>";
			for($i=$endNumber;$i>=$startNumber;$i--)
			{
				if($i == $comparedVal) print "<option value='$i' selected>$i</option>";
				else  print "<option value='$i'>$i</option>";
			}
			print "</select>";
		}	
		else
		{
			print "<select id='seachsubmit' name='".$inputName."'><option value=''>".$titleName."</option>";
			for($i=$startNumber;$i<=$endNumber;$i++)
			{
				if($i == $comparedVal) print "<option value='$i' selected>$i</option>";
				else  print "<option value='$i'>$i</option>";
			}
			print "</select>";


		}
	}

	function selectArray($arrayInput, $inputName, $titleName, $comparedVal='')
	{
		print "<select id='s' name='".$inputName."'><option value=''>".$titleName."</option>";
		while(list($key,$val) = each($arrayInput))
		{
			if($val == $comparedVal) print "<option value='$val' selected>$val</option>";
			else  print "<option value='$val'>$val</option>";
		}
		print "</select>";
	}

	function selectMonth($inputName, $titleName, $comparedVal='')
	{
		global $cfg;
		print "<select id='searchsubmit' name='".$inputName."'><option value=''>".$titleName."</option>";
		while(list($key,$val) = each($cfg['month']))
		{
			$monthIndex = $key + 1;
			if($monthIndex == $comparedVal) print "<option value='$monthIndex' selected>$val</option>";
			else  print "<option value='$monthIndex'>$val</option>";
		}
		print "</select>";
	}

	function selectField($inputName, $titleName, $fieldSelectID, $fieldSelectName, $tableName, $fieldRef='', $fieldValue='', $comparedVal='')
	{

		print "<select id='s' name='".$inputName."'><option value=''>".$titleName."</option>";

		global $connect;
		if(!$fieldRef && !$fieldValue) $sql	= "SELECT ".$fieldSelectID.",".$fieldSelectName." FROM ".$tableName;
		else $sql	= "SELECT ".$fieldSelectID.",".$fieldSelectName." FROM ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";

		$result	= sql_query($sql,$connect);
		while($row	= sql_fetch_row($result))
		{
			if($comparedVal==$row[0]) print "<option value='$row[0]' selected>".stripslashes($row[1])."</option>";
			else print "<option value='$row[0]'>".stripslashes($row[1])."</option>";
		}
		sql_free_result($result);

		print "</select>";
	}

	function selectFieldvisible($inputName, $titleName, $fieldSelectID, $fieldSelectName, $tableName, $fieldRef='', $fieldValue='', $comparedVal='')
	{

		print "<select id='s' name='".$inputName."' onChange=\"alertselected(this)\"><option value=''>".$titleName."</option>";

		global $connect;
		if(!$fieldRef && !$fieldValue) $sql	= "SELECT ".$fieldSelectID.",".$fieldSelectName." FROM ".$tableName;
		else $sql	= "SELECT ".$fieldSelectID.",".$fieldSelectName." FROM ".$tableName." WHERE ".$fieldRef."='".$fieldValue."'";

		$result	= sql_query($sql,$connect);
		while($row	= sql_fetch_row($result))
		{
			if($comparedVal==$row[0]) print "<option value='$row[0]' selected>".stripslashes($row[1])."</option>";
			else print "<option value='$row[0]'>".stripslashes($row[1])."</option>";
		}
		sql_free_result($result);

		print "</select>";
	}

}
?>
