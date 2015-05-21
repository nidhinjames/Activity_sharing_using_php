<?

function mark_filter_interface($adminID, $preferredMarkSystem, $taskType, $processType, $courseTypeID, $deptID, $batchID, $batchStartYear, $batchEndYear, $currentMarkFilter, $prevMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark)
{
	// $universityMarkSystem specifies whether the student mark is in percentage, cgpa 
	global $connect;
	//$preferredMarkSystem = 0; // Each Course Type with its mark system
	//$taskType = 0; // For studentIDs
	//$processType = 0; // For Event, Announcement, Student Filter Where only one couse type at a time and other marks are previous course
	//$processType = 1; // For Job, Internship Where multiple couse type at a time and their marks with no previous course mark 
	
	//$courseTypeID = "array";
	//$deptID = "array";
	//$batchID = "array";
	//$batchStartYear = "array";
	//$batchEndYear = "array";
	//$currentMarkFilter = "1=BETWEEN:50,90-3=ABOVE:8-4=ABOVE:6";
	//$prevMarkFilter = "";
	//$genderFilter = "male";
	//$backLog = 3;
	//$backHistory = 5;
	//$tenthMark = "ABOVE:60";
	//$twelthMark = "";
	
	
	if($batchStartYear)
	{
		$batchEndYear = NULL;
		$batchStartYear = process_year_array($batchStartYear, $batchEndYear);
	}
	else if($batchEndYear)
	{
		$batchStartYear = NULL;
		$batchEndYear = process_year_array($batchStartYear, $batchEndYear);
	}
	
	//echo "<br> year string : Interface : ".$batchStartYear."<br>";
	
	$dept_string = process_department_array($deptID, $adminID);
	
	//echo "<br> Dept string : Interface : ".$dept_string."<br>";
	
	$course_string = process_course_array($courseTypeID);
	
	//echo "<br>course string : Interface : ".$course_string."<br>";
	
	$batch_string = process_batch_array($course_string, $batchID, $dept_string, $batchStartYear, $batchEndYear);
	
	//echo "<br>batch string : Interface : ".$batch_string."<br><br>";
	
	$sql = " SELECT entryType FROM placement_settings ";
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_row($res);
		$dataEntryFormat = $row[0];
	}
	//echo $processType;
	
	//echo $batch_string."batchstring";
	
	if($batch_string)
	{
	
		if($taskType == 0)
		{
		
			if($dataEntryFormat == 0) //Detailed Data Entry
			{
				if($processType == 0) // Filter Student With Privious Course Mark 
				{
					$studentID = get_student_from_mark_or_grade_detailed_data_with_prev_course($adminID, $courseTypeID, $batch_string, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark);
					
					//echo "<br> Filter Student With Privious Course Mark In Detailed Entry. <br>";
				}
				else if($processType == 1) // Filter Students of multiple Courses
				{
					$studentID = get_student_from_mark_or_grade_detailed_data($adminID, $courseTypeID, $batch_string, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark);
				}
			}
			else if($dataEntryFormat == 1) // Row Data Entry
			{
				if($processType == 0) // Filter Student With Privious Course Mark 
				{
					//echo "<br> Filter Student With Privious Course Mark In Row Data Entry. <br>";
					
					$studentID = get_student_from_mark_or_grade_row_data_with_prev_course($adminID, $courseTypeID, $batch_string, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark);
					
					
				}
				else if($processType == 1) // Filter Students of multiple Courses 
				{
					//echo "<br> Filter Student Without Privious Course Mark In Row data entry. <br>";
					
					$studentID = get_student_from_mark_or_grade_row_data($adminID, $courseTypeID, $batch_string, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark);
				}
			}
		
		}
		else
		{
			
		}
	}
	else
	{
		$studentID = "";
	}
	
	return $studentID;
}

