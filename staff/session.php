<?
if(!isset($_SESSION['userID']) || !isset($_SESSION['username']) || !isset($_SESSION['userstatus'])) {?> 
        <script type="text/javascript">
        window.location.href="index.php";
        </script>
<?    
exit();
}
?>

