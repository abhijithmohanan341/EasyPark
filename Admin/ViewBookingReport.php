<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::ViewBooking</title>
<style>
/* Table Styling */
table {
  width: 100%;
  max-width: 1200px;
  margin: auto;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  font-size: 14px;
  background: #fff;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}
h2 {
    margin-bottom: 15px;
    color: #007bff;
}
th, td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: center;
}

th {
  background-color: #007bff;
  color: white;
  text-transform: uppercase;
  font-weight: bold;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: #f1f1f1;
}

.profit-row {
  background: #e9f5ff;
  font-weight: bold;
}

input[type="submit"] {
  background: #007bff;
  color: white;
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background: #0056b3;
}
</style>
</head>
<body>
<h2 align="center">📊 BOOKING REPORT</h2><br>
<form id="form1" name="form1" method="post" action="">
  <table style="width:100%; max-width:1000px; margin:auto; border:none; box-shadow:none; background:transparent;">
    <tr>
      <td>Type</td>
      <td>
        <select name="sel_type">
          <option value="">--All--</option>
          <?php
          $typeQry = "SELECT * FROM tbl_type";
          $typeRes = $Con->query($typeQry);
          while($trow = $typeRes->fetch_assoc()) {
              ?>
              <option value="<?php echo $trow['type_id']; ?>" 
                <?php if(isset($_POST['sel_type']) && $_POST['sel_type']==$trow['type_id']) echo "selected"; ?>>
                <?php echo $trow['type_name']; ?>
              </option>
              <?php
          }
          ?>
        </select>
      </td>
      <td>From Date</td>
      <td><input type="date" name="from_date" value="<?php if(isset($_POST['from_date'])) echo $_POST['from_date']; ?>" /></td>
      <td>To Date</td>
      <td><input type="date" name="to_date" value="<?php if(isset($_POST['to_date'])) echo $_POST['to_date']; ?>" /></td>
      <td>Search</td>
      <td><input type="text" name="search" placeholder="User/Vehicle/Plot" value="<?php if(isset($_POST['search'])) echo $_POST['search']; ?>" /></td>
      <td><input type="submit" name="btn_filter" value="Filter" /></td>
    </tr>
  </table>
</form>
<br>

<!-- 🔎 Booking Report -->
<table width="113%">
  <tr>
    <th>Sl No</th>
    <th>Booking Id</th>
    <th>User Name</th>
    <th>From Date Time</th>
    <th>To Date Time</th>
    <th>Plot Details</th>
    <th>Slot Id</th>
    <th>Slot Number</th>
    <th>Vehicle Type</th>
    <th>Slot Price</th>
    <th>Vehicle Number</th>
    <th>Total Price</th>
  </tr>
  <?php
  $i=0;
  $total_profit = 0;

  // ✅ Only confirmed (paid) bookings
  $SelQry = "SELECT * FROM tbl_booking b 
             INNER JOIN tbl_slot s ON s.slot_id=b.slot_id 
             INNER JOIN tbl_plot d ON d.plot_id=s.plot_id 
             INNER JOIN tbl_type t ON t.type_id=d.type_id
             INNER JOIN tbl_user u ON u.user_id=b.user_id
             WHERE b.booking_status='2'"; // <-- Only paid bookings

  if(isset($_POST['btn_filter'])) {
      if(!empty($_POST['sel_type'])) {
          $SelQry .= " AND d.type_id='".$_POST['sel_type']."'";
      }
      if(!empty($_POST['from_date']) && !empty($_POST['to_date'])) {
          $SelQry .= " AND DATE(b.booking_fromdatetime) >= '".$_POST['from_date']."' 
                       AND DATE(b.booking_todatetime) <= '".$_POST['to_date']."'";
      }
      if(!empty($_POST['search'])) {
          $search = $_POST['search'];
          $SelQry .= " AND (u.user_name LIKE '%$search%' 
                         OR b.user_vehicleno LIKE '%$search%' 
                         OR d.plot_details LIKE '%$search%')";
      }
  }

  $SelQry .= " ORDER BY b.booking_id DESC";
  $result = $Con->query($SelQry);

  while($row=$result->fetch_assoc()) {
    $i++;
    $total_profit += $row['booking_amount'];
  ?>
  <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $row['booking_id']; ?></td> 
    <td><?php echo $row['user_name']; ?></td>
    <td><?php echo $row['booking_fromdatetime']; ?></td>
    <td><?php echo $row['booking_todatetime']; ?></td>
    <td><?php echo $row['plot_details']; ?></td>
    <td><?php echo $row['slot_id']; ?></td>
    <td><?php echo $row['slot_no']; ?></td>
    <td><?php echo $row['type_name']; ?></td>
    <td><?php echo $row['slot_price']; ?></td>
    <td><?php echo $row['user_vehicleno']; ?></td>
    <td><?php echo $row['booking_amount'];?></td>
  </tr>
  <?php
  }
  ?>
  <tr class="profit-row">
    <td colspan="10" align="right">Total Profit</td>
    <td colspan="2">₹<?php echo $total_profit; ?></td>
  </tr>
</table>

</body>
</html>
<?php include("Footer.php"); ?>