function get_student_from_mark_or_grade_row_data_with_prev_course($adminID, $courseTypeID, $batchString, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark)
{
	global $connect;
	
	$sql = " SELECT priorcourseID FROM course_type_prior WHERE courseTypeID =\"".$courseTypeID."\" ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		unset($prevCourseTypeID);
		$i = 0;
		while($row = sql_fetch_row($res))
		{
			$prevCourseTypeID[$i] = $row[0];
			$i++;
		}
	}
	//print_r($prevCourseTypeID);
	
	//$currentMarkFilter = "1=BETWEEN:50,90-3=ABOVE:8-4=ABOVE:6";
	//echo $currentMarkFilter;
	$MarkFilters = explode("-",$currentMarkFilter);
	array_pop($MarkFilters);
	//print_r($MarkFilters);
	//echo "<br><br><br>";
	//$MarkFilters = array(1 => "1=BETWEEN:50,90", 2 => "3=ABOVE:8", 3 => "4=ABOVE:6")
	$j = 0;
	foreach($MarkFilters as $mark)
	{
		//echo "mark : ".$mark."<br>";
		if($mark)
		{
			$MarkStr[$j] = explode("=", $mark);
			$j++;
		}
	}
	//print_r($MarkStr);
	//Array ( [0] => Array ( [0] => 3 [1] => BETWEEN:5,6 ) [1] => Array ( [0] => 1 [1] => ABOVE:56 ) [2] => Array ( [0] => ) )
	
	$len = sizeof($MarkStr);
	
	//print_r($CourseMark);
	
	for($i = 0; $i<$len ; $i++)
	{
		$course = $MarkStr[$i][0];
		
		//echo "couresTypeID mark rule str : fn ".$course;
		
		$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$course."\" ";
		//echo $sql;
		$res = sql_query($sql, $connect);
		$row = sql_fetch_row($res);
		$markSystem = $row[0];
		
		if($markSystem != 0)
		{
			$MarkStr[$i][1] =  mark_rule("t3", $MarkStr[$i][1], $markSystem);
		}
		else
		{
			$MarkStr[$i][1] = "";
		}
		
		if($i == 0)
		{
			$correntMark = $markSystem;
		}
	}
	
		//print_r($MarkStr);
		//echo  $courseTypeID;
		
	$batchID = batch_by_course_type("t4", $batchString, $courseTypeID);
		
	$gender_string = gender_rule($gender);
			
			
	//echo "back log : ".$backLog."<br>";		
	//echo "backHistory : ".$backHistory."<br>";	
		
	$backpaper_string = back_history_and_log_rule($backLog, $backHistory);
	
	foreach($MarkStr as $mrk)
	{
		if($mrk[0] == $courseTypeID)
		{
			$mark_string = $mrk[1];
		}
	}
	
	//echo "<br>".$mark_string."<br>hai";
	//echo $tenthMark."<br>";
	//echo $twelthMark."<br>";
	
	$sslcMark_string = sslc_plustwo_rule("t1", "sslc", $tenthMark);
	//echo $sslcMark_string."sslc1<br>";
		
	$plusTwoMark_string = sslc_plustwo_rule("t1", "plustwo", $twelthMark);
	//echo $plusTwoMark_string."plustwo1";
		
	unset($studentID);	
	
	if($correntMark != 0)
	{
		$sql = " select t1.studentID, sum(t2.totalArrears) as backhistory, sum(t2.presentArrears) as backpapers  from studentaccount t1, student_course_mark t2, student_cgpa_mark t3, batches t4 where $gender_string $sslcMark_string $plusTwoMark_string $mark_string $batchID  t1.studentID = t2.studentID and t2.studentID = t3.studentID and t1.batchID = t4.batchID group by t1.studentID $backpaper_string ";
		
	}
	else
	{
		$sql = " select t1.studentID from studentaccount t1, batches t4 where $gender_string $sslcMark_string $plusTwoMark_string $mark_string $batchID t1.batchID = t4.batchID group by t1.studentID";
	}
	
	//echo "CURRENT : ".$sql."<br>";
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		while($row = sql_fetch_row($res))
		{
			if($studentID[0]  ==  NULL)
			{
				$studentID[0] = $row[0];
			}
			else
			{
				$studentID[0] = $studentID[0].",".$row[0];
			}
		}
	}
	
	$i = 0;
	
	if( is_array($prevCourseTypeID) && $studentID[0] )
	{
		//print_r($prevCourseTypeID);
		
		//print_r($MarkStr);
		foreach($prevCourseTypeID as $course)
		{
			$i++;
			
			$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$course."\" ";
			//echo $sql;
			$res = sql_query($sql, $connect);
			$row = sql_fetch_row($res);
			$markSystem = $row[0];
			
			//$batchID = batch_by_course_type("t4", $batchString, $courseTypeID);
			//echo $batchID;
			
			$gender_string = gender_rule($gender);
					
			//$backpaper_string = back_history_and_log_rule($backLog, $backHistory);
				
			$mark_string = $MarkStr[$i][1];
			
			//echo "<br>".$mark_string."<br>";
			
			if($markSystem != 0)
			{
				$sql = " select t1.studentID from studentaccount t1, student_course_mark_old t2, student_cgpa_mark_old t3, batches t4 where $mark_string t3.courseTypeID = \"".$course."\" AND t1.studentID IN (".$studentID[0].") AND t1.studentID = t2.studentID and t2.studentID = t3.studentID group by studentID ";
			
			}
			else
			{
				$sql = " select t1.studentID from studentaccount t1, university_assignbatchcourse t2, batches t4 where t1.studentID IN (".$studentID[0].") AND t2.batchID = t4.batchID AND $mark_string t2.typeID = \"".$course."\" AND t1.batchID = t4.batchID group by studentID ";
			}
			
			//echo "COURSE $course : ".$sql."<br>";
			
			$res = sql_query($sql, $connect);
			if(sql_num_rows($res))
			{
				while($row = sql_fetch_row($res))
				{
					if($studentID[$i]  == NULL)
					{
						$studentID[$i] = $row[0];
					}
					else
					{
						$studentID[$i] = $studentID[$i].",".$row[0];
					}
				}
			}
			else
			{
				$studentID[$i] = NULL;
			}
		}
		
	}
	
	//echo $sql;
	
	//print_r($studentID);
	
	$student_flag = 0;
	$studentIDs = "";
	
	if(is_array($studentID))
	{
	
		foreach($studentID as $std)
		{
			if($std == NULL)
			{
				$student_flag = 1;
				//echo "<br>HAI".$student_flag."<br>";
			}
			else
			{
				//$studentIDs = $studentIDs.",".$std;
				$studentIDs = $studentIDs." studentID IN (".$std.") AND ";
			}
		}
	}
	else
	{
		$student_flag = 1;
	}
	
	if(!$student_flag)
	{
		$students = "";
		$sql = " SELECT DISTINCT studentID FROM studentaccount WHERE $studentIDs ";
		$sql = substr($sql, 0, -5);
		//echo $sql;
		$res = sql_query($sql, $connect);
		if(sql_num_rows($res))
		{
			while($row = sql_fetch_row($res))
			{
				if($students  == "")
				{
					$students = $row[0];
				}
				else
				{
					$students = $students.",".$row[0];
				}
			}
		}
	}
	
	return $students;
	
}

