<?php
include("../Assest/Connection/Connection.php");
include("Header.php");

$Rid = isset($_GET['Rid']) ? intval($_GET['Rid']) : 0;

// Fetch complaint details
$SelQry = "SELECT complaint_title, complaint_content, complaint_reply 
           FROM tbl_complaint 
           WHERE complaint_id = '$Rid'";
$result = $Con->query($SelQry);
$complaint = $result->fetch_assoc();

if (isset($_POST["btn_submit"])) {
    $reply = $_POST["txt_reply"];
    $upQry = "UPDATE tbl_complaint 
              SET complaint_reply='$reply', complaint_status=1 
              WHERE complaint_id='$Rid'";
    if ($Con->query($upQry)) {
        ?>
        <script>
        alert("Reply submitted successfully!");
        window.location="ViewComplaint.php";
        </script>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>ParkingSlot :: Reply</title>
<style>
/* ==== Global Layout ==== */
/* body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    margin: 0;
    padding: 0;
} */

/* ==== Card Container ==== */
.container {
    width: 90%;
    max-width: 700px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

/* ==== Heading ==== */
h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 24px;
    color: #2c3e50;
}

/* ==== Complaint Details ==== */
.details {
    margin-bottom: 20px;
    padding: 12px 15px;
    background: #f7f9fa;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
}
.details p {
    margin: 8px 0;
    font-size: 15px;
    color: #333;
}

/* ==== Form ==== */
form table {
    width: 100%;
}
form td {
    padding: 10px;
    vertical-align: top;
}
textarea {
    width: 100%;
    padding: 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    resize: vertical;
    transition: 0.3s;
    /* removed text-align: center; */
}
textarea:focus {
    border-color: #999;      /* neutral gray */
    box-shadow: none;        /* remove blue glow */
    outline: none;           /* remove blue outline */
}

/* ==== Buttons ==== */
.button-group {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}
.btn {
    padding: 10px 22px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 600;
    transition: transform 0.2s ease, background 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    min-width: 140px;
}

/* Submit button */
.btn-submit {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: #fff;
}
.btn-submit:hover {
    background: linear-gradient(135deg, #2980b9, #2471a3);
    transform: translateY(-2px);
}

/* Back button */
.btn-back {
    background: linear-gradient(135deg, #95a5a6, #7f8c8d);
    color: #fff;
}
.btn-back:hover {
    background: linear-gradient(135deg, #7f8c8d, #636e72);
    transform: translateY(-2px);
}
.btn-back::before {
    /* content: "← "; */
    font-weight: bold;
}

/* ==== Responsive ==== */
@media (max-width: 600px) {
    .container {
        padding: 20px;
    }
    h2 {
        font-size: 20px;
    }
    .button-group {
        flex-direction: column;
        gap: 10px;
    }
    .btn {
        width: 100%;
    }
}
</style>
</head>
<body>
<div class="container">
    <h2>Reply to Complaint</h2>
    
    <div class="details">
        <p><b>Title:</b> <?php echo htmlspecialchars($complaint['complaint_title']); ?></p>
        <p><b>Content:</b> <?php echo htmlspecialchars($complaint['complaint_content']); ?></p>
    </div>

    <form method="post">
        <table>
            <tr>
                <td><b>Reply</b></td>
                <td>
                    <textarea name="txt_reply" id="txt_reply" rows="6" required><?php echo htmlspecialchars($complaint['complaint_reply']); ?></textarea>
                </td>
            </tr>
        </table>
        <div class="button-group">
            <a href="ViewComplaint.php" class="btn btn-back">Back</a>
            <input type="submit" name="btn_submit" class="btn btn-submit" value="Submit Reply" />
        </div>
    </form>
</div>
</body>
</html>
<?php include("Footer.php"); ?>
