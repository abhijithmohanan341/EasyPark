<?php
include("../Assest/Connection/Connection.php");
include("Header.php");

$place = "";
$district = "";
$eid = 0;

// Insert / Update Place
if (isset($_POST['btn_submit'])) {

    $district = $_POST['sel_district'];
    $place = trim($_POST['txt_place']);
    $eid = $_POST['txt_eid'];

    // Duplicate Check (same place in same district)
    $checkQry = "
        SELECT * FROM tbl_place 
        WHERE LOWER(TRIM(place_name)) = LOWER(TRIM('$place'))
        AND district_id = '$district'
        AND place_id != '$eid'
    ";

    $checkResult = $Con->query($checkQry);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('This place is already added in this district'); window.location='Place.php';</script>";
        exit();
    }

    // Insert
    if ($eid == 0) {
        $insQry = "INSERT INTO tbl_place (place_name, district_id) 
                   VALUES ('" . ucwords($place) . "', '$district')";
        if ($Con->query($insQry)) {
            echo "<script>alert('Place Inserted'); window.location='Place.php';</script>";
        }
    }
    // Update
    else {
        $upQry = "UPDATE tbl_place SET 
                     place_name='" . ucwords($place) . "', 
                     district_id='$district' 
                  WHERE place_id='$eid'";
        if ($Con->query($upQry)) {
            echo "<script>alert('Place Updated'); window.location='Place.php';</script>";
        }
    }
}

// Delete Place
if (isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_place WHERE place_id=" . $_GET['did'];
    if ($Con->query($delQry)) {
        echo "<script>alert('Place Deleted'); window.location='Place.php';</script>";
    }
}

// Edit Place
if (isset($_GET['eid'])) {
    $editSel = "SELECT * FROM tbl_place WHERE place_id='" . $_GET['eid'] . "'";
    $editResult = $Con->query($editSel);
    $editRow = $editResult->fetch_assoc();
    $place = $editRow['place_name'];
    $district = $editRow['district_id'];
    $eid = $editRow['place_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Place</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        .container { width: 70%; margin: 30px auto; }
        h2 {
            margin-bottom: 15px;
            color: #007bff;
        }
        table { border-collapse: collapse; width: 100%; margin: 20px auto; background: white; box-shadow: 0px 2px 6px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #f4f4f4; }
        select, input[type="text"] { width: 95%; padding: 6px; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
        input[type="submit"]:hover { background: #0056b3; }
        .btn-delete { background: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-delete:hover { background: #c0392b; }
        .btn-edit { background: #27ae60; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; }
        .btn-edit:hover { background: #1e8449; }
    </style>
</head>
<body>

<div class="container">
    <h2 align="center">MANAGE PLACES</h2><br>

    <form method="post" action="">
        <table>
            <tr>
                <td><b>District</b></td>
                <td>
                    <input type="hidden" name="txt_eid" value="<?php echo $eid; ?>" />
                    <select name="sel_district" required>
                        <option value="">--- Select District ---</option>
                        <?php
                        $districtSel = "SELECT * FROM tbl_district ORDER BY district_name ASC";
                        $disResult = $Con->query($districtSel);
                        while ($disRow = $disResult->fetch_assoc()) {
                            $selected = ($district == $disRow['district_id']) ? "selected" : "";
                            echo "<option value='" . $disRow['district_id'] . "' $selected>" . $disRow['district_name'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Place</b></td>
                <td><input type="text" name="txt_place" required value="<?php echo $place; ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="btn_submit" value="Submit" /></td>
            </tr>
        </table>
    </form>

    <h3 style="text-align:center;">EXISTING PLACES</h3>
    <table>
        <tr>
            <th>Sl No</th>
            <th>District</th>
            <th>Place</th>
            <th>Action</th>
        </tr>
        <?php
        $i = 0;
        $SelQry = "
            SELECT * 
            FROM tbl_place p 
            INNER JOIN tbl_district d ON d.district_id = p.district_id
            ORDER BY d.district_name, p.place_name
        ";
        $result = $Con->query($SelQry);
        while ($row = $result->fetch_assoc()) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['district_name']; ?></td>
                <td><?php echo $row['place_name']; ?></td>
                <td>
                    <a class="btn-delete" href="Place.php?did=<?php echo $row['place_id']; ?>" onclick="return confirm('Delete this place?');">Delete</a>
                    <a class="btn-edit" href="Place.php?eid=<?php echo $row['place_id']; ?>">Edit</a>
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
