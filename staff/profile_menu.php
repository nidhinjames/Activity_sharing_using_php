<? include "session.php"; ?>
<? include "header.php"; ?>
<div class="left_mid_content">      
   <ul class="submenu">        
	<?php 	
	if($_GET[menu]=="myposts" )
	{
		echo "<li class=title_sel><a href=\"?menu=posts&action=list\"><b>My Posts</b></a></li>";
	}
	else
	{
		echo "<li class=title><a href=\"?menu=posts&action=list\"><b>My Posts</b></a></li>";
	}
	if($_GET[menu]=="people_posts")
	{
		echo "<li class=title_sel><a href=\"?menu=people_posts&action=list\"><b> people posts</b></a></li>";
	}
	else
	{
		echo "<li class=title><a href=\"?menu=people_posts&action=list\"><b>people posts</b></a></li>";
	}		
	if($_GET[menu]=="contacts")
	{
		echo "<li class=title_sel><a href=\"?menu=contacts&action=list\"><b>My contacts</b></a></li>";
	}
	else
	{
		echo "<li class=title><a href=\"?menu=contacts&action=list\"><b>My contacts</b></a></li>";
	}		
	
?>
</ul>
</div>
