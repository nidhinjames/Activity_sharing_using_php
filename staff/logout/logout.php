<?php
	if($_GET["action"] == "logout")
	{
		session_unset();
		session_destroy(); echo "string";?>
		<script type="text/javascript">
			window.location.replace("index.php");
		</script> <?php
	}
?>