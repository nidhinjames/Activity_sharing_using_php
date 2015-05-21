<?php
//session_start();
//include "session.php";
include "../libcommon/conf.php";
include "../libcommon/classes/form.cls.php";
include "../libcommon/classes/paginator.cls.php";
include "../libcommon/classes/sql.cls.php";
include "../libcommon/classes/db_mysql.php";
include "../libcommon/classes/package.cls.php";
include "../libcommon/functions.php";
include "../libcommon/calendar_function.php";
include "../libcommon/db_inc.php";

$cForm = new InputForm();
$cPage = new paginator();
$cPkg = new Package();
$cSQL = new SQL();
$PATH = $_GET["menu"];
#include "header.php";



if( $_SERVER['REQUEST_METHOD'] == "POST") 
{
  $name = $_POST['name'];
  $password = $_POST['password'];
  $address = $_POST['address'];
  $sex = $_POST['sex'];
  $district = $_POST['district'];
  $state = $_POST['state'];
  $pincode = $_POST['pincode'];
  $email = $_POST['emai'];
  $dob = $_POST['dob'];
  $mobile = $_POST['mobile'];

   $sql = "INSERT INTO registration(name,password,address,sex,district,state,pincode,email,dob,mobile) 
        VALUES (\"$name\",md5(\"$password\"), \"$address\", \"$sex\", \"$district\", \"$state\", \"$pincode\", \"$email\",\"$dob\",\"$mobile\")";

   $result = sql_query($sql, $connect);

  if ($result == false)
 {
   echo "Registration Failed..";
 }
 else
 {
   echo "Registration Success..";
 }
				
}	            
?>