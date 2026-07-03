<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();

if(isset($_POST["btn_submit"])) {
    $title = $_POST["txt_title"];
    $content = $_POST["txt_content"];
    $insQry = "INSERT INTO tbl_complaint (complaint_title, complaint_content, user_id) 
               VALUES ('".$title."', '".$content."', '".$_SESSION['uid']."')";
    if($Con->query($insQry)) {
        echo "<script>alert('Complaint Submitted Successfully');</script>";
    }
}

if(isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_complaint WHERE complaint_id=".$_GET['did'];
    if($Con->query($delQry)) {
        echo "<script>alert('Complaint Deleted Successfully'); window.location='Complaint.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>ParkingSlot::Complaint</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: lightskyblue;
        margin: 20px;
    }

    /* 🔥 Gradient Heading */
    h2 {
        text-align: center;
        margin: 25px 0;
        font-size: 32px;
        font-weight: bold;
        background: linear-gradient(90deg, #3498db, #8e44ad);
        background-clip: text;
        -webkit-text-fill-color: transparent;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    table {
        width: 80%;
        border-collapse: collapse;
        margin: 20px auto;
        background: #fff;
        box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
    }
    table, th, td {
        border: 1px solid #000;
    }
    th, td {
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #007bff;
        color: white;
    }
    .form-table {
        width: 60%;
        background: #fff;
    }
    .form-table input, .form-table textarea {
        width: 95%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .btn {
        background-color: #007bff;
        color: #fff;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn:hover {
        background-color: #0056b3;
    }
    a {
        color: red;
        text-decoration: none;
        font-weight: bold;
    }
</style>
</head>
<body>
<h2>Submit Your Complaint</h2>
<form method="post" action="">
  <table class="form-table">
    <tr>
      <td>Title</td>
      <td><input type="text" required name="txt_title" id="txt_title" /></td>
    </tr>
    <tr>
      <td>Content</td>
      <td><textarea name="txt_content" id="txt_content" cols="45" rows="5" required></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="btn_submit" class="btn" value="Submit" /></td>
    </tr>
  </table>
</form>

<h2>My Complaints</h2>
<table>
  <tr>
    <th>Sl No</th>
    <th>Title</th>
    <th>Content</th>
    <th>Reply</th>
    <th>Action</th>
  </tr>
  <?php
    $i = 0;
    $SelQry = "SELECT * FROM tbl_complaint WHERE user_id='".$_SESSION['uid']."'";
    $result = $Con->query($SelQry);
    while($row = $result->fetch_assoc()) {
        $i++;
  ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row['complaint_title']; ?></td>
      <td><?php echo $row['complaint_content']; ?></td>
      <td><?php echo $row['complaint_reply'] ?: '<span style="color:orange;">Pending.....</span>'; ?></td>
      <td><a href="Complaint.php?did=<?php echo $row['complaint_id']?>"
             onclick="return confirm('Are you sure you want to delete this complaint?');">Delete</a></td>
    </tr>
  <?php
    }
  ?>
</table>
</body>
</html>
<?php include("Footer.php"); ?>
