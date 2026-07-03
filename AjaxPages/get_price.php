
<?php
include("../Connection/Connection.php");

if(isset($_POST['fromdate']) && isset($_POST['todate']) && isset($_POST['slot'])){
    $fromdate = $_POST['fromdate'];
    $todate   = $_POST['todate'];
    $slot     = $_POST['slot'];

    $from = new DateTime($fromdate);
    $to   = new DateTime($todate);

    if($to <= $from){
        echo 0;
        exit;
    }

    $interval = $from->diff($to);
    $hours = ($interval->days * 24) + $interval->h + ($interval->i / 60);

    $priceQry = "SELECT slot_price FROM tbl_slot WHERE slot_id='$slot'";
    $priceRes = $Con->query($priceQry);
    $priceRow = $priceRes->fetch_assoc();
    $slot_price = $priceRow['slot_price'];

    $amount = ceil($hours) * $slot_price;

    echo $amount;
}
?>
