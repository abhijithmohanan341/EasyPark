<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
session_start();

$pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;

if(isset($_POST["btn_submit"]))
{
    $fromdate = $_POST["txt_fromdate"];
    $todate   = $_POST["txt_todate"];
    $slot     = $_POST["sel_slot"];
    $vehicleno= $_POST["txt_vehicleno"];

    $now = new DateTime(); 
    $from = new DateTime($fromdate);
    $to   = new DateTime($todate);

    if($from < $now){
        echo "<script>alert('From Date/Time cannot be in the past!');window.location='Booking.php?pid=".$pid."';</script>";
        exit;
    }

    $maxTo = (clone $from)->modify("+3 months");
    if($to > $maxTo){
        echo "<script>alert('Booking cannot exceed 3 months from start date!');window.location='Booking.php?pid=".$pid."';</script>";
        exit;
    }

    $interval = $from->diff($to);
    $hours = ($interval->days * 24) + $interval->h + ($interval->i / 60);

    $priceQry = "SELECT slot_price FROM tbl_slot WHERE slot_id='$slot'";
    $priceRes = $Con->query($priceQry);
    $priceRow = $priceRes->fetch_assoc();
    $slot_price = $priceRow['slot_price'];

    $amount = ceil($hours) * $slot_price;

    $checkQry = "SELECT * FROM tbl_booking 
                 WHERE slot_id='$slot' 
                 AND (
                     (booking_fromdatetime < '$todate' AND booking_todatetime > '$fromdate')
                 )";
    $res = $Con->query($checkQry);

    if($res->num_rows > 0){
        echo "<script>alert('This slot is already booked for the selected time!');window.location='Booking.php?pid=".$pid."';</script>";
    } else {
        $insQry="INSERT INTO tbl_booking
            (booking_fromdatetime, booking_todatetime, slot_id, user_vehicleno, booking_date, user_id, booking_amount, booking_status)
            VALUES ('$fromdate','$todate','$slot','$vehicleno',curdate(),'".$_SESSION['uid']."','$amount','1')";

        if($Con->query($insQry)){
            $_SESSION['bid'] = $Con->insert_id;
            echo "<script>alert('Booking Successful! Amount: ".$amount."');window.location='Payment.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>ParkingSlot::Booking</title>
<script src="../Assest/JQ/jQuery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>

<style>
body.booking-page {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background: lightskyblue;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}
.booking-container {
    width: 100%;
    max-width: 650px;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    padding: 35px 30px;
}
/* 🔥 Stylish Heading (No underline) */
.booking-container h2,
#slotPopup h2 {
    text-align: center;
    font-size: 32px;
    font-weight: bold;
    margin-bottom: 25px;
    background: linear-gradient(90deg, #3498db, #8e44ad);
    background-clip: text;
    -webkit-text-fill-color: transparent;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.booking-container table { width: 100%; }
.booking-container td { padding: 12px; color: #34495e; }
.booking-container input, .booking-container select {
    width: 100%; padding: 10px; border-radius: 8px;
    border: 1px solid #ccc; font-size: 14px;
}
.buttons-container {
    display: flex; justify-content: center; gap: 15px; margin-top: 25px;
}
input[type="submit"], .back-button {
    background: linear-gradient(135deg,#3498db,#2980b9); color: #fff;
    padding: 12px 22px; border: none; border-radius: 10px;
    cursor: pointer; font-weight: bold; text-decoration: none;
}

/* Slot styles */
.slot { width:120px; padding:10px; margin:5px; text-align:center;
    border-radius:10px; border:2px solid #ddd;
    cursor:pointer; transition:0.3s;
}
.slot.available { background:#2ecc71; color:#fff; border:2px solid #27ae60; }
.slot.booked { background:#e74c3c; color:#fff; cursor:not-allowed; }
.slot.selected { background:#3498db; color:#fff; }
.slot:hover { transform:scale(1.05); }

/* Layout for road rectangle */
.road-container { display:flex; justify-content:center; gap:25px; }
.slot-side { display:flex; flex-direction:column; gap:10px; }

.road-rectangle {
    background: gray;
    border-radius: 12px;
    min-width: 150px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    position: relative;
}
.road-rectangle .top-label {
    font-weight: bold;
    color: #27ae60;
}
.road-rectangle .bottom-label {
    font-weight: bold;
    color: #c0392b;
}
/* Road lines */
.road-lines {
    position: absolute;
    left: 50%;
    top: 40px;
    bottom: 40px;
    transform: translateX(-50%);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.road-line {
    width: 6px;
    height: 25px;
    background: white;
    margin: 10px 0;
}

/* Legend with small color box */
.legend {
    text-align:center;
    margin-bottom:15px;
}
.legend-item {
    display:inline-flex;
    align-items:center;
    margin:0 15px;
    font-weight:bold;
    color:#2c3e50;
}
.legend-box {
    width:18px;
    height:18px;
    border-radius:3px;
    margin-right:6px;
}
.legend-box.booked { background:#e74c3c; }
.legend-box.available { background:#2ecc71; }
</style>
</head>
<body class="booking-page">

<div class="booking-container">
    <h2>BOOK YOUR SLOT</h2>
    <form method="post">
      <table>
        <tr>
          <td>From Date</td>
          <td><input type="datetime-local" required name="txt_fromdate" id="txt_fromdate" onchange="setToDateLimit();getSlot()" min="<?php echo date('Y-m-d\TH:i'); ?>"/></td>
        </tr>
        <tr>
          <td>To Date</td>
          <td><input type="datetime-local" required name="txt_todate" id="txt_todate" onchange="getSlot()" /></td>
        </tr>
        <tr>
          <td>Slot</td>
          <td>
            <input type="hidden" name="sel_slot" id="sel_slot" required>
            <button type="button" onclick="openSlotPopup()" style="padding:8px 15px;background:#200cb8;color:#fff;border:none;border-radius:6px;">Choose Slot</button>
            <span id="slot_display" style="margin-left:10px;font-weight:bold;color:green;"></span>
          </td>
        </tr>
        <tr>
          <td>Price</td>
          <td><input type="text" name="txt_price" id="txt_price" readonly /></td>
        </tr>
        <tr>
          <td>Vehicle Number</td>
          <td><input type="text" required name="txt_vehicleno" id="txt_vehicleno"pattern="^[A-Z]{2}[0-9]{1,3}[A-Z]{1,3}[0-9]{1,4}$"
         title="Format:Example: KL17T7504" /></td>
        </tr>
      </table>
      <div class="buttons-container">
        <input type="submit" name="btn_submit" value="Confirm Booking" />
        <a href="ViewPlot.php" class="back-button">Back</a>
      </div>
    </form>
</div>

<!-- Slot Popup -->
<div id="slotPopup" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:1000;justify-content:center;align-items:center;">
  <div style="background:#fff;border-radius:10px;width:90%;max-width:1000px;max-height:90vh;overflow-y:auto;padding:20px;position:relative;">
    <span onclick="closeSlotPopup()" style="position:absolute;top:10px;right:15px;cursor:pointer;font-size:20px;font-weight:bold;">&times;</span>
    <h2>CHOOSE YOUR SLOT</h2><br>
    
    <!-- Legend -->
    <div class="legend">
        <div class="legend-item"><div class="legend-box booked"></div>Booked</div>
        <div class="legend-item"><div class="legend-box available"></div>Available</div>
    </div>

    <div class="road-container">
        <div class="slot-side left"></div>
        
        <div class="road-rectangle">
            <div class="top-label">ENTRY</div>
            <div class="road-lines">
                <div class="road-line"></div>
                <div class="road-line"></div>
                <div class="road-line"></div>
                <div class="road-line"></div>
                <div class="road-line"></div>
            </div>
            <div class="bottom-label">EXIT</div>
        </div>
        
        <div class="slot-side right"></div>
    </div>
  </div>
</div>

<script>
function openSlotPopup(){ document.getElementById("slotPopup").style.display="flex"; getSlot(); }
function closeSlotPopup(){ document.getElementById("slotPopup").style.display="none"; }
function chooseSlot(id,no,price){
    document.getElementById("sel_slot").value = id;
    document.getElementById("slot_display").innerText = "Selected: S"+no+" (₹"+price+"/hr)";
    calculatePrice(); closeSlotPopup();
}
function getSlot(){
    var fdate=$("#txt_fromdate").val(), tdate=$("#txt_todate").val(), pid="<?php echo $pid;?>";
    if(fdate && tdate){
        $.get("../Assest/AjaxPages/AjaxSlot.php",{fdate:fdate,tdate:tdate,pid:pid},function(data){
            let half=Math.ceil(data.length/2), leftHtml="", rightHtml="";
            data.forEach(function(slot,i){
                let cls = (slot.booked === "booked") ? "booked" : "available";
                let evt = (slot.booked === "") ? 
                    `onclick="chooseSlot('${slot.id}','${slot.no}','${slot.price}')"` : "";
                let html = `<div class="slot ${cls}" ${evt}><i class="fa-solid fa-car"></i> S${slot.no}<br>₹${slot.price}/hr</div>`;
                if(i<half){ leftHtml+=html; } else { rightHtml+=html; }
            });
            $(".slot-side.left").html(leftHtml); $(".slot-side.right").html(rightHtml);
        },"json");
    }
}
function calculatePrice(){
    let from=$("#txt_fromdate").val(), to=$("#txt_todate").val(), slot=$("#sel_slot").val();
    if(from && to && slot){
        $.post("../Assest/AjaxPages/get_price.php",{fromdate:from,todate:to,slot:slot},function(data){
            $("#txt_price").val(data);
        });
    }
}
function setToDateLimit(){
    let from=$("#txt_fromdate").val(); if(from){
        let f=new Date(from), max=new Date(f); max.setMonth(max.getMonth()+3);
        $("#txt_todate").attr("min",from).attr("max",max.toISOString().slice(0,16));
    }
}
</script>

</body>
</html>

<?php include("Footer.php"); ?>