function get_student_from_mark_or_grade_detailed_data_with_prev_course($adminID, $courseTypeID, $batch_string, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark)
{
	global $connect;
	
	$sql = " SELECT priorcourseID FROM course_type_prior WHERE courseTypeID =\"".$courseTypeID."\" ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		unset($prevCourseTypeID);
		$i = 0;
		while($row = sql_fetch_row($res))
		{
			$prevCourseTypeID[$i] = $row[0];
			$i++;
		}
	}
	
	//$currentMarkFilter = "1=BETWEEN:50,90-3=ABOVE:8-4=ABOVE:6";
	//echo $currentMarkFilter;
	$MarkFilters = explode("-",$currentMarkFilter);
	array_pop($MarkFilters);
	//print_r($MarkFilters);
	//echo "<br><br><br>";
	//$MarkFilters = array(1 => "1=BETWEEN:50,90", 2 => "3=ABOVE:8", 3 => "4=ABOVE:6")
	$j = 0;
	foreach($MarkFilters as $mark)
	{
		//echo "mark : ".$mark."<br>";
		if($mark)
		{
			$MarkStr[$j] = explode("=", $mark);
			$j++;
		}
	}
	//print_r($MarkStr);
	//Array ( [0] => Array ( [0] => 3 [1] => BETWEEN:5,6 ) [1] => Array ( [0] => 1 [1] => ABOVE:56 ) [2] => Array ( [0] => ) )
	
	$len = sizeof($MarkStr);
	
	//print_r($CourseMark);
	
	for($i = 0; $i<$len ; $i++)
	{
		$course = $MarkStr[$i][0];
		
		//echo "couresTypeID mark rule str : fn ".$course;
		
		$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$course."\" ";
		//echo $sql;
		$res = sql_query($sql, $connect);
		$row = sql_fetch_row($res);
		$markSystem = $row[0];
		//echo $MarkStr[$i][1]."mark".$markSystem."backlog ".$backLog."his ".$backHistory;
		if($markSystem != 0)
		{
			//echo $courseTypeID." courseTypeID ".$course." course "; 
			if($courseTypeID == $course)
			{
				$MarkStr[$i][1] =  mark_and_backlog_rule("", $MarkStr[$i][1], $markSystem, $backLog, $backHistory);
			}
			else
			{
				$MarkStr[$i][1] = mark_rule("t3", $MarkStr[$i][1], $markSystem);
				//echo $MarkStr[$i][1];
			}
		}
		else
		{
			$MarkStr[$i][1] = "";
		}
		
		if($i == 0)
		{
			$correntMark = $markSystem;
		}
	}
	
		//print_r($MarkStr);
		//echo  $batchString;
		
	$batchID = batch_by_course_type("t2", $batch_string, $courseTypeID);
	//echo $gender."gender";
	$gender_string = gender_rule($gender);
			
			
	//echo "back log : ".$backLog."<br>";		
	//echo "backHistory : ".$backHistory."<br>";
	
	foreach($MarkStr as $mrk)
	{
		if($mrk[0] == $courseTypeID)
		{
			$mark_string = $mrk[1];
		}
	}
	
	//echo "<br>".$mark_string."<br>hai";
	//echo $tenthMark."<br>";
	//echo $twelthMark."<br>";
	
	$sslcMark_string = sslc_plustwo_rule("t1", "sslc", $tenthMark);
	//echo $sslcMark_string."sslc1<br>";
		
	$plusTwoMark_string = sslc_plustwo_rule("t1", "plustwo", $twelthMark);
	//echo $plusTwoMark_string."plustwo1";
		
	unset($studentID);	
	
	if($correntMark == 0)
	{
		$sql = " SELECT t1.studentID from studentaccount t1, batches t2 WHERE $gender_string $sslcMark_string $plusTwoMark_string $batchID t1.batchID = t2.batchID group by t1.studentID $mark_string ";
	}
	else if($correntMark == 1)
	{
		$sql = " SELECT t1.studentID, t1.studentName, sum(case when (t4.chances) > 1 then 1 else 0 end) as backhistory, sum(case when ( (t4.internalMark+t4.marksObtained) < 75 AND t3.examTotalMarks > 0 ) OR (t4.marksObtained < 40 AND t3.examTotalMarks > 0) then 1 else 0 end) as backpapers, ((SUM(t4.marksObtained + t4.internalMark)/SUM(t3.examTotalMarks+t3.maxInternal))*100) as percentage from studentaccount t1, batches t2, universityMarks t4,  universityExams t3 WHERE  $gender_string $sslcMark_string $plusTwoMark_string $batchID t1.batchID = t2.batchID AND t4.subjectID = t3.subjectID AND t1.batchID = t3.batchID AND t4.examID = t3.examID AND t1.studentID = t4.studentID group by t1.studentID  $mark_string ";
	}
	else if($correntMark == 2)
	{
		//Correct
		$sql = "SELECT t1.studentID, t1.studentName, (sum(t4.gradePoint * t2.creditValue )) / (sum(t2.creditValue)) as perct, sum(case when (t3.gradeObtained = 10) then 1 else 0 end) as backpapers, sum(case when (((t3.noOfChances) > 1) || ((t3.noOfChances = 1) && (t3.gradeObtained = 10))) then 1 else 0 end) as backhistory FROM studentaccount t1, universityexams_bygrade t2, universitygrade t3, universitygradepoints t4 WHERE $gender_string $sslcMark_string $plusTwoMark_string $batchID t1.studentID = t3.studentID AND t2.examID = t3.examID AND t3.gradeObtained = t4.gradeID group by t3.studentID $mark_string ";
	}
	
	//echo "CURRENT : ".$sql."<br>";
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		while($row = sql_fetch_row($res))
		{
			if($studentID[0]  ==  NULL)
			{
				$studentID[0] = $row[0];
			}
			else
			{
				$studentID[0] = $studentID[0].",".$row[0];
			}
		}
	}
	//print_r($studentID);
	$i = 0;
	
	if( is_array($prevCourseTypeID) && $studentID[0] )
	{
		//print_r($prevCourseTypeID);
		
		//print_r($MarkStr);
		foreach($prevCourseTypeID as $course)
		{
			$i++;
			
			$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$course."\" ";
			//echo $sql;
			$res = sql_query($sql, $connect);
			$row = sql_fetch_row($res);
			$markSystem = $row[0];
				
			$mark_string = $MarkStr[$i][1];
			
			//echo "<br>".$mark_string."<br>";
			
			if($mark_string)
			{
			
				if($markSystem == 2)
				{
					$sql = " select t1.studentID, t3.cgpa as perct from studentaccount t1, student_course_mark_old t2, student_cgpa_mark_old t3, batches t4 where t3.courseTypeID = \"".$course."\" AND t1.studentID IN (".$studentID[0].") AND t1.studentID = t2.studentID and t2.studentID = t3.studentID group by studentID $mark_string ";
				
				}
				else if($markSystem == 1)
				{
					$sql = " select t1.studentID, t3.percentage as percentage from studentaccount t1, student_course_mark_old t2, student_cgpa_mark_old t3, batches t4 where t3.courseTypeID = \"".$course."\" AND t1.studentID IN (".$studentID[0].") AND t1.studentID = t2.studentID and t2.studentID = t3.studentID group by studentID $mark_string";
				}
				else if($markSystem == 0)
				{
					$sql = " select t1.studentID from studentaccount t1, university_assignbatchcourse t2, batches t4 where t1.studentID IN (".$studentID[0].") AND t2.batchID = t4.batchID AND t2.typeID = \"".$course."\" AND t1.batchID = t4.batchID group by studentID";
				}
				
				//echo "COURSE $course : ".$sql."<br>";
				
				$res = sql_query($sql, $connect);
				if(sql_num_rows($res))
				{
					while($row = sql_fetch_row($res))
					{
						if($studentID[$i]  == NULL)
						{
							$studentID[$i] = $row[0];
						}
						else
						{
							$studentID[$i] = $studentID[$i].",".$row[0];
						}
					}
				}
				else
				{
					$studentID[$i] = NULL;
				}
			
			}
			
		}
		
	}
	
	//echo $sql;
	
	//print_r($studentID);
	
	$student_flag = 0;
	$studentIDs = "";
	
	if(is_array($studentID))
	{
	
		foreach($studentID as $std)
		{
			if($std == NULL)
			{
				$student_flag = 1;
				//echo "<br>HAI".$student_flag."<br>";
			}
			else
			{
				//$studentIDs = $studentIDs.",".$std;
				$studentIDs = $studentIDs." studentID IN (".$std.") AND ";
			}
		}
	}
	else
	{
		$student_flag = 1;
	}
	
	//echo $studentIDs;
	
	if(!$student_flag)
	{
		$students = "";
		$sql = " SELECT DISTINCT studentID FROM studentaccount WHERE $studentIDs ";
		$sql = substr($sql, 0, -5);
		//echo $sql;
		$res = sql_query($sql, $connect);
		if(sql_num_rows($res))
		{
			while($row = sql_fetch_row($res))
			{
				if($students  == "")
				{
					$students = $row[0];
				}
				else
				{
					$students = $students.",".$row[0];
				}
			}
		}
	}
	//echo $students;
	return $students;
}


