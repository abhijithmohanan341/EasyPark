<?php
// Fix path if your folder structure is deep
include("../../Assest/Connection/Connection.php"); 

if(isset($_GET["email"])) {
    $email = $_GET["email"];
    $sel = "SELECT * FROM tbl_user WHERE user_email='".$email."'";
    $res = $Con->query($sel);

    if($res->num_rows > 0) {
        echo "Exists";
    } else {
        echo "Available";
    }
}
// die() prevents any accidental extra characters from being sent
die(); 
?>