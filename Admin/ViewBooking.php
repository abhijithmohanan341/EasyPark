<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>ParkingSlot :: ViewBooking</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f7f7f7;
    }
    .container {
        width: 90%;
        margin: 20px auto;
        text-align: center;
    }
    h1 {
        margin: 20px 0;
        color: #007bff;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin: 20px auto;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
        border: 1px solid #888;
        padding: 10px;
        text-align: center;
    }
    th {
        background: #007bff;
        font-weight: bold;
        color: #fff;
    }
</style>
</head>
<body>

<div class="container">
    <h1>BOOKING DETAILS</h1>
    <form method="post">
        <table width="105%">
            <tr>
                <th width="10%">Sl No</th>
                <th width="8%">Booking Id</th>
                <th width="12%">From Date Time</th>
                <th width="10%">To Date Time</th>
                <th width="9%">Plot Details</th>
                <th width="6%">Slot Id</th>
                <th width="10%">Slot Number</th>
                <th width="10%">Vehicle Type</th>
                <th width="8%">Slot Price</th>
                <th width="9%">Total Price</th>
                <th width="12%">Vehicle Number</th>
            </tr>
            <?php
            $i=0;
            // ✅ Show only completed (paid) bookings — booking_status = 2
            $SelQry = "SELECT * FROM tbl_booking p 
                        INNER JOIN tbl_slot s ON s.slot_id=p.slot_id 
                        INNER JOIN tbl_plot d ON d.plot_id=s.plot_id 
                        INNER JOIN tbl_type t ON t.type_id=d.type_id
                        WHERE p.booking_status='2'
                        ORDER BY p.booking_id DESC";

            $result = $Con->query($SelQry);
            while($row=$result->fetch_assoc()) {
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
            <?php } ?>
        </table>
    </form>

    <h1>CANCELLED BOOKINGS</h1>
    <form method="post">
        <table width="105%">
            <tr>
                <th width="10%">Sl No</th>
                <th width="8%">Booking Id</th>
                <th width="12%">From Date Time</th>
                <th width="10%">To Date Time</th>
                <th width="9%">Plot Details</th>
                <th width="6%">Slot Id</th>
                <th width="10%">Slot Number</th>
                <th width="10%">Vehicle Type</th>
                <th width="8%">Slot Price</th>
                <th width="9%">Total Price</th>
                <th width="12%">Vehicle Number</th>
            </tr>
            <?php
            $i=0;
            // ✅ Show only cancelled bookings — booking_status = 3
            $SelQry = "SELECT * FROM tbl_booking p 
                        INNER JOIN tbl_slot s ON s.slot_id = p.slot_id 
                        INNER JOIN tbl_plot d ON d.plot_id = s.plot_id 
                        INNER JOIN tbl_type t ON t.type_id = d.type_id 
                        WHERE p.booking_status = '3'
                        ORDER BY p.booking_id DESC";
            $result = $Con->query($SelQry);
            while($row=$result->fetch_assoc()) {
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
            <?php } ?>
        </table>
    </form>
</div>

</body>
</html>
<?php include("Footer.php"); ?>