function get_student_from_mark_or_grade_row_data($adminID, $courseTypeID, $batchString, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark)
{
	global $connect;
	//$currentMarkFilter = "1=BETWEEN:50,90-3=ABOVE:8-4=ABOVE:6";
	//echo $batchString."batch str";
	
	$MarkFilters = explode("-",$currentMarkFilter);
	array_pop($MarkFilters);
	
	//$MarkFilters = array(1 => "1=BETWEEN:50,90", 2 => "3=ABOVE:8", 3 => "4=ABOVE:6")
	
	$j = 0;
	foreach($MarkFilters as $mark)
	{
		//echo "mark : ".$mark."<br>";
		if($mark)
		{
			$MarkStr[$j] = explode("=", $mark);
			$j++;
		}
	}
	
	$len = sizeof($MarkStr);
	
	//print_r($CourseMark);
	
	for($i = 0; $i<$len ; $i++)
	{
		$course = $MarkStr[$i][0];
		
		//echo "couresTypeID mark rule str : fn ".$course;
		
		$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$course."\" ";
		//echo $sql;
		$res = sql_query($sql, $connect);
		$row = sql_fetch_row($res);
		$markSystem = $row[0];
		
		$MarkStr[$i][2] = $markSystem;
		
		if($markSystem != 0)
		{
			$MarkStr[$i][1] =  mark_rule("t3", $MarkStr[$i][1], $markSystem);
		}
		else
		{
			$MarkStr[$i][1] = "";
		}
		
	}
	
	//print_r($MarkStr);
	$i = 0;
	$studentIDs  = "";
	foreach($MarkStr as $mkr)
	{
		$courseTypeID = $mkr[0];
		$mark_string = $mkr[1];
		$markSystem = $mkr[2];
		
		$batchID = batch_by_course_type("t4", $batchString, $courseTypeID);
		$gender_string = gender_rule($gender);
		//echo "course batches: ".$batchID."<br>";
		
		//echo "back log : ".$backLog."<br>";		
		//echo "backHistory : ".$backHistory."<br>";	
		
		if($markSystem != 0)
		{
			$backpaper_string = back_history_and_log_rule($backLog, $backHistory);
		}
		else
		{
			$backpaper_string = "";
		}
	
		//echo "<br>".$mark_string."<br>hai";
		//echo $tenthMark."<br>";
		//echo $twelthMark."<br>";
	
		$sslcMark_string = sslc_plustwo_rule("t1", "sslc", $tenthMark);
		//echo $sslcMark_string."sslc1<br>";
			
		$plusTwoMark_string = sslc_plustwo_rule("t1", "plustwo", $twelthMark);
		
		if($markSystem != 0)
		{
			$sql = " select t1.studentID, sum(t2.totalArrears) as backhistory, sum(t2.presentArrears) as backpapers  from studentaccount t1, student_course_mark t2, student_cgpa_mark t3, batches t4 where $gender_string $sslcMark_string $plusTwoMark_string $mark_string $batchID t1.studentID = t2.studentID and t2.studentID = t3.studentID and t1.batchID = t4.batchID group by studentID $backpaper_string ";
		}
		else
		{
			$sql = " select t1.studentID  from studentaccount t1, batches t4 where $gender_string $sslcMark_string $plusTwoMark_string $batchID t1.batchID = t4.batchID group by studentID $backpaper_string ";
		}
		/*echo "<br>";
		echo "<br>";
		echo $sql."<br>";
		echo "<br>";
		echo "<br>";*/
		
		$res = sql_query($sql, $connect);
		if(sql_num_rows($res))
		{
			while($row = sql_fetch_row($res))
			{
				if($studentIDs  == "")
				{
					$studentIDs = $row[0];
				}
				else
				{
					$studentIDs = $studentIDs.",".$row[0];
				}
			}
		}
			
		$i++;	
	}
	return $studentIDs;
}

//.....................................................NOW...................................................................................................

