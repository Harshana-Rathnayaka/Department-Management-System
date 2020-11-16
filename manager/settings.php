<?php
session_start();
if (!isset($_SESSION['UserName'])) {
    $_SESSION['error'] = "Session timed out. Please login to continue.";
    header('location:../signin.php');
} elseif (isset($_SESSION['UserType'])) {
    $usertype = $_SESSION['UserType'];

    if ($usertype == 0) {
        header('location:../admin/index.php');
    } else if ($usertype == 1) {
        header('location:../leader/index.php');
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
        <?php
$currentPage = 'settings';
include 'sidebar.php';
?>


    <div class="page-wrapper">
      <!-- Header -->
      <?php

include '../header.php';

require_once '../api/getLists.php';
$all_orders_count = mysqli_num_rows($all_orders_department);
$pending_orders_count = mysqli_num_rows($pending_orders_department);
$rejected_orders_count = mysqli_num_rows($rejected_orders_department);
$completed_orders_count = mysqli_num_rows($completed_orders_department);

?>
      <div class="content-wrapper">
        <div class="content">

          <!-- Top Statistics -->
          <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-primary border">
                <div class="card-block">
                  <i class="mdi mdi-cart mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $all_orders_count; ?></h3>
                  <p>All Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-warning border">
                <div class="card-block">
                  <i class="mdi mdi-basket-fill mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $pending_orders_count; ?></h3>
                  <p>Pending Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-success border">
                <div class="card-block">
                  <i class="mdi mdi-clipboard-check mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $completed_orders_count; ?></h3>
                  <p>Completed Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-danger border">
                <div class="card-block">
                  <i class="mdi mdi-cart-off mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $rejected_orders_count; ?></h3>
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


                      <div class="col-lg-12">
                        <div class="card card-default">
                            <div class="card-header card-header-border-bottom">
                                <h2>Account Settings</h2>
                            </div>
                            <div class="card-body">
                                <form action="../api/accountSettings.php" method="POST">
                                <div class="form-group">

                                        <input value="<?php echo $_SESSION['Id']; ?>" type="hidden" name="userId">

                                        <label for="nameInput">Full Name</label>
                                        <input value="<?php echo $account_details_all['fullname']; ?>" required type="text" name="fullname" class="form-control" id="nameInput"
                                            placeholder="Enter your full name">
                                        <span class="mt-2 d-block">This is your name.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="usernameInput">Username</label>
                                        <input value="<?php echo $account_details_all['username']; ?>" required type="text" name="username" class="form-control" id="usernameInput"
                                            placeholder="Enter your username">
                                        <span class="mt-2 d-block">This is your username.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="emailInput">Email address</label>
                                        <input value="<?php echo $account_details_all['email']; ?>" required type="email" name="email" class="form-control" id="emailInput"
                                            placeholder="Enter your email">
                                        <span class="mt-2 d-block">This is your email address.</span>
                                    </div>
                                    <div class="form-footer pt-4 pt-5 mt-4 border-top">
                                        <button type="submit" name="editAccountInfoBtn" class="btn btn-primary btn-default">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
      </div>

      <?php include '../footer.php';?>

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
      $('#userTable').DataTable({
        "lengthMenu": [5, 10],
      });
    });
  </script>

  <!-- open edit user modal on button click -->
<script>
    $('.btnEditUser').on('click', function() {

      $('#editUserForm').modal('show');

      $tr = $(this).closest('tr');

      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();

      console.log(data);

      $('#editUserId').val(data[0]);
      $('#editFullName').val(data[1]);

    });
  </script>



</body>

</html>
