<?php
session_start();
if (!isset($_SESSION['UserName'])) {
    $_SESSION['error'] = "Session timed out. Please login to continue.";
    header('location:../signin.php');
} elseif (isset($_SESSION['UserType'])) {
    $usertype = $_SESSION['UserType'];

    // if ($usertype == 1) {
    //   header('location:../leader/index.php');
    // } else if ($usertype == 2) {
    //   header('location:../manager/index.php');
    // } else if ($usertype == 3) {
    //   header('location:../finance/index.php');
    // }
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

            <li>
              <a class="sidenav-item-link" href="index.php">
                <i class="mdi mdi-city"></i>
                <span class="nav-text">Departments</span>
              </a>
            </li>

            <li class="active">
              <a class="sidenav-item-link" href="users.html">
                <i class="mdi mdi-account-multiple"></i>
                <span class="nav-text">Users</span>
              </a>
            </li>

            <li>
              <a class="sidenav-item-link" href="settings.html">
                <i class="mdi mdi-settings"></i>
                <span class="nav-text">Settings</span>
              </a>
            </li>

          </ul>

        </div>

        <hr class="separator" />

        <ul class="nav sidebar-inner" id="sidebar-menu">
          <li class="active">
            <a class="sidenav-item-link" href="index.html">
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
                    <a href="#"> <i class="mdi mdi-settings"></i> Account Setting </a>
                  </li>

                  <li class="dropdown-footer">
                    <a href="signin.html"> <i class="mdi mdi-logout"></i> Log Out </a>
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
              <div class="card widget-block p-4 rounded bg-danger border">
                <div class="card-block">
                  <i class="mdi mdi-account-outline mr-4 text-white"></i>
                  <h3 class="text-white my-2">5300</h3>
                  <p>New Users</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-success border">
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


          <!-- Add New User Form Modal -->
          <div class="modal fade" id="newDepartmentForm" tabindex="-1" role="dialog"
            aria-labelledby="newDepartmentFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="newDepartmentFormTitle">Add New User</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../api/createUser.php" method="POST">
                    <div class="form-group">
                      <label for="fullname">Full Name</label>
                      <input type="text" class="form-control" name="fullname" id="fullname" aria-describedby="fullnameHelp" required
                        placeholder="Enter the full name">
                      <small id="fullnameHelp" class="form-text text-muted">This is the full name of the new User.</small>
                    </div>
                    <div class="form-group">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" name="username" id="username" aria-describedby="usernameHelp" required
                        placeholder="Enter the username">
                      <small id="usernameHelp" class="form-text text-muted">This is the username for the new User.</small>
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required
                        placeholder="Enter the email">
                      <small id="emailHelp" class="form-text text-muted">This is the email of the new User.</small>
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password" aria-describedby="passwordHelp" required
                        placeholder="Enter the name">
                      <small id="passwordHelp" class="form-text text-muted">This is the password for the new User.</small>
                    </div>
                    <div class="form-group">
                      <label for="usertype">Account Type</label>
                      <select class="form-control" name="usertype" id="usertype">
                        <option value="0">Admin</option>
                        <option value="1">Team Leader</option>
                        <option value="2">Department Manager</option>
                        <option value="3">Finance Manager</option>
                      </select>
                      <small class="form-text text-muted">This is the account type of the new User.</small>
                    </div>
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
                      <small class="form-text text-muted">This is the department of the new User.</small>
                    </div>
                    <button type="submit" name="btnCreateUser" class="btn btn-block btn-primary">Submit</button>
                  </form>
                </div>
                <div class="modal-footer">
                </div>
              </div>
            </div>
          </div>


          <!-- Edit User Form Modal -->
          <div class="modal fade" id="editUserForm" tabindex="-1" role="dialog"
            aria-labelledby="editUserFormTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editUserFormTitle">Update User Status</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="../api/editUser.php" method="POST">

                  <input type="hidden" name="editUserId" id="editUserId">

                    <div class="form-group">
                      <label for="editFullName">Full Name</label>
                      <input type="text" class="form-control" disabled name="editFullName" id="editFullName"
                        aria-describedby="editFullNameHelp" placeholder="Enter the name">
                      <small id="editFullNameHelp" class="form-text text-muted">This is the name of the
                        User.</small>
                    </div>
                    <div class="form-group">
                      <label for="editUserStatus">Account Status</label>
                      <select class="form-control" name="editUserStatus" id="editUserStatus">
                        <option value="1">Activate</option>
                        <option value="0">Suspend</option>
                      </select>
                      <small class="form-text text-muted">This is the status of the account.</small>
                    </div>
                    <button type="submit" name="editUserBtn" class="btn btn-block btn-primary">Submit</button>
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
                    data-target="#newDepartmentForm">
                    <i class="mdi mdi-account-plus"></i>
                    New user
                  </button>
                </div>
                <hr>
                <div class="card-body pt-0 pb-5">
                  <table class="table table-hover table-responsive table-responsive-large"
                    style="width:100%" id="userTable">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Full Name</th>
                        <th>Department</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php
while ($row = mysqli_fetch_array($users)):
?>

                      <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td ><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['department_name']; ?></td>
                        <?php
$user_type = $row['user_type'];
if ($user_type == 1):
?>
                        <td>
                          <span class="badge badge-warning text-uppercase">Team Leader</span>
                        </td>
                        <?php
elseif ($user_type == 2):
?>
                          <td>
                          <span class="badge badge-primary text-uppercase">Department Manager</span>
                        </td>
                        <?php
elseif ($user_type == 3):
?>
                          <td>
                          <span class="badge badge-info text-uppercase">Finance Manager</span>
                        </td>
                        <?php
endif;

$status = $row['status'];
if ($status == 1):
?>
  <td>
                          <span class="badge badge-success text-uppercase">Active</span>
                        </td>
                        <?php
elseif ($status == 0):
?>
<td>
                          <span class="badge badge-danger text-uppercase">Suspended</span>
                        </td>
                        <?php
endif;
?>

                        <td>
                          <button class="btn btn-dark btn-sm"><i class="mdi mdi-tooltip-edit btnEditUser"></i></button>
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
