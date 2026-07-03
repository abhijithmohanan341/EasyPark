 <?php
  include("../Assest/Connection/Connection.php");
  session_start();

  $selUser = "select COUNT(*) AS total_user from tbl_user";
  $userRow = $Con->query($selUser);
  $userData = $userRow->fetch_assoc();

  $selplot = "select COUNT(*) AS total_plot from tbl_plot";
  $plotRow = $Con->query($selplot);
  $plotData = $plotRow->fetch_assoc();

  $selslot = "select COUNT(*) AS total_slot from tbl_slot";
  $slotRow = $Con->query($selslot);
  $slotData = $slotRow->fetch_assoc();

  $selbooking = "select COUNT(*) AS total_booking from tbl_booking";
  $bookingRow = $Con->query($selbooking);
  $bookingData = $bookingRow->fetch_assoc();

  $q = "
SELECT p.plot_id,
       p.plot_details,
       COUNT(b.booking_id) AS bookings,
       COALESCE(SUM(b.booking_amount),0) AS revenue
FROM tbl_plot p
LEFT JOIN tbl_slot s ON s.plot_id = p.plot_id
LEFT JOIN tbl_booking b ON b.slot_id = s.slot_id
GROUP BY p.plot_id
ORDER BY p.plot_id
";
  $res = $Con->query($q);
  $data = [];
  while ($row = $res->fetch_assoc()) {
    // shorten/clean plot label from plot_details for display
    $label = $row['plot_details'];
    // get first line or location fragment
    $parts = preg_split("/\r\n|\n/", $label);
    $label = trim($parts[0]);
    if ($label === '') $label = 'Plot ' . $row['plot_id'];

    $data[] = [
      'plot_id' => (int)$row['plot_id'],
      'label'   => $label,
      'bookings' => (int)$row['bookings'],
      'revenue' => (int)$row['revenue']
    ];
  }
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
               <div class="nav-profile-image">
                 <span class="login-status online"></span>
                 <!--change to offline or busy as needed-->
               </div>
               <div class="nav-profile-text d-flex flex-column pr-3">
                 <span class="font-weight-medium mb-2" style="color: indigo; width:200px !important;">
                   <h2> EasyPark</h2>
                 </span>
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
     <div class="container-fluid page-body-wrapper">
       <div id="theme-settings" class="settings-panel">
         <i class="settings-close mdi mdi-close"></i>
         <p class="settings-heading">SIDEBAR SKINS</p>
         <div class="sidebar-bg-options selected" id="sidebar-default-theme">
           <div class="img-ss rounded-circle bg-light border mr-3"></div> Default
         </div>
         <div class="sidebar-bg-options" id="sidebar-dark-theme">
           <div class="img-ss rounded-circle bg-dark border mr-3"></div> Dark
         </div>
         <p class="settings-heading mt-2">HEADER SKINS</p>
         <div class="color-tiles mx-0 px-4">
           <div class="tiles light"></div>
           <div class="tiles dark"></div>
         </div>
       </div>
       <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
         <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
           <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="index.html"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
           <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
             <i class="mdi mdi-menu"></i>
           </button>
           <!-- <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell-outline"></i>
                  <span class="count count-varient1">7</span>
                </a>
                <div class="dropdown-menu navbar-dropdown navbar-dropdown-large preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../Assest/Templates/Admin/assets/images/faces/face4.jpg" alt="" class="profile-pic" />
                    </div>
                    <div class="preview-item-content">
                      <p class="mb-0"> Dany Miles <span class="text-small text-muted">commented on your photo</span>
                      </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../Assest/Templates/Admin/assets/images/faces/face3.jpg" alt="" class="profile-pic" />
                    </div>
                    <div class="preview-item-content">
                      <p class="mb-0"> James <span class="text-small text-muted">posted a photo on your wall</span>
                      </p>
                    </div>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../Assest/Templates/Admin/assets/images/faces/face2.jpg" alt="" class="profile-pic" />
                    </div>
                    <div class="preview-item-content">
                      <p class="mb-0"> Alex <span class="text-small text-muted">just mentioned you in his post</span>
                      </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0">View all activities</p>
                </div>
              </li>
              <li class="nav-item dropdown d-none d-sm-flex">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-email-outline"></i>
                  <span class="count count-varient2">5</span>
                </a>
                <div class="dropdown-menu navbar-dropdown navbar-dropdown-large preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <a class="dropdown-item preview-item">
                    <div class="preview-item-content flex-grow">
                      <span class="badge badge-pill badge-success">Request</span>
                      <p class="text-small text-muted ellipsis mb-0"> Suport needed for users</p>
                    </div>
                    <p class="text-small text-muted align-self-start"> 4:10 PM </p>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-item-content flex-grow">
                      <span class="badge badge-pill badge-warning">Invoices</span>
                      <p class="text-small text-muted ellipsis mb-0"> Invoice for order is mailed </p>
                    </div>
                    <p class="text-small text-muted align-self-start"> 4:10 PM </p>
                  </a>
                  <a class="dropdown-item preview-item">
                    <div class="preview-item-content flex-grow">
                      <span class="badge badge-pill badge-danger">Projects</span>
                      <p class="text-small text-muted ellipsis mb-0"> Add more slots</p>
                    </div>
                    <p class="text-small text-muted align-self-start"> 4:10 PM </p>
                  </a>
                  <h6 class="p-3 mb-0">See all activity</h6>
                </div>
              </li>
              <li class="nav-item nav-search border-0 ml-1 ml-md-3 ml-lg-5 d-none d-md-flex">
                <form class="nav-link form-inline mt-2 mt-md-0">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" />
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-magnify"></i>
                      </span>
                    </div>
                  </div>
                </form>
              </li>
            </ul>  -->
           <ul class="navbar-nav navbar-nav-right ml-lg-auto">
             <!-- <li class="nav-item dropdown d-none d-xl-flex border-0">
                <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-earth"></i> English </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                  <a class="dropdown-item" href="#"> French </a>
                  <a class="dropdown-item" href="#"> Spain </a>
                  <a class="dropdown-item" href="#"> Latin </a>
                  <a class="dropdown-item" href="#"> Japanese </a>
                </div>
              </li> -->
             <li class="nav-item nav-profile dropdown border-0">
               <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
                 <img class="nav-profile-img mr-2" alt="" src="../Assest/Templates/Admin/assets/images/faces/face5.jpg" />
                 <span class="profile-name"><?php echo $_SESSION["aname"] ?></span>
               </a>
               <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">


                 <a class="dropdown-item" href="../Index.php">
                   <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
               </div>
             </li>
           </ul>
           <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
             <span class="mdi mdi-menu"></span>
           </button>
         </div>
       </nav>



       <div class="main-panel">
         <div class="content-wrapper pb-0">
           <div class="page-header flex-wrap">
             <h3 class="mb-0"> Hi, welcome back!
             </h3>
             <div class="d-flex">
               <!-- <button type="button" class="btn btn-sm bg-white btn-icon-text border">
                  <i class="mdi mdi-email btn-icon-prepend"></i> Email </button>
                <button type="button" class="btn btn-sm bg-white btn-icon-text border ml-3">
                  <i class="mdi mdi-printer btn-icon-prepend"></i> Print </button>
                <button type="button" class="btn btn-sm ml-3 btn-success"> Add User </button> -->
             </div>
           </div>
           <div class="row">
             <!-- Sales -->
             <div class="col-xl-3 col-md-6 stretch-card grid-margin">
               <div class="card bg-warning">
                 <div class="card-body px-3 py-4">
                   <div class="d-flex justify-content-between align-items-start">
                     <div class="color-card">
                       <p class="mb-0 color-card-head">Total Users</p>
                       <h1 class="text-white" align="center"><?php echo $userData['total_user'] ?><span class="h5"></span></h1>
                     </div>
                     <i class="card-icon-indicator mdi mdi-account-multiple bg-inverse-icon-info
