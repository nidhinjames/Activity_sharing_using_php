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
	include "header.php";
	?>

<script type="text/javascript">
	
function delete_post(post_id)
{
	var dataString = "";
	dataString = "post_id="+post_id;
	jConfirm('You are going to delete the event. Are you sure ?', 'Confirmation', function(r) 
	{
		if( r==true)
		{
			$('#loader').show();
			$.ajax({
				type: "GET",
				url: "posts/ajax_delete_post.php",
				data: dataString,
				success: function(response)
					{
						$('#loader').hide();
						$('#'+post_id).remove();
					}
			   });	
		}
	
	});	
}
function edit_post(post_id)
{
	var dataString = "";
	dataString = "post_id="+post_id;
	alert(dataString);
	$('#loader').show();
	$.ajax({
		type: "GET",
		url: "posts/ajax_edit_post.php",
		data: dataString,
			success: function(response)
				{
					$('#loader').hide();
					$('#'+post_id).html(response);			
				}
			});
} 

function update_post($post_id) 
{
	var post_id = $post_id;
	var post = $('#postid').val();
	dataString ="post_id="+post_id+"&post="+post;
	$.ajax({
		type: "GET",
		url: "posts/ajax_update_post.php",
		data: dataString,
			success: function(response)
				{
					$('#'+post_id).html(response);
				}
		  });
}
function cancel_post($post_id)
{
	var post_id = $post_id;
	dataString = "post_id="+post_id;
	$.ajax({
		type: "GET",
		url: "posts/ajax_cancel_post.php",
		data: dataString,
			success: function(response)
				{
					$('#'+post_id).html(response);
				}
		  });

}		

</script>



<div>	
<table class="table table-boardered">
<tr id= "head" >
<th>Posts</th>
<th>Date</th>
<th>Edit</th>
<th>Delete</th>
</tr>
<?
$i = 1;
$user_id = $_SESSION['userID'];
//echo $user_id;
$sql = "select * from posts where user_id=$user_id";
$result = sql_query($sql, $connect);
if(sql_num_rows($result))
	{
		while ($row = sql_fetch_array($result)) 
		{       $post_id = $row[0];
		        $date = $row[3];					
				echo "<tr id=\"$post_id\">
			 			<td>".$row[2]."</td>
			 			<td>".$date."</td>
			 			<td><a class='btn btn-primary btn-sm' onclick=\"edit_post($post_id)\"><span class='glyphicon glyphicon-edit'></span></a></td>
			 			<td><a class='btn btn-danger btn-sm' onclick=\"delete_post($post_id)\"><span class='glyphicon glyphicon-trash'></span></a></td>

			 	      </tr>
			 	      <tr ></tr>";
		}
	}

?>
</table>
</div>		