<?

function placement_report_interface($interfaceType, $studentID, $courseTypeID)
{
	global $connect;
	//echo $studentID. $courseTypeID;
	$sql = " SELECT entryType FROM placement_settings ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_row($res);
		$dataEntryFormat = $row[0];
	}
	
	if($interfaceType == 0)// bootstrap model
	{
		if($dataEntryFormat == 0) // Detailed Entry
		{
			bootstrap_model_mark_list_detailed_data($studentID, $courseTypeID);
		}
		else if($dataEntryFormat == 1) // Row data entry
		{
			//echo $studentID.$courseTypeID;
			bootstrap_model_mark_list_row_data($studentID, $courseTypeID);
		}
	}
	else if($interfaceType == 1)// table format ict
	{
		if($dataEntryFormat == 0) // Detailed Entry
		{
			mark_or_grade_view_default($studentID, $courseTypeID);
		}
		else if($dataEntryFormat == 1) // Row data entry
		{
			table_model_ict_row_data($studentID, $courseTypeID);
		}
	}
	else if($interfaceType == 2)
	{
		if($dataEntryFormat == 0) // Detailed Entry
		{
			
		}
		else if($dataEntryFormat == 1) // Row data entry
		{
			print_list_row_data($studentID, $courseTypeID);
		}
	}
	else if($interfaceType == 3)
	{
		if($dataEntryFormat == 0) // Detailed Entry
		{
			
		}
		else if($dataEntryFormat == 1) // Row data entry
		{
			table_model_ict_row_data_temp($studentID, $courseTypeID);
		}
	}
}

function bootstrap_model_mark_list_detailed_data($studentID, $courseTypeID)
{
	global $connect;
	
	$sql = " SELECT studentID, studentName, sslc, plustwo, batchID FROM studentaccount WHERE studentID = \"".$studentID."\" ";
	//echo $sql;
	$resSt = sql_query($sql, $connect);
	if(sql_num_rows($resSt))
	{
		$rowSt = sql_fetch_array($resSt);
		$studentID = $rowSt[studentID];
		$studentName = $rowSt[studentName];
		$sslc = $rowSt[sslc];
		$plustwo = $rowSt[plustwo];
		$batchID = $rowSt[batchID];
		
	}
	
	
				echo "   <a class='btn btn-primary btn-xs ' style='text-decoration:none;cursor:pointer;' data-toggle=\"modal\" data-target='#myModaldetails".$studentID."' data-placement='left' title='More Details' >";
						echo "<span class='glyphicon glyphicon-share-alt'></span>";
						echo "</a>";
					
								echo "<div class='modal fade' id='myModaldetails".$studentID."' >
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
												<h4 class='modal-title'>".$studentName."</h4>
											</div>
											<div class='modal-body' style='padding-top:1%;padding-bottom:1%;margin-bottom:0;' > ";
											
												echo "<table class='table table-bordered' style='margin-bottom:0;padding-bottom:0;' >";
												
												echo "<tr><td style='text-align:left;width:20%;' ><b>X</b></td><td style='text-align:left;' >".$sslc."</td></tr>";
												
												echo "<tr><td style='text-align:left;width:20%;' ><b>XII</b></td><td style='text-align:left;' >".$plustwo."</td></tr>";
												
												echo "</table>";
											
											echo "</div>
											<div class='modal-footer' style='margin-top:0;'  >
												<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
											</div>
										</div>
									</div>
								</div> ";
								
}

function bootstrap_model_mark_list_row_data($studentID, $courseTypeID)
{
	global $connect;
	
	$sql = " SELECT studentID, studentName, sslc, plustwo, batchID FROM studentaccount WHERE studentID = \"".$studentID."\" ";
	//echo $sql;
	$resSt = sql_query($sql, $connect);
	if(sql_num_rows($resSt))
	{
		$rowSt = sql_fetch_array($resSt);
		$studentID = $rowSt[studentID];
		$studentName = $rowSt[studentName];
		$sslc = $rowSt[sslc];
		$plustwo = $rowSt[plustwo];
		$batchID = $rowSt[batchID];
		
	}
	
	
					
							echo "   <a class='btn btn-primary btn-xs ' style='text-decoration:none;cursor:pointer;' data-toggle=\"modal\" data-target='#myModaldetails".$studentID."' data-placement='left' title='More Details' >";
						echo "<span class='glyphicon glyphicon-share-alt'></span>";
						echo "</a>";
					
								echo "<div class='modal fade' id='myModaldetails".$studentID."' >
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header'>
												<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
												<h4 class='modal-title'>".$studentName."</h4>
											</div>
											<div class='modal-body' style='padding-top:1%;padding-bottom:1%;margin-bottom:0;' > ";
											
												echo "<table class='table table-bordered' style='margin-bottom:0;padding-bottom:0;' >";
												
												echo "<tr><td style='text-align:left;width:20%;' ><b>X</b></td><td style='text-align:left;' >".$sslc."</td></tr>";
												
												echo "<tr><td style='text-align:left;width:20%;' ><b>XII</b></td><td style='text-align:left;' >".$plustwo."</td></tr>";
												
												echo "</table>";
												
												echo "<div class='row' ><div class='col-md-12' style='font-size:14px;font-weight:bold;margin:2% 0;' >PRESENT COURSE</div></div>";
												
												course_mark($studentID, $courseTypeID, 1);
												
												$sqlpr = " SELECT priorcourseID FROM course_type_prior WHERE courseTypeID = \"".$courseTypeID."\" ";
												$respr = sql_query($sqlpr, $connect);
												if(sql_num_rows($respr))
												{
													
													echo "<div class='row'  ><div class='col-md-12' style='font-size:14px;font-weight:bold;margin:2% 0;' >PREVIOUS COURSE</div></div>";
													
													while($rowpr = sql_fetch_row($respr))
													{
														course_mark_previous($studentID, $rowpr[0], 1);
														
													}
												}
																	
												
											echo "</div>
											<div class='modal-footer' style='margin-top:0;'  >
												<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
											</div>
										</div>
									</div>
								</div> ";
	
	
}

