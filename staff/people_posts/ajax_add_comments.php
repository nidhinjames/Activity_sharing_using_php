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


<?
$post_id = $_GET[post_id];
$result = sql_query($sql, $connect);	
echo "<div class='modal fade'>
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title'>Modal title</h4>
      </div>
      <div class='modal-body'>
        <p>One fine body&hellip;</p>
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        <button type='button' class='btn btn-primary'>Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->";
?>