<?php
function input_error_reporting( $input_errors) 
{	
echo "<div class=\"alert_error\">
		<h3>Error(s)!!</h3>";
$count = 0;
foreach( $input_errors as $error) 
{
	echo "<p style=\"margin:10px 0 10px 50px; text-align:left; color:#f00; font-family:Arial, Helvetica, sans-serif; font-size:12px;\">".++$count.") $error. </p>";
}
echo "</div>";	
}

function success_messagetoconfirm($message)
{
	if($message)
	{
		echo "<h2 class=\"alert_success\">";					
		echo $message;
		echo "</h2>";
	}
	else
	{
		echo "<h2 class=\"alert_success\">";					
		echo "Added Successfully";
		echo "</h2>";
	}	 	
}

function input_error_reporting_feedback($input_errors) 
{
	echo "<div style=\"width:59%; height:auto; margin: 15px 0 50px 0;\">	
			<h3 style=\"margin-left:25px; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;\">Error(s)!!</h3>";

	$count = 0;
	foreach( $input_errors as $error) 
	{
		echo "<p style=\"margin:10px 0 10px 50px; text-align:left; color:#f00; font-family:Arial, Helvetica, sans-serif; font-size:12px;\">".++$count.") $error. </p>";
	}
	echo "</div>";	
}

function input_error_reporting_library( $input_errors) 
{
echo "<div style=\"width:600px; height:auto; margin: 15px 0 10px 0; border: 1px solid #F00;\">	
		<h3 style=\"margin-left:25px; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:bold; color:#F00;\">Error(s)!!
		</h3>";
$count = 0;
foreach( $input_errors as $error) 
{
		echo "<p style=\"margin:10px 0 10px 50px; text-align:left; color:#f00; font-family:Arial, Helvetica, sans-serif; font-size:12px;\">".++$count.") $error. </p>";
}
echo "</div>";	
}

function nextDay($date) 
{
        $arr = explode("-", $date);
        return date("Y-m-d",(mktime(0,0,0,$arr[1],$arr[2], $arr[0]) + (24*60*60)));
}
function nextNDay($date, $N, $incHoliday = true)
{
    $i = 0;
    while ($i<$N)
    {   
      $date = nextDay($date);
      $arr = explode("-", $date);
      $i++;
    }   
  return $date;
}
function staffIsAllowed($groupID, $menu, $action)
{   
        global $connect;
        global $l_error;

        if($action) $fileName = $menu;
        else  $fileName = $menu;

        $sql            = "SELECT * FROM library_privileges WHERE stafftypeID='$groupID' AND menuItems='$fileName'";
        $result = sql_query($sql, $connect);
        if(!sql_num_rows($result)) return 0;
	else 
		return 1;
}

function placementStaffIsAllowed($groupID, $menu, $action)
{
		global $connect;
        global $l_error;

        if($action) $fileName = $menu;
        else  $fileName = $menu;

        $sql  = "SELECT * FROM placement_privileges WHERE stafftypeID='$groupID' AND menuItems='$fileName'";
        $result = sql_query($sql, $connect);
        if(!sql_num_rows($result)) return 0;
	else 
		return 1;
}

function hrStaffIsAllowed($groupID, $menu, $action)
{
        global $connect;
        global $l_error;

        if($action) $fileName = $menu;
        else  $fileName = $menu;

        $sql  = "SELECT * FROM hr_privileges WHERE stafftypeID='$groupID' AND menuItems='$fileName'";
        $result = sql_query($sql, $connect);
        if(!sql_num_rows($result)) return 0;
    else
        return 1;
}

function adminIsAllowed($groupID, $menu, $action)
{   
        global $connect;
        global $l_error;

        if($action) $fileName = $menu;
        else  $fileName = $menu;

        $sql            = "SELECT * FROM admin_privileges WHERE admintypeID='$groupID' AND menuItems='$fileName'";
        $result = sql_query($sql, $connect);
        if(!sql_num_rows($result)) return 0;
	else 
		return 1;
}
/*
   Page:           _drawrating.php
   Created:        Aug 2006
   Last Mod:       Oct 27 2009
   modfied by bstinthomas
   The function that draws the rating bar.
   --------------------------------------------------------- 
   ryan masuga, masugadesign.com
   ryan@masugadesign.com 
   Licensed under a Creative Commons Attribution 3.0 License.
   http://creativecommons.org/licenses/by/3.0/
   See readme.txt for full credit details.
   --------------------------------------------------------- */
