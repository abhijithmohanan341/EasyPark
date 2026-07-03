<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ParkingSlot :: View Feedback</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f7f7f7;
    }
    .container {
        width: 70%;
        margin: 20px auto;
        text-align: center;
    }
    h2 {
        margin: 20px 0;
        color: #007bff;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }
    th {
        background: #007bff;
        font-weight: bold;
    }
</style>
</head>
<body>
<div class="container">
    <h2>FEEDBACKS</h2>
    <form method="post">
        <table>
            <tr>
                <th>Sl No</th>
                <th>Feedback</th>
            </tr>
            <?php
            $i = 0;
            $SelQry = "SELECT * FROM tbl_feedback ORDER BY feedback_id DESC";
            $result = $Con->query($SelQry);
            while ($row = $result->fetch_assoc()) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['feedback_content']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
