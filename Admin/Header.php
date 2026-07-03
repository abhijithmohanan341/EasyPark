<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>EasyPark Admin</title>
    <link rel="stylesheet" href="../Assest/Templates/Admin/assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="../Assest/Templates/Admin/assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="../Assest/Templates/Admin/assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="../Assest/Templates/Admin/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../Assest/Templates/Admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="../Assest/Templates/Admin/assets/css/style.css" />
    <link rel="shortcut icon" href="../Assest/Templates/Admin/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div style="display: flex;justify-content: center;margin-top: 20px;color:blueviolet;font-family: Georgia, 'Times New Roman', Times, serif;">
          
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
             
              <div class="nav-profile-text d-flex flex-column pr-3">
               <span class="font-weight-medium mb-2" style="color: indigo; width:200px !important;"> <h2>  EasyPark</h2></span>
                <!-- <span class="font-weight-normal">$8,753.00</span> -->
              </div>
              <!-- <span class="badge badge-danger text-white ml-3 rounded">3</span> -->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="HomePage.php">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
         
          <!-- <li class="nav-item">
            <a class="nav-link" href="AdminRegistration.php">
              <i class="mdi mdi-contacts menu-icon"></i>
              <span class="menu-title">Admin Registration</span>
            </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="ViewUsers.php">
              <i class="mdi mdi-account-multiple-outline menu-icon"></i>
              <span class="menu-title">View User</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ParkingPlot.php">
              <i class="mdi mdi-map-marker-plus menu-icon"></i>
              <span class="menu-title"> Add Plots</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Slot.php">
              <i class="mdi mdi-car-parking-lights menu-icon"></i>
              <span class="menu-title">Add Slot</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Type.php">
              <i class="mdi mdi-car menu-icon"></i>
              <span class="menu-title">Add Type</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ViewBooking.php">
              <i class="mdi mdi-calendar-text menu-icon"></i>
              <span class="menu-title">View Booking</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ViewComplaint.php">
              <i class="mdi mdi-message-alert-outline menu-icon"></i>
              <span class="menu-title">Complaints</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ViewFeedback.php">
              <i class="mdi mdi-comment-text-multiple-outline menu-icon"></i>
              <span class="menu-title">Feedback</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ViewBookingReport.php">
              <i class="mdi mdi-file-document-outline menu-icon"></i>
              <span class="menu-title">Report</span>
            </a>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="../Index.php">
              <i class="mdi mdi-logout menu-icon"></i>
              <span class="menu-title">Sign Out</span>
            </a>
          </li>
        </ul>
      </nav>
      
        <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
          <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between"> 
            <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
            <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
              <i class="mdi mdi-menu"></i>
            </button>
            
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>
        <div class="main-panel">
          <div class="content-wrapper pb-0">