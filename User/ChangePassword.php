<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();

$SelUser = "select * from tbl_user where user_id='" . $_SESSION['uid'] . "'";
$userResult = $Con->query($SelUser);
$userData = $userResult->fetch_assoc();
$userPass = $userData['user_password'];

if (isset($_POST['btn_submit'])) {
    $currentPass = $_POST['txt_oldpassword'];
    $newPass = $_POST['txt_newpassword'];
    $rePass = $_POST['txt_retypepassword'];

    if ($userPass == $currentPass) {
        if ($newPass == $rePass) {
            $upQry = "update tbl_user set user_password='" . $newPass . "' where user_id='" . $_SESSION['uid'] . "'";
            if ($Con->query($upQry)) {
?>
                <script>
                    alert("Password updated successfully");
                    window.location = "MyFile.php";
                </script>
<?php
            }
        } else {
?>
            <script>
                alert("Password mismatch");
                window.location = "ChangePassword.php";
            </script>
<?php
        }
    } else {
?>
        <script>
            alert("Current Password mismatch");
            window.location = "ChangePassword.php";
        </script>
<?php
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<title>ParkingSlot::ChangePassword</title>
<style>
    body {
        background-color: lightskyblue;
        font-family: Arial, sans-serif;
    }
    .form-container {
        margin: 50px auto;
        width: 400px;
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td {
        padding: 10px;
        text-align: left;
    }
    input[type="text"], input[type="password"] {
        width: 95%;
        padding: 8px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: all 0.3s ease;
        margin: 10px 5px;
    }
    .btn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .back-btn {
        background-color: #6c757d;
        text-decoration: none;
        color: white;
        border-radius: 5px;
        padding: 10px 25px;
        font-weight: bold;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .back-btn:hover {
        background-color: #5a6268;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-row {
        text-align: center;
        margin-top: 15px;
    }
</style>
</head>

<body>
    <div class="form-container">
         <h2 style="color:#007bff; margin:0; font-size:24px; font-weight:bold; text-align:center;">
         CHANGE PASSWORD
        </h2>
        <hr style="width:50px; border:2px solid #007bff; border-radius:5px; margin:10px auto;" /><br>
        <form id="form1" name="form1" method="post" action="">
          <table>
            <tr>
              <td>Current Password</td>
              <td><input type="password" required name="txt_oldpassword" id="txt_oldpassword"
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Must contain at least one number, one uppercase and lowercase letter, and 8 or more characters"/></td>
            </tr>
            <tr>
              <td>New Password</td>
              <td><input type="password" required name="txt_newpassword" id="txt_newpassword"
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Must contain at least one number, one uppercase and lowercase letter, and 8 or more characters"/></td>
            </tr>
            <tr>
              <td>Retype Password</td>
              <td><input type="password" required name="txt_retypepassword" id="txt_retypepassword"
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               title="Must contain at least one number, one uppercase and lowercase letter, and 8 or more characters"/></td>
            </tr>
          </table>

          <div class="btn-row">
              <input type="submit" name="btn_submit" id="btn_submit" value="Submit" class="btn" />
              <a href="MyFile.php" class="back-btn">Back</a>
          </div>
        </form>
    </div>

    <!-- Client-side password validation -->
    <script>
    document.getElementById("form1").addEventListener("submit", function(e) {
        const oldPass = document.getElementById("txt_oldpassword").value.trim();
        const actualPass = "<?php echo $userPass; ?>"; 
        const newPass = document.getElementById("txt_newpassword").value.trim();
        const rePass = document.getElementById("txt_retypepassword").value.trim();

        if (oldPass !== actualPass) {
            alert("Current password does not match your existing password.");
            e.preventDefault();
            return false;
        }

        if (newPass !== rePass) {
            alert("New password and retype password do not match.");
            e.preventDefault();
            return false;
        }

        return true;
    });
    </script>
</body>
</html>
<?php include("Footer.php"); ?>
