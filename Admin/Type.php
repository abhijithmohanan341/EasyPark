<?php
include("../Assest/Connection/Connection.php");
include("Header.php");

// Insert Type with Duplicate Check
if (isset($_POST["btn_submit"])) {

    $type = trim($_POST["txt_type"]);

    // Duplicate check
    $checkQry = "
        SELECT * FROM tbl_type 
        WHERE LOWER(TRIM(type_name)) = LOWER(TRIM('$type'))
    ";

    $checkResult = $Con->query($checkQry);

    if ($checkResult->num_rows > 0) {
        ?>
        <script>
            alert("This type is already added");
            window.location = "Type.php";
        </script>
        <?php
        exit();
    }

    // Insert
    $insQry = "INSERT INTO tbl_type(type_name) VALUES ('" . ucwords($type) . "')";
    if ($Con->query($insQry)) {
        ?>
        <script>
            alert("Type Inserted Successfully");
            window.location = "Type.php";
        </script>
        <?php
    }
}

// Delete Type
if (isset($_GET['did'])) {
    $delQry = "DELETE FROM tbl_type WHERE type_id=" . $_GET['did'];
    if ($Con->query($delQry)) {
        ?>
        <script>
            alert("Type Deleted Successfully");
            window.location = "Type.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Parking Slot :: Type</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7ff;
        }
        h2 {
            margin-bottom: 15px;
            color: #007bff;
        }
        .container {
            width: 70%;
            margin: 30px auto;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #010e1cff;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        .form-table {
            width: 60%;
            margin: 0 auto;
        }
        .form-table input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-submit {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .btn-delete {
            background-color: #c9301fff;
            color: white;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 3px;
            font-size: 14px;
        }
        .btn-delete:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>MANAGE VEHICLE TYPES</h2><br>

    <form method="post" action="">
        <table class="form-table">
            <tr>
                <td style="width: 20%;">Type</td>
                <td style="width: 80%;">
                    <input type="text" required name="txt_type" id="txt_type" />
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" class="btn-submit" name="btn_submit" value="Submit" />
                </td>
            </tr>
        </table>
    </form>

    <br><br><h2>EXISTING TYPES</h2>
    <table>
        <tr>
            <th>Sl No</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <?php
        $i = 0;
        $SelQry = "SELECT * FROM tbl_type ORDER BY type_name ASC";
        $result = $Con->query($SelQry);
        while ($row = $result->fetch_assoc()) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['type_name']; ?></td>
                <td>
                    <a class="btn-delete" 
                       href="Type.php?did=<?php echo $row['type_id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this type?');">
                        Delete
                    </a>
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