function table_model_ict_row_data_temp($studentID, $courseTypeID)
{
	global $connect;
	global $COLLEGE_NAME;
	
	$fieldType = "grade";
	//$fieldType = "mark";
	echo "<tr>";
		echo "<td>";
		
		echo "<tr style=\"text-align:left;font-weight:bold;padding:10px;vertical-align:top;\">";
			echo "<td colspan='2' >";
				echo "Educational Qualifications (University): ";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr style=\"text-align:center;padding:10px;vertical-align:top;cellspacing:0\" >";
			echo "<td colspan='2' style='border:0px solid #000;' >";
			
				echo " <table cellpadding='0' cellspacing='0' border='1' align='left' width='100%' style=\"font-family:'Times New Roman',Georgia,Serif;font-size:12px;margin-top:1px;\"> ";
			
						$sql = " SELECT t2.batchStartYear, t1.yearOfPassing FROM studentaccount t1, batches t2 WHERE t1.studentID = \"".$studentID."\" AND t1.batchID = t2.batchID";
						//echo $sql ;
						$res = sql_query($sql, $connect);
						$row = sql_fetch_array($res);
						$batchStartYear = $row[batchStartYear];
						$yearOfPassing = $row[yearOfPassing];
						if($yearOfPassing)
							$yearOfPassing = $yearOfPassing - 4;
			
				$sql10 = " select t1.priorcourseID, t1.courseTypeID, t2.typeName from course_type_prior t1, university_coursetypegrading t2 WHERE t1.priorcourseID = t2.typeID AND t1.courseTypeID = \"".$courseTypeID."\" AND t2.entryType != 0 ";
				//echo $sql;
				$res10 = sql_query($sql10, $connect);
				if(sql_num_rows($res10))
				{
					while($row = sql_fetch_array($res10))
					{
						
						$priorcourseID = $row[priorcourseID];
						
						
						$sqlmark = "SELECT courseTypeID, sgpa, cgpa FROM placement_student_course_mark_old_temp WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$priorcourseID."\" ";
						//echo $sqlmark;
						$resmark = sql_query($sqlmark, $connect);
						if(sql_num_rows($resmark))
						{
							$cnt = 0;
							unset($sgpa);
							unset($Cgpa);
							while($row = sql_fetch_row($resmark))
							{
								//$courseTypeID = $row[0];
								if($row[1] == "0")
								{
									$row[1] = "-";
								}
								if( ($row[2] == "0") || ($row[2] == "99") )
								{
									$row[2] = "-";
								}
								$sgpa[$cnt] = $row[1];
								$Cgpa[$cnt] = $row[2];
								$cnt++;
							}
							
						}
						
						$sqlmark = "SELECT cgpa FROM placement_student_cgpa_mark_old_temp WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$priorcourseID."\" ";
						//echo $sqlmark;
						$resmark = sql_query($sqlmark, $connect);
						unset($cgpa);
						if(sql_num_rows($resmark))
						{
							$row = sql_fetch_row($resmark);
							$cgpa = $row[0];
							
						}
						
						$sqlCol = " SELECT t1.studentID, t2.collegeName FROM studentaccount t1, studentaccount_college t2 WHERE t1.studentID = t2.studentID AND t1.studentID = \"".$studentID."\" AND t2.typeID = \"".$priorcourseID."\" ";
						//echo $sqlCol;
						$resCol = sql_query($sqlCol, $connect);
						if(sql_num_rows($resCol))
						{
							$row = sql_fetch_array($resCol);
							$collegeName = $row[collegeName];
						}
						
						$sqlCol = " SELECT t1.studentID, t3.deptName FROM studentaccount t1, department t3 WHERE t1.deptID = t3.deptID AND t1.studentID = \"".$studentID."\" ";
						//echo $sqlCol;
						$resCol = sql_query($sqlCol, $connect);
						if(sql_num_rows($resCol))
						{
							$row = sql_fetch_array($resCol);
							$deptName = $row[deptName];
						}
						
						
						echo "<tr style=\"text-align:center;font-weight:bold;padding:10px;vertical-align:top;cellspacing:0\" >";
							echo "<td colspan='8' >";
								echo "B. E. (".$deptName.") ,  ".$collegeName;
							echo "</td>";
						echo "</tr>";
						
						echo "<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td 									style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>
							<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>";
						
						$sqlCol ="select count(semID) from student_course_mark_old where studentID=\"$studentID\" and courseTypeID=\"$priorcourseID\"";
						//echo $sqlCol;
						$resCol = sql_query($sqlCol, $connect);
						if(sql_num_rows($resCol))
						{
							$row = sql_fetch_row($resCol);
							$totalSemPrev = $row[0];
						}
						
						$halfCount = ceil(($totalSemPrev/2));
						$yearCount = ceil(($halfCount/2));
						
						$yearOfPassing1 = $yearOfPassing+$yearCount;
						
						$j = 0; $k = 0; $n=0;
						
						if( (($totalSemPrev -5) % 4 != 0) && (($totalSemPrev -6) % 4 != 0) && ($totalSemPrev != 5) && ($totalSemPrev != 6) )
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	$k++;	
									}
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
						}
						else
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	
									}
									
									
									if( ($i%2 == 0) && ($i != 0) )
									{
										$k++;	
									}
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
							
						}
						
						
					}
				}
			
			
				
			
				$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$courseTypeID."\" ";
				$res = sql_query($sql, $connect);
				$row = sql_fetch_array($res);
				$markSystem = $row[entryType]; 
				
				if($markSystem != 0)
				{
					
						echo "<tr style=\"text-align:center;font-weight:bold;padding:10px;vertical-align:top;cellspacing:0\" >";
							echo "<td colspan='8' >";
								echo "B. E. (".$deptName.") ,  ".$COLLEGE_NAME;
							echo "</td>";
						echo "</tr>";
						
						echo "<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td 									style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>
							<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>";
					
						$sql = " SELECT t4.typeID, t4.entryType, t2.totalSemester FROM studentaccount t1, batches t2, university_assignbatchcourse t3, university_coursetypegrading t4 WHERE t1.batchID = t2.batchID AND t2.batchID = t3.batchID AND t3.typeID = t4.typeID AND t1.studentID = \"".$studentID."\" ";
						//echo $sql;
						$res = sql_query($sql, $connect);
						if(sql_num_rows($res))
						{
							$row = sql_fetch_array($res);
							$courseTypeID = $row[typeID];
							$markSystem = $row[entryType];
							$totalSemester = $row[totalSemester];
						}
					
					
					if($markSystem == 2)
					{
						$sqlmark = "SELECT courseTypeID, sgpa, cgpa FROM placement_student_course_mark_temp WHERE studentID = \"".$studentID."\" AND courseTypeID =  \"".$courseTypeID."\" ";
					}
					else if($markSystem == 1)
					{
						$sqlmark = "SELECT courseTypeID, percentage FROM placement_student_course_mark_temp WHERE studentID = \"".$studentID."\" AND courseTypeID =  \"".$courseTypeID."\" ";
					}
					//echo $sqlmark;
					$resmark = sql_query($sqlmark, $connect);
						unset($sgpa);
						unset($Cgpa);
					if(sql_num_rows($resmark))
					{
						$cnt = 0;
						
						while($row = sql_fetch_row($resmark))
						{
							//$courseTypeID = $row[0];
							if($row[1] == "999")
							{
								$row[1] = "-";
							}
							if($row[2] == "99")
							{
								$row[2] = "-";
							}
							$sgpa[$cnt] = $row[1];
							$Cgpa[$cnt] = $row[2];
							$cnt++;
						}
				
					}
					
					$sqlmark = "SELECT cgpa FROM placement_student_cgpa_mark_temp WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
					//echo $sqlmark;
					$resmark = sql_query($sqlmark, $connect);
					unset($cgpa);
					if(sql_num_rows($resmark))
					{
						while($row = sql_fetch_row($resmark))
						{
							//$courseTypeID = $row[0];
							$cgpa = $row[0];
						}
						
					}
					

						$halfCount = ceil(($totalSemester/2));
						$yearCount = ceil(($halfCount/2));
	
						$yearOfPassing = $batchStartYear;
						
						$yearOfPassing1 = $yearOfPassing+$yearCount;
						
						$j = 0; $k = 0; $n=0;
						
						if( (($totalSemPrev -5) % 4 != 0) && (($totalSemPrev -6) % 4 != 0) && ($totalSemPrev != 5) && ($totalSemPrev != 6) )
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	$k++;	
									}
									
									//echo ($halfCount+$i);
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
						}
						else
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	
									}
									
									
									if( ($i%2 == 0) && ($i != 0) )
									{
										$k++;	
									}
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
							
						}
					
					
				}
				
				
				echo "</table>";
				
				
			
			echo "</td>";
		echo "</tr>";	
		
		echo "</td>";
	echo "</tr>";
	
}

