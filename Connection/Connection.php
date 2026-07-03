<?php
$ServerName = "localhost";
$UserName = "root";
$DBPassword = "";
$DBName = "db_miniproject";
$Con =  mysqli_connect($ServerName,$UserName,$DBPassword,$DBName);
if(!$Con)
{
	echo "Connection Failed";
}
?>
