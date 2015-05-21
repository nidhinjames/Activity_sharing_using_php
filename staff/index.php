<?php
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
include "header.php";
?>
<center>
<h2>Activity Sharing System</h2>
</center>

<form action="" method = "POST">
<div class="form-group">
<label for="username">username:</label>
<input type=text class="form-control" name="textnames" placeholder="Enter username" >
</div>


<div class="form-group">
<label for="password">Password:</label>
<input type=password class="form-control" name="password" placeholder="Enter password">
</div>

<button type="submit" value='submit' class="btn btn-default">Submit</button>
</form>
</body>
</html>



<?php 
if( $_SERVER['REQUEST_METHOD'] == "POST") 
{
  $userid = $_POST['textnames'];
  $password = $_POST['password'];
  if(!empty($userid)) 
  {
  	$sql = "select * from registration where name = '$userid' and password=md5('$password')";
  	//echo $sql;
	$result = sql_query($sql, $connect);
	if(sql_num_rows($result))
	{
		while ($row = sql_fetch_array($result)) 
		{   
			session_start();
			$_SESSION['userID']     = $row[0];
			$_SESSION['username']   = $row[1];
			$_SESSION['userstatus'] = $row[11];

			echo "<script type=\"text/javascript\">
        	window.location.href=\"staff.php?menu=home\";
    		 </script>"; 
		}
	}
	else 
	{
		echo "Not an authorized user";
		//include "index.php";	     
    }
   }
}			
 ?>