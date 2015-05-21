<?include "session.php";
echo "hello ".$_SESSION['username'];
include "header.php";
 ?>

 <script type="text/javascript">
function view_post(post_id)
{
	var dataString = "";
	dataString = "post_id="+post_id;
	//alert(dataString);
	$.ajax({
		type: "GET",
		url: "people_posts/ajax_add_comments.php",
		data: dataString,
			success: function(response)
				{
					//$('#'+post_id).html(response);
					$('#comment').html(response);

					//alert(response);			
				}
			});


}
 </script>


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
<?
		echo "<a href=\"?menu=logout&action=logout\"><b>logout!</b></a>";	
?>
<h2>People Posts</h2>
<div class='row' >
	<div class="col-md-offset-2 col-md-8 col-md-offset-2">
<table class="table table-boardered">
<tr id='comment'>
<th>Name</th>
<th>Post</th>
<th>Comment</th>
</tr>
<?
	$user_id = $_SESSION['userID'];
	$sql = "select t1.name, t2.post_id, t2.post from registration t1, posts t2 where t1.user_id = t2.user_id and t2.user_id<> '$user_id'";
	$result = sql_query($sql, $connect);
	$i = 1;
	if(sql_num_rows($result))
	{
		while ($row = sql_fetch_array($result))		 
		{  

			 $name = $row[0];
			 $post_id = $row[1];
			 $post = $row[2];		 	  
			 echo "<tr id=\"$post_id\">
			 	   <td>$name</td>
			 	   <td>$post</td>
			 	   <td><a class='btn btn-success btn-sm' onclick=\"view_post($post_id)\"><span class=' glyphicon glyphicon-circle-arrow-right'></span></a></td>
		 	       </tr>"; 	   
	 	}	
	}
	else 
	{
		echo "No posts";	     
    }

?>
</table>
</div>
</div>
</html>