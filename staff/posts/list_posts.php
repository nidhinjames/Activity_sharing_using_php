<? include "session.php"; ?>
<?include "header.php";
?>
<? echo "hello ".$_SESSION['username']; ?>
<!-- <div id="loader" style="margin-left:350px; display:none;"><img src="../libcommon/images/custom1/ajax_load.gif" /></div> -->
<div class='row' >
	<div class="col-md-offset-2 col-md-8 col-md-offset-2">
	<div class="panel panel-primary">
		<div class='panel-heading'>My Posts</div>
		<div class="panel-body">
	
	<table class="table table-boardered">
	<tr>
		<td>Post:</td>
		<td><textarea class='form-controll' name=post id="post"></textarea></td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center;"><input type="button" value="Submit" onclick="insert()" /></td>
	</tr>
    </table>
    </div></div>
   </div> 
</div>
<div class="row">
	<div class='col-md-offset-2 col-md-8 col-md-offset-2'  id="res">
	</div>
<div>
</html>

<script>
$( document ).ready(function() 
{
    posts()
});


function posts() 
{
	$.ajax({
			type : "GET",
			url: "posts/ajax_list_posts.php",
			success: function(response){
		 	$("#res").html(response);
		                               }
			});
}		



function insert() 
{
	var sessionid = <?=$_SESSION['userID']?>;
	var datastring = "";
	var post = $('#post').val()
	datastring = "post="+post+"&id="+sessionid;
	alert(datastring);
    
	$.ajax({
			type :"POST",
			url: "posts/create_newpost.php",
			data:datastring,
			success: function(response){
		 	$('#head').after(response);
		                               }
		

		
			
		});
	
}


</script>


