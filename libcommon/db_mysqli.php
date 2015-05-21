<?php
$mysqli = mysqli_connect($HOST,$USER,$PASSWD,$DB_NAME);
if (mysqli_connect_errno())
{
    echo mysqli_connect_error();
    exit();
}
?>
