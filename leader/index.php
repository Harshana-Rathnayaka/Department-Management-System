<?php
session_start();
if (!isset($_SESSION['UserName'])) {
    $_SESSION['error'] = "Session timed out. Please login to continue.";
    header('location:../index.php');
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
$currentPage = 'pending-orders';
include 'sidebar.php';
?>


    <div class="page-wrapper">
      <!-- Header -->

      <?php

include '../header.php';

require_once '../api/getLists.php';
$all_order_count = mysqli_num_rows($all_orders_leader);
$pending_order_count = mysqli_num_rows($pending_orders_leader);
$cancelled_order_count = mysqli_num_rows($cancelled_orders_leader);
$completed_order_count = mysqli_num_rows($completed_orders_leader);

?>


      <div class="content-wrapper">
        <div class="content">

          <!-- Top Statistics -->
          <div class="row">
          <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-primary border">
                <div class="card-block">
                  <i class="mdi mdi-clipboard-check mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $all_order_count; ?></h3>
                  <p>All Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-warning border">
                <div class="card-block">
                  <i class="mdi mdi-basket-fill mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $pending_order_count; ?></h3>
                  <p>Pending Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-success border">
                <div class="card-block">
                  <i class="mdi mdi-clipboard-check mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $completed_order_count; ?></h3>
                  <p>Completed Orders</p>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3">
              <div class="card widget-block p-4 rounded bg-danger border">
                <div class="card-block">
                  <i class="mdi mdi-cart-off mr-4 text-white"></i>
                  <h3 class="text-white my-2"><?php echo $cancelled_order_count; ?></h3>
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
                      <label for="item">Item</label>
                      <input name="item" id="item" class="form-control" aria-describedby="itemHelp" placeholder="Item name" required>
                      <small id="itemHelp" class="form-text text-muted">This is the item required.</small>
                    </div>
                    <div class="form-group">
                      <label for="quantity">Quantity</label>
                      <input name="quantity" id="quantity" class="form-control" aria-describedby="quantityHelp" placeholder="Amount required" required>
                      <small id="quantityHelp" class="form-text text-muted">This is the quantity required.</small>
                    </div>
                    <div class="form-group">
                      <label for="orderDetails">Requirement</label>
                      <textarea name="orderDetails" id="orderDetails" class="form-control" aria-describedby="orderDetailsHelp" rows="4" col="6" placeholder="Order details" required></textarea>
                      <small id="orderDetailsHelp" class="form-text text-muted">These are the requirements of the new Order.</small>
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
                  <form action="../api/editOrder.php" method="POST">

                  <input type="hidden" name="orderId" id="orderId">

                  <div class="form-group">
                      <label for="editOrderDepartment">Department</label>
                      <input disabled type="text" class="form-control" name="editOrderDepartment" id="editOrderDepartment" required
                        aria-describedby="editOrderDepartmentHelp" placeholder="Enter the name">
                      <small id="editOrderDepartmentHelp" class="form-text text-muted">This is the department for this Order.</small>
                    </div>

                    <div class="form-group">
                      <label for="editItem">Item</label>
                      <input name="editItem" id="editItem" class="form-control" aria-describedby="editItemHelp" placeholder="Order details" required>
                      <small id="editItemHelp" class="form-text text-muted">This is the item required.</small>
                    </div>

                    <div class="form-group">
                      <label for="editQuantity">Quantity</label>
                      <input name="editQuantity" id="editQuantity" class="form-control" aria-describedby="editQuantityHelp" placeholder="Order details" required>
                      <small id="editQuantityHelp" class="form-text text-muted">This is the quantity required.</small>
                    </div>

                    <div class="form-group">
                      <label for="editOrderDetails">Requirement</label>
                      <textarea name="editOrderDetails" id="editOrderDetails" class="form-control" aria-describedby="editOrderDetailsHelp" rows="4" col="6" placeholder="Order details" required></textarea>
                      <small id="editOrderDetailsHelp" class="form-text text-muted">These are the requirements of this Order.</small>
                    </div>

                    <label class="control control-checkbox">Cancel Order
											<input value="3" type="checkbox" id="cancelOrderCheckbox" name="cancelOrderCheckbox"/>
												<div class="control-indicator"></div>
										</label>


                    <button type="submit" name="editOrderBtn" class="btn btn-block btn-primary">Update Order</button>
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
                    <i class="mdi mdi-cart-plus"></i>
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
                        <th scope="col">Item</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Details</th>
                        <th scope="col">Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>

<?php
while ($row = mysqli_fetch_array($pending_orders_leader)):
?>
                      <tr>
                        <td> <?php echo $row['order_id']; ?> </td>
                        <td> <?php echo $row['department_name']; ?> </td>
                        <td> <?php echo $row['item']; ?> </td>
                        <td> <?php echo $row['quantity']; ?> </td>
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
                          <span class="badge badge-success text-uppercase">Approved</span>
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
                          <button class="btn btn-dark btn-sm btnEditOrder"><i class="mdi mdi-square-edit-outline"></i></button>
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
  <script src="../timeout.js"></script>

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
      $('#editOrderDepartment').val(data[1]);
      $('#editItem').val(data[2]);
      $('#editQuantity').val(data[3]);
      $('#editOrderDetails').val(data[4]);

    });
  </script>

</body>
</html>