function table_model_ict_row_data($studentID, $courseTypeID)
{
	global $connect;
	global $COLLEGE_NAME;
	
	$fieldType = "grade";
	//$fieldType = "mark";
	
	echo "<tr>";
		echo "<td>";
		
		echo "<tr style=\"text-align:left;font-weight:bold;padding:10px;vertical-align:top;\">";
			echo "<td colspan='2' >";
				echo "Educational Qualifications (University): ";
			echo "</td>";
		echo "</tr>";
		
		echo "<tr style=\"text-align:center;padding:10px;vertical-align:top;cellspacing:0\" >";
			echo "<td colspan='2' style='border:0px solid #000;' >";
			
				echo " <table cellpadding='0' cellspacing='0' border='1' align='left' width='100%' style=\"font-family:'Times New Roman',Georgia,Serif;font-size:12px;margin-top:1px;\"> ";
			
						$sql = " SELECT t2.batchStartYear, t1.yearOfPassing FROM studentaccount t1, batches t2 WHERE t1.studentID = \"".$studentID."\" AND t1.batchID = t2.batchID";
						//echo $sql ;
						$res = sql_query($sql, $connect);
						$row = sql_fetch_array($res);
						$batchStartYear = $row[batchStartYear];
						$yearOfPassing = $row[yearOfPassing];
						if($yearOfPassing)
							$yearOfPassing = $yearOfPassing - 4;
			
				$sql10 = " select t1.priorcourseID, t1.courseTypeID, t2.typeName from course_type_prior t1, university_coursetypegrading t2 WHERE t1.priorcourseID = t2.typeID AND t1.courseTypeID = \"".$courseTypeID."\" AND t2.entryType != 0 ";
				//echo $sql;
				$res10 = sql_query($sql10, $connect);
				if(sql_num_rows($res10))
				{
					while($row = sql_fetch_array($res10))
					{
						
						$priorcourseID = $row[priorcourseID];
						
						
						$sqlmark = "SELECT courseTypeID, sgpa, cgpa FROM student_course_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$priorcourseID."\" ";
						//echo $sqlmark;
						$resmark = sql_query($sqlmark, $connect);
						if(sql_num_rows($resmark))
						{
							$cnt = 0;
							unset($sgpa);
							unset($Cgpa);
							while($row = sql_fetch_row($resmark))
							{
								//$courseTypeID = $row[0];
								if($row[1] == "0")
								{
									$row[1] = "-";
								}
								if( ($row[2] == "0") || ($row[2] == "99") )
								{
									$row[2] = "-";
								}
								$sgpa[$cnt] = $row[1];
								$Cgpa[$cnt] = $row[2];
								$cnt++;
							}
							
						}
						
						$sqlmark = "SELECT cgpa FROM student_cgpa_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$priorcourseID."\" ";
						//echo $sqlmark;
						$resmark = sql_query($sqlmark, $connect);
						unset($cgpa);
						if(sql_num_rows($resmark))
						{
							$row = sql_fetch_row($resmark);
							$cgpa = $row[0];
							
						}
						
						$sqlCol = " SELECT t1.studentID, t2.collegeName FROM studentaccount t1, studentaccount_college t2 WHERE t1.studentID = t2.studentID AND t1.studentID = \"".$studentID."\" AND t2.typeID = \"".$priorcourseID."\" ";
						//echo $sqlCol;
						$resCol = sql_query($sqlCol, $connect);
						if(sql_num_rows($resCol))
						{
							$row = sql_fetch_array($resCol);
							$collegeName = $row[collegeName];
						}
						
						$sqlCol = " SELECT t1.studentID, t3.deptName FROM studentaccount t1, department t3 WHERE t1.deptID = t3.deptID AND t1.studentID = \"".$studentID."\" ";
						//echo $sqlCol;
						$resCol = sql_query($sqlCol, $connect);
						if(sql_num_rows($resCol))
						{
							$row = sql_fetch_array($resCol);
							$deptName = $row[deptName];
						}
						
						
						echo "<tr style=\"text-align:center;font-weight:bold;padding:10px;vertical-align:top;cellspacing:0\" >";
							echo "<td colspan='8' >";
								echo "B. E. (".$deptName.") ,  ".$collegeName;
							echo "</td>";
						echo "</tr>";
						
						echo "<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td 									style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>
							<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>";
						
						$sqlCol ="select count(semID) from student_course_mark_old where studentID=\"$studentID\" and courseTypeID=\"$priorcourseID\"";
						//echo $sqlCol;
						$resCol = sql_query($sqlCol, $connect);
						if(sql_num_rows($resCol))
						{
							$row = sql_fetch_row($resCol);
							$totalSemPrev = $row[0];
						}
						
						$halfCount = ceil(($totalSemPrev/2));
						$yearCount = ceil(($halfCount/2));
						
						$yearOfPassing1 = $yearOfPassing+$yearCount;
						
						$j = 0; $k = 0; $n=0;
						
						if( (($totalSemPrev -5) % 4 != 0) && (($totalSemPrev -6) % 4 != 0) && ($totalSemPrev != 5) && ($totalSemPrev != 6) )
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	$k++;	
									}
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
						}
						else
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	
									}
									
									
									if( ($i%2 == 0) && ($i != 0) )
									{
										$k++;	
									}
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
							
						}
						
						
					}
				}
			
			
				
			
				$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$courseTypeID."\" ";
				$res = sql_query($sql, $connect);
				$row = sql_fetch_array($res);
				$markSystem = $row[entryType]; 
				
				if($markSystem != 0)
				{
					
						echo "<tr style=\"text-align:center;font-weight:bold;padding:10px;vertical-align:top;cellspacing:0\" >";
							echo "<td colspan='8' >";
								echo "B. E. (".$deptName.") ,  ".$COLLEGE_NAME;
							echo "</td>";
						echo "</tr>";
						
						echo "<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td 									style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>
							<td style='text-align:center;font-weight:bold;' >Semester</td><td style='text-align:center;font-weight:bold;' >Year</td><td style='text-align:center;font-weight:bold;' >SGPA/Percentage</td><td style='text-align:center;font-weight:bold;' >CGPA</td>";
					
						$sql = " SELECT t4.typeID, t4.entryType, t2.totalSemester FROM studentaccount t1, batches t2, university_assignbatchcourse t3, university_coursetypegrading t4 WHERE t1.batchID = t2.batchID AND t2.batchID = t3.batchID AND t3.typeID = t4.typeID AND t1.studentID = \"".$studentID."\" ";
						//echo $sql;
						$res = sql_query($sql, $connect);
						if(sql_num_rows($res))
						{
							$row = sql_fetch_array($res);
							$courseTypeID = $row[typeID];
							$markSystem = $row[entryType];
							$totalSemester = $row[totalSemester];
						}
					
					
					if($markSystem == 2)
					{
						$sqlmark = "SELECT courseTypeID, sgpa, cgpa FROM student_course_mark WHERE studentID = \"".$studentID."\" AND courseTypeID =  \"".$courseTypeID."\" ";
					}
					else if($markSystem == 1)
					{
						$sqlmark = "SELECT courseTypeID, percentage FROM student_course_mark WHERE studentID = \"".$studentID."\" AND courseTypeID =  \"".$courseTypeID."\" ";
					}
					//echo $sqlmark;
					$resmark = sql_query($sqlmark, $connect);
						unset($sgpa);
						unset($Cgpa);
					if(sql_num_rows($resmark))
					{
						$cnt = 0;
						
						while($row = sql_fetch_row($resmark))
						{
							//$courseTypeID = $row[0];
							if($row[1] == "999")
							{
								$row[1] = "-";
							}
							if($row[2] == "99")
							{
								$row[2] = "-";
							}
							$sgpa[$cnt] = $row[1];
							$Cgpa[$cnt] = $row[2];
							$cnt++;
						}
				
					}
					
					$sqlmark = "SELECT cgpa FROM student_cgpa_mark WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
					//echo $sqlmark;
					$resmark = sql_query($sqlmark, $connect);
					unset($cgpa);
					if(sql_num_rows($resmark))
					{
						while($row = sql_fetch_row($resmark))
						{
							//$courseTypeID = $row[0];
							$cgpa = $row[0];
						}
						
					}
					

						$halfCount = ceil(($totalSemester/2));
						$yearCount = ceil(($halfCount/2));
	
						$yearOfPassing = $batchStartYear;
						
						$yearOfPassing1 = $yearOfPassing+$yearCount;
						
						$j = 0; $k = 0; $n=0;
						
						if( (($totalSemPrev -5) % 4 != 0) && (($totalSemPrev -6) % 4 != 0) && ($totalSemPrev != 5) && ($totalSemPrev != 6) )
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	$k++;	
									}
									
									//echo ($halfCount+$i);
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
						}
						else
						{
							
							for($i=0; $i<$halfCount;$i++)
							{

									if( ($i%2 != 0) && ($i != 0) )
									{
										$j++;	
									}
									
									
									if( ($i%2 == 0) && ($i != 0) )
									{
										$k++;	
									}
								
								echo "<tr>";
								
									echo "<td>";
										echo letter_format( ($i+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing+$j);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo letter_format( ($i+$halfCount+1), 0);
									echo "</td>";
									
									echo "<td>";
										echo ($yearOfPassing1+$k);
									echo "</td>";
									
									echo "<td>";
										echo $sgpa[$i+$halfCount];
									echo "</td>";
									
									echo "<td>";
										echo $Cgpa[$i+$halfCount];
									echo "</td>";
									
								echo "</tr>";
							}
							
						}
					
					
				}
				
				
				echo "</table>";
				
				
			
			echo "</td>";
		echo "</tr>";	
		
		echo "</td>";
	echo "</tr>";
	
}