function get_student_from_mark_or_grade_detailed_data($adminID, $courseTypeID, $batchString, $currentMarkFilter, $gender, $backLog, $backHistory, $tenthMark, $twelthMark)
{
	global $connect;
	//$currentMarkFilter = "1=BETWEEN:50,90-3=ABOVE:8-4=ABOVE:6";
	//echo $batchString."batch str";
	
	$MarkFilters = explode("-",$currentMarkFilter);
	array_pop($MarkFilters);
	
	//$MarkFilters = array(1 => "1=BETWEEN:50,90", 2 => "3=ABOVE:8", 3 => "4=ABOVE:6")
	
	$j = 0;
	foreach($MarkFilters as $mark)
	{
		//echo "mark : ".$mark."<br>";
		if($mark)
		{
			$MarkStr[$j] = explode("=", $mark);
			$j++;
		}
	}
	
	$len = sizeof($MarkStr);
	
	//print_r($MarkStr);
	
	for($i = 0; $i<$len ; $i++)
	{
		$course = $MarkStr[$i][0];
		
		//echo "couresTypeID mark rule str : fn ".$course;
		
		$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$course."\" ";
		//echo $sql;
		$res = sql_query($sql, $connect);
		$row = sql_fetch_row($res);
		$markSystem = $row[0];
		
		$MarkStr[$i][2] = $markSystem;
		
		if($markSystem != 0)
		{
			//$MarkStr[$i][1] =  mark_rule("t3", $MarkStr[$i][1], $markSystem);
			$MarkStr[$i][1] = mark_and_backlog_rule("", $MarkStr[$i][1], $markSystem, $backLog, $backHistory);
		}
		else
		{
			$MarkStr[$i][1] = "";
		}
		
	}
	
	//print_r($MarkStr);
	$i = 0;
	$studentIDs  = "";
	foreach($MarkStr as $mkr)
	{
		$courseTypeID = $mkr[0];
		$mark_string = $mkr[1];
		$markSystem = $mkr[2];
		
		$batchID = batch_by_course_type("t1", $batchString, $courseTypeID);
		$gender_string = gender_rule($gender);
		//echo "course batches: ".$batchID."<br>";
		
		//echo "back log : ".$backLog."<br>";		
		//echo "backHistory : ".$backHistory."<br>";	
		
		//$backpaper_string = back_history_and_log_rule($backLog, $backHistory);
	
		//echo "<br>".$mark_string."<br>hai";
		//echo $tenthMark."<br>";
		//echo $twelthMark."<br>";
	
		$sslcMark_string = sslc_plustwo_rule("t1", "sslc", $tenthMark);
		//echo $sslcMark_string."sslc1<br>";
			
		$plusTwoMark_string = sslc_plustwo_rule("t1", "plustwo", $twelthMark);
		
		if($markSystem == 0)
		{
			$sql = " SELECT t1.studentID, t1.studentName FROM studentaccount t1, batches t2 WHERE $gender_string $sslcMark_string $plusTwoMark_string $batchID t1.batchID = t2.batchID ";
		}
		if($markSystem == 1)
		{
			
			$sql = " SELECT t1.studentID, t1.studentName, sum(case when (t2.chances) > 1 then 1 else 0 end) as backhistory, sum(case when ( (t2.internalMark+t2.marksObtained) < 75 AND t3.examTotalMarks > 0 ) OR (t2.marksObtained < 40 AND t3.examTotalMarks > 0) then 1 else 0 end) as backpapers, ((SUM(t2.marksObtained + t2.internalMark)/SUM(t3.examTotalMarks+t3.maxInternal))*100) as percentage from universityMarks t2, studentaccount t1, universityExams t3 WHERE  $gender_string $sslcMark_string $plusTwoMark_string t2.subjectID = t3.subjectID AND t1.batchID = t3.batchID AND t2.examID = t3.examID AND $batchID t1.studentID = t2.studentID group by t1.studentID  $mark_string ";
				
		}
		else if($markSystem == 2)
		{	
			//$sql = "SELECT t1.studentID, t1.studentName, (sum(t4.gradePoint * t2.creditValue )) / (sum(t2.creditValue)) as perct, sum(case when (t3.gradeObtained = 10) then 1 else 0 end) as backpaper, sum(case when (((t3.noOfChances) > 1) || ((t3.noOfChances = 1) && (t3.gradeObtained = 10))) then 1 else 0 end) as backhistory FROM studentaccount t1, universityexams_bygrade t2, universitygrade t3, universitygradepoints t4 WHERE $gender_string $sslcMark_string $plusTwoMark_string $batchID t1.studentID = t3.studentID AND t2.examID = t3.examID AND t3.gradeObtained = t4.gradeID group by t3.studentID $mark_string ";
			
			$sql = "SELECT t1.studentID, t1.studentName, (sum(t4.gradePoint * t2.creditValue )) / (sum(t2.creditValue)) as perct, sum(case when (t3.gradeObtained = 10) then 1 else 0 end) as backpapers, sum(case when (((t3.noOfChances) > 1) || ((t3.noOfChances = 1) && (t3.gradeObtained = 10))) then 1 else 0 end) as backhistory FROM studentaccount t1, universityexams_bygrade t2, universitygrade t3, universitygradepoints t4 WHERE $gender_string $sslcMark_string $plusTwoMark_string $batchID t1.studentID = t3.studentID AND t2.examID = t3.examID AND t3.gradeObtained = t4.gradeID group by t3.studentID $mark_string ";
		}
		
		
		/*echo "<br>";
		echo "<br>";
		echo $sql."<br>";
		echo "<br>";
		echo "<br>";*/
		
		$res = sql_query($sql, $connect);
		if(sql_num_rows($res))
		{
			while($row = sql_fetch_row($res))
			{
				if($studentIDs  == "")
				{
					$studentIDs = $row[0];
				}
				else
				{
					$studentIDs = $studentIDs.",".$row[0];
				}
			}
		}
			
		$i++;	
	}
	return $studentIDs;
}

function placed_direct($studentIDs)
{
	global $connect;
	
	if($studentIDs)
	{
		$studentIDs = " WHERE studentID IN ($studentIDs) ";
	
	
		$sqlplaced = "SELECT DISTINCT studentID FROM direct_student_placement $studentIDs  ";
		//echo $sqlplaced;
		$resplaced = sql_query($sqlplaced, $connect);
		if(sql_num_rows($resplaced))
		{
			$stdplaced = "";
			while($rowplaced = sql_fetch_row($resplaced))
			{
				if($stdplaced == "")
				{
					$stdplaced = $rowplaced[0];
				}
				else
				{
					$stdplaced = $stdplaced.",".$rowplaced[0];
				}
			}
		}
	
	}
						
	return $stdplaced;
}

function placed_event($studentIDs)
{
	global $connect;
	
	
	$sql1 = "select max(interviewLevelID) from placement_interview_levels";
	//echo $sql1;
	$res1 = sql_query($sql1, $connect);
	$row1 = sql_fetch_row($res1);
	$max = $row1[0];
	
	if($studentIDs)
	{
		$studentIDs = " t1.studentID IN ($studentIDs) AND ";
	
		$sqlplaced = " SELECT DISTINCT t1.studentID FROM studentaccount t1, placement_eventlevel_student t8 WHERE $studentIDs t1.studentID = t8.studentID AND t8.eventLevelID = \"".$max."\" ";
		//echo $sqlplaced;
		$resplaced = sql_query($sqlplaced, $connect);
		if(sql_num_rows($resplaced))
		{
			$stdplaced = "";
			while($rowplaced = sql_fetch_row($resplaced))
			{
				if($stdplaced == "")
				{
					$stdplaced = $rowplaced[0];
				}
				else
				{
					$stdplaced = $stdplaced.",".$rowplaced[0];
				}
			}
		}
	
	}
						
	return $stdplaced;
}

function placed_students($studentIDs)
{
	global $connect;
	
	if($studentIDs)
	{
		$studentIDs = "studentID IN ($studentIDs) AND ";
	
	
		$sqlplaced = "SELECT DISTINCT studentID FROM placement_profile_student_report WHERE $studentIDs selected = 1  ";
		//echo $sqlplaced;
		$resplaced = sql_query($sqlplaced, $connect);
		if(sql_num_rows($resplaced))
		{
			$stdplaced = "";
			while($rowplaced = sql_fetch_row($resplaced))
			{
				if($stdplaced == "")
				{
					$stdplaced = $rowplaced[0];
				}
				else
				{
					$stdplaced = $stdplaced.",".$rowplaced[0];
				}
			}
		}
	
	}
						
	return $stdplaced;
}