function rating_bar($id,$units='',$userID='', $tableName='',$userType='') { 

	global $connect, $rating_unitwidth;
	/*set some variables*/
	if (!$units) {$units = 10;}
	if (!$static) {$static = FALSE;}

	$sql = "select sum(rateValue), count(studentID) from $tableName where docID='$id'";
	$query=sql_query($sql,$connect);

	$numbers=sql_fetch_array($query);

	if ($numbers['count(studentID)'] < 1) {
		$count = 0;
	} else {
		$count = $numbers['count(studentID)']; /*how many votes total*/
	}

	
	$current_rating	= $numbers['sum(rateValue)']; /*total number of rating added together and stored*/
	$tense = ($count == 1) ? "vote" : "votes"; /*plural form votes/vote*/

	$sql = "select $userType from $tableName where docID='$id' and $userType=$userID";
	$query=sql_query($sql, $connect);
	if(sql_num_rows($query) ) {
		$voted = 1;
	}
	else {
	
		$voted = 0;
	}
	$rating_width = @number_format($current_rating/$count,2)*$rating_unitwidth;
	$rating1 = @number_format($current_rating/$count,1);
	$rating2 = @number_format($current_rating/$count,2);
	if ($static == 'static') {

		$static_rater = array();
		$static_rater[] .= "\n".'<div class="ratingblock">';
		$static_rater[] .= '<div id="unit_long'.$id.'">';
		$static_rater[] .= '<ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
		$static_rater[] .= '<li class="current-rating" style="width:'.$rating_width.'px;">Currently '.$rating2.'/'.$units.'</li>';
		$static_rater[] .= '</ul>';
		$static_rater[] .= '<p class="static">Rating: <strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.' cast) <em>This is \'static\'.</em></p>';
		$static_rater[] .= '</div>';
		$static_rater[] .= '</div>'."\n\n";

		return join("\n", $static_rater);


	} else {

		$rater ='';
		$rater.='<div class="ratingblock">';

		$rater.='<div id="unit_long">';
		$rater.='  <ul id="unit_ul'.$id.'" class="unit-rating" style="width:'.$rating_unitwidth*$units.'px;">';
		$rater.='     <li class="current-rating" style="width:'.$rating_width.'px;">Currently'.$rating2.'/'.$units.'</li>';

		for ($ncount = 1; $ncount <= $units; $ncount++) { /* loop from 1 to the number of units*/
				$rater.='<li><a onClick="rateAction(\'j='.$ncount.'&amp;q='.$id.'&amp;t='.$userID.'&amp;c='.$units.'&table='.$tableName.'&type='.$userType.'\')" title="'.$ncount.' out of '.$units.'" class="r'.$ncount.'-unit rater" rel="nofollow">'.$ncount.'</a></li>';
		}
		$ncount=0; // resets the count

		$rater.='  </ul>';
		$rater.='  <p';
		$rater.='>Rating: <strong> '.$rating1.'</strong>/'.$units.' ('.$count.' '.$tense.' cast)';
		$rater.='  </p>';
		$rater.='</div>';
		$rater.='</div>';
		return $rater;
	}
}

