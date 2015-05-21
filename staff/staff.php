<?php
session_start();
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

//include "header.php";


?>
<table class="staffTab" border="0" cellspacing="0" cellpadding="0">
<tr>
 <td></td>
 <td style="height:25px; text-align:left; vertical-align:top; bgcolor:green; ">
   
    <?php  
    
    		//include "topnavigation.php";
    
    ?>


    </td>
</tr>

<tr>
  <td style="width:225px; height:auto; vertical-align:top; text-transform:capitalize; color:black; ">
<?php
	include "profile_menu.php";
?>		
</td>
<td style="width:770px; vertical-align:top;">

<?php
	if($_GET["menu"]) $filename = $_GET["menu"].".php";
	
	if( is_file( "$PATH/$filename")) 
	{
		  print_r($_session);
	      include "$PATH/$filename";
	}
	else 
	{
		?>
		<script type="text/javascript">
     				   window.location.href="staff.php?menu=home";
     	</script>
    <?php 	
	}
?>
		
</td></tr>
<tr><td colspan="2" style="width:100%; height:60px;" align="center" valign="bottom">

  <?php
 	 //include "footer.php";
  ?>
</td></tr>  
</table>

<?php
include "../libcommon/db_close.php";
?>
</body>
</html>
