<? include "session.php"; ?>
<? echo "hello ".$_SESSION['username']; ?>



<html>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?
		echo "<a href=\"?menu=logout&action=logout\"><b>logout!</b></a>";	
?>
<h2>my contacts</h2>
<table class="table table-hover">
<tr>
<th>SI</th>
<th>Name</th>
<th>address</th>
<th>phone</th>
<th>email</th>
<th>View</th>
</tr>
<?
	$sql = "select * from registration";
	$result = sql_query($sql, $connect);
	$i = 1;
	if(sql_num_rows($result))
	{
		while ($row = sql_fetch_array($result)) 
		{   
			 echo "<tr>";
			 		echo "<td>".$i++."</td>";
			 		echo "<td>".$row[1]."</td>";
			 		echo "<td>".$row[3]."</td>";
			 	    echo "<td>".$row[10]."</td>";
			 	    echo "<td>".$row[8]."</td>";	 	

		 echo "</tr>";
		}
	}
	else 
	{
		echo "No contacts";	     
    }

?>
</table>
</html>