function intern_students($studentIDs)
{
	global $connect;
	
	if($studentIDs)
	{
		$studentIDs = "studentID IN ($studentIDs) AND ";
	
	
		$sqlplaced = "SELECT DISTINCT studentID FROM internship_student_report WHERE $studentIDs selected = 1  ";
		$resplaced = sql_query($sqlplaced, $connect);
		if(sql_num_rows($resplaced))
		{
			$stdplaced = "";
			while($rowplaced = sql_fetch_row($resplaced))
			{
				if($stdplaced == "")
				{
					$stdplaced = $rowplaced[0];
				}
				else
				{
					$stdplaced = $stdplaced.",".$rowplaced[0];
				}
			}
		}
	
	}
						
	return $stdplaced;
}

function mark_string_to_filter_string($mark_string, $gender_string, $grade, $type)
{
	if($type == 0)
	{
		$first = explode(":", $mark_string);
		if($first[0] == "ALL")
		{
			$filterString = "ALL ".$genderString." STUDENTS ";
		} 
		else if($first[0] == "BETWEEN")
		{
			$second = explode(",", $first[1]);
			$start = $second[0];
			$end = $second[1];
			if($grade == 1)
				$filterString = " ".$genderString."STUDENTS WITH MARK BETWEEN ".$start." AND ".$end." PERCENTAGE";
			else if($grade == 2)
				$filterString = " ".$genderString."STUDENTS WITH CGPA BETWEEN ".$start." AND ".$end." ";
		}
		else if($first[0] == "ABOVE")
		{
			$above = $first[1];
			if($grade == 1)
				$filterString = " ".$genderString." STUDENTS WITH MARK ABOVE ".$above." PERCENTAGE";
			else if($grade == 2)
				$filterString = " ".$genderString." STUDENTS WITH CGPA ABOVE ".$above." ";
		}
		else if($first[0] == "BELOW")
		{
			$below = $first[1];
			if($grade == 1)
				$filterString = " ".$genderString." STUDENTS WITH MARK BELOW".$below." PERCENTAGE";
			else if($grade == 2)
				$filterString = " ".$genderString." STUDENTS WITH CGPA BELOW".$below." ";
		}	
	}
	
	return $filterString;
}

function mark_and_backlog_rule($table_prefix, $markString, $markSystem, $backLog, $backHistory)
{
	
	//echo "table: ".$table_prefix." mark ".$markString." markSystem ".$markSystem." backLog ".$backLog." backHistory ".$backHistory;
	
	if( ($backLog == 999) && ($backHistory != 999)  )
	{
		$backPaperHistorySql = " backhistory <= \"".$backHistory."\" ";
	}				
	else if( ($backHistory == 999) && ($backLog != 999) )
	{
		$backPaperHistorySql = " backpapers <= \"".$backLog."\" ";
	}
	else if( ($backHistory != 999) && ($backLog != 999)  )
	{
		$backPaperHistorySql = " backhistory <= \"".$backHistory."\" AND backpapers <= \"".$backLog."\" ";
	}
	else
	{
		$backPaperHistorySql = "";
	}
	
	//echo $backPaperHistorySql." back history";
	
	$split_mark1 = explode(":", $markString);
	//print_r($split_mark1);
	if($split_mark1[0] == "BETWEEN")
	{
		$split_mark2 = explode(",", $split_mark1[1]);
		
		if($markSystem == 0)
		{
			$sqlString = "";
		}	
		else if($markSystem == 1)
		{
			$sqlString = " percentage >= \"".$split_mark2[0]."\" AND percentage <= \"".$split_mark2[1]."\" ";
		}	
		else if($markSystem == 2)
		{
			$sqlString = " perct >= \"".$split_mark2[0]."\" AND perct <= \"".$split_mark2[1]."\" ";
		}
		
	}
	else if($split_mark1[0] == "ABOVE")
	{
		if($markSystem == 0)
		{
			$sqlString = "";
		}	
		else if($markSystem == 1)
		{
			$sqlString = " percentage >= \"".$split_mark1[1]."\" ";
		}	
		else if($markSystem == 2)
		{
			$sqlString = " perct >= \"".$split_mark1[1]."\" ";
		}
	}
	else if($split_mark1[0] == "BELOW")
	{
		if($markSystem == 0)
		{
			$sqlString = "";
		}	
		else if($markSystem == 1)
		{
			$sqlString = " percentage <= \"".$split_mark1[1]."\" ";
		}	
		else if($markSystem == 2)
		{
			$sqlString = " perct <= \"".$split_mark1[1]."\" ";
		}
	}
	else if($split_mark1[0] == "ALL")
	{
		$sqlString = "";
	}
	//echo $sqlString." mark string ";
	
	
	if( ($sqlString != "") && ($backPaperHistorySql != "") )
	{
		$str = "having ( ".$sqlString." AND ".$backPaperHistorySql." )";
	}
	else if ( ($sqlString != "") && ($backPaperHistorySql == "") )
	{
		$str = "having ( ".$sqlString." )";
	}
	else if ( ($backPaperHistorySql != "") && ($sqlString == "") )
	{
		$str = "having (".$backPaperHistorySql." )";
	}
	else
	{
		$str = " ";
	}
	
	return $str;
	
}

function sslc_plustwo_rule($table_prefix, $fieldName, $markString)
{
	//echo "table : ".$table_prefix." fieldName : ".$fieldName." : ".$markString;
	
	//global $connect;
	
	$split_mark1 = explode(":", $markString);
	
	if($split_mark1[0] == "BETWEEN")
	{
		$split_mark2 = explode(",", $split_mark1[1]);
		
		$sqlString = $table_prefix.".".$fieldName." >= ".$split_mark2[0]." AND ".$table_prefix.".".$fieldName." <= ".$split_mark2[1]." AND  ";
	}
	else if($split_mark1[0] == "ABOVE")
	{
		$sqlString = $table_prefix.".".$fieldName." >= ".$split_mark1[1]." AND ";
	}
	else if($split_mark1[0] == "BELOW")
	{
		$sqlString = $table_prefix.".".$fieldName." <= ".$split_mark1[1]." AND ";
	}
	else if($split_mark1[0] == "ALL")
	{
		$sqlString = "";
	}
	
	return $sqlString;
}

function gender_rule($gender)
{
	$gender_string = "";

	if($gender == 'male')
	{
		$gender_string = "t1.studentGender = 'male' AND";
	}

	if($gender == 'female')
	{
		$gender_string = "t1.studentGender = 'female' AND";
	}
	
	return $gender_string;
}

function back_history_and_log_rule($backLog, $backHistory)
{
	if( ($backLog == 999) && ($backHistory != 999)  )
	{
		$backPaperHistorySql = " having (backhistory <= \"".$backHistory."\" ) ";
	}				
	else if( ($backHistory == 999) && ($backLog != 999) )
	{
		$backPaperHistorySql = " having ( backpapers <= \"".$backLog."\" ) ";
	}
	else if( ($backHistory != 999) && ($backLog != 999)  )
	{
		$backPaperHistorySql = " having (backhistory <= \"".$backHistory."\" AND backpapers <= \"".$backLog."\" ) ";
	}
	else
	{
		$backPaperHistorySql = "";
	}
	
	return $backPaperHistorySql;
}

