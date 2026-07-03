<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();

// ✅ Fetch current user data
$SelUser = "SELECT * FROM tbl_user WHERE user_id='" . $_SESSION['uid'] . "'";
$userResult = $Con->query($SelUser);
$userData = $userResult->fetch_assoc();

if (isset($_POST['btn_submit'])) {
    $name = $_POST['txt_name'];
    $email = $_POST['txt_email'];
    $contact = $_POST['txt_contact'];
    $address = $_POST['txt_address'];

    // ✅ Profile Photo Upload
    $photo = $userData['user_photo']; // keep old photo by default
    if (!empty($_FILES['txt_photo']['name'])) {
        $fileName = $_FILES['txt_photo']['name'];
        $fileTmp = $_FILES['txt_photo']['tmp_name'];
        $folder = "../Assest/Files/User/";

        if (move_uploaded_file($fileTmp, $folder . $fileName)) {
            $photo = $fileName;
        }
    }

    // ✅ Update query (no password)
    $upQry = "UPDATE tbl_user 
              SET user_name='" . $name . "',
                  user_email='" . $email . "',
                  user_contact='" . $contact . "',
                  user_address='" . $address . "',
                  user_photo='" . $photo . "'
              WHERE user_id='" . $_SESSION['uid'] . "'";

    if ($Con->query($upQry)) {
        ?>
        <script>
            alert("Profile Updated Successfully!");
            window.location="MyFile.php";
        </script>
        <?php
    } else {
        echo "<script>alert('Update Failed!');</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::EditProfile</title>

<style>
/* Page background */
body {
  background-color: lightskyblue;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

/* Form container */
.edit-profile-container {
  max-width: 500px;
  margin: 40px auto;
  padding: 25px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Table */
.edit-profile-table {
  width: 100%;
  border-collapse: collapse;
}
.edit-profile-table td {
  padding: 12px;
  vertical-align: middle;
}
.edit-profile-table tr {
  border-bottom: 1px solid #eee;
}
.edit-profile-table tr:last-child {
  border-bottom: none;
}

/* Labels */
.edit-profile-label {
  font-weight: bold;
  color: #555;
  width: 30%;
}

/* Inputs */
input[type="text"], input[type="password"], input[type="file"],[type="email"], textarea, select {
    width: 95%;
    padding: 8px 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}
.edit-profile-table textarea {
  resize: vertical;
}

/* Profile Photo */
.profile-photo-preview {
  display: block;
  margin-bottom: 10px;
  border-radius: 8px;
  border: 2px solid #007bff;
}

/* Buttons */
.btn {
  background-color: #007bff;
  color: #fff;
  font-size: 15px;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: bold;
  margin: 5px;
}
.btn:hover {
  background-color: #0056b3;
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Back Button */
.back-btn {
  background-color: #6c757d;
  color: white;
  text-decoration: none;
  font-size: 15px;
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: bold;
  transition: all 0.3s ease;
  margin: 5px;
  display: inline-block;
}
.back-btn:hover {
  background-color: #5a6268;
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Button container */
.button-row {
  text-align: center;
  margin-top: 10px;
}
</style>

</head>

<body>
<div class="edit-profile-container">
   <h2 style="color:#007bff; margin:0; font-size:24px; font-weight:bold; text-align:center;">
   EDIT MY PROFILE
  </h2>
  <hr style="width:50px; border:2px solid #007bff; border-radius:5px; margin:10px auto;" /><br>
<form id="form1" name="form1" method="post" enctype="multipart/form-data" action="">
  <table class="edit-profile-table">
    <tr>
      <td class="edit-profile-label">Name</td>
      <td>
        <input type="text" name="txt_name" id="txt_name" 
               required 
               pattern="^[A-Z]+[a-zA-Z ]*$" 
               title="Name allows only letters, spaces, first letter must be capital"
               value="<?php echo $userData['user_name']; ?>"/>
      </td>
    </tr>
    <tr>
      <td class="edit-profile-label">Email</td>
      <td>
        <input type="email" required name="txt_email" id="txt_email" 
               value="<?php echo $userData['user_email']; ?>" />
      </td>
    </tr>
    <tr>
      <td class="edit-profile-label">Contact</td>
      <td>
        <input type="text" required name="txt_contact" id="txt_contact"  
               pattern="[7-9]{1}[0-9]{9}" 
               title="Phone number must start with 7-9 and be 10 digits"
               value="<?php echo $userData['user_contact']; ?>"/>
      </td>
    </tr>
    <tr>
      <td class="edit-profile-label">Address</td>
      <td>
        <textarea name="txt_address" id="txt_address" cols="45" rows="5" required><?php echo $userData['user_address']; ?></textarea>
      </td>
    </tr>
    <tr>
      <td class="edit-profile-label">Profile Photo</td>
      <td>
        <?php if (!empty($userData['user_photo'])) { ?>
          <img src="../Assets/Files/User/Photo/<?php echo $userData['user_photo']; ?>" width="60" height="60" class="profile-photo-preview"/>
        <?php } ?>
        <input type="file" name="txt_photo" id="txt_photo"/>
      </td>
    </tr>
  </table>

  <!-- ✅ Button Row (Submit + Back in same line) -->
  <div class="button-row">
    <input type="submit" name="btn_submit" id="btn_submit" value="Update Profile" class="btn" />
    <a href="MyFile.php" class="back-btn">Back</a>
  </div>

</form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