function mark_or_grade_view_default($studentID, $courseTypeID)
{
	global $connect;
	
	global $templateID;
	
	$sql = "select t1.sslc, t1.plustwo, t2.tenthSchool, t2.tenthExam, t2.tenthYear, t2.tenthMonth, t2.twelthSchool, t2.twelthBoard, t2.twelthYear, t2.twelthMonth from studentaccount t1 left join studentaccount_extras t2 on t1.studentID = t2.studentID where t1.studentID = \"$studentID\"";
	//echo $sql;
	$result = sql_query($sql, $connect);	
	$row=sql_fetch_row($result);	
	$sslc = $row[0];
	$plustwo = $row[1];
	$tenthSchool = $row[2];
	$tenthExam = $row[3];
	$tenthYear = $row[4];
	$tenthMonth = $row[5];
	$twelthSchool = $row[6]; 
	$twelthBoard = $row[7];
	$twelthYear = $row[8];
	$twelthMonth = $row[9];
	
	$sql = " SELECT entryType FROM university_coursetypegrading WHERE typeID = \"".$courseTypeID."\" ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	$row = sql_fetch_array($res);
	$markSystem = $row[entryType]; 
	
	$sql = " SELECT t2.departmentDesc FROM department t2, studentaccount t1 WHERE t1.deptID = t2.deptID AND t1.studentID = \"".$studentID."\" ";
	$res = sql_query($sql, $connect);
	$row = sql_fetch_array($res);
	$departmentDesc = $row[departmentDesc]; 
	
	if($templateID == NULL)
	{
		$sqldeftmpl = " SELECT templateID FROM placement_resume_templates WHERE defaultTempl = 1 ";
		$resdeftmpl = sql_query($sqldeftmpl, $connect);
		$defCount = sql_num_rows($resdeftmpl);
		if($defCount == 1)
		{
			$rowdeftmpl = sql_fetch_row($resdeftmpl);
			$templateID = $rowdeftmpl[0];
		}
		else if($defCount > 1)
		{
			while($rowdeftmpl = sql_fetch_array($resdeftmpl))
			{
				$sqlstdtmpl = " SELECT templateID FROM student_resume_template WHERE studentID = \"".$studentID."\" AND templateID = \"".$rowdeftmpl[templateID]."\" ";
				$resstdtmpl = sql_query($sqlstdtmpl, $connect);
				if(sql_num_rows($resstdtmpl))
				{
					$rowtmpl = sql_fetch_row($resstdtmpl);
					$templateID = $rowtmpl[0];
				}
			}
		}
	}
	
	if($markSystem == 1)
	{
		if($templateID == 2)
		{
		echo "<tr>";
		echo "<td style=\"width:25%;text-align:left;font-weight:bold;padding:10px;vertical-align:top;\">Education: </td>";
		echo "<td style=\"width:75%; height:auto; text-align:left;padding:5px;\"";	
			
				$studentPercent = array();
				$count = 0;
				echo "<span style=\"font-weight:bold;text-transform:capitalize;\">B.Tech: ".strtolower($departmentDesc)."</span><br />".$COLLEGE_NAME."<br />"; 
				$sql = "select distinct t1.semID, t2.semName from universityMarks t1, semesters t2 where t1.semID=t2.semID and studentID = \"$studentID\"";
				//echo $sql."hai";
				$result = sql_query($sql, $connect);
				if(sql_num_rows($result))
				{							
					while($row=sql_fetch_row($result))
					{	
						$semID = $row[0];
						$semName = $row[1];
						$sql_university = "select (sum((percentage+internalPercentage)/2))/count(*) from universityMarks t1, semesters t2 where t1.semID=t2.semID and t1.semID=\"$semID\" and t1.studentID = \"$studentID\"";		
						//echo $sql_university;
						$result_university = sql_query($sql_university, $connect);
						$row_university = sql_fetch_row($result_university);
						$studentPercent[$semName] = round($row_university[0], 2);
						$aggragate = $aggragate + round($row_university[0], 2);
						$count++;																		
					}
				}
				if($count > 0)
				{
					echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"30%\" style=\"margin:5px 0;font-family:'Times New Roman',Georgia,Serif;font-size:14px; text-align:left; float:left;\">";
					echo "<tr style=\"font-weight:bold;\"><td style=\"height:20px;\">Aggregate </td><td>: ".round(($aggragate/$count), 2)."%</td></tr>";
					foreach($studentPercent as $key => $val)
					{
						echo "<tr><td style=\"height:20px;\">".$key."</td><td>: ".$val."%</td></tr>";
					}
					echo "<tr><td style=\"height:20px;\" ><b>CGPA</b></td><td>: <b>".percentage_to_cgpa(round(($aggragate/$count), 2))."</b></td></tr>";
					echo "</table>";
				}

				if($twelthSchool )
				{
					echo $twelthSchool."<br />12th: ".strtoupper($twelthBoard)."  Aggregate : ".round($plustwo, 2)."%<br /><br />";
				}
				if($tenthSchool )
				{
					echo $tenthSchool."<br />10th: ".strtoupper($tenthExam)."  Aggregate : ".round($sslc, 2)."%<br /><br />";
				}
		
		echo "</td>";
		echo "</tr>";
		}
		else if($templateID == 1)
		{
			
		echo "<tr>";
		echo "<td colspan='2' style=\"text-align:left;font-weight:bold;padding-top:10px;vertical-align:top;\">Education: </td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style=\"height:auto; text-align:left;padding:5px;\" >";	
			
				$studentPercent = array();
				$count = 0;
				echo "<span style=\"font-weight:bold;text-transform:capitalize;\">B.Tech: ".strtolower($departmentDesc)."</span><br />".$COLLEGE_NAME."<br />"; 
				$sql = "select distinct t1.semID, t2.semName from universityMarks t1, semesters t2 where t1.semID=t2.semID and studentID = \"$studentID\"";
				//echo $sql."hai";
				$result = sql_query($sql, $connect);
				if(sql_num_rows($result))
				{							
					while($row=sql_fetch_row($result))
					{	
						$semID = $row[0];
						$semName = $row[1];
						$sql_university = "select (sum((percentage+internalPercentage)/2))/count(*) from universityMarks t1, semesters t2 where t1.semID=t2.semID and t1.semID=\"$semID\" and t1.studentID = \"$studentID\"";		
						//echo $sql_university;
						$result_university = sql_query($sql_university, $connect);
						$row_university = sql_fetch_row($result_university);
						$studentPercent[$semName] = round($row_university[0], 2);
						$aggragate = $aggragate + round($row_university[0], 2);
						$count++;																		
					}
				}
				if($count > 0)
				{
					echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"30%\" style=\"margin-top:5px 0;font-family:'Times New Roman',Georgia,Serif;font-size:14px; text-align:left; float:left;\">";
					echo "<tr style=\"font-weight:bold;\"><td style=\"height:20px;\">Aggregate </td><td>: ".round(($aggragate/$count), 2)."%</td></tr>";
					foreach($studentPercent as $key => $val)
					{
						echo "<tr><td style=\"height:20px;\">".$key."</td><td>: ".$val."%</td></tr>";
					}
					echo "<tr><td style=\"height:20px;\" ><b>CGPA</b></td><td>: <b>".percentage_to_cgpa(round(($aggragate/$count), 2))."</b></td></tr>";
					echo "</table>";
				}

				if($twelthSchool )
				{
					echo $twelthSchool."<br />12th: ".strtoupper($twelthBoard)."  Aggregate : ".round($plustwo, 2)."%<br /><br />";
				}
				if($tenthSchool )
				{
					echo $tenthSchool."<br />10th: ".strtoupper($tenthExam)."  Aggregate : ".round($sslc, 2)."%<br /><br />";
				}
		
		echo "</td>";
		echo "</tr>";
			
		}
	}
	else if($markSystem == 2)
	{
		
		echo "<tr>";
		echo "<td style=\"width:25%;text-align:left;font-weight:bold;padding:10px;vertical-align:top;\">Education: </td>";
		echo "<td style=\"width:75%; height:auto; text-align:left;padding:5px;\"";	
			
				$studentPercent = array();
				$count = 0;
				echo "<span style=\"font-weight:bold;text-transform:capitalize;\">B.Tech: ".strtolower($departmentDesc)."</span><br />".$COLLEGE_NAME."<br />"; 
				$sql = "select distinct t1.semID, t2.semName from universityMarks t1, semesters t2 where t1.semID=t2.semID and studentID = \"$studentID\"";
				$result = sql_query($sql, $connect);
				if(sql_num_rows($result))
				{							
					while($row=sql_fetch_row($result))
					{	
						$semID = $row[0];
						$semName = $row[1];
						$sql_university = "select (sum((percentage+internalPercentage)/2))/count(*) from universityMarks t1, semesters t2 where t1.semID=t2.semID and t1.semID=\"$semID\" and t1.studentID = \"$studentID\"";						   
						$result_university = sql_query($sql_university, $connect);
						$row_university = sql_fetch_row($result_university);
						$studentPercent[$semName] = round($row_university[0], 2);
						$aggragate = $aggragate + round($row_university[0], 2);
						$count++;																		
					}
				}
				if($count > 0)
				{
					echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"30%\" style=\"margin:5px 0;font-family:'Times New Roman',Georgia,Serif;font-size:14px; text-align:left; float:left;\">";
					echo "<tr style=\"font-weight:bold;\"><td style=\"height:20px;\">Aggregate </td><td>: ".round(($aggragate/$count), 2)."%</td></tr>";
					foreach($studentPercent as $key => $val)
					{
						echo "<tr><td style=\"height:20px;\">".$key."</td><td>: ".$val."%</td></tr>";
					}
					echo "</table>";
				}
				echo "<br />";
				if($twelthSchool && $twelthBoard)
				{
					echo $twelthSchool."<br />12th: ".strtoupper($twelthBoard).", Aggregate ".round($plustwo, 2)."%<br /><br />";
				}
				if($tenthSchool && $tenthExam)
				{
					echo $tenthSchool."<br />10th: ".strtoupper($tenthExam).", Aggregate ".round($sslc, 2)."%<br /><br />";
				}
		
		echo "</td>";
		echo "</tr>";
		
	}
}

