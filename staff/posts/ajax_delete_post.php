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


$post_id = $_GET[post_id];
$sql = "DELETE FROM posts WHERE post_id = \"$post_id\" ";
$result = sql_query($sql, $connect);

if($result)
{
	echo "deleted";

} 
	else
	{
		echo "not deleted";
	}
?>