"></i>
                   </div>
                   <!-- <h6 class="text-white">18.33% Since last month</h6> -->
                 </div>
               </div>
             </div>

             <!-- Margin -->
             <div class="col-xl-3 col-md-6 stretch-card grid-margin">
               <div class="card bg-danger">
                 <div class="card-body px-3 py-4">
                   <div class="d-flex justify-content-between align-items-start">
                     <div class="color-card">
                       <p class="mb-0 color-card-head">Total Plots</p>
                       <h1 class="text-white" align="center"><?php echo $plotData['total_plot'] ?><span class="h5"></span></h1>
                     </div>
                     <i class="card-icon-indicator mdi mdi-map bg-inverse-icon-success
"></i>
                   </div>
                   <!-- <h6 class="text-white">13.21% Since last month</h6> -->
                 </div>
               </div>
             </div>

             <!-- Orders -->
             <div class="col-xl-3 col-md-6 stretch-card grid-margin">
               <div class="card bg-primary">
                 <div class="card-body px-3 py-4">
                   <div class="d-flex justify-content-between align-items-start">
                     <div class="color-card">
                       <p class="mb-0 color-card-head">Avaliable Slots</p>
                       <h1 class="text-white" align="center"><?php echo $slotData['total_slot'] ?><span class="h5"></span></h1>
                     </div>
                     <i class="card-icon-indicator mdi mdi-car-parking-lights bg-inverse-icon-primary
