<?php

session_start();

if(!isset($_SESSION['custUser'])) {
  echo "<script>alert('ACCESS DENIED!');</script>";
  echo "<script>window.location='stationlogin.php?cust'</script>"; 
}

$username= $_SESSION['custUser'];
$user_id= $_SESSION['user_id'];
include('container/dbqueries.php');
$obj = new GasDelivery;

if(isset($_GET['logout'])) {
  $obj->customer_logout();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Gas Delivery System</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Customer Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="Customer_home.php?hi">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
  
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gas Submitted">
          <a class="nav-link" href="?custreq">
            <i class="fa fa-fw fa-arrow-right"></i>
            <span class="nav-link-text">Pending Requests <span style="background-color: red!important; color: white!important;">(<?php echo $obj->count_customer_pendingrq($user_id); ?>)</span></span>
          </a>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gas Submitted">
          <a class="nav-link" href="?paidreq">
            <i class="fa fa-fw fa-arrow-right"></i>
            <span class="nav-link-text">Responded Requests <span style="background-color: red!important; color: white!important;">(<?php echo $obj->count_customer_paidrq($user_id); ?>)</span></span>
          </a>
        </li>

      </ul>

      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">

        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="fa fa-fw fa-sign-out"></i><?php echo $username;?>(Logout)</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">


      
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Customer</li>
      </ol>





      <?php if(isset($_GET['hi'])) { ?>
      <h1></h1>
      <hr>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-12 col-xl-12 mb-5">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <div class="mr-5">Welcome to customer dashboard</b></div>
            </div>
            <br>
            <hr>
            <br>
          </div>
        </div>

    
      </div>
    </div>
    </center>
    <?php } ?>









    <?php if(isset($_GET['regcustomer'])) { ?>
    <div class="card col-6 mx-auto mt-5" style="background-color: #eaf2f8!important">
      <div class="card-header text-center"><h3>Register new Customer!</h3></div>

      <?php
      if(isset($_POST['regcustomerbtn'])) {
        if($obj->register_customer($_POST['c_names'], $_POST['username'], $_POST['telno'], $_POST['address'])) { ?>
          <div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Customer is registered!</strong> 
    
          </div>

      <?php } else { ?>
          <div class='alert alert-danger'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Failed to be registered!</strong>
          </div>
      <?php }} ?>

      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1"><strong>Customer Names</strong></label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter names" name="c_names" required="">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1"><strong>Username</strong></label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter Username" name="username" required="">
          </div>

          <div class="form-group">
            <label for="examplePhone"><strong>Phone Number</strong></label>
            <input class="form-control" id="examplePhone" type="text" placeholder="Tel No" name="telno" required="">
          </div>

          <div class="form-group">
            <label for="examplePhone"><strong>Address</strong></label>
            <input class="form-control" id="examplePhone" type="text" placeholder="Address..." name="address" required="">
          </div>

          <button type="submit" class="btn btn-primary btn-block" name="regcustomerbtn">Register</button>
        </form><hr>
        <center><a href="Customer_home.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
      </div>
    </div>
    <?php } ?>


















    <?php if(isset($_GET['custreq'])) { ?>
      <div class="card mb-3">
        <div class="card-header">
          <h3><center><i class="fa fa-table"></i>&nbsp;Pending requests</h3></center></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

              <tbody>
                <tr>
                  <th>No.</th>
                  <th>Gas Quantity</th>
                  <th>Agent Comment</th>
                  <th>Status</th>
                  <th>Amount to pay</th>
                  <th><center>Action</center></th>
                </tr>
              </tbody>
              <?php
              $num =1;
              $stmt= $obj->view_customer_pendingrq($user_id);
              while($row= $stmt->FETCH(PDO::FETCH_ASSOC)) {
              ?>
              <tbody>
                <tr>
                  <td><?php echo $num; ?></td>
                  <td><?php echo $row['gas_quantity'];?></td>
                  <td><?php echo $row['comment'];?></td>
                  <td>
                    <a data-id="<?= $row['payment_id'] ?>" href="./verify_trandaction.php" class="verify_payment">
                      <?= $row['transaction_status']; ?>
                    </a>
                  </td>
                  <td><?php echo '5 rwf'; ?></td>
                  <td>
                    <center>
                      <a href="Customer_home.php?payreq=<?php echo $row['g_id'];?>&cust_id=<?php echo $row['cust_id'];?>&agent_id=<?php echo $row['agent_id'];?>" class="btn btn-primary pay_command" data-url="pay_form.php?request_id=<?= $row['g_id'] ?>">Pay</a>
                    </center>
                  </td>
                </tr>
              </tbody>
            <?php } $num++; ?>

            <?php if($obj->count_customer_pendingrq($user_id)=='0') { ?>
              <tfoot>
                <tr>
                  <td colspan="6"><center><button class="btn btn-danger" disabled>No pending request!</button></center></td>
                </tr>
              </tbody>
            <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>

    <?php } 
    if(isset($_GET['payreq'])) {
      if($obj->customer_keeping_payment($_GET['payreq'], $_GET['cust_id'])) {

        $stmt30= $obj->view_cust_details($user_id);
        $row30= $stmt30->FETCH(PDO::FETCH_ASSOC);
        $finalbal = $row30['balance'] - 2000;

        $custxtmt= $obj->view_cust_details($_GET['cust_id']);
        $rowcxt= $custxtmt->FETCH(PDO::FETCH_ASSOC);

        $obj->update_customer_balance($finalbal, $_GET['cust_id'], $rowcxt['phone_number']);
        $obj->make_full_payments('2000', $_GET['cust_id'], $_GET['agent_id']);

        echo "<script>alert('SUCCESSFULLY PAID!');</script>";
        echo "<script>window.location='customer_home.php?custreq'</script>";  
      } else {
        echo "<script>alert('OOPS, MAYBE U HAVE INSUFICIENT BALANCE!');</script>";
        echo "<script>window.location='customer_home.php?custreq'</script>";
      }
    }
    ?>











    <?php if(isset($_GET['paidreq'])) { ?>
      <div class="card mb-3">
        <div class="card-header">
          <h3><center><i class="fa fa-table"></i>&nbsp;Paid requests</h3></center></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

              <tbody>
                <tr>
                  <th>No.</th>
                  <th>Gas Quantity</th>
                  <th>Agent Comment</th>
                  <th>Status</th>
                  <th>Amount paid</th>
                  <th><center>Action</center></th>
                </tr>
              </tbody>
              <?php
              $num =1;
              $stmt= $obj->view_customer_paidreq($user_id);
              while($row= $stmt->FETCH(PDO::FETCH_ASSOC)) {
              ?>
              <tbody>
                <tr>
                  <td><?php echo $num; ?></td>
                  <td><?php echo $row['gas_quantity'];?></td>
                  <td><?php echo $row['comment'];?></td>
                  <td><?php echo $row['status'];?></td>
                  <td><?php echo '5 rwf'; ?></td>
                  <td>
                    <center>
                      <button class="btn btn-success" type="submit" disabled>Paid</a>
                    </center>
                  </td>
                </tr>
              </tbody>
            <?php } $num++; ?>

            <?php if($obj->count_customer_paidrq($user_id)=='0') { ?>
              <tfoot>
                <tr>
                  <td colspan="6"><center><button class="btn btn-danger" disabled>No paid request!</button></center></td>
                </tr>
              </tbody>
            <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>


    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © 2021 Gas Delivery Management Information System</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="logoutModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Click logout if You want to logout.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="Customer_home.php?logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="pay_modal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="payModalLabel">Pay the sent Gas</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Click logout if You want to logout.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="Customer_home.php?logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <!-- <script src="js/sb-admin-datatables.min.js"></script> -->
    <script type="text/javascript">
      $(document).ready(function(){
        $(".pay_command").click(function(e){
          e.preventDefault();

          $("#pay_modal").find('.modal-content').load($(this).data('url'), function(){
            $("#pay_modal").modal('show');
          });
        });

        $(".verify_payment").click(function(e){
          e.preventDefault();
          var clicked = $(this);
          var old = clicked.html();

          clicked.html("Checking...");

          $.ajax({
              type: "POST",
              url: clicked.attr('href'),  
              data: "payment_id=" + clicked.data('id'),
              success: function(response){
                  // console.log(response.success);
                  if(response.success){
                      clicked.html(response.status);
                  } else {
                      clicked.html(response.message);
                  }
              },
              error: function(error){
                  clicked.html(old);
              }
          });
        });
      });
    </script>
  </div>
</body>

</html>
