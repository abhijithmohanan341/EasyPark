<?php
include("../Assest/Connection/Connection.php");
session_start();

if(isset($_POST["btn_login"]))
{
    $email = $_POST["txt_email"];
    $password = $_POST["txt_pswd"];
    
    // Check User Table
    $selUser = "select * from tbl_user where user_email='".$email."' and user_password='".$password."'";
    $resultUser = $Con->query($selUser);

    // Check Admin Table
    $selAdmin = "select * from tbl_admin where admin_email='".$email."' and admin_password='".$password."'";
    $resultAdmin = $Con->query($selAdmin);

    if($userData = $resultUser->fetch_assoc())
    {
        $_SESSION['uid'] = $userData['user_id'];  
        $_SESSION['uname'] = $userData['user_name'];
        header("location:../User/HomePage.php");
    }
    else if($adminData = $resultAdmin->fetch_assoc())
    {
        $_SESSION['aid'] = $adminData['admin_id'];
        $_SESSION['aname'] = $adminData['admin_name'];
        header("location:../Admin/HomePage.php");
    }
    else
    {
        echo "<script>alert('Invalid Login Credentials'); window.location='Login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyPark | Secure Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-navy: #0d47a1;
            --primary-navy-dark: #0a3a82;
            --primary-gold: #15b0a5;
            --bg-canvas: #fdfbf6;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #E2E8F0;
            --input-focus: rgba(13, 71, 161, 0.1);
        }

        /* Entry Animations */
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-canvas);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-main);
            padding: 1rem;
        }

        .login-landscape-card {
            display: flex;
            flex-direction: row;
            background: var(--card-bg);
            border-radius: 1.25rem;
            box-shadow: 0 15px 35px rgba(13, 71, 161, 0.1);
            width: 100%;
            max-width: 850px;
            min-height: 460px;
            overflow: hidden;
            border: 1px solid rgba(198, 148, 63, 0.2);
            animation: slideUpFade 0.6s ease-out;
        }

        /* Left Panel - Brand Section */
        .brand-panel {
            flex: 1;
            background: var(--primary-navy);
            color: white;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: left;
        }

        .brand-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 0.5rem 0;
            letter-spacing: 3px;
            text-transform: uppercase;
            animation: slideRight 0.5s ease-out forwards;
        }

        .brand-header h1 span {
            color: var(--primary-gold);
        }

        .brand-header p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0;
            font-weight: 500;
            animation: slideRight 0.5s ease-out 0.1s forwards;
            opacity: 0;
        }

        .register-prompt {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideUpFade 0.5s ease-out 0.3s forwards;
            opacity: 0;
        }

        .register-prompt p {
            font-size: 0.9rem;
            margin-bottom: 1.2rem;
            font-weight: 600;
        }

        .btn-ghost {
            display: inline-block;
            width: 100%;
            padding: 0.85rem;
            background: transparent;
            color: var(--primary-gold);
            border: 2px solid var(--primary-gold);
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-sizing: border-box;
        }

        .btn-ghost:hover {
            background: var(--primary-gold);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* Right Panel - Form Section */
        .form-panel {
            flex: 1.2;
            padding: 3.5rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #ffffff;
        }

        .form-title {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary-gold);
            margin-bottom: 2rem;
            animation: slideUpFade 0.5s ease-out 0.2s forwards;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .form-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            margin-bottom: 1.5rem;
            animation: slideUpFade 0.5s ease-out 0.4s forwards;
            opacity: 0;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 1.5px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 1rem;
            font-family: inherit;
            color: var(--text-main);
            box-sizing: border-box;
            transition: all 0.3s ease;
            background-color: #fcfcfc;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 4px var(--input-focus);
            background-color: #ffffff;
        }

        .form-actions {
            margin-top: 1.5rem;
            animation: slideUpFade 0.5s ease-out 0.5s forwards;
            opacity: 0;
        }

        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: var(--primary-navy);
            color: #ffffff;
            border: none;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            background: var(--primary-navy-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(13, 71, 161, 0.2);
        }

        @media (max-width: 768px) {
            .login-landscape-card {
                flex-direction: column;
                max-width: 450px;
            }
            .brand-panel { padding: 2.5rem 2rem; text-align: center; }
            .form-panel { padding: 2.5rem 2rem; }
        }
    </style>
</head>
<body>

    <div class="login-landscape-card">
        <div class="brand-panel">
            <div class="brand-header">
                <h1>Easy<span>Park</span></h1>
                <p>Welcome back! Securely log in to manage your parking slots and profile dashboard.</p>
            </div>

            <div class="register-prompt">
                <p>New to EasyPark?</p>
                <a href="UserRegistration.php" class="btn-ghost">Create Account</a>
            </div>
        </div>

        <div class="form-panel">
            <div class="form-title">Member Login</div>

            <form action="" method="post">
                <div class="input-wrapper">
                    <label class="form-label" for="txt_email">
                        <i class="fa-solid fa-envelope"></i> Email Address
                    </label>
                    <input type="email" name="txt_email" class="form-input" id="txt_email" required
                        placeholder="name@example.com">
                </div>

                <div class="input-wrapper">
                    <label class="form-label" for="txt_pswd">
                        <i class="fa-solid fa-lock"></i> Password
                    </label>
                    <input type="password" name="txt_pswd" class="form-input" id="txt_pswd" required
                        placeholder="••••••••">
                </div>

                <div class="form-actions">
                    <button type="submit" name="btn_login" class="btn-primary">
                        Sign In <i class="fa-solid fa-right-to-bracket"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>