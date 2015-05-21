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
//include "header.php";



$post_id = $_GET[post_id];
$post = $_GET[post];
$sql = "UPDATE posts SET post=\"$post\" WHERE post_id=\"$post_id\"";
$result = sql_query($sql, $connect);

if($result)
{
	   		$sql = "SELECT time from posts where post_id=\"$post_id\"";
	   		$result = sql_query($sql, $connect);
	   		if(sql_num_rows($result))
			{
				while ($row = sql_fetch_array($result))		 
				{
					$date =$row[0];
					 	echo "<td>".$post."</td>
			 			<td>".$date."</td>
			 			<td><a class='btn btn-primary btn-sm' onclick=\"edit_post($post_id)\"><span class='glyphicon glyphicon-edit'></span></a></td>
			 			<td><a class='btn btn-danger btn-sm' onclick=\"delete_post($post_id)\"><span class='glyphicon glyphicon-trash'></span></a></td>";

				}
			}  					 	  



} 
	else
	{
		echo "not updated";
	}
	
?>