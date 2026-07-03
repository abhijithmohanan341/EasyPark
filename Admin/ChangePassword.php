<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
$SelAdmin="select * from tbl_admin where admin_id='".$_SESSION['aid']."'";
$adminResult=$Con->query($SelAdmin);
$adminData=$adminResult->fetch_assoc();
$adminPass=$adminData['admin_password'];
if(isset($_POST['btn_submit']))
{
	$currentPass=$_POST['txt_oldpassword'];
	$newPass=$_POST['txt_newpassword'];
	$rePass=$_POST['txt_retypepassword'];
	
	if($adminPass == $currentPass)
	{
		if($newPass == $rePass)
		{
			$upQry="update tbl_admin set admin_password='".$newPass."' where admin_id='".$_SESSION['aid']."'";
			if($Con->query($upQry))
			{
				?>
				<script>
				 alert("Data updated");
				 window.location="ChangePassword.php";
				 </script>
				 <?php
			}
		}
		else
		{
		 ?>
		 <script>
		 alert("Password missmatch");
		 window.location="ChangePassword.php";
		 </script>
		 <?php
		}
	}
	else
	{
		 ?>
		 <script>
		 alert("Current Password missmatch");
		 window.location="ChangePassword.php";
		 </script>
		 <?php
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Change Password | EasyPark Admin</title>
<style>
	
.container {
  width: 420px;
  background: rgba(255, 255, 255, 0.9);
  padding: 30px 40px;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
  backdrop-filter: blur(6px);
}

h2 {
  text-align: center;
  color: #0d47a1;
  margin-bottom: 25px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

td {
  padding: 10px 0;
  vertical-align: middle;
}

input[type="text"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
  box-sizing: border-box;
  font-size: 14px;
  transition: 0.3s;
}

input[type="text"]:focus,
input[type="password"]:focus {
  border-color: #0d47a1;
  box-shadow: 0 0 6px rgba(13,71,161,0.3);
  outline: none;
}

input[type="submit"] {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 6px;
  background-color: #0d47a1;
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  font-size: 15px;
  transition: all 0.3s ease-in-out;
}

input[type="submit"]:hover {
  background-color: #1565c0;
  transform: scale(1.05);
  box-shadow: 0 6px 12px rgba(13,71,161,0.4);
}
</style>
</head>

<body>
<div class="container">
  <h2>Change Password</h2>
  <form id="form1" name="form1" method="post" action="">
    <table>
      <tr>
        <td>Current Password</td>
      </tr>
      <tr>
        <td><input type="text" name="txt_oldpassword" id="txt_oldpassword" required 
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                   title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters" /></td>
      </tr>
      <tr>
        <td>New Password</td>
      </tr>
      <tr>
        <td><input type="text" name="txt_newpassword" id="txt_newpassword" required 
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                   title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters" /></td>
      </tr>
      <tr>
        <td>Retype Password</td>
      </tr>
      <tr>
        <td><input type="text" name="txt_retypepassword" id="txt_retypepassword" required 
                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                   title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters" /></td>
      </tr>
      <tr>
        <td><input type="submit" name="btn_submit" id="btn_submit" value="Update Password" /></td>
      </tr>
    </table>
  </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
