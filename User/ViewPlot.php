<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ParkingSlot::ViewPlot</title>

<style>
/* Page background */
body {
  background-color: lightskyblue;
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

/* 🔹 Heading in single color */
.page-heading {
  text-align: center;
  font-size: 32px;
  font-weight: bold;
  margin: 25px 0;
  color: #007bff; /* solid blue */
  text-transform: uppercase;
  letter-spacing: 2px;
}

/* Form container */
.plot-search-form {
  max-width: 500px;
  margin: 30px auto 20px;
  padding: 20px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  text-align: center;
}

/* Dropdown + button */
.plot-search-form select,
.plot-search-form input[type="submit"] {
  padding: 10px;
  margin: 5px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
}
.plot-search-form input[type="submit"] {
  background: #007bff;
  color: #fff;
  cursor: pointer;
  border: none;
}
.plot-search-form input[type="submit"]:hover {
  background: #0056b3;
}

/* Table container */
.plot-table-container {
  max-width: 800px;
  margin: 20px auto;
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Table */
.plot-table {
  width: 100%;
  border-collapse: collapse;
}
.plot-table th, .plot-table td {
  padding: 12px;
  text-align: center;
  border-bottom: 1px solid #eee;
}
.plot-table th {
  background: #007bff;
  color: #fff;
}
.plot-table tr:nth-child(even) {
  background: #f9f9f9;
}

/* Action link */
.plot-table a {
  display: inline-block;
  padding: 6px 12px;
  background: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 6px;
  font-size: 14px;
}
.plot-table a:hover {
  background: #1e7e34;
}
</style>

</head>

<body>
  <!-- Updated Heading -->
  <h2 class="page-heading">CHOOSE YOUR PARKING PLOT</h2>

<form id="form1" name="form1" method="post" action="" class="plot-search-form">
    <label for="sel_type"></label>
    <select name="sel_type" id="sel_type">
        <option value="">---Select Type---</option>
        <?php
        $typeSel="select * from tbl_type";
        $typeResult=$Con->query($typeSel);
        while($typeRow=$typeResult->fetch_assoc())
        {
            ?>
            <option value="<?php echo $typeRow['type_id']?>"
                <?php if(isset($_POST['sel_type']) && $_POST['sel_type']==$typeRow['type_id']) echo "selected"; ?>>
                <?php echo $typeRow['type_name']?>
            </option>
            <?php
        }
        ?>
    </select>
    <input type="submit" name="btn_search" value="Search"/>
</form>

<div class="plot-table-container">
<table class="plot-table">
    <tr>
        <th>SINO</th>
        <th>Type</th>
        <th>Plot Details</th>
        <th>Action</th>
    </tr>
    <?php
    $i=0;
    // Default query
    $SelQry = "select * from tbl_plot p inner join tbl_type d on d.type_id=p.type_id";

    // If search button is clicked & type is selected
    if(isset($_POST['btn_search']) && $_POST['sel_type']!="") {
        $typeid = $_POST['sel_type'];
        $SelQry .= " where p.type_id='$typeid'";
    }

    $result=$Con->query($SelQry);
    if($result->num_rows > 0){
        while($row=$result->fetch_assoc())
        {
            $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row['type_name']?></td>
                <td><?php echo $row['plot_details']?></td>
                <td>
                    <a href="Booking.php?pid=<?php echo $row['plot_id'] ?>">Book Now</a>      
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='4'>No plots found</td></tr>";
    }
    ?>
</table>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