function print_list_row_data($studentID, $courseTypeID)
{
	global $connect;
	
	$sqlyear = "SELECT yearOfPassing FROM studentaccount WHERE studentID = \"".$studentID."\" ";
	$resyear = sql_query($sqlyear, $connect);
	if(sql_num_rows($resyear))
	{

		$rowyear = sql_fetch_array($resyear);
		$yearOfPassing = $rowyear[yearOfPassing];
	}
												
	$sqlpr = " SELECT priorcourseID FROM course_type_prior WHERE courseTypeID = \"".$courseTypeID."\" ";
	//echo $sqlpr;
	$respr = sql_query($sqlpr, $connect);
	if(sql_num_rows($respr))
	{
		$i = 0;

		while($rowpr = sql_fetch_row($respr))
		{
			course_mark_previous($studentID, $rowpr[0], 2);
			
			if($i == 0)
			{
				echo "<td style='width:60%;' >"; // pass year
					echo $yearOfPassing;
				echo "</td>";
			}
			$i++;
		}
	
	}
	
	course_mark($studentID, $courseTypeID, 2);
}

function course_mark($studentID, $courseTypeID, $type)
{
	global $connect;
	
if($type == 1)
{
	
	$sqlCourse = " SELECT typeName, typeDesc, entryType FROM university_coursetypegrading WHERE typeID = \"".$courseTypeID."\" ";
	//echo $sqlCourse;
	$resCourse = sql_query($sqlCourse, $connect);
												
	$rowCourse = sql_fetch_array($resCourse);
									
	$course = $rowCourse[0];
	$couresDesc = $rowCourse[1];
	$entryType = $rowCourse[2];
											
	echo "<table class='table table-bordered' style='margin:2% 0;' >";
									
	echo "<tr><td style='text-align:center;' colspan='2' >".$couresDesc."</td></tr>";
					
	if($entryType == 0)
	{
		echo "<tr><td style='text-align:center;' colspan='2' >No Marks</td></tr>";
	}
	else if($entryType == 1)
	{
		$sqlMark = " SELECT percentage, presentArrears FROM student_course_mark WHERE studentID = \"".$studentID."\"  ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		if(sql_num_rows($res))
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$i++;
				if(!$row1[0] || $row1[0] == 99 )
				{
					$row1[0] = "-";
				}
				echo "<tr><td style='text-align:left;width:20%;' ><b>Semester $i</b></td><td style='text-align:left;' >".$row1[0]."</td></tr>";
				$backlog = $backlog+$row1[1];
			}
			if(!$backlog)
			{
				$backlog = "-";
			}
		}
													
		$sqlCg = " SELECT percentage FROM student_cgpa_mark WHERE studentID = \"".$studentID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
		if(!$cgpa)
		{
			$cgpa = "-";
		}
												
		echo "<tr><td style='text-align:left;width:20%;' ><b>CGPA </b></td><td style='text-align:left;' >".$cgpa."</td></tr>";
													
		echo "<tr><td style='text-align:left;width:20%;' ><b>Backlog/attempts</b></td><td style='text-align:left;' >".$backlog."</td></tr>";
	}
	else if($entryType == 2)
	{
		$sqlMark = " SELECT sgpa, presentArrears FROM student_course_mark WHERE studentID = \"".$studentID."\"  ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		if(sql_num_rows($res))
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$backlog = $backlog + $row1[1];
				if(!$row1[0] || $row1[0] == 999)
				{
					$row1[0] = "-";
				}
				$i++;
				echo "<tr><td style='text-align:left;width:20%;' ><b>Semester $i</b></td><td style='text-align:left;' >".$row1[0]."</td></tr>";
			}
		}
		
		$sqlCg = " SELECT cgpa FROM student_cgpa_mark WHERE studentID = \"".$studentID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
		if(!$cgpa)
		{
			$cgpa = "-";
		}
													
		echo "<tr><td style='text-align:left;width:20%;' ><b>CGPA </b></td><td style='text-align:left;' >".$cgpa."</td></tr>";
												
		echo "<tr><td style='text-align:left;width:20%;' ><b>Backlog/attempts</b></td><td style='text-align:left;' >".$backlog."</td></tr>";
		
		
	}
	//echo $sqlMark;
	echo "</table>";
	
}
else if($type == 2)
{
	
	$sql = " select max(semID) from student_course_mark where courseTypeID = \"".$courseTypeID."\" ";
	//echo $sql;
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_row($res);
		$semno = $row[0];
	}
	
	$sqlCourse = " SELECT typeName, typeDesc, entryType FROM university_coursetypegrading WHERE typeID = \"".$courseTypeID."\" ";
	//echo $sqlCourse;
	$resCourse = sql_query($sqlCourse, $connect);
												
	$rowCourse = sql_fetch_array($resCourse);
									
	$course = $rowCourse[0];
	$couresDesc = $rowCourse[1];
	$entryType = $rowCourse[2];
					
	if($entryType == 0)
	{
		
	}
	else if($entryType == 1)
	{
		$sqlMark = " SELECT percentage, presentArrears FROM student_course_mark WHERE studentID = \"".$studentID."\"  ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		$num = sql_num_rows($res);
		if($num)
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$i++;
				if($row1[0]  == 999.000)
				{
					$row1[0] = "-";
				}
				
				echo "<td style='text-align:left;' >".$row1[0]."</td>";
				$backlog = $backlog+$row1[1];
			}
			
		}
			for($t=0; $t<($semno-$num); $t++)
			{
				echo "<td style='text-align:left;' ></td>";
			}
													
		$sqlCg = " SELECT percentage FROM student_cgpa_mark WHERE studentID = \"".$studentID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
												
		echo "<td style='text-align:left;' >".$cgpa."</td>";
													
		echo "<td style='text-align:left;' >".$backlog."</td>";
	}
	else if($entryType == 2)
	{
		$sqlMark = " SELECT sgpa, presentArrears FROM student_course_mark WHERE studentID = \"".$studentID."\"  ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		$num = sql_num_rows($res);
		if($num)
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$i++;
				if( ($row1[0]  == 999) || ($row1[0]  == 99))
				{
					$row1[0] = "-";
				}
				echo "<td style='text-align:left;' >".$row1[0]."</td>";
			}
			
		}
		
			for($t=0; $t<($semno-$num); $t++)
			{
				echo "<td style='text-align:left;' ></td>";
			}
		
		$sqlCg = " SELECT cgpa FROM student_cgpa_mark WHERE studentID = \"".$studentID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
													
		echo "<td style='text-align:left;' >".$cgpa."</td>";
												
		echo "<td style='text-align:left;' >".$backlog."</td>";
	
	}
	
}
	
}

