<?
	session_start();
	include "../../libcommon/conf.php";
	include "../../libcommon/classes/form.cls.php";
	include "../../libcommon/classes/paginator.cls.php";
	include "../../libcommon/classes/sql.cls.php";
	include "../../libcommon/classes/db_mysql.php";
	include "../../libcommon/classes/package.cls.php";
	include "../../libcommon/functions.php";
	include "../../libcommon/calendar_function.php";
	include "../../libcommon/db_inc.php";

	$cForm = new InputForm();
	$cPage = new paginator();
	$cPkg = new Package();
	$cSQL = new SQL();
	$PATH = $_GET["menu"];
	//include "header.php";




if( $_SERVER['REQUEST_METHOD'] == "POST") 
{
	//$user_id = $_SESSION['userID'];
	$user_id = $_POST['id'];
	$post = $_POST['post'];
	//echo $user_id;
	//echo $post;
    $sql = "call create_post(\"$user_id\", \"$post\", @postID)";
    $res =sql_query($sql, $connect);
    if($res==True)
    {
		$result =  sql_query("SELECT @postID", $connect);
		$row = sql_fetch_row($result);
		$post_id = $row[0];
	    echo "$post_id";
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
				
}	            

?>