function write_php_ini($array, $file)
{
    $res = array();
    foreach($array as $key => $val)
    {
        if(is_array($val))
        {   
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }   
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }   
    safefilerewrite($file, implode("\r\n", $res));
}
function safefilerewrite($fileName, $dataToSave)
{    if ($fp = fopen($fileName, 'w'))
    {   
        $startTime = microtime();
        do  
        {            $canWrite = flock($fp, LOCK_EX);
           /* If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load*/
           if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } while ((!$canWrite)and((microtime()-$startTime) < 1000));

        /*file was locked so now we can store information*/
        if ($canWrite)
        {            fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        }   
        fclose($fp);
    }
}
function isEmail($email){
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

function isName($name){
  return preg_match('/^([\w\d\s\&\-\_\+\.\:\|\/]+)$/iU', $name) ? TRUE : FALSE;
}

function assignmentView($batchID,$subjectID,$staffID, $assignmentID='') {

	global $connect;
	if($assignmentID) {
		
		$sql = "select assignmentID, question, description, submissionDate, submissionTime,assiNu from batch_assigment where assignmentID=$assignmentID order by assignmentID DESC";
	}
	else {
		$sql = "select assignmentID, question, description, submissionDate, submissionTime,assiNu from batch_assigment where batchID=$batchID AND subjectID=$subjectID AND staffID=".$_SESSION['staffID']." order by assignmentID DESC";
	}
	$result = sql_query($sql, $connect);
	if(sql_num_rows($result))
	{
	while($row = sql_fetch_row($result)) 
	{
		echo "<div id=\"div".$row[0]."\">
					<table class=\"assign_tab\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
						<tr>
							<td colspan=\"2\" id=\"head\">
								Assignment you given
							</td>
						</tr>
				        <tr>
							<td id=\"left\">
								Question: 		
							</td>
							<td id=\"right\">
							 	".nl2br($row[1])."&nbsp;		
							</td>
						</tr>
				        <tr>
							<td id=\"left\">
								Assignment number: 		
							</td>
							<td id=\"right\">
							 	".$row[5]."&nbsp;		
							</td>
						</tr>
						<tr>
							<td id=\"left\">
								Description: 		
							</td>
							<td id=\"right\">
							 	".nl2br($row[2])."&nbsp; 		
							</td>
						</tr>
				        <tr>
							<td id=\"left\">
								Date: 		
							</td>
							<td id=\"right\">
							 	".$row[3]."&nbsp; 		
							</td>
						</tr>
				        <tr>
							<td id=\"left\">
								Time: 		
							</td>
							<td id=\"right\">
							 	".$row[4]."&nbsp; 		
							</td>
						</tr>
						<tr>
							<th colspan='2' id=\"head\">
								<input name=\"upload\" type=\"submit\" class=\"box\" id=\"upload\" value=\"Delete\" onclick=\"deleteassignment('ajax_delete_assinments.php', 'batchID=".$batchID."&subjectID=".$subjectID."&staffID=".$_SESSION['staffID']."&assignmentID=".$row[0]."')\">
								<input name=\"upload\" type=\"submit\" class=\"box\" id=\"upload\" value=\"Edit\" onclick=\"editassignment('ajax_edit_assinments.php', 'batchID=".$batchID."&subjectID=".$subjectID."&staffID=".$_SESSION['staffID']."&assignmentID=".$row[0]."', 'div'+'".$row[0]."')\">
							</th>
						</tr>
					</table>
				  </div>";
	}
	}else
	{
		echo "<br /><br /><br /><span style=\"margin-top:20px; color:#f00; font-size:14px\">Sorry! there is no records.</span>";	
	}
}
function markListView($batchID, $subjectID, $examID, $action) 
{
	global $connect;
	if( $examID ) {
		echo "<table class=\"assign_tab\"  cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
		echo "<tr>";
		echo "<td id=\"left\">ExamName: </td>";
		echo "<td>";
		echo $examName;
		echo "</td>";
		echo "</tr>";
		$sql = "select markID from student_marks where batchID=$batchID and subjectID=$subjectID  and examID=$examID";
		$result = sql_query($sql, $connect);
		if( !sql_num_rows($result)) {
		
			$sql = "select t1.studentID, t1.studentAccount from  studentaccount t1 where t1.batchID=$batchID";
		}
		else {
			$sql = "select t2.studentID, t2.studentAccount,t1.markID, t1.marksObtained, t1.studentID from student_marks t1, studentaccount t2 where t1.studentID=t2.studentID and t1.batchID=$batchID and t1.subjectID=$subjectID and examID=$examID";
			echo "<input type=\"hidden\" value=\"1\" name=\"edit\">";
		}
		$result = sql_query($sql, $connect);
		while($row = sql_fetch_row($result)) {
		
		        $studentID = $row[0];
		        echo "<tr>";
		        echo "<td id=\"left\">".$row[1].": </td>";
		        echo "<td id=\"right\">".$row[3]."</td>";
		        echo "</tr>";
		
		}
		echo "</table>";		
    }
	else {
		echo "No exam assign for this test";
	}
}
function no_fo_subjects_in_ass($assNo,$batchID,$semID) {

        global $connect;
        $sql = "select count(distinct(subjectID)) from assinment_marks where batchID=$batchID and semID=$semID and assiNu=\"$assNo\"";
        $result = sql_query($sql, $connect);
        $row = sql_fetch_row($result);
        return $row[0];
}

/*Functions for library section*/

function get_menuhead($userType) /* For leftside menu in library*/
{
	global $connect;
    global $l_error;
	global $GroupPrivileges;
	$userPrivileges = $GroupPrivileges;
	if(is_array($userPrivileges))
	{
		foreach($userPrivileges as $item)	
		{						
			$sql = "SELECT menuItems FROM library_privileges WHERE stafftypeID='$userType' AND menuItems='$item'";
			$result = sql_query($sql, $connect);
			while($row = sql_fetch_array($result))
			{
				$data_db[] = $row[0]; 
			}
		}
	}
	return $data_db;
}

function calculating_studentreturndate($ret_date, $deptID, $batchID)
{
	global $connect;	 
	$sql ="select holiday from library_studentcalendar where deptID = ".$deptID." AND batchID = ".$batchID." AND holiday >=\"".$ret_date."\" ORDER BY holiday";
	/*echo $sql;*/
	$result = sql_query($sql, $connect);
	$b=0;
	while($row = sql_fetch_row($result)) 
	{
        if($row[0] == $ret_date)
        {    
                $ret_date = nextNDay($ret_date, 1); 
                $b++;
                /*echo $ret_date."<br />";*/
        }
        else if($b!=0)
        {
                break;
        }
	}
	$find_holiday['ret_date'] = $ret_date;
	$find_holiday['count_day'] = $b; 
	return $find_holiday;
}

function calculating_staffreturndate($ret_date, $deptID)
{
                        global $connect;
    
                        $sql ="select holiday from library_staffcalendar where deptID = ".$deptID." AND holiday >=\"".$ret_date."\" ORDER BY holiday";  
                        $result = sql_query($sql, $connect);
                        $b=0;
                        while($row = sql_fetch_row($result))
                        {
                                if($row[0] == $ret_date)
                                {
                                        $ret_date = nextNDay($ret_date, 1);
                                        $b++;
                                        /*echo $date;*/
                                }
                                else if($b!=0)
                                {
                                        break;
                                }
                        }
                        $find_holiday['ret_date'] = $ret_date;
                        $find_holiday['count_day'] = $b;
                        return $find_holiday;
}
function revers_dateformat($date) {

	$date = preg_split("/[\-]/", $date);
	
	$day = $date[2];
	$month = $date[1];
	$year = $date[0];
	return "$day-$month-$year";
}



function assign_rand_value($num)
{
/* accepts 1 - 36*/
  switch($num)
  {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "0";
    break;
    case "28":
     $rand_value = "1";
    break;
    case "29":
     $rand_value = "2";
    break;
    case "30":
     $rand_value = "3";
    break;
    case "31":
     $rand_value = "4";
    break;
    case "32":
     $rand_value = "5";
    break;
    case "33":
     $rand_value = "6";
    break;
    case "34":
     $rand_value = "7";
    break;
    case "35":
     $rand_value = "8";
    break;
    case "36":
     $rand_value = "9";
    break;
  }
return $rand_value;
}


function get_rand_id($length)
{
  if($length>0)
  {
    $rand_id="";
    for($i=1; $i<=$length; $i++)
    {
        mt_srand((double)microtime() * 1000000);
        $num = mt_rand(1,36);
        $rand_id .= assign_rand_value($num);
    }
  }
return $rand_id;
}


function header_deptbatchsem($batchid, $semid)
{
    global $connect;
    
    if($semid)
    {
        $sql ="select t1.deptName, t1.departmentDesc, t2.batchName, t2.batchDesc, t3.semName from department t1, batches t2, semesters t3 where t2.batchID=\"".$batchid."\" and t3.semID=\"".$semid."\" and t1.deptID = t2.deptID";
    }
    else
    {
        $sql ="select t1.deptName, t1.departmentDesc, t2.batchName, t2.batchDesc, t3.semName from department t1, batches t2, semesters t3 where t2.batchID=\"".$batchid."\" and t3.semID=t2.semID and t1.deptID = t2.deptID";
    }
    $result = sql_query($sql, $connect);
    $row = sql_fetch_row($result);
    return "Department:".$row[0]." &nbsp;&nbsp;&nbsp; Batch:".$row[2]." &nbsp;&nbsp;&nbsp; Semester:".$row[4];
    
}


function subjectnames($subjectid)
{
    
    global $connect;
    
    $sql ="select subjectName, subjectDesc from subjects where subjectID=\"".$subjectid."\"";
    $result = sql_query($sql, $connect);
    $row = sql_fetch_row($result);
    return $row[0]."&nbsp;".$row[1];
}

function footer_staffName($staffid)
{
    global $connect;

    $sql ="select staffName from staffaccounts where staffID=\"".$staffid."\"";
    $result = sql_query($sql, $connect);
    $row = sql_fetch_row($result);
    return $row[0];
}

function display_datetime()
{
    $date = date('d-m-Y g:i a');
    return $date;   
}

function insertuser_log($staffID, $type, $startTime, $userSession)
{
	global $connect;
	$sql = "insert into user_logins (userID, userType, userSession, startTime) values(\"".$staffID."\", \"".$type."\", \"".$userSession."\", \"$startTime\")";				
	sql_query($sql, $connect);
}

function updateuser_log($endtime, $userSession)
{
	global $connect;
	$sql = "update user_logins set userSession=\"0\", endTime=\"$endtime\" where userSession=\"".$userSession."\"";
	$result = sql_query($sql, $connect);
}

function getDesignation($isStaff, $isHOD, $isPrincipal)
{
    if($isStaff == 1) 
	{		
       	return "Faculty";
   }   
   if($isStaff == 2) 
   {
       	return "Others";
   }   
   if($isHOD == 1) 
   {
       	return "HOD";
   }   
   if($isHOD == 2) 
   {
       	return "HOD In Charge";
   }   
   if($isPrincipal == 1) 
   {
			return "Principal";
   }
   if($isPrincipal == 2) 
   {
			return "Vice Principal";
   }
   if($isPrincipal == 3) 
   {
			return "Dean";
   }
   if($isPrincipal == 4) 
   {
			return "Director";
   }
   if($isPrincipal == 5) 
   {
			return "Manager";
   }
   if($isPrincipal == 6) 
   {
			return "Academic Coordinator";
   }
   if($isPrincipal == 7) 
   {
			return "ERP Admin";
   }
}

function sendSMS($phonNo, $msg, $route) 
{
	global $SMS_USERNAME, $SMS_PASSWORD, $SMS_DOMAIN, $SMS_SENDERID;
		
	if (!defined('TYPE_NORMAL')) define('TYPE_NORMAL', '1');
	//define('ROUTE_TRANSACTIONAL','2');
	
    $login_name=$SMS_USERNAME;
    $api_password=$SMS_PASSWORD;
    $ver='1';
    
    $url= $SMS_DOMAIN.'ver='.$ver;
    $url.='&login_name='.$login_name;
    $url.='&api_password='.$api_password;
    
    $action='push_sms';       
    
    if($route == 1) //this is for promotional sms
    {
		$data=array(
	       
	        'message'=>$msg,
	        'number'=>$phonNo,
			'type' => TYPE_NORMAL,
			'route' => $route
	
	    );
	}
	else //this is for transactional sms
	{
	    $data=array(
	       
	        'message'=>$msg,
	        'number'=>$phonNo,
			'type' => TYPE_NORMAL,
			'route' => $route,
			'sender' => $SMS_SENDERID
	
	    );
	}
    
    $url.='&action='.$action;
    $json_data= urlencode(json_encode($data));
    $url.='&data='.$json_data;
    //echo $url;
    $result=  @file_get_contents($url);
    if($result === FALSE) 
    {
		echo "<h3 style=\"color:red; font-size:12px;\">Failed to deliver SMS to ".$phonNo.".</h3>";
	}
    else
    {
		return 1;
	}
}


function cgpa_to_percentage($cgpa)
{
	$percentage = ($cgpa - 0.5)*10;
	return $percentage;
}

function percentage_to_cgpa($studentID)
{
	global $connect;
	
	$sql = "select t2.gradePoint*t6.credit  from universityMarks t1, university_gradepoints t2, university_assignbatchcourse t3, studentaccount t4, universityExams t5, university_examcredits t6 where t6.subjectID = t5.subjectID and t1.examID=t5.examID and t1.studentID=\"".$studentID."\" and ((if(t1.marksObtained is null, 0, t1.marksObtained) +  t1.internalMark) / (t5.examTotalMarks + t5.maxInternal) * 100) between t2.percentFrom and t2.percentTo and t3.typeID=t2.typeID and t3.batchID=t4.batchID and t4.studentID=t1.studentID and t1.subjectID=t5.subjectID";
	
	$res =sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$sumOfNumerator = 0;
		while($row = sql_fetch_row($res))
		{
			$sumOfNumerator = $sumOfNumerator + $row[0];
		}
		
	}
	
	$sql = "select sum(t6.credit) from universityMarks t1, university_gradepoints t2, university_assignbatchcourse t3, studentaccount t4, universityExams t5, university_examcredits t6 where t6.subjectID = t5.subjectID and t1.examID=t5.examID and t1.studentID=\"".$studentID."\" and ((if(t1.marksObtained is null, 0, t1.marksObtained) +  t1.internalMark) / (t5.examTotalMarks + t5.maxInternal) * 100) between t2.percentFrom and t2.percentTo and t3.typeID=t2.typeID and t3.batchID=t4.batchID and t4.studentID=t1.studentID and t1.subjectID=t5.subjectID";
	
	$res =sql_query($sql, $connect);
	if(sql_num_rows($res))
	{
		$row = sql_fetch_row($res);
		$sumOfDenomenator = $row[0];	
	}
	
	if($sumOfNumerator && $sumOfDenomenator)
	{
		$cgpa = $sumOfNumerator/$sumOfDenomenator;
	}
	else
	{
		$cgpa = 0;
	}
	
	return round($cgpa, 2);
	
}

