<?php
session_start();
if (!isset($_SESSION['UserName'])) {
    $_SESSION['error'] = "Session timed out. Please login to continue.";
    header('location:../signin.php');
} elseif (isset($_SESSION['UserType'])) {
    $usertype = $_SESSION['UserType'];

    if ($usertype == 1) {
        header('location:../leader/index.php');
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

  <title>Department Management System</title>

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
        <?php
$currentPage = 'send-reports';
include 'sidebar.php';
?>


    <div class="page-wrapper">
      <!-- Header -->
      <?php

include 'header.php';

require_once '../api/getLists.php';
$department_count = mysqli_num_rows($departments_admin);
$user_count = mysqli_num_rows($users_admin);
$order_count = mysqli_num_rows($orders_admin);
$email_count = mysqli_num_fields($emails_admin);

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
                  <p>Users</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-success border">
                <div class="card-block">
                  <i class="mdi mdi-account-outline mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $order_count; ?></h3>
                  <p>Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-secondary border">
                <div class="card-block">
                  <i class="mdi mdi-account-outline mr-4 text-white"></i>
                  <h3 class="text-white my-2">5300</h3>
                  <p>New Users</p>
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


          <!-- Add New Email Form Modal -->
          <div class="modal fade" id="newEmailForm" tabindex="-1" role="dialog"
            aria-labelledby="newEmailFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="newEmailFormTitle">Add New Email</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../api/createEmail.php" method="POST">
                    <div class="form-group">
                      <label for="fullname">Name</label>
                      <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" required
                        placeholder="Enter the name">
                      <small id="nameHelp" class="form-text text-muted">This is the name of the Senior Manager.</small>
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required
                        placeholder="Enter the email">
                      <small id="emailHelp" class="form-text text-muted">This is the email of the Senior Manager.</small>
                    </div>
                    <button type="submit" name="btnCreateEmail" class="btn btn-block btn-primary">Save</button>
                  </form>
                </div>
                <div class="modal-footer">
                </div>
              </div>
            </div>
          </div>


          <!-- Edit Email Form Modal -->
          <div class="modal fade" id="editEmailForm" tabindex="-1" role="dialog"
            aria-labelledby="editEmailFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editEmailFormTitle">Update Senior Manager Details</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../api/editEmail.php" method="POST">

                  <input type="hidden" name="editSeniorManagerId" id="editSeniorManagerId">

                    <div class="form-group">
                      <label for="editName">Name</label>
                      <input type="text" class="form-control" name="editName" id="editName"
                        aria-describedby="editNameHelp" placeholder="Enter the name">
                      <small id="editNameHelp" class="form-text text-muted">This is the name of the
                        Senior Manager.</small>
                    </div>
                    <div class="form-group">
                      <label for="editEmail">Email</label>
                      <input type="editEmail" class="form-control" name="editEmail" id="editEmail" aria-describedby="editEmailHelp" required
                        placeholder="Enter the editEmail">
                      <small id="emailHelp" class="form-text text-muted">This is the email of the Senior Manager.</small>
                    </div>
                    <button type="submit" name="editEmailBtn" class="btn btn-block btn-primary">Save</button>
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
                    data-target="#newEmailForm">
                    <i class="mdi mdi-account-box"></i>
                    New Email Address
                  </button>
                </div>
                <hr>
                <div class="card-body pt-0 pb-5">
                  <table class="table table-hover table-responsive table-responsive-large"
                    style="width:100%" id="emailTable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th>Email</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php
while ($row = mysqli_fetch_array($emails_admin)):
?>

                      <tr>
                        <td><?php echo $row['senior_manager_id']; ?></td>
                        <td ><?php echo $row['senior_manager_name']; ?></td>
                        <td><?php echo $row['senior_manager_email']; ?></td>
                        <td>
                          <button class="btn btn-dark btn-sm btnEditEmail"><i class="mdi mdi-account-edit"></i></button>
                          <!-- <button class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i></button> -->
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

      <?php include 'footer.php';?>

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
      $('#emailTable').DataTable({
        "lengthMenu": [5, 10],
      });
    });
  </script>

  <!-- open edit user modal on button click -->
<script>
    $('.btnEditEmail').on('click', function() {

      $('#editEmailForm').modal('show');

      $tr = $(this).closest('tr');

      var data = $tr.children('td').map(function() {
        return $(this).text();
      }).get();

      console.log(data);

      $('#editSeniorManagerId').val(data[0]);
      $('#editName').val(data[1]);
      $('#editEmail').val(data[2]);

    });
  </script>



</body>

</html>
