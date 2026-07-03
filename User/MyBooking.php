<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();

// ✅ Cancel Booking
if(isset($_GET['cancel_id'])) {
    $cancel_id = $_GET['cancel_id'];
    $updateQry = "UPDATE tbl_booking SET booking_status='3' WHERE booking_id='$cancel_id'";
    if($Con->query($updateQry)) {
        echo "<script>alert('Booking cancelled successfully,The amount will be credited to your account within 5–7 working days.'); window.location='MyBooking.php';</script>";
    } else {
        echo "<script>alert('Error cancelling booking');</script>";
    }
}
if(isset($_GET['pid']))
{
  $_SESSION['bid'] = $_GET['pid'];
  echo "<script>window.location='Payment.php'</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::MyBooking</title>

<style>
/* Unique CSS for MyBooking */
.mybooking-page {
    background: lightskyblue;
    font-family: Arial, sans-serif;
    padding: 30px;
    min-height: 100vh;
}

.mybooking-container {
    max-width: 95%;
    margin: 0 auto;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
}

/* 🔥 Multicolor Gradient Heading */
.mybooking-container h2 {
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

.mybooking-container table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 40px;
}

.mybooking-container table th,
.mybooking-container table td {
    border: 1px solid #ddd;
    padding: 10px;
    font-size: 14px;
    text-align: center;
}

.mybooking-container table th {
    background: #007bff;
    color: #fff;
}

.mybooking-container table tr:nth-child(even) {
    background: #f9f9f9;
}

.mybooking-container table tr:hover {
    background: #eef7ff;
}

.mybooking-container a {
    display: inline-block;
    margin: 5px;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
    font-weight: bold;
    transition: 0.3s;
}
.mybooking-container a[href*="Receipt"] {
    background: #28a745;
    color: white;
}
.mybooking-container a[href*="pid"] {
    background: blueviolet;
    color: white;
}

.mybooking-container a[href*="cancel_id"] {
    background: #dc3545;
    color: white;
}

.mybooking-container a:hover {
    opacity: 0.85;
}
</style>
</head>
<body class="mybooking-page">
<div class="mybooking-container">

<h2> MY BOOKINGS </h2>
<form id="form1" name="form1" method="post" action="">
  <table>
    <tr>
      <th>Sl No</th>
      <th>Booking Id</th>
      <th>From Date Time</th>
      <th>To Date Time</th>
      <th>Plot Details</th>
      <th>Slot Id</th>
      <th>Slot Number</th>
      <th>Vehicle Type</th>
      <th>Slot Price</th>
      <th>Total Price</th>
      <th>Vehicle Number</th>
      <th>Action</th>
    </tr>
    <?php
    $i=0;
    $SelQry = "SELECT * 
    FROM tbl_booking p 
    INNER JOIN tbl_slot s ON s.slot_id = p.slot_id 
    INNER JOIN tbl_plot d ON d.plot_id = s.plot_id 
    INNER JOIN tbl_type t ON t.type_id = d.type_id 
    WHERE p.user_id = '".$_SESSION['uid']."' 
    AND p.booking_status < '3'
     ORDER BY p.booking_id DESC";

    $result = $Con->query($SelQry);
    while($row=$result->fetch_assoc())
    {
        $i++;	
        $fromDate = strtotime($row['booking_fromdatetime']);
        $now = time();
    ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row['booking_id']; ?></td> 
      <td><?php echo $row['booking_fromdatetime']; ?></td>
      <td><?php echo $row['booking_todatetime']; ?></td>
      <td><?php echo $row['plot_details']; ?></td>
      <td><?php echo $row['slot_id']; ?></td>
      <td><?php echo $row['slot_no']; ?></td>
      <td><?php echo $row['type_name']; ?></td>
      <td>₹<?php echo $row['slot_price']; ?></td>
      <td>₹<?php echo $row['booking_amount']; ?></td>
      <td><?php echo $row['user_vehicleno']; ?></td>
      <td>
        <?php
        if($row['booking_status'] == 2)
        {
        ?>
        <a href="Receipt.php?bid=<?php echo $row['booking_id']?>">View Receipt</a>
        <?php if ($fromDate > $now) { ?>
          <a href="MyBooking.php?cancel_id=<?php echo $row['booking_id']; ?>" 
             onclick="return confirm('Are you sure you want to cancel this booking?');">
             Cancel
          </a>
        <?php }
        }
        else
        {
          echo "<a href='MyBooking.php?pid=".$row['booking_id']."'>Payment</a>";
        }
        ?>
      </td>
    </tr>
    <?php
    }
    ?>
  </table>
</form>

<h2> CANCELLED BOOKINGS </h2>
<form id="form2" name="form2" method="post" action="">
<table>
    <tr>
      <th>Sl No</th>
      <th>Booking Id</th>
      <th>From Date Time</th>
      <th>To Date Time</th>
      <th>Plot Details</th>
      <th>Slot Id</th>
      <th>Slot Number</th>
      <th>Vehicle Type</th>
      <th>Slot Price</th>
      <th>Total Price</th>
      <th>Vehicle Number</th>
    </tr>
    <?php
    $i=0;
    $SelQry = "SELECT * 
    FROM tbl_booking p 
    INNER JOIN tbl_slot s ON s.slot_id = p.slot_id 
    INNER JOIN tbl_plot d ON d.plot_id = s.plot_id 
    INNER JOIN tbl_type t ON t.type_id = d.type_id 
    WHERE p.user_id = '".$_SESSION['uid']."' 
    AND p.booking_status = '3'";

    $result = $Con->query($SelQry);
    while($row=$result->fetch_assoc())
    {
        $i++;	
    ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $row['booking_id']; ?></td> 
      <td><?php echo $row['booking_fromdatetime']; ?></td>
      <td><?php echo $row['booking_todatetime']; ?></td>
      <td><?php echo $row['plot_details']; ?></td>
      <td><?php echo $row['slot_id']; ?></td>
      <td><?php echo $row['slot_no']; ?></td>
      <td><?php echo $row['type_name']; ?></td>
      <td>₹<?php echo $row['slot_price']; ?></td>
      <td>₹<?php echo $row['booking_amount']; ?></td>
      <td><?php echo $row['user_vehicleno']; ?></td>
    </tr>
    <?php
    }
    ?>
  </table>
</form>
</div>
</body>
</html>
<?php include("Footer.php");?>
