<?php

function placement_resume_interface($studentID, $returnLink)
{
	global $connect;
	//echo $returnLink;
	$sql = "SELECT entryType FROM placement_settings";
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_array($res);
		$dataEntryFormat = $row[0];
	}
	//echo $dataEntryFormat;
	
	$sql = " SELECT t4.typeID, t4.entryType FROM studentaccount t1, batches t2, university_assignbatchcourse t3, university_coursetypegrading t4 WHERE t1.batchID = t2.batchID AND t2.batchID = t3.batchID AND t3.typeID = t4.typeID AND t1.studentID = \"".$studentID."\" ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_array($res);
		$courseTypeID = $row[typeID];
		$markSystem = $row[entryType];
	}
	
	if($dataEntryFormat == 0)
	{
		//include "../resumeTemplates/view_student_resume.php";
		
		$sqltmpls = " SELECT viewFile FROM placement_resume_templates WHERE defaultTempl = 1 ";
		$restmpls = sql_query($sqltmpls, $connect);
		if(sql_num_rows($restmpls) == 1)
		{
			$rowtmpls = sql_fetch_row($restmpls);
			
			include "".$rowtmpls[0]."";
		}
		else if(sql_num_rows($restmpls) > 1)
		{
			$sqlstdtmpl = " SELECT t1.viewFile FROM placement_resume_templates t1, student_resume_template t2 WHERE t1.templateID = t2.templateID AND t2.studentID = \"".$studentID."\" ";
			$resstdtmpl = sql_query($sqlstdtmpl, $connect);
			if(sql_num_rows($resstdtmpl))
			{
				$rowstdtmpl = sql_fetch_row($resstdtmpl);
				
				include "".$rowstdtmpl[0]."";
			}
		}
		
	}
	else if($dataEntryFormat == 1)
	{
		//include "../resumeTemplates/view_student_resume_sgpa_tmpl1.php";
		
		$sqltmpls = " SELECT viewFile FROM placement_resume_templates WHERE defaultTempl = 1 ";
		//echo $sql;
		$restmpls = sql_query($sqltmpls, $connect);
		if(sql_num_rows($restmpls) == 1)
		{
			$rowtmpls = sql_fetch_row($restmpls);
			include "".$rowtmpls[0]."";
		}
		else if(sql_num_rows($restmpls) > 1)
		{
			$sqlstdtmpl = " SELECT t1.viewFile FROM placement_resume_templates t1, student_resume_template t2 WHERE t1.templateID = t2.templateID AND t2.studentID = \"".$studentID."\" ";
			$resstdtmpl = sql_query($sqlstdtmpl, $connect);
			if(sql_num_rows($resstdtmpl))
			{
				$rowstdtmpl = sql_fetch_row($resstdtmpl);
				
				include "".$rowstdtmpl[0]."";
			}
		}
		
	}
	
}


?>