"></i>
                   </div>
                   <!-- <h6 class="text-white">67.98% Since last month</h6> -->
                 </div>
               </div>
             </div>

             <!-- Affiliate -->
             <div class="col-xl-3 col-md-6 stretch-card grid-margin">
               <div class="card bg-success">
                 <div class="card-body px-3 py-4">
                   <div class="d-flex justify-content-between align-items-start">
                     <div class="color-card">
                       <p class="mb-0 color-card-head">Total Bookings</p>
                       <h1 class="text-white" align="center"><?php echo $bookingData['total_booking'] ?></h1>
                     </div>
                     <i class="card-icon-indicator mdi mdi-calendar-check bg-inverse-icon-danger
"></i>
                   </div>
                   <!-- <h6 class="text-white">20.32% Since last month</h6> -->
                 </div>
               </div>
             </div>
           </div>
           <style>
             #chartWrap {
               position: relative;
               max-width: 1000px;
             }

             canvas {
               width: 100%;
               height: 420px;
               border: 1px solid #ddd;
               background: white;
               display: block;
             }

             #tooltip {
               position: absolute;
               pointer-events: none;
               background: rgba(0, 0, 0, 0.8);
               color: white;
               padding: 6px 8px;
               border-radius: 4px;
               font-size: 13px;
               display: none;
               transform: translate(-50%, -120%);
               white-space: nowrap;
             }

             .legend {
               margin-top: 8px;
               display: flex;
               gap: 16px;
               align-items: center;
             }

             .legend .item {
               display: flex;
               gap: 6px;
               align-items: center;
               font-size: 13px;
             }

             .swatch {
               width: 14px;
               height: 14px;
               border-radius: 3px;
               display: inline-block;
             }
           </style>
           <div class="col-xl-12 stretch-card grid-margin">
             <div class="card">
               <div class="card-body">
                 <div class="row mb-3">
                   <div class="col-sm-8">
                     <h3>Parking Slot Booking Trends</h3>
                     <p class="text-muted">Monthly booking count & revenue</p><br>
                   </div>
                 </div>
                 <div class="row justify-content-center">
                   <!-- <div class="col-md-8 text-center"> -->
                     <!-- <canvas id="bookingTrendChart" height="120"></canvas> -->
                      <div id="chartWrap">
                        <canvas id="chartCanvas" width="1100" height="420"></canvas>
                        <div id="tooltip"></div>
                      </div>
                     <div class="legend">
                       <div class="item"><span class="swatch" style="background:#4caf50"></span>Bookings</div>
                       <div class="item"><span class="swatch" style="background:#2196f3"></span>Revenue</div>
                     </div>
                   </div>

                   
                 </div>
               </div>
             </div>
           <!-- </div> -->

           <!-- Chart.js Script -->
           <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
           <!-- <script>
  const ctx = document.getElementById('bookingTrendChart').getContext('2d');
  const bookingTrendChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      ],
      datasets: [{
        label: 'Bookings',
        data: [50, 70, 60, 90, 85, 120, 150, 100, 80, 95, 110, 130], 
        borderColor: '#007bff',
        backgroundColor: 'rgba(0,123,255,0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.3,
        pointBackgroundColor: '#007bff'
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: true }
      },
      scales: {
        y: {
          beginAtZero: true,
          title: { display: true, text: 'Number of Bookings' }
        },
        x: {
          title: { display: true, text: 'Months (Jan - Dec)' }
        }
      }
    }
  });
