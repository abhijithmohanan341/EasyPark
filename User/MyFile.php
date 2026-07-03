<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();
$selUser="select * from tbl_user u 
inner join tbl_place p on p.place_id=u.place_id 
inner join tbl_district d on d.district_id=p.district_id 
where user_id='".$_SESSION['uid']."'";
$userResult=$Con->query($selUser);
$userData=$userResult->fetch_assoc();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::MyProfile</title>

<style>
/* Page background */
body {
  background-color: lightskyblue;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

/* Container */
.profile-container {
  max-width: 500px;
  margin: 40px auto;
  padding: 25px;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  text-align: center;
}

/* Profile Table */
.profile-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}
.profile-table tr {
  border-bottom: 1px solid #eee;
}
.profile-table td {
  padding: 12px;
  text-align: left;
}

/* Labels */
.profile-label {
  font-weight: bold;
  color: #555;
  width: 30%;
}

/* Values */
.profile-value {
  color: #333;
}

/* Profile Photo */
.profile-photo-cell {
  text-align: center;
  padding: 20px 0;
  display: flex;
  justify-content: center;
}

.profile-photo {
  display: block;
  margin: auto;
  width: 140px;
  height: 140px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #007bff;
  transition: transform 0.3s ease;
}

.profile-photo:hover {
  transform: scale(1.05);
}

/* Home link */
.profile-home-link {
  display: inline-block;
  margin: 15px;
  font-size: 16px;
  color: #007bff;
  text-decoration: none;
}
.profile-home-link:hover {
  text-decoration: underline;
}

</style>

</head>

<body>
<div class="profile-container">
  
  <!-- Stylish Heading -->
  <h2 style="color:#007bff; margin:0; font-size:24px; font-weight:bold; text-align:center;">
   MY PROFILE
  </h2>
  <hr style="width:50px; border:2px solid #007bff; border-radius:5px; margin:10px auto;" />

  <form id="form1" name="form1" method="post" action="">
    <table class="profile-table">
      <tr>
        <td colspan="2" class="profile-photo-cell"> 
          <img src="../Assets/Files/User/Photo/<?php echo $userData['user_photo']?>" class="profile-photo"/>
        </td>
      </tr>
      <tr>
        <td class="profile-label">Name</td>
        <td class="profile-value"><?php echo $userData['user_name']?></td>
      </tr>
      <tr>
        <td class="profile-label">Email</td>
        <td class="profile-value"><?php echo $userData['user_email']?></td>
      </tr>
      <tr>
        <td class="profile-label">Contact</td>
        <td class="profile-value"><?php echo $userData['user_contact']?></td>
      </tr> 	
      <tr>
        <td class="profile-label">Address</td>
        <td class="profile-value"><?php echo $userData['user_address']?></td>
      </tr>
      <tr>
        <td class="profile-label">District</td>
        <td class="profile-value"><?php echo $userData['district_name']?></td>
      </tr>
      <tr>
        <td class="profile-label">Place</td>
        <td class="profile-value"><?php echo $userData['place_name']?></td>
      </tr>
    </table>
  </form>
  <a href="EditProfile.php" class="profile-home-link">Edit Profile</a>
  <a href="ChangePassword.php" class="profile-home-link">Change Password</a>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
