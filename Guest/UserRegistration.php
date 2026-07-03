<?php
include("../Assest/Connection/Connection.php");

if(isset($_POST["btn_submit"]))
{
    $name     = $_POST["txt_name"];
    $email    = $_POST["txt_email"];
    $contact  = $_POST["txt_contact"];
    $address  = $_POST["txt_address"];
    $password = $_POST["txt_pswd"];
    $place    = $_POST['sel_place'];
    
    $photo    = $_FILES['file_photo']['name'];
    $temp     = $_FILES['file_photo']['tmp_name'];
    move_uploaded_file($temp,'../Assets/Files/User/Photo/'.$photo);

    // Server-side check for existing data
    $seleemail = "SELECT * FROM tbl_user WHERE user_email='".$email."'";
    $resemail   = $Con->query($seleemail);

    $selecontact = "SELECT * FROM tbl_user WHERE user_contact='".$contact."'";
    $rescontact   = $Con->query($selecontact);

    if($resemail->num_rows > 0) {
        echo "<script>alert('Email Already Exists'); window.location='UserRegistration.php';</script>";
    } elseif($rescontact->num_rows > 0) {
        echo "<script>alert('Contact Number Already Exists'); window.location='UserRegistration.php';</script>";
    } else {
        $insQry="INSERT INTO tbl_user(user_name,user_email,user_contact,user_address,user_photo,user_password,place_id,user_doj)
                 VALUES ('$name','$email','$contact','$address','$photo','$password','$place',CURDATE())";
        if($Con->query($insQry)) {
            echo "<script>alert('User registered successfully'); window.location='Login.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyPark | User Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-navy: #0d47a1;
            --primary-gold: #c6943f;
            --bg-canvas: #fdfbf6;
            --card-white: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --error-red: #dc2626;
            --border-subtle: rgba(0,0,0,0.06);
            --input-focus: rgba(13, 71, 161, 0.1);
        }

        @keyframes springReveal {
            0% { opacity: 0; transform: scale(0.95) translateY(20px); }
            70% { transform: scale(1.01) translateY(-2px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        @keyframes staggerFade {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        body {
            background: linear-gradient(135deg, #f0f4f8 0%, #ffffff 100%);
            background-attachment: fixed;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-main);
            padding: 1.5rem;
        }

        .registration-card {
            background: var(--card-white);
            width: 100%;
            max-width: 580px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(13, 71, 161, 0.08);
            border: 1px solid var(--border-subtle);
            overflow: hidden;
            animation: springReveal 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .card-header {
            background: var(--primary-navy);
            padding: 1.2rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .back-btn-header {
            position: absolute; left: 20px; top: 50%; transform: translateY(-50%);
            color: white; cursor: pointer; opacity: 0.6; transition: 0.2s;
        }
        .back-btn-header:hover { opacity: 1; transform: translateY(-50%) translateX(-3px); }

        .card-header h2 {
            margin: 0; font-size: 1.1rem; letter-spacing: 4px; font-weight: 800; text-transform: uppercase;
        }

        .sub-header-bar {
            background: #f8fafc; padding: 8px; text-align: center; border-bottom: 1px solid var(--border-subtle);
        }

        .sub-header-bar span {
            font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px;
            color: var(--primary-gold); font-weight: 800;
        }

        .form-content { padding: 1.5rem 2rem; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .full-row { grid-column: span 2; }

        .section-tag {
            grid-column: span 2; font-size: 0.6rem; font-weight: 800; color: var(--primary-gold);
            text-transform: uppercase; letter-spacing: 1px; margin-top: 0.5rem;
            display: flex; align-items: center; gap: 8px;
        }
        .section-tag::after { content: ""; height: 1px; flex-grow: 1; background: var(--border-subtle); }

        .form-group { display: flex; flex-direction: column; gap: 4px; animation: staggerFade 0.5s ease-out forwards; }

        .form-group label {
            font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;
        }

        .custom-input, .custom-select, .custom-textarea {
            width: 100%; padding: 0.75rem; border: 1px solid var(--border-subtle);
            border-radius: 8px; background: #fafafa; font-family: inherit;
            font-size: 0.85rem; transition: 0.2s; box-sizing: border-box;
        }

        .custom-input:focus, .custom-select:focus, .custom-textarea:focus {
            outline: none; border-color: var(--primary-gold); background: #fff;
            box-shadow: 0 0 0 3px var(--input-focus);
        }

        #email-error {
            font-size: 0.65rem; color: var(--error-red); font-weight: 700;
            margin-top: 2px; display: none;
        }

        .custom-textarea { height: 70px; resize: none; }

        .action-row { display: flex; gap: 12px; margin-top: 1.5rem; }

        .btn-base {
            padding: 0.85rem; border-radius: 8px; font-size: 0.8rem; font-weight: 700;
            text-transform: uppercase; cursor: pointer; display: flex;
            justify-content: center; align-items: center; gap: 8px; border: none; transition: 0.2s;
        }

        .btn-submit { flex: 3; background: var(--primary-navy); color: white; }
        .btn-clear { flex: 1; background: #f1f5f9; color: var(--text-muted); }
        .btn-base:hover { filter: brightness(1.1); transform: translateY(-1px); }
        .btn-base:active { transform: scale(0.98); }

        .footer-row {
            text-align: center; margin-top: 1.2rem; padding-top: 1rem;
            border-top: 1px solid var(--border-subtle); font-size: 0.75rem;
        }

        .signin-link { font-weight: 800; color: var(--primary-gold); text-decoration: none; }

        @media (max-width: 500px) {
            .form-grid { grid-template-columns: 1fr; }
            .full-row { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <div class="registration-card">
        <div class="card-header">
            <i class="fa-solid fa-arrow-left back-btn-header" onclick="window.history.back()"></i>
            <h2>EASY<span style="color: var(--primary-gold);">PARK</span></h2>
        </div>
        
        <div class="sub-header-bar">
            <span>User Registration Portal</span>
        </div>

        <div class="form-content">
            <form action="" method="post" id="registrationForm" enctype="multipart/form-data">
                <div class="form-grid">
                    
                    <div class="section-tag">Personal Details</div>
                    
                    <div class="form-group">
                        <label><i class="fa-solid fa-user"></i> Full Name</label>
                        <input type="text" name="txt_name" class="custom-input" required 
                               placeholder="John Doe" pattern="^[A-Z]+[a-zA-Z ]*$" title="First letter must be capital">
                    </div>

                    <div class="form-group">
                        <label><i class="fa-solid fa-phone"></i> Contact</label>
                        <input type="text" name="txt_contact" class="custom-input" required 
                               placeholder="10-digit number" maxlength="10" pattern="[7-9]{1}[0-9]{9}" title="Phone number must be exactly 10 digits starting with 7-9">
                    </div>

                    <div class="form-group full-row">
                        <label><i class="fa-solid fa-envelope"></i> Email Address</label>
                        <input type="email" name="txt_email" id="txt_email" class="custom-input" required placeholder="john@example.com">
                        <span id="email-error"><i class="fa-solid fa-triangle-exclamation"></i> This email is already registered!</span>
                    </div>

                    <div class="form-group full-row">
                        <label><i class="fa-solid fa-map-location-dot"></i> Residential Address</label>
                        <textarea name="txt_address" class="custom-textarea" required placeholder="Enter your full address..."></textarea>
                    </div>

                    <div class="section-tag">Location & Security</div>

                    <div class="form-group">
                        <label>District</label>
                        <select name="sel_district" id="sel_district" class="custom-select" onChange="getPlace(this.value)" required>
                            <option value="">Select District</option>
                            <?php
                            $districtSel="select * from tbl_district";
                            $disResult=$Con->query($districtSel);
                            while($disRow=$disResult->fetch_assoc()) {
                                echo "<option value='".$disRow['district_id']."'>".$disRow['district_name']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Place</label>
                        <select name="sel_place" id="sel_place" class="custom-select" required>
                            <option value="">Select Place</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><i class="fa-solid fa-image"></i> Profile Photo</label>
                        <input type="file" name="file_photo" class="custom-input" accept="image/*" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fa-solid fa-lock"></i> Password</label>
                        <input type="password" name="txt_pswd" class="custom-input" required 
                               placeholder="••••••••" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number, uppercase, lowercase letter and 8+ characters">
                    </div>
                </div>

                <div class="action-row">
                    <button type="submit" name="btn_submit" id="btn_submit" class="btn-base btn-submit">
                        <i class="fa-solid fa-circle-check"></i> Register Now
                    </button>
                    <button type="reset" class="btn-base btn-clear">Clear</button>
                </div>

                <div class="footer-row">
                    Already have an account? <a href="Login.php" class="signin-link">Sign In</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Ajax for Place loading
        function getPlace(did) {
            $.ajax({
                url: "../Assest/AjaxPages/AjaxPlace.php?did=" + did,
                success: function (data) {
                    $("#sel_place").html(data);
                }
            });
        }

        // Real-time Email Check
        $("#txt_email").keyup(function () {
            var email = $(this).val();
            if (email !== "") {
                $.ajax({
                    url: "../Assest/AjaxPages/AjaxEmailCheck.php?email=" + email,
                    success: function (data) {
                        // Backend must echo "Exists" if found
                        if (data.trim() === "Exists") {
                            $("#email-error").fadeIn();
                            $("#txt_email").css("border-color", "var(--error-red)");
                            $("#btn_submit").prop("disabled", true).css("opacity", "0.6");
                        } else {
                            $("#email-error").fadeOut();
                            $("#txt_email").css("border-color", "var(--border-subtle)");
                            $("#btn_submit").prop("disabled", false).css("opacity", "1");
                        }
                    }
                });
            } else {
                $("#email-error").fadeOut();
                $("#txt_email").css("border-color", "var(--border-subtle)");
            }
        });
    </script>
</body>
</html>