function course_mark_previous($studentID, $courseTypeID, $type)
{
	global $connect;
	
if($type == 2)
{
	
	$sql = " select max(semID) from student_course_mark_old where courseTypeID = \"".$courseTypeID."\" ";
	$res = sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_row($res);
		$semno = $row[0];
	}
	
	$sqlCourse = " SELECT typeName, typeDesc, entryType FROM university_coursetypegrading WHERE typeID = \"".$courseTypeID."\" ";
	//echo $sqlCourse;
	$resCourse = sql_query($sqlCourse, $connect);
												
	$rowCourse = sql_fetch_array($resCourse);
									
	$course = $rowCourse[0];
	$couresDesc = $rowCourse[1];
	$entryType = $rowCourse[2];
					
	if($entryType == 0)
	{
		
	}
	else if($entryType == 1)
	{
		$sqlMark = " SELECT percentage FROM student_course_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\"  ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		$num = sql_num_rows($res);
		if($num)
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$i++;
				if( ($row1[0]  == 999) )
				{
					$row1[0] = "-";
				}
				echo "<td style='text-align:left;' >".$row1[0]."</td>";
				$backlog = $backlog+$row1[1];
			}
			
		}
		
			for($t=0; $t<($semno-$num); $t++)
			{
				echo "<td style='text-align:left;' ></td>";
			}
													
		$sqlCg = " SELECT percentage FROM student_cgpa_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
												
		echo "<td style='text-align:left;' >".$cgpa."</td>";
													
		echo "<td style='text-align:left;' >".$backlog."</td>";
	}
	else if($entryType == 2)
	{
		$sqlMark = " SELECT sgpa FROM student_course_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		$num = sql_num_rows($res);
		if($num)
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$i++;
				if( ($row1[0]  == 999) || ($row1[0]  == 99))
				{
					$row1[0] = "-";
				}
				echo "<td style='text-align:left;' >".$row1[0]."</td>";
			}
			
		}
		
			for($t=0; $t<($semno-$num); $t++)
			{
				echo "<td style='text-align:left;' ></td>";
			}
		
		$sqlCg = " SELECT cgpa FROM student_cgpa_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
													
		echo "<td style='text-align:left;' >".$cgpa."</td>";
												
		//echo "<td style='text-align:left;' >".$backlog."</td>";
		
		
	}
	
}
else if($type == 1)
{
	
	$sqlCourse = " SELECT typeName, typeDesc, entryType FROM university_coursetypegrading WHERE typeID = \"".$courseTypeID."\" ";
	//echo $sqlCourse;
	$resCourse = sql_query($sqlCourse, $connect);
												
	$rowCourse = sql_fetch_array($resCourse);
									
	$course = $rowCourse[0];
	$couresDesc = $rowCourse[1];
	$entryType = $rowCourse[2];
											
	echo "<table class='table table-bordered' style='margin:2% 0;' >";
									
	echo "<tr><td style='text-align:center;' colspan='2' >".$couresDesc."</td></tr>";
					
	if($entryType == 0)
	{
		echo "<tr><td style='text-align:center;' colspan='2' >No Marks</td></tr>";
	}
	else if($entryType == 1)
	{
		$sqlMark = " SELECT percentage FROM student_course_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\"  ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		if(sql_num_rows($res))
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$i++;
				echo "<tr><td style='text-align:left;width:20%;' ><b>Semester $i</b></td><td style='text-align:left;' >".$row1[0]."</td></tr>";
				$backlog = $backlog+$row1[1];
			}
		}
													
		$sqlCg = " SELECT percentage FROM student_cgpa_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
												
		echo "<tr><td style='text-align:left;width:20%;' ><b>CGPA </b></td><td style='text-align:left;' >".$cgpa."</td></tr>";
													
		echo "<tr><td style='text-align:left;width:20%;' ><b>Backlog/attempts</b></td><td style='text-align:left;' >".$backlog."</td></tr>";
	}
	else if($entryType == 2)
	{
		$sqlMark = " SELECT sgpa FROM student_course_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
		//echo $sqlMark;
		$res = sql_query($sqlMark, $connect);
		if(sql_num_rows($res))
		{
			$backlog = 0;
			unset($sgpa);
			$i = 0;
			while($row1 = sql_fetch_row($res))
			{
				$i++;
				echo "<tr><td style='text-align:left;width:20%;' ><b>Semester $i</b></td><td style='text-align:left;' >".$row1[0]."</td></tr>";
			}
		}
		
		$sqlCg = " SELECT cgpa FROM student_cgpa_mark_old WHERE studentID = \"".$studentID."\" AND courseTypeID = \"".$courseTypeID."\" ";
		$resCg = sql_query($sqlCg, $connect);
		$rowCg = sql_fetch_array($resCg);
		$cgpa = $rowCg[0];
													
		echo "<tr><td style='text-align:left;width:20%;' ><b>CGPA </b></td><td style='text-align:left;' >".$cgpa."</td></tr>";
												
		echo "<tr><td style='text-align:left;width:20%;' ><b>Backlog/attempts</b></td><td style='text-align:left;' >".$backlog."</td></tr>";
		
		
	}
	//echo $sqlMark;
	echo "</table>";
	
}
	
}