function mark_rule($table_prefix, $markString, $markSystem)
{
	//$markString = "BETWEEN:50,60";
	//echo "Table Prifix : ".$table_prefix."mark : ".$markString." Mark system: ".$markSystem;
	global $connect;
	
	$sql = " SELECT entryType FROM placement_settings ";
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_row($res);
		$dataEntryFormat = $row[0];
	}
	
	$split_mark1 = explode(":", $markString);
	//print_r($split_mark1);
	if($split_mark1[0] == "BETWEEN")
	{
		$split_mark2 = explode(",", $split_mark1[1]);
		
		//$sqlString = " t3.cgpa <= ".$below." AND ";
		
		if($dataEntryFormat == 0)
		{
			if($markSystem == 0)
			{
				$sqlString = "";
			}	
			else if($markSystem == 1)
			{
				$sqlString = " having (percentage >= \"".$split_mark2[0]."\" AND percentage <= \"".$split_mark2[1]."\" ) ";
			}	
			else if($markSystem == 2)
			{
				$sqlString = " having (perct >= \"".$split_mark2[0]."\" AND perct <= \"".$split_mark2[1]."\" ) ";
			}
		}
		else
		{
			if($markSystem == 0)
			{
				$sqlString = "";
			}	
			else if($markSystem == 1)
			{
				$sqlString = $table_prefix.".percentage >= ".$split_mark2[0]." AND ".$table_prefix.".percentage <= ".$split_mark2[1]." AND  ";
			}	
			else if($markSystem == 2)
			{
				$sqlString = $table_prefix.".cgpa >= ".$split_mark2[0]." AND ".$table_prefix.".cgpa <= ".$split_mark2[1]." AND  ";
			}
		}
		
	}
	else if($split_mark1[0] == "ABOVE")
	{
		//print_r($split_mark1);
		if($dataEntryFormat == 0)
		{
			if($markSystem == 0)
			{
				$sqlString = "";
			}	
			else if($markSystem == 1)
			{
				$sqlString = " having percentage >= \"".$split_mark1[1]."\" ";
			}	
			else if($markSystem == 2)
			{
				$sqlString = " having perct >= \"".$split_mark1[1]."\" ";
			}
		}
		else
		{
			if($markSystem == 0)
			{
				$sqlString = "";
			}	
			else if($markSystem == 1)
			{
				$sqlString = $table_prefix.".percentage >= ".$split_mark1[1]." AND " ;
			}	
			else if($markSystem == 2)
			{
				$sqlString = $table_prefix.".cgpa >= ".$split_mark1[1]." AND ";
			}
		}
	}
	else if($split_mark1[0] == "BELOW")
	{
		//print_r($split_mark1);
		if($dataEntryFormat == 0)
		{
			if($markSystem == 0)
			{
				$sqlString = "";
			}	
			else if($markSystem == 1)
			{
				$sqlString = " having percentage <= \"".$split_mark1[1]."\" ";
			}	
			else if($markSystem == 2)
			{
				$sqlString = " having perct <= \"".$split_mark1[1]."\" ";
			}
		}
		else
		{
			if($markSystem == 0)
			{
				$sqlString = "";
			}	
			else if($markSystem == 1)
			{
				$sqlString = $table_prefix.".percentage <= ".$split_mark1[1]." AND " ;
			}	
			else if($markSystem == 2)
			{
				$sqlString = $table_prefix.".cgpa <= ".$split_mark1[1]." AND ";
			}
		}
	}
	else if($split_mark1[0] == "ALL")
	{
		$sqlString = "";
	}
	
	return $sqlString;
	
}

function placement_admin_dept_privilege($adminID, $table_prefix)
{
	global $connect;
	
	$sql = " SELECT t1.deptID FROM placement_dept_privileges t1 , placement_admin t2 WHERE t1.stafftypeID = t2.stafftypeID AND t2.adminID = \"".$adminID."\" ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	$i = 0;
	while($row = sql_fetch_row($res))
	{
		if($i == 0)
		{
			$deptID = $row[0];
		}
		else
		{
			$deptID = $deptID.",".$row[0];
		}
		$i++;
	}
	//$deptID = $row[0];
	
	if($deptID == "0")
	{
		$deptStrs = "";
	}
	else
	{
		if( ($table_prefix != "") && ($deptStrs != "0") )
		{
			$deptStrs = "$table_prefix.deptID IN ($deptID) ";
		}
		else
		{
			$deptStrs = "deptID IN ($deptID) ";
		}
	} 
	 
	return $deptStrs;
}

function process_course_array($courseTypeID)
{
	global $connect;
	$course_flag = 0;
	
	if(is_array($courseTypeID))
	{
		$course_string = "";
		foreach($courseTypeID as $b)
		{
			
			if($course_string == "")
				$course_string = $b;
			else
				$course_string = $course_string.",".$b;
			if($b == 0)
			{
				$course_flag = 1;
			}
		}
	}
	else if($courseTypeID)
	{
		$course_string = $courseTypeID;
	}
	else
	{
		$course_flag = 1;
	}
	
	if($course_flag)
	{
		$sql = " SELECT typeID FROM university_coursetypegrading ";
		$res = sql_query($sql, $connect);
		if(sql_num_rows($res))
		{
			$course_string = "";
			while($row = sql_fetch_row($res))
			{
				if($course_string == "")
				{
					$course_string = $row[0];
				}
				else
				{
					$course_string = $course_string.",".$row[0];
				}
			}
		}
		
	}
	
	return $course_string;
	
}

