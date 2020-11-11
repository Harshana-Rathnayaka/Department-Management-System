<?php
session_start();
if (!isset($_SESSION['UserName'])) {
    $_SESSION['error'] = "Session timed out. Please login to continue.";
    header('location:../signin.php');
} elseif (isset($_SESSION['UserType'])) {
    $usertype = $_SESSION['UserType'];

    if ($usertype == 0) {
        header('location:../admin/index.php');
    } else if ($usertype == 2) {
        header('location:../manager/index.php');
    } else if ($usertype == 3) {
        header('location:../finance/index.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Inventory Management System</title>

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500"
    rel="stylesheet" />
  <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />

  <!-- PLUGINS CSS STYLE -->
  <link href="assets/plugins/toaster/toastr.min.css" rel="stylesheet" />
  <link href="assets/plugins/nprogress/nprogress.css" rel="stylesheet" />
  <link href="assets/plugins/flag-icons/css/flag-icon.min.css" rel="stylesheet" />
  <link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  <link href="assets/plugins/ladda/ladda.min.css" rel="stylesheet" />
  <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />

  <!-- SLEEK CSS -->
  <link id="sleek-css" rel="stylesheet" href="assets/css/sleek.css" />

  <!-- FAVICON -->
  <link href="assets/img/favicon.png" rel="shortcut icon" />

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="assets/plugins/nprogress/nprogress.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>


<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
  <script>
    NProgress.configure({ showSpinner: false });
    NProgress.start();
  </script>

  <div class="mobile-sticky-body-overlay"></div>

  <div class="wrapper">

    <!--
          ====================================
          ——— LEFT SIDEBAR WITH FOOTER
          =====================================
        -->
    <aside class="left-sidebar bg-sidebar">
      <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
          <a href="/index.html">
            <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30"
              height="33" viewBox="0 0 30 33">
              <g fill="none" fill-rule="evenodd">
                <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
              </g>
            </svg>
            <span class="brand-name">Sleek Dashboard</span>
          </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-scrollbar">

          <!-- sidebar menu -->
          <ul class="nav sidebar-inner" id="sidebar-menu">

            <li class="active">
              <a class="sidenav-item-link" href="index.php">
                <i class="mdi mdi-shopping"></i>
                <span class="nav-text">Orders</span>
              </a>
            </li>

            <li>
              <a class="sidenav-item-link" href="settings.php">
                <i class="mdi mdi-settings"></i>
                <span class="nav-text">Settings</span>
              </a>
            </li>

          </ul>

        </div>

        <hr class="separator" />

        <ul class="nav sidebar-inner" id="sidebar-menu">
          <li>
            <a class="sidenav-item-link" href="../logout.php?logout">
              <i class="mdi mdi-exit-to-app"></i>
              <span class="nav-text">Logout</span>
            </a>
          </li>
        </ul>

      </div>
    </aside>


    <div class="page-wrapper">
      <!-- Header -->
      <header class="main-header " id="header">
        <nav class="navbar navbar-static-top navbar-expand-lg">
          <!-- Sidebar toggle button -->
          <button id="sidebar-toggler" class="sidebar-toggle">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <!-- search form -->
          <div class="search-form d-none d-lg-inline-block">
            <div class="input-group">
              <button type="button" name="search" id="search-btn" class="btn btn-flat">
                <i class="mdi mdi-magnify"></i>
              </button>
              <input type="text" name="query" id="search-input" class="form-control"
                placeholder="'departments', 'users', etc." autofocus autocomplete="on" />
            </div>
            <div id="search-results-container">
              <ul id="search-results"></ul>
            </div>
          </div>

          <div class="navbar-right ">
            <ul class="nav navbar-nav">
              <!-- User Account -->
              <li class="dropdown user-menu">
                <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                  <img src="assets/img/user/user.png" class="user-image" alt="User Image" />
                  <span class="d-none d-lg-inline-block"><?php echo $_SESSION['FullName']; ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                  <!-- User image -->
                  <li class="dropdown-header">
                    <img src="assets/img/user/user.png" class="img-circle" alt="User Image" />
                    <div class="d-inline-block">
                    <?php echo $_SESSION['FullName']; ?> <small class="pt-1"><?php echo $_SESSION['Email']; ?></small>
                    </div>
                  </li>
                  <li>
                    <a href="settings.php"> <i class="mdi mdi-settings"></i> Account Settings </a>
                  </li>

                  <li class="dropdown-footer">
                    <a href="../logout.php?logout"> <i class="mdi mdi-logout"></i> Log Out </a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>


      </header>

      <?php

require_once '../api/getLists.php';
$department_count = mysqli_num_rows($departments);
$user_count = mysqli_num_rows($users);
$order_count = mysqli_num_rows($orders);

?>


      <div class="content-wrapper">
        <div class="content">

          <!-- Top Statistics -->
          <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-primary border">
                <div class="card-block">
                  <i class="mdi mdi-city mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $department_count; ?></h3>
                  <p>Departments</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-warning border">
                <div class="card-block">
                  <i class="mdi mdi-account-multiple mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $user_count; ?></h3>
                  <p>Pending Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-success border">
                <div class="card-block">
                  <i class="mdi mdi-account-outline mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $order_count; ?></h3>
                  <p>All Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-danger border">
                <div class="card-block">
                  <i class="mdi mdi-account-outline mr-4 text-white"></i>
                  <h3 class="text-white my-2">5300</h3>
                  <p>Cancelled Orders</p>
                </div>
              </div>
            </div>
          </div>


          <?php
if (@$_SESSION['success'] == true) {
    $success = $_SESSION['success'];
    ?>
          <script>
            swal({
              title: "SUCCESS!",
              text: "<?php echo $success; ?>",
              icon: "success",
              button: "OK",
            });
          </script>
        <?php
unset($_SESSION['success']);
} elseif (@$_SESSION['error'] == true) {
    $error = $_SESSION['error'];
    ?>
        <script>
          swal({
            title: "ERROR!",
            text: "<?php echo $error; ?>",
            icon: "warning",
            button: "OK",
          });
        </script>
        <?php
unset($_SESSION['error']);
} elseif (@$_SESSION['missing'] == true) {
    $missing = $_SESSION['missing'];
    ?>
          <script>
            swal({
              title: "INFO!",
              text: "<?php echo $missing; ?>",
              icon: "info",
              button: "OK",
            });
          </script>
        <?php
unset($_SESSION['missing']);
}
?>


          <!-- Add New Order Form Modal -->
          <div class="modal fade" id="newOrderForm" tabindex="-1" role="dialog"
            aria-labelledby="newOrderFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="newOrderFormTitle">New Order</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../api/createOrder.php" method="POST">
                  <div class="form-group">
                      <label for="department">Department</label>
                      <select class="form-control" name="department" id="department">
                      <?php
include '../api/getLists.php';
if ($departments):
    while ($row = mysqli_fetch_array($departments)):
    ?>
																		                    <option value="<?php echo $row['department_id']; ?>"> <?php echo $row['department_name']; ?></option>
																		                <?php
endwhile;
endif;
?>
                      </select>
                      <small class="form-text text-muted">This is the department for the new Order.</small>
                    </div>
                    <div class="form-group">
                      <label for="password">Requirement</label>
                      <textarea name="orderDetails" id="orderDetails" class="form-control" aria-describedby="orderDetailsHelp" rows="4" col="6" placeholder="Order details" required></textarea>
                      <small id="orderDetailsHelp" class="form-text text-muted">These are the requirements of this Order.</small>
                    </div>
                    <button type="submit" name="createOrderBtn" class="btn btn-block btn-primary">Place Order</button>
                  </form>
                </div>
                <div class="modal-footer">
                </div>
              </div>
            </div>
          </div>

          <!-- Edit Order Form Modal -->
          <div class="modal fade" id="editOrderForm" tabindex="-1" role="dialog"
            aria-labelledby="editOrderFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editOrderFormTitle">Edit Order</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../api/updateOrder.php" method="POST">

                  <input type="hidden" name="orderId" id="orderId">

                  <div class="form-group">
                      <label for="orderStatus">Account Type</label>
                      <select class="form-control" name="orderStatus" id="orderStatus">
                        <option value="0">Cancel</option>
                        <option value="1">Team Leader</option>
                        <option value="2">Department Manager</option>
                        <option value="3">Finance Manager</option>
                      </select>
                      <small class="form-text text-muted">This is the account type of the new User.</small>
                    </div>
                    <button type="submit" name="editOrderBtn" class="btn btn-block btn-primary">Submit</button>
                  </form>
                </div>
                <div class="modal-footer">
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card card-table-border-none" id="recent-orders">
                <div class="card-header justify-content-between">
                  <button type="button" class="btn btn-info text-uppercase btn-lg" data-toggle="modal"
                    data-target="#newOrderForm">
                    <i class="mdi mdi-cart"></i>
                    Place New Order
                  </button>
                </div>
                <hr>

                <div class="card-body pt-0 pb-5">
                  <table class="table card-table table-hover table-responsive table-responsive-large"
                    style="width:100%" id="departmentTable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Department</th>
                        <th scope="col">Details</th>
                        <th scope="col">Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

<?php
while ($row = mysqli_fetch_array($orders)):
?>
                      <tr>
                        <td> <?php echo $row['order_id']; ?> </td>
                        <td> <?php echo $row['department_name']; ?> </td>
                        <td> <?php echo $row['order_details']; ?> </td>
                        <?php

$order_status = $row['order_status'];
if ($order_status == 0):
?>
  <td>
                          <span class="badge badge-warning text-uppercase">Pending</span>
                        </td>
                        <?php
elseif ($order_status == 1):
?>
<td>
                          <span class="badge badge-info text-uppercase">Processing</span>
                        </td>
                        <?php
elseif ($order_status == 2):
?>
                          <td>
                          <span class="badge badge-success text-uppercase">Completed</span>
                        </td>
                        <?php
elseif ($order_status == 3):
?>
                          <td>
                          <span class="badge badge-danger text-uppercase">Cancelled</span>
                        </td>
                        <?php
endif;
?>
                        <td>
                          <button class="btn btn-primary btn-sm"><i class="mdi mdi-tooltip-edit btnEditOrder"></i></button>
                        </td>
                      </tr>

                      <?php
endwhile;
?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <footer class="footer mt-auto">
        <div class="copyright bg-white">
          <p>
            &copy; <span id="copy-year">2019</span> Made with &#128154; by
            <a class="text-primary" href="https://github.com/Harshana-Rathnayaka" target="_blank">Dreeko
              Corporations</a>.
          </p>
        </div>
        <script>
          var d = new Date();
          var year = d.getFullYear();
          document.getElementById("copy-year").innerHTML = year;
        </script>
      </footer>

    </div>
  </div>


  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/plugins/toaster/toastr.min.js"></script>
  <script src="assets/plugins/slimscrollbar/jquery.slimscroll.min.js"></script>
  <script src="assets/plugins/charts/Chart.min.js"></script>
  <script src="assets/plugins/ladda/spin.min.js"></script>
  <script src="assets/plugins/ladda/ladda.min.js"></script>
  <script src="assets/plugins/jquery-mask-input/jquery.mask.min.js"></script>
  <script src="assets/plugins/select2/js/select2.min.js"></script>
  <script src="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
  <script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
  <script src="assets/plugins/daterangepicker/moment.min.js"></script>
  <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="assets/plugins/jekyll-search.min.js"></script>
  <script src="assets/js/sleek.js"></script>
  <script src="assets/js/chart.js"></script>
  <script src="assets/js/date-range.js"></script>
  <script src="assets/js/map.js"></script>
  <script src="assets/js/custom.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#departmentTable').DataTable({
        "lengthMenu": [5, 10],
      });
    });
  </script>

<!-- open edit department modal on button click -->
<script>
    $('.btnEditOrder').on('click', function() {

      $('#editOrderForm').modal('show');

      $tr = $(this).closest('tr');

      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();

      console.log(data);

      $('#orderId').val(data[0]);
      $('#editDepartmentName').val(data[1]);

    });
  </script>

</body>
</html>