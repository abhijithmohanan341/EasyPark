<?php
include("../Assest/Connection/Connection.php");
include("Header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ParkingSlot :: View Complaint</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f7f7f7;
    }
    .container {
        width: 80%;
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
    .btn-reply {
        background: #ea4b12ff;
        color: #fff;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s;
    }
    .btn-reply:hover {
        background: #be6f20ff;
    }
</style>
</head>
<body>
<div class="container">
    <h2>COMPLAINTS</h2>
    <form method="post">
        <table>
            <tr>
                <th>Sl No</th>
                <th>Title</th>
                <th>Content</th>
                <th>Reply</th>
                <th>Action</th>
            </tr>
            <?php
            $i=0;
            $SelQry = "SELECT * FROM tbl_complaint where complaint_status=0 ORDER BY complaint_id DESC";
            $result = $Con->query($SelQry);
            while($row=$result->fetch_assoc()) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['complaint_title']; ?></td>
                <td><?php echo $row['complaint_content']; ?></td>
                <td><?php echo !empty($row['complaint_reply']) ? $row['complaint_reply'] : '<span style="color:red;">Pending</span>'; ?></td>
                <td>
                    <a href="Reply.php?Rid=<?php echo $row['complaint_id']; ?>" class="btn-reply">Reply</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </form>

    <br><br> <h2>REPLIED COMPLAINTS</h2>
    <form method="post">
        <table>
            <tr>
                <th>Sl No</th>
                <th>Title</th>
                <th>Content</th>
                <th>Reply</th>
               
            </tr>
            <?php
            $i=0;
            $SelQry = "SELECT * FROM tbl_complaint where complaint_status=1 ORDER BY complaint_id DESC";
            $result = $Con->query($SelQry);
            while($row=$result->fetch_assoc()) {
                $i++;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $row['complaint_title']; ?></td>
                <td><?php echo $row['complaint_content']; ?></td>
                <td><?php echo $row['complaint_reply']  ?></td>
              
            </tr>
            <?php } ?>
        </table>
    </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
