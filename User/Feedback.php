<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();

if(isset($_POST["btn_submit"])) {
    $feedback = $_POST["txt_feedback"];
    $insQry = "INSERT INTO tbl_feedback (feedback_content,user_id) 
               VALUES ('".$feedback."', '".$_SESSION['uid']."')";
    if($Con->query($insQry)) {
        echo "<script>alert('Feedback Submitted Successfully');</script>";
    }
}

if(isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_feedback WHERE feedback_id=".$_GET['did'];
    if($Con->query($delQry)) {
        echo "<script>alert('Feedback Deleted Successfully'); window.location='Feedback.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>ParkingSlot::Feedback</title>
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
        background-color: #0055aa;
    }
    a {
        color: red;
        text-decoration: none;
        font-weight: bold;
    }
</style>
</head>
<body>


<h2>Submit Your Feedback</h2>
<form method="post" action="">
  <table class="form-table">
    <tr>
      <td>Feedback</td>
      <td><textarea name="txt_feedback" id="txt_feedback" cols="45" rows="5" required></textarea></td>
    </tr>
    <tr>
      <center>
      <td colspan="2" alignment="center"><input type="submit" name="btn_submit" class="btn" value="Submit" /></td>
      </center>
    </tr>
  </table>
</form>

<h2>My Feedbacks</h2>
<table>
  <tr>
    <th>Sl No</th>
    <th>Feedback</th>
    <th>Action</th>
  </tr>
  <?php
    $i=0;
    $SelQry = "SELECT * FROM tbl_feedback WHERE user_id='".$_SESSION['uid']."'";
    $result = $Con->query($SelQry);
    while($row = $result->fetch_assoc()) {
        $i++;
  ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row['feedback_content']; ?></td>
      <td>
        <a href="Feedback.php?did=<?php echo $row['feedback_id']?>"
           onclick="return confirm('Are you sure you want to delete this feedback?');">Delete</a>
      </td>
    </tr>
  <?php
    }
  ?>
</table>
</body>
</html>
<?php include("Footer.php"); ?>
