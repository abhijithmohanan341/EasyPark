<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
$plot="";
$eid=0;
$type="";
if(isset($_POST["btn_submit"]))
{
	$type=$_POST['sel_type'];
	$plot=$_POST["txt_plot"];
	$eid=$_POST['txt_eid'];
	if($eid==0)
	{
		$insQry="insert into tbl_plot (type_id,plot_details) values ('".$type."','".$plot."')";
		if($Con->query($insQry))
		{
			?>
			<script>
			alert("Values Inserted");
			</script>
			<?php
		}
	}
	else
	{
		$upQry="update tbl_plot set type_id='".$type."', plot_details='".$plot."' where plot_id='".$eid."'";
		if($Con->query($upQry))
		{
			?>
			<script>
			alert("Value updated");
			window.location="ParkingPlot.php";
			</script>
			<?php
		}
	}
}

if(isset($_GET['did']))
{
	$delQry="delete from tbl_plot where plot_id=".$_GET['did'];
	if($Con->query($delQry))
	{
		?>
		<script>
		alert("value Deleted.");
		window.location="ParkingPlot.php";
		</script>
		<?php
	}
}

if(isset($_GET['eid']))
{
	$editSel="select * from tbl_plot where plot_id='".$_GET['eid']."'";
	$editResult=$Con->query($editSel);
	$editRow=$editResult->fetch_assoc();
	$plot=$editRow['plot_details'];
	$eid=$editRow['plot_id'];
	$type=$editRow['type_id'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::ParkingPlot</title>

<style>
.parking-plot-wrapper {
    max-width: 900px;
    margin: 10px auto; /* Reduced margin to move up */
    font-family: "Segoe UI", Arial, sans-serif;
    color: #333;
}

.plot-form {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.plot-form h2 {
    margin-bottom: 15px;
    color: #007bff;
}

.plot-form table {
    width: 100%;
    border-collapse: collapse;
}

.plot-form td {
    padding: 10px;
    font-size: 14px;
}

.plot-form select,
.plot-form textarea {
    width: 95%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    transition: 0.3s;
}

.plot-form select:focus,
.plot-form textarea:focus {
    border-color: #007bff;
    outline: none;
}

.plot-form input[type="submit"] {
    background: #007bff;
    color: #fff;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

.plot-form input[type="submit"]:hover {
    background: #0056b3;
}

.plot-list {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.plot-list h2 {
    margin-bottom: 15px;
    color: #007bff;
}

.plot-list table {
    width: 100%;
    border-collapse: collapse;
}

.plot-list th, 
.plot-list td {
    padding: 12px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}

.plot-list th {
    background: #007bff;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
}

.plot-list tr:hover {
    background: #f1f1f1;
}

.plot-list .action-btn {
    display: inline-block;
    padding: 6px 14px;
    margin: 2px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
}

.plot-list .btn-delete {
    background: #e63946;
    color: #fff;
    border: none;
}

.plot-list .btn-delete:hover {
    background: #c1121f;
}

.plot-list .btn-edit {
    background: #007bff;
    color: #fff;
    border: none;
}

.plot-list .btn-edit:hover {
    background: #0056b3;
}
</style>
</head>

<body>
<div class="parking-plot-wrapper">
  <form id="form1" name="form1" method="post" action="">
    <div class="plot-form">
      <h2 align="center">ADD PARKING PLOTS</h2><br>
      <table border="0">
        <tr>
          <td>Vehicle Type</td>
          <td>
            <select name="sel_type" id="sel_type" required>
              <option value="">---Select Type---</option>
              <?php
              $typeSel="select * from tbl_type";
              $disResult=$Con->query($typeSel);
              while($disRow=$disResult->fetch_assoc())
              {
                $selected = ($type == $disRow['type_id']) ? "selected" : "";
              ?>
              <option value="<?php echo $disRow['type_id']?>" <?php echo $selected; ?>>
                <?php echo $disRow['type_name']?>
              </option>
              <?php
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Parking Plot Details</td>
          <td>
            <input type="hidden" name="txt_eid" id="txt_eid" value="<?php echo $eid?>" />
            <textarea name="txt_plot" id="txt_plot" cols="45" rows="5" required><?php echo $plot?></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="submit" name="btn_submit" id="btn_submit" value="Submit" />
          </td>
        </tr>
      </table>
    </div>

    <div class="plot-list">
      <h2 align="center">PARKING PLOT LIST</h2><br>
      <table border="0">
        <tr>
          <th>SL NO</th>
          <th>Type Name</th>
          <th>Plot Details</th>
          <th>Action</th>
        </tr>
        <?php
        $i=0;
        $SelQry = "select * from tbl_type p inner join tbl_plot d on d.type_id=p.type_id";
        $result=$Con->query($SelQry);
        while($row=$result->fetch_assoc())
        {
          $i++;
        ?>
        <tr>
          <td><?php echo $i ?></td>
          <td><?php echo $row['type_name']?></td>
          <td><?php echo $row['plot_details']?></td>
          <td>
            <a href="ParkingPlot.php?did=<?php echo $row['plot_id']?>" class="action-btn btn-delete">Delete</a> 
            <a href="ParkingPlot.php?eid=<?php echo $row['plot_id']?>" class="action-btn btn-edit">Edit</a>
          </td>
        </tr>
        <?php
        }
        ?>
      </table>
    </div>
  </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
