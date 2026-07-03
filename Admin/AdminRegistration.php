<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
if(isset($_POST["btn_submit"]))
{
	$name=$_POST["name_txt"];
	$email=$_POST["email_txt"];
	$password=$_POST["pswd_txt"];
	$insQry="insert into tbl_admin(admin_name,admin_email,admin_password) values ('".$name."','".$email."','".$password."')";
	if($Con->query($insQry))
	{
		?>
        <script>
		alert("Values Inserted");
		window.location="AdminRegistration.php";
		</script>
        <?php
	}
	
}
	if(isset($_GET['did']))
{
	$delQry="delete from tbl_admin where admin_id=".$_GET['did'];
	if($Con->query($delQry))
	{
		?>
		<script>
		alert("value Deleted.");
		window.location="AdminRegistration.php";
		</script>
        <?php
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::AdminRegistartion</title>

<style>
/* Unique CSS for Admin Registration Page */
.admin-reg-wrapper {
    max-width: 800px;
    margin: 40px auto;
    font-family: "Segoe UI", Arial, sans-serif;
    color: #333;
}

.admin-reg-form {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.admin-reg-form table {
    width: 100%;
    border-collapse: collapse;
}

.admin-reg-form td {
    padding: 10px;
    font-size: 14px;
}

.admin-reg-form input[type="text"],
.admin-reg-form input[type="email"],
.admin-reg-form input[type="password"] {
    width: 95%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: 0.3s;
}

.admin-reg-form input[type="text"]:focus,
.admin-reg-form input[type="email"]:focus,
.admin-reg-form input[type="password"]:focus {
    border-color: #007bff;
    outline: none;
}

.admin-reg-form input[type="submit"] {
    background: #007bff;
    color: #fff;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.admin-reg-form input[type="submit"]:hover {
    background: #0056b3;
}

.admin-list {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.admin-list table {
    width: 100%;
    border-collapse: collapse;
}

.admin-list th, 
.admin-list td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.admin-list th {
    background: #007bff;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
}

.admin-list tr:hover {
    background: #f1f1f1;
}

.admin-list a {
    color: #e63946;
    font-weight: bold;
    text-decoration: none;
    padding: 5px 10px;
    border: 1px solid #e63946;
    border-radius: 5px;
    transition: 0.3s;
}

.admin-list a:hover {
    background: #e63946;
    color: #fff;
}
</style>
</head>

<body>
<div class="admin-reg-wrapper">
  <form id="form1" name="form1" method="post" action="">
    <div class="admin-reg-form">
      <h2>Admin Registration</h2>
      <table border="0">
        <tr>
          <td>Name</td>
          <td>
            <input type="text" required name="name_txt" id="name_txt" 
            title="Name Allows Only Alphabets,Spaces and First Letter Must Be Capital Letter" 
            pattern="^[A-Z]+[a-zA-Z ]*$" />
          </td>
        </tr>
        <tr>
          <td>Email</td>
          <td>
            <input type="email" required name="email_txt" id="email_txt" />
          </td>
        </tr>
        <tr>
          <td>Password</td>
          <td>
            <input type="password" required name="pswd_txt" id="pswd_txt"  
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
          </td>
        </tr>
      </table>
    </div>

    <div class="admin-list">
      <h2>Admin List</h2>
      <table border="0">
        <tr>
          <th>SL NO</th>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
        <?php
        $i=0;
        $SelQry="select * from tbl_admin";
        $result=$Con->query($SelQry);
        while($row=$result->fetch_assoc())
        {
          $i++;
        ?>
        <tr>
          <td><?php echo $i ?></td>
          <td><?php echo $row['admin_name']?></td>
          <td><?php echo $row['admin_email']?></td>
          <td><a href ="AdminRegistration.php?did=<?php echo $row['admin_id']?>">Delete</a></td>
        </tr>
        <?php
        }
        ?>
      </table>
    </div>
  </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
