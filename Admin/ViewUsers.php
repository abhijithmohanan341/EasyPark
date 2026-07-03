<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Booking Report</title>

<style>
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f9f9f9;
    color: #333;
}

h2 {
    color: #007bff;
    margin-top: 20px;
}

.report-container {
    max-width: 1100px;
    margin: 30px auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.report-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.report-table th, 
.report-table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

.report-table th {
    background: #007bff;
    color: #fff;
    text-transform: uppercase;
    font-size: 13px;
}

.report-table tr:nth-child(even) {
    background: #f8f8f8;
}

.report-table tr:hover {
    background: #eef4ff;
}

.report-table img {
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
}
</style>
</head>

<body>
<div class="report-container">
  <center><h2>USER REPORT</h2></center>
  <form id="form1" name="form1" method="post" action="">
    <table class="report-table">
      <tr>
        <th>User Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Address</th>
        <th>District</th>
        <th>Place</th>
        <th>Photo</th>
        <th>Registration Date</th>
      </tr>
      <?php
      $SelQry = "SELECT u.user_name, 
                        u.user_email, 
                        u.user_contact, 
                        u.user_address,
                        d.district_name, 
                        p.place_name, 
                        u.user_photo, 
                        u.user_doj
                 FROM tbl_user u
                 INNER JOIN tbl_place p ON u.place_id = p.place_id
                 INNER JOIN tbl_district d ON p.district_id = d.district_id
                 ORDER BY u.user_doj DESC";

      $result = $Con->query($SelQry);

      if($result){
        while($row = $result->fetch_assoc()) {
      ?>
      <tr>
        <td><?php echo $row['user_name']; ?></td>
        <td><?php echo $row['user_email']; ?></td>
        <td><?php echo $row['user_contact']; ?></td>
        <td><?php echo $row['user_address']; ?></td>
        <td><?php echo $row['district_name']; ?></td>
        <td><?php echo $row['place_name']; ?></td>
        <td>
          <?php if(!empty($row['user_photo'])) { ?>
            <img src="../Assets/Files/User/Photo/<?php echo $row['user_photo']; ?>" width="60" height="60" />
          <?php } else { echo "No Photo"; } ?>
        </td>
        <td><?php echo $row['user_doj']; ?></td>
      </tr>
      <?php
        }
      } else {
        echo "<tr><td colspan='8'>SQL Error: " . $Con->error . "</td></tr>";
      }
      ?>
    </table>
  </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
