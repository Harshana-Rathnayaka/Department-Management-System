<?php
session_start();
if (isset($_SESSION['UserName'])) {
    $usertype = $_SESSION['UserType'];
    if ($usertype == 0) {
        header("location:admin/index.php");
    } elseif ($usertype == 1) {
        header("location:leader/index.php");
    } elseif ($usertype == 2) {
        header("location:manager/index.php");
    } elseif ($usertype == 3) {
        header("location:finance/index.php");
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title></title>

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
  <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />

  <!-- PLUGINS CSS STYLE -->
  <link href="admin/assets/plugins/toaster/toastr.min.css" rel="stylesheet" />
  <link href="admin/assets/plugins/nprogress/nprogress.css" rel="stylesheet" />
  <link href="admin/assets/plugins/flag-icons/css/flag-icon.min.css" rel="stylesheet"/>
  <link href="admin/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  <link href="admin/assets/plugins/ladda/ladda.min.css" rel="stylesheet" />
  <link href="admin/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="admin/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />

  <!-- SLEEK CSS -->
  <link id="sleek-css" rel="stylesheet" href="admin/assets/css/sleek.css" />



  <!-- FAVICON -->
  <link href="admin/assets/img/favicon.png" rel="shortcut icon" />

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="assets/plugins/nprogress/nprogress.js"></script>
</head>

</head>
  <body class="bg-light-gray" id="body">
      <div class="container d-flex flex-column justify-content-between vh-100">
      <div class="row justify-content-center mt-5">
        <div class="col-xl-5 col-lg-6 col-md-10">
          <div class="card">
            <div class="card-header bg-primary">
              <div class="app-brand">
                <a href="/index.html">
                  <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" width="30" height="33"
                    viewBox="0 0 30 33">
                    <g fill="none" fill-rule="evenodd">
                      <path class="logo-fill-blue" fill="#7DBCFF" d="M0 4v25l8 4V0zM22 4v25l8 4V0z" />
                      <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                    </g>
                  </svg>
                  <span class="brand-name">Sleek Dashboard</span>
                </a>
              </div>
            </div>
            <div class="card-body p-5">

              <h4 class="text-dark mb-5">OTP Verification</h4>
              <form action="api/verify.php" method="POST">
                <div class="row">
                  <div class="form-group col-md-12 mb-4">
                    <input type="text" class="form-control input-lg" name="otp" required id="otp" aria-describedby="otpHelp" placeholder="OTP Code">
                  </div>
                  <div class="col-md-12">

                    <button type="submit" class="btn btn-lg btn-primary btn-block mb-4">Continue</button>


                    <?php
if (@$_SESSION['error'] == true) {
    ?>
                        <div role="alert" class=" alert-danger alert text-center py-3">
                        <i class="mdi mdi-alert mr-1"></i>
                            <?php echo $_SESSION['error']; ?>
                        </div>
                    <?php
unset($_SESSION['error']);
} elseif (@$_SESSION['missing'] == true) {
    ?>

                        <div role="alert" class=" alert-info alert text-center py-3">
                        <i class="mdi mdi-alert mr-1"></i>
                        <?php echo $_SESSION['missing']; ?>
                        </div>
                    <?php
unset($_SESSION['missing']);
} elseif (@$_SESSION['success'] == true) {
    ?>
                        <div role="alert" class=" alert-success alert text-center py-3">
                        <i class="mdi mdi-alert mr-1"></i>
                        <?php echo $_SESSION['success']; ?>
                        </div>
                    <?php
unset($_SESSION['success']);
}
?>



                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

        <footer class="footer mt-auto">
        <div class="copyright bg-white">
          <p class="text-center">
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
</body>
</html>