function placement_reports($type, $css_class, $head_string, $table_field_string, $tables, $table_relation_strings )
{
	global $connect;
	
	$head = explode(",", $head_string);
	
	$fields = explode(",", $table_field_string);
	
	foreach($fields as $field)
	{
		$field = substr($field, 0, 3);
	}
	
	if($type == 0)
	{
		echo "<table class='".$css_class."' >";
			
			echo "<tr>";
				foreach($head as $th)
				{
					echo "<th>".$th."</th>";
				}
			echo "</tr>";
			
			$sql = "SELECT $table_field_string FROM $tables WHERE $table_relation_strings";
			$res = sql_query($sql, $connect);
			if(sql_num_rows($res))
			{
				
				while($row = sql_fetch_array($res))
				{
					echo "<tr>";
						
						foreach($fileds as $field)
						{
							echo "<td>".$row[$field]."</td>";
						}
						
					echo "</tr>";
				}
			}
			else
			{
				echo "<tr><td class='alert alert-danger' >No Record</td></tr>";
			}
			
		echo "</table>";
	}
	
}

function letter_format($i, $type)
{
	
	if($type == 0)
	{
		if($i == 1)
		{
			$i = "I";
		}
		
		if($i == 2)
		{
			$i = "II";
		}
		
		if($i == 3)
		{
			$i = "III";
		}
		
		if($i == 4)
		{
			$i = "IV";
		}
		
		if($i == 5)
		{
			$i = "V";
		}
		
		if($i == 6)
		{
			$i = "VI";
		}
		
		if($i == 7)
		{
			$i = "VII";
		}
		
		if($i == 8)
		{
			$i = "VIII";
		}
		
		if($i == 9)
		{
			$i = "IX";
		}
		
		if($i == 10)
		{
			$i = "X";
		}
		
		return $i;
	}
	
}

?>