function placement_admin_dept_privileges($adminID, $table_prefix)
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

function convert_mark($mark, $format, $type)
{
	if($type == 1)
	{
		if($format == "gradePoint")
		{
			$mark = ($mark)*10;
		}
		else if($format == "mark")
		{
			$mark = ($mark)/10;
		}
	}
	
	return $mark;
}

function feecollectionStaffIsAllowed($groupID, $menu, $action)
{
        global $connect;
        global $l_error;

        if($action) 
        {
			$fileName = $menu;
		}
        else 
        {
			$fileName = $menu;
		}

        $sql  = "SELECT * FROM feecollection_privileges WHERE stafftypeID='$groupID' AND menuItems='$fileName'";
        //echo $sql;
        $result = sql_query($sql, $connect);
        if(!sql_num_rows($result))
        { 
			return 0;
		}
		else
		{
			return 1;
		}
}

function get_feemenu($userType) /* For leftside menu in library*/
{
	global $connect;
    global $l_error;
	global $feecollectionGroupPrivileges;
	$userPrivileges = $feecollectionGroupPrivileges;
	if(is_array($userPrivileges))
	{
		foreach($userPrivileges as $item)	
		{						
			$sql = "SELECT menuItems FROM feecollection_privileges WHERE stafftypeID='$userType' AND menuItems='$item'";
			$result = sql_query($sql, $connect);
			while($row = sql_fetch_array($result))
			{
				$data_db[] = $row[0]; 
			}
		}
	}
	return $data_db;
}

?>