function process_batch_array($course_string, $batchID, $dept_string, $batchStartYear, $batchEndYear)
{
	global $connect;
	
	//echo "Course : ".$course_string." dept : ".$dept_string." year : ".$batchStartYear;
	
	if($dept_string)
	{
		$dept_string = "t1.deptID IN ($dept_string) AND";
	}
	
	if($batchStartYear)
	{
		$year_string = "t1.batchStartYear IN ($batchStartYear) AND";
	}
	else if($batchEndYear)
	{
		$year_string = "t1.batchEndYear IN ($batchEndYear) AND";
	}
	
	if($course_string)
	{
		$course_string = "t2.typeID IN ($course_string) AND";
	}
	//print_r($batchID);
	if(is_array($batchID))
	{
		$batch_string = "";
		foreach($batchID as $b)
		{
			
			if($batch_string == "")
				$batch_string = $b;
			else
				$batch_string = $batch_string.",".$b;
			if($b == 0)
			{
				$batch_flag = 1;
			}
		}
	}
	else if($batchID == 0)
	{
		$batch_flag = 1;
	}
	else
	{
		$batch_string = $batchID;
	}
	
	//print_r($batchID);
	
	if($batch_flag == 1)
	{	
		$batch_string = "";
		$sql = "SELECT t1.batchID FROM batches t1, university_assignbatchcourse t2 where t1.batchID = t2.batchID AND $course_string $dept_string $year_string t1.batchHide = 0";
		//echo $sql;
		$result = sql_query($sql, $connect);
		$btst = 0;
		while($row=sql_fetch_array($result)) 
		{ 
			if($batch_string == "")
			{
				$batch_string = $row[0];
			}
			else
			{
				$batch_string = $batch_string.",".$row[0];
			}

		}
		
	}
	else
	{
		if($batch_string)
		{
			$batch_string = "batchID IN ($batch_string) AND ";
		}
		else
		{
			$batch_string = "";
		}
		$sql = "SELECT t1.batchID FROM batches t1 where $batch_string $dept_string $year_string batchHide = 0";
		//echo $sql;
		$result = sql_query($sql, $connect);
		$btst = 0;
		if(sql_num_rows($result))
		{
			$batch_string = "";
			while($row=sql_fetch_array($result)) 
			{ 
				if($batch_string == "")
				{
					$batch_string = $row[0];
				}
				else
				{
					$batch_string = $batch_string.",".$row[0];
				}

			}
		}
		else
		{
			$batch_string = "";
		}
	}
	//echo $sql;
	//echo "Batch : ".$batch_string."</br>";
	
	return $batch_string;
	
}

function process_year_array($batchStartYear, $batchEndYear)
{
	$year_string = "";
	$year_flag = 0;
	global $connect;
	
	if($batchStartYear)
	{
		if(is_array($batchStartYear))
		{
			foreach($batchStartYear as $d)
			{
				if($year_string == "")
				{
					$year_string = $d;
				}
				else
				{
					$year_string = $year_string.",".$d;
				}
				
				if($d == 0)
				{
					$year_flag = 1;
				}
			}
		}
		else if($batchStartYear == 0)
		{
			$year_flag = 1;
		}
		
		if($year_flag)
		{
			$sql = " SELECT DISTINCT batchStartYear FROM batches WHERE batchHide = 0 AND batchName != 'failed' ";
			//echo $sql;
			$result = sql_query($sql, $connect);
			if(sql_num_rows($result))
			{
				$year_string = "";
				while($row  = sql_fetch_row($result)) 
				{
					if($year_string == "")
					{
						$year_string = $row[0];
					}
					else
					{
						$year_string = $year_string.",".$row[0];
					}
				}
			}
			
		}
	}
	else if($batchEndYear)
	{
		
		if(is_array($batchEndYear))
		{
			foreach($batchEndYear as $d)
			{
				if($year_string == "")
				{
					$year_string = $d;
				}
				else
				{
					$year_string = $year_string.",".$d;
				}
				
				if($d == 0)
				{
					$year_flag = 1;
				}
			}
		}
		else if($batchEndYear == 0)
		{
			$year_flag = 1;
		}
		
		if($year_flag)
		{
			$sql = " SELECT DISTINCT batchEndYear FROM batches WHERE batchHide = 0 AND batchName != 'failed' ";
			//echo $sql;
			$result = sql_query($sql, $connect);
			if(sql_num_rows($result))
			{
				$year_string = "";
				while($row  = sql_fetch_row($result)) 
				{
					if($year_string == "")
					{
						$year_string = $row[0];
					}
					else
					{
						$year_string = $year_string.",".$row[0];
					}
				}
			}
			
		}
	}
	
	return $year_string;
}

function process_department_array($deptID, $adminID)
{
	global $connect;
	
	$dept_string = "";
	$dept_flag = 0;
	
	$table_prefix = "";
	
	if($adminID)
	{
		$deptStrs = placement_admin_dept_privilege($adminID, $table_prefix);
		
		if($deptStrs)
		{
			$deptStrs = "$deptStrs AND";
		}
	}
	
	//echo " ADMIN ID Prev dept : ".$adminID;
	
	if(is_array($deptID))
	{
		foreach($deptID as $d)
		{
			if($dept_string == "")
			{
				$dept_string = $d;
			}
			else
			{
				$dept_string = $dept_string.",".$d;
			}
			
			if($d == 0)
			{
				$dept_flag = 1;
			}				
		}
	}
	else if($deptID == 0)
	{
		$dept_flag = 1;
	}
	else
	{
		$dept_string = $deptID;
	}
	
	if($dept_flag)
	{
		$dept_string = "";
		$sql = "SELECT deptID FROM department where $deptStrs deptShow = 1 ";
		$res = sql_query($sql, $connect);
		if(sql_num_rows($res))
		{
			$dept_string = "";
			while($row = sql_fetch_row($res))
			{
				if($dept_string == "")
				{
					$dept_string = $row[0];
				}
				else
				{
					$dept_string = $dept_string.",".$row[0];
				}
			}
		}
	}
	else
	{
		if($dept_string)
		{
			$dept_string = "deptID IN ($dept_string) AND";
		}
		
		$sql = "SELECT deptID FROM department where $dept_string $deptStrs deptShow = 1 ";
		$res = sql_query($sql, $connect);
		if(sql_num_rows($res))
		{
			$dept_string = "";
			while($row = sql_fetch_row($res))
			{
				if($dept_string == "")
				{
					$dept_string = $row[0];
				}
				else
				{
					$dept_string = $dept_string.",".$row[0];
				}
			}
		}
	}
	
	//echo $sql;
	
	return $dept_string;
}

function batch_by_course_type($table_prefix, $batchString, $courseTypeID) // Return the batchIDs of a perticular course
{
	global $connect;
	
	//$batchID = "46,47,48,49,50,51,52,54,55,56,57";
	
	$sql = " SELECT t1.batchID FROM batches t1, university_assignbatchcourse t2 WHERE t1.batchID IN ($batchString) AND t1.batchID = t2.batchID AND t2.typeID = \"".$courseTypeID."\" ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$batches = "";
		while($row = sql_fetch_row($res))
		{
			if($batches == "")
			{
				$batches = $row[0];
			}
			else
			{
				$batches = $batches.",".$row[0];
			}
		}
	}
	
	if($batches)
	{
		$batches = $table_prefix.". batchID IN ($batches) AND";
	}
	
	return $batches;
}


?>
