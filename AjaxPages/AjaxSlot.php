<?php
include("../Connection/Connection.php");
session_start();

$fdate = $_GET['fdate'];
$tdate = $_GET['tdate'];
$pid   = $_GET['pid'];

$slotSel = "SELECT * FROM tbl_slot WHERE plot_id='$pid'";
$slotResult = $Con->query($slotSel);

$slots = [];
while($slotRow = $slotResult->fetch_assoc()) {
    $slot_id    = $slotRow['slot_id'];
    $slot_no    = $slotRow['slot_no'];
    $slot_price = $slotRow['slot_price'];

    $checkQry = "SELECT * FROM tbl_booking 
                 WHERE slot_id='$slot_id' 
                 AND booking_status != '3'
                 AND (
                     (booking_fromdatetime < '$tdate' AND booking_todatetime > '$fdate')
                 )";
    $res = $Con->query($checkQry);

    $booked = ($res->num_rows > 0) ? "booked" : "";
    $slots[] = [
        "id"    => $slot_id,
        "no"    => $slot_no,
        "price" => $slot_price,
        "booked"=> $booked
    ];
}

header("Content-Type: application/json");
echo json_encode($slots);
?>
