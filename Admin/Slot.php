<?php
include("../Assest/Connection/Connection.php");
include("Header.php");

$slotno="";
$plot="";
$price="";
$eid=0;

if(isset($_POST['btn_submit']))
{
    $slotno = $_POST['txt_slotno'];
    $plot   = $_POST['sel_plot'];
    $price  = $_POST['txt_price'];
    $eid    = $_POST['txt_eid'];

    if($eid==0){
        $insQry = "INSERT INTO tbl_slot(slot_no,slot_price,plot_id) VALUES ('".$slotno."','".$price."','".$plot."')";
        if($Con->query($insQry))
        {
            ?>
            <script>
                alert("Values Inserted");
                window.location="Slot.php";
            </script>
            <?php
        }
    } else {
        $upQry = "UPDATE tbl_slot SET slot_no='".$slotno."', slot_price='".$price."', plot_id='".$plot."' WHERE slot_id='".$eid."'";
        if($Con->query($upQry))
        {
            ?>
            <script>
                alert("Value Updated");
                window.location="Slot.php";
            </script>
            <?php
        }
    }
}

if(isset($_GET['did']))
{
    $delQry = "DELETE FROM tbl_slot WHERE slot_id=".$_GET['did'];
    if($Con->query($delQry))
    {
        ?>
        <script>
            alert("Value Deleted.");
            window.location="Slot.php";
        </script>
        <?php
    }
}

if(isset($_GET['eid']))
{
    $editSel="SELECT * FROM tbl_slot WHERE slot_id='".$_GET['eid']."'";
    $editResult=$Con->query($editSel);
    $editRow=$editResult->fetch_assoc();
    $slotno=$editRow['slot_no'];
    $plot=$editRow['plot_id'];
    $price=$editRow['slot_price'];
    $eid=$editRow['slot_id'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::Slot</title>

<style>
body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: #f9f9f9;
    color: #333;
}
h2 {
    margin-bottom: 15px;
    color: #007bff;
}

.slot-container {
    max-width: 900px;
    margin: 30px auto;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.form-table, .list-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

.form-table td {
    padding: 10px;
    font-size: 14px;
}

.form-table input, 
.form-table select {
    width: 95%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.form-table input[type="submit"] {
    background: #007bff;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    border: none;
    transition: 0.3s;
}

.list-table th, .list-table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

.list-table th {
    background: #007bff;
    color: #fff;
    font-size: 13px;
    text-transform: uppercase;
}

.list-table tr:nth-child(even) {
    background: #f8f8f8;
}

.list-table tr:hover {
    background: #eef4ff;
}

/* Action buttons */
.action-btn {
    display: inline-block;
    padding: 6px 12px;
    margin: 2px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
}

.btn-delete {
    background: #e63946;
    color: #fff;
}

.btn-delete:hover {
    background: #c1121f;
}

.btn-edit {
    background: #007bff;
    color: #fff;
}

.btn-edit:hover {
    background: #0056b3;
}
</style>
</head>

<body>
<div class="slot-container">
  <h2 align="center">MANAGE PARKING SLOTS</h2><br>
  <form id="form1" name="form1" method="post" action="">
    <table class="form-table">
      <tr>
        <td width="30%">Slot Number</td>
        <td>
          <input type="hidden" name="txt_eid" id="txt_eid" value="<?php echo $eid?>" />
          <input type="text" required name="txt_slotno" id="txt_slotno" value="<?php echo $slotno?>" />
        </td>
      </tr>
      <tr>
        <td>Parking Plot</td>
        <td>
          <select name="sel_plot" id="sel_plot" required>
            <option value="">---Select Plot---</option>
            <?php
            $plotSel="SELECT * FROM tbl_plot";
            $disResult=$Con->query($plotSel);
            while($disRow=$disResult->fetch_assoc())
            {
                $selected = ($plot==$disRow['plot_id']) ? "selected" : "";
            ?>
            <option value="<?php echo $disRow['plot_id']?>" <?php echo $selected; ?>>
              <?php echo $disRow['plot_details']?>
            </option>
            <?php
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Slot Price/Hr</td>
        <td><input type="text" required name="txt_price" id="txt_price" value="<?php echo $price?>" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
        </td>
      </tr>
    </table>

    <h2 align="center">SLOT LIST</h2><br>
    <table class="list-table">
      <tr>
        <th>Sl No</th>
        <th>Slot Number</th>
        <th>Plot</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
      <?php
      $i=0;
      $SelQry = "SELECT * FROM tbl_slot p INNER JOIN tbl_plot d ON d.plot_id=p.plot_id";
      $result = $Con->query($SelQry);
      while($row=$result->fetch_assoc())
      {
        $i++;  
      ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $row['slot_no'];?> </td>
        <td><?php echo $row['plot_details'];?> </td>
        <td><?php echo $row['slot_price'];?> </td>
        <td>
          <a href="Slot.php?did=<?php echo $row['slot_id']?>" class="action-btn btn-delete">Delete</a>
          <a href="Slot.php?eid=<?php echo $row['slot_id']?>" class="action-btn btn-edit">Edit</a>
        </td>
      </tr>
      <?php
      }
      ?>
    </table>
  </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
