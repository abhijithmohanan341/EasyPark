<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();

$userId = $_SESSION['uid'];
$bookingId = $_GET['bid'];

// Fetch booking
$selBooking = "SELECT b.*, s.slot_no, s.slot_price, p.plot_details, u.user_name, u.user_contact,u.user_email
               FROM tbl_booking b
               INNER JOIN tbl_slot s ON b.slot_id=s.slot_id
               INNER JOIN tbl_plot p ON s.plot_id=p.plot_id
               INNER JOIN tbl_user u ON b.user_id=u.user_id
               WHERE b.booking_id='$bookingId' AND b.user_id='$userId'";
$resBooking = $Con->query($selBooking);
$booking = $resBooking->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EasyPark | Booking Receipt</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: lightskyblue;
    margin: 0; padding: 30px;
}
.receipt-container {
    max-width: 850px;
    margin: auto;
    background: #fff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    border-top: 6px solid #007bff;
}
.header {
    display: flex; justify-content: space-between; align-items: center;
    border-bottom: 2px solid #ddd;
    padding-bottom: 12px;
    margin-bottom: 25px;
}
.logo {
    font-size: 28px; font-weight: 700; color: #007bff;
    display: flex; align-items: center;
}
.logo i { margin-right: 10px; }
.booking-id {
    font-size: 15px; font-weight: 600; color: #444;
}
h3.section-title {
    margin: 20px 0 10px;
    color: #007bff;
    font-size: 18px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 5px;
}
.details-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.details-table th, .details-table td {
    border: 1px solid #ddd;
    padding: 10px 12px;
    text-align: left;
    font-size: 14px;
}
.details-table th {
    background: #f1f6fc;
    color: #333;
    width: 30%;
}
.amount-box {
    margin: 25px 0;
    padding: 15px;
    border: 2px dashed #28a745;
    background: #eafff0;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    color: #28a745;
    border-radius: 10px;
}
.footer {
    text-align: center;
    margin-top: 30px;
    font-size: 14px;
    color: #555;
    border-top: 1px solid #ddd;
    padding-top: 15px;
}
.action-buttons {
    text-align: center;
    margin-top: 25px;
}
button {
    padding: 12px 25px;
    margin: 6px;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}
button i { margin-right: 6px; }
button:first-child {
    background: #007bff; color: #fff;
}
button:first-child:hover {
    background: #0056b3;
}
button:last-child {
    background: #6c757d; color: #fff;
}
button:last-child:hover {
    background: #5a6268;
}
</style>
</head>
<body>
<div class="receipt-container">
    <div class="header">
        <div class="logo"><i class="fas fa-parking"></i> EasyPark</div>
        <div class="booking-id"><b></b>Booking Receipt : <?php echo $bookingId; ?></b></b></div>
    </div>

    <h1 class="section-title">Booking Receipt</h1><br><br>
    <table class="details-table">
         <th>Booked By</th>
            <td><?php echo $booking['user_name']; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo $booking['user_email']; ?></td>
        </tr>
         <tr>
            <th>Contact Number</th>
            <td><?php echo $booking['user_contact']; ?></td>
        </tr>
        <tr>
            <th>Plot</th>
            <td><?php echo $booking['plot_details']; ?></td>
        </tr>
        <tr>
            <th>Slot</th>
            <td>Slot <?php echo $booking['slot_no']; ?></td>
        </tr>
         <tr>
            <th>Price</th>
            <td>₹<?php echo $booking['slot_price']; ?>/hr</td>
        </tr>
        <tr>
            <th>Booking Date</th>
            <td><?php echo $booking['booking_date']; ?></td>
        </tr>
        <tr>
            <th>From Date</th>
            <td><?php echo $booking['booking_fromdatetime']; ?></td>
        </tr>
        <tr>
            <th>To Date</th>
            <td><?php echo $booking['booking_todatetime']; ?></td>
        </tr>
        <tr>
            <th>Vehicle Number</th>
            <td><?php echo $booking['user_vehicleno']; ?></td>
        </tr>
        <tr>
           
    </table>

    <div class="amount-box">
        Total Amount Paid: ₹<?php echo $booking['booking_amount']; ?>
    </div>

    <!-- Optional QR Code -->
    <!-- <div style="text-align:center; margin-top:20px;">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=EasyParkBooking<?php echo $bookingId; ?>" alt="QR Code">
    </div> -->

    <div class="footer" style="color:white; font-size:16px; text-align:center; height:90px;">
        Thank you for choosing <b>EasyPark</b> 🚗 <br>
        Please arrive on time and park responsibly.
    </div>

    <div class="action-buttons">
        <button onclick="window.print()"><i class="fas fa-print"></i> Print Receipt</button>
        <button onclick="window.location.href='HomePage.php'"><i class="fas fa-home"></i> Back to Home</button>
    </div>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
