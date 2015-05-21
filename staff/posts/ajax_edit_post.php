<?
session_start();
include "../../libcommon/conf.php";
include "../../libcommon/classes/form.cls.php";
include "../../libcommon/classes/paginator.cls.php";
include "../../libcommon/classes/sql.cls.php";
include "../../libcommon/classes/package.cls.php";
include "../../libcommon/classes/db_mysql.php";
include "../../libcommon/functions.php";
include "../../libcommon/db_inc.php";
include "../session.php";
$cForm = new InputForm();
$cPage = new paginator();
$cPkg = new Package();
$cSQL = new SQL();
$PATH = ".";
include "header.php";
?>

<script type="text/javascript">

</script>




<?
$post_id = $_GET[post_id];
$sql = "SELECT post FROM posts WHERE post_id = \"$post_id\" ";
$result = sql_query($sql, $connect);
if(sql_num_rows($result))
{

	while ($row = sql_fetch_array($result))		 
		{  					 	  
			 $post = $row[0];
	
		echo "<td colspan='4'>
		<table class='table table-boardered'>
		<tr>
		<td>Post:</td>
		<td><textarea class='form-controll' name='post' id='postid'>$post</textarea></td>
		</tr>
		<tr>
		<td style='text-align:center;' colspan='2'><button class=\"btn btn-success btn-sm\" onclick=\"update_post($post_id)\">Update</button>
		<button class=\"btn btn-danger btn-sm\" onclick=\"cancel_post($post_id)\">Cancel</button></td>
		</tr>
    	</table>
    	</td>";

    }
}    
?>