</script> -->


           <script>
             // config
             const canvas = document.getElementById('chartCanvas');
             const ctx = canvas.getContext('2d');
             const tooltip = document.getElementById('tooltip');
             const DPR = window.devicePixelRatio || 1;

             // scale canvas for crisp drawing on HiDPI
             function resizeCanvas() {
               const rect = canvas.getBoundingClientRect();
               canvas.width = Math.round(rect.width * DPR);
               canvas.height = Math.round(rect.height * DPR);
               canvas.style.width = rect.width + 'px';
               canvas.style.height = rect.height + 'px';
               ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
             }
             resizeCanvas();
             window.addEventListener('resize', () => {
               resizeCanvas();
               draw();
             });

             // state for hit testing
             let bars = [];

             function loadDataAndDraw() {
               // PHP data directly available here
               const data = <?php echo json_encode($data); ?>;
               const labels = data.map(r => r.label);
               const bookings = data.map(r => r.bookings);
               const revenue = data.map(r => r.revenue);
               drawChart({
                 labels,
                 bookings,
                 revenue
               });
             }


             function drawChart({
               labels,
               bookings,
               revenue
             }) {
               bars = [];
               ctx.clearRect(0, 0, canvas.width, canvas.height);

               // layout
               const padding = {
                 top: 40,
                 right: 50,
                 bottom: 90,
                 left: 60
               };
               const W = canvas.clientWidth;
               const H = canvas.clientHeight;
               const innerW = W - padding.left - padding.right;
               const innerH = H - padding.top - padding.bottom;

               // axes lines
               ctx.strokeStyle = '#e6e6e6';
               ctx.lineWidth = 1;
               ctx.beginPath();
               ctx.moveTo(padding.left, padding.top);
               ctx.lineTo(padding.left, padding.top + innerH);
               ctx.lineTo(padding.left + innerW, padding.top + innerH);
               ctx.stroke();

               // scale for bookings (left axis) and revenue (right axis)
               const maxBookings = Math.max(1, ...bookings);
               const maxRevenue = Math.max(1, ...revenue);

               // determine top ticks nicely
               const bookingsMaxTick = niceMax(maxBookings);
               const revenueMaxTick = niceMax(maxRevenue);

               // draw y-axis ticks and labels (bookings)
               ctx.fillStyle = '#333';
               ctx.font = '12px Arial';
               ctx.textAlign = 'right';
               ctx.textBaseline = 'middle';
               const yTicks = 5;
               for (let i = 0; i <= yTicks; i++) {
                 const t = i / yTicks;
                 const y = padding.top + innerH - t * innerH;
                 const val = Math.round(t * bookingsMaxTick);
                 ctx.fillStyle = '#666';
                 ctx.fillText(val, padding.left - 8, y);
                 // grid line
                 ctx.strokeStyle = '#f2f2f2';
                 ctx.beginPath();
                 ctx.moveTo(padding.left, y);
                 ctx.lineTo(padding.left + innerW, y);
                 ctx.stroke();
               }

               // right axis for revenue
               ctx.textAlign = 'left';
               for (let i = 0; i <= yTicks; i++) {
                 const t = i / yTicks;
                 const y = padding.top + innerH - t * innerH;
                 const val = Math.round(t * revenueMaxTick);
                 ctx.fillStyle = '#666';
                 ctx.fillText('₹' + val, padding.left + innerW + 8, y);
               }

               // bars layout
               const n = labels.length;
               const groupWidth = innerW / Math.max(1, n);
               const barPadding = 0.16 * groupWidth;
               const barWidthBookings = (groupWidth - barPadding) * 0.52;
               const barWidthRevenue = (groupWidth - barPadding) * 0.32;

               // clamp fonts
               ctx.font = '12px Arial';
               ctx.textAlign = 'center';

               // for each label
               labels.forEach((label, i) => {
                 const gx = padding.left + i * groupWidth + groupWidth / 2;
                 const bookingsVal = bookings[i];
                 const revenueVal = revenue[i];

                 // bookings bar (green)
                 const bookingsHeight = (bookingsVal / bookingsMaxTick) * innerH;
                 const bx = gx - (barWidthBookings / 2) - (barWidthRevenue / 2 + 6);
                 const by = padding.top + innerH - bookingsHeight;
                 ctx.fillStyle = '#4caf50'; // bookings
                 roundRectFill(ctx, bx, by, barWidthBookings, bookingsHeight, 3);
                 // revenue bar (blue)
                 const revenueHeight = (revenueVal / revenueMaxTick) * innerH;
                 const rx = gx + (barWidthRevenue / 2) + 6 - barWidthRevenue;
                 const ry = padding.top + innerH - revenueHeight;
                 ctx.fillStyle = '#2196f3';
                 roundRectFill(ctx, rx, ry, barWidthRevenue, revenueHeight, 3);

                 // store hit boxes for tooltip
                 bars.push({
                   x: bx,
                   y: by,
                   w: barWidthBookings,
                   h: bookingsHeight,
                   type: 'bookings',
                   label,
                   value: bookingsVal,
                   index: i
                 });
                 bars.push({
                   x: rx,
                   y: ry,
                   w: barWidthRevenue,
                   h: revenueHeight,
                   type: 'revenue',
                   label,
                   value: revenueVal,
                   index: i
                 });

                 // labels (rotate if needed)
                 const labelY = padding.top + innerH + 18;
                 const text = label.length > 18 ? label.slice(0, 18) + '…' : label;
                 ctx.fillStyle = '#333';
                 ctx.save();
                 ctx.translate(gx, labelY);
                 ctx.rotate(-0.0);
                 ctx.fillText(text, 0, 0);
                 ctx.restore();
               });

               // small axis titles
               ctx.fillStyle = '#444';
               ctx.textAlign = 'left';
               ctx.fillText('Bookings (count)', padding.left, padding.top - 18);
               ctx.textAlign = 'right';
               ctx.fillText('Revenue (₹)', padding.left + innerW, padding.top - 18);
             }

             // helper - draw rounded rect filled
             function roundRectFill(ctx, x, y, w, h, r) {
               if (h <= 0) return;
               ctx.beginPath();
               ctx.moveTo(x + r, y);
               ctx.lineTo(x + w - r, y);
               ctx.quadraticCurveTo(x + w, y, x + w, y + r);
               ctx.lineTo(x + w, y + h);
               ctx.lineTo(x, y + h);
               ctx.lineTo(x, y + r);
               ctx.quadraticCurveTo(x, y, x + r, y);
               ctx.closePath();
               ctx.fill();
             }

             // nice round max for axis
             function niceMax(n) {
               if (n <= 10) return 10;
               const pow = Math.pow(10, Math.floor(Math.log10(n)));
               let norm = n / pow;
               if (norm <= 1) norm = 1;
               else if (norm <= 2) norm = 2;
               else if (norm <= 5) norm = 5;
               else norm = 10;
               return norm * pow;
             }

             // hover handling
             canvas.addEventListener('mousemove', (ev) => {
               const rect = canvas.getBoundingClientRect();
               const x = (ev.clientX - rect.left);
               const y = (ev.clientY - rect.top);
               let found = null;
               for (const b of bars) {
                 if (x >= b.x && x <= b.x + b.w && y >= b.y && y <= b.y + b.h) {
                   found = b;
                   break;
                 }
               }
               if (found) {
                 tooltip.style.display = 'block';
                 tooltip.innerText = `${found.label}\n${found.type === 'bookings' ? 'Bookings: ' : 'Revenue: ₹'}${found.value}`;
                 tooltip.style.left = ev.clientX - rect.left + 'px';
                 tooltip.style.top = ev.clientY - rect.top + 'px';
               } else {
                 tooltip.style.display = 'none';
               }
             });

             canvas.addEventListener('mouseleave', () => tooltip.style.display = 'none');

             // initial draw wrapper
             function draw() {
               // re-load data and draw (keeps things simple for resizing)
               loadDataAndDraw();
             }

             draw();
           </script>

         </div>
         <footer class="footer">
           <div class="d-sm-flex justify-content-center justify-content-sm-between">
             <!-- <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard template</a> from Bootstrapdash.com</span>
            </div> -->
         </footer>
       </div>
       <!-- main-panel ends -->
     </div>
     <!-- page-body-wrapper ends -->
   </div>
   <!-- container-scroller -->
   <!-- plugins:js -->
   <script src="../Assest/Templates/Admin/assets/vendors/js/vendor.bundle.base.js"></script>
   <!-- endinject -->
   <!-- Plugin js for this page -->
   <!-- <script src="../Assest/Templates/Admin/assets/vendors/chart.js/Chart.min.js"></script> -->
   <script src="../Assest/Templates/Admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
   <script src="../Assest/Templates/Admin/assets/vendors/flot/jquery.flot.js"></script>
   <script src="../Assest/Templates/Admin/assets/vendors/flot/jquery.flot.resize.js"></script>
   <script src="../Assest/Templates/Admin/assets/vendors/flot/jquery.flot.categories.js"></script>
   <script src="../Assest/Templates/Admin/assets/vendors/flot/jquery.flot.fillbetween.js"></script>
   <script src="../Assest/Templates/Admin/assets/vendors/flot/jquery.flot.stack.js"></script>
   <script src="../Assest/Templates/Admin/assets/vendors/flot/jquery.flot.pie.js"></script>
   <!-- End plugin js for this page -->
   <!-- inject:js -->
   <!-- <script src="../Assest/Templates/Admin/assets/js/off-canvas.js"></script> -->
   <script src="../Assest/Templates/Admin/assets/js/hoverable-collapse.js"></script>
   <script src="../Assest/Templates/Admin/assets/js/misc.js"></script>
   <!-- endinject -->
   <!-- Custom js for this page -->
   <script src="../Assest/Templates/Admin/assets/js/dashboard.js"></script>
   <!-- End custom js for this page -->
 </body>

 </html>