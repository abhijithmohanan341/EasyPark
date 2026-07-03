<?php
include("../Assest/Connection/Connection.php");
include("Header.php");

$district = "";
$eid = 0;

// Insert or Update
if (isset($_POST["btn_submit"])) {

    $district = trim($_POST["dist_txt"]); // remove extra spaces
    $eid = $_POST['txt_eid'];

    // Duplicate Check (ignore same record during update)
    $checkQry = "
        SELECT * FROM tbl_district 
        WHERE LOWER(TRIM(district_name)) = LOWER('$district')
        AND district_id != '$eid'
    ";

    $checkResult = $Con->query($checkQry);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('District already added'); window.location='District.php';</script>";
        exit();
    }

    // Insert
    if ($eid == 0) {

        $insQry = "INSERT INTO tbl_district (district_name) VALUES ('$district')";
        if ($Con->query($insQry)) {
            echo "<script>alert('District Inserted'); window.location='District.php';</script>";
        }

    } 
    // Update
    else {

        $upQry = "UPDATE tbl_district SET district_name='$district' WHERE district_id='$eid'";
        if ($Con->query($upQry)) {
            echo "<script>alert('District Updated'); window.location='District.php';</script>";
        }

    }
}

// Delete
if (isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_district WHERE district_id=" . $_GET['did'];
    if ($Con->query($delQry)) {
        echo "<script>alert('District Deleted'); window.location='District.php';</script>";
    }
}

// Edit
if (isset($_GET['eid'])) {
    $editSel = "SELECT * FROM tbl_district WHERE district_id='" . $_GET['eid'] . "'";
    $editResult = $Con->query($editSel);
    $editRow = $editResult->fetch_assoc();
    $district = $editRow['district_name'];
    $eid = $editRow['district_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Districts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
        }
        .container {
            width: 70%;
            margin: 30px auto;
        }
      h2 {
            margin-bottom: 15px;
            color: #007bff;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
            background: white;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #f4f4f4;
        }
        input[type="text"] {
            width: 95%;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .btn-delete {
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .btn-edit {
            background: #27ae60;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 3px;
        }
        .btn-edit:hover {
            background: #1e8449;
        }
    </style>
</head>
<body>

<div class="container">
       <h2 align="center">MANAGE DISTRICTS</h2><br>

    <form method="post" action="">
        <table>
            <tr>
                <td style="width: 25%;"><b>District</b></td>
                <td>
                    <input type="hidden" name="txt_eid" value="<?php echo $eid; ?>" />
                    <input type="text" name="dist_txt" required value="<?php echo $district; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="btn_submit" value="Submit" />
                </td>
            </tr>
        </table>
    </form>

    <h3 style="text-align:center;">EXISTING DISTRICTS</h3>
    <table>
        <tr>
            <th>Sl No</th>
            <th>District Name</th>
            <th>Action</th>
        </tr>
        <?php
        $i = 0;
        $SelQry = "SELECT * FROM tbl_district";
        $result = $Con->query($SelQry);
        while ($row = $result->fetch_assoc()) {
            $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['district_name']; ?></td>
                <td>
                    <a class="btn-delete" 
                       href="District.php?did=<?php echo $row['district_id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this district?');">Delete</a>

                    <a class="btn-edit" 
                       href="District.php?eid=<?php echo $row['district_id']; ?>">Edit</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

</body>
</html>
<?php include("Footer.php"); ?>
