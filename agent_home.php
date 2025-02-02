<?php
session_start();

if(!isset($_SESSION['agentUser'])) {
  echo "<script>alert('ACCESS DENIED!');</script>";
  echo "<script>window.location='stationlogin.php?agent'</script>"; 
}

$username= $_SESSION['agentUser'];
$agent_id= $_SESSION['user_id'];
include('container/dbqueries.php');
$obj = new GasDelivery;

if(isset($_GET['logout'])) {
  $obj->agent_logout();
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
    <a class="navbar-brand" href="index.html">Agent Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="agent_home.php?overview">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <!-- <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Add agent">
          <a class="nav-link" href="?regcustomer">
            <i class="fa fa-fw fa-edit"></i>
            <span class="nav-link-text">Register customer</span>
          </a>
        </li> -->

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="View Agents">
          <a class="nav-link" href="?viewcust">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">View customers</span>
          </a>
        </li>
  
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gas Submitted">
          <a class="nav-link" href="?gassubm">
            <i class="fa fa-fw fa-arrow-right"></i>
            <span class="nav-link-text">Submit gas</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gas Submitted">
          <a class="nav-link" href="?vgassubm">
            <i class="fa fa-fw fa-book"></i>
            <span class="nav-link-text">View gas in store <span style="background-color: red!important; color: white!important;">(<?php echo $obj->count_gas_in_storeby_agent($agent_id); ?>)</span></span></span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gas Submitted">
          <a class="nav-link" href="?vpayments">
            <i class="fa fa-fw fa-book"></i>
            <span class="nav-link-text">View all payments</span>
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
        <li class="breadcrumb-item active">Agent</li>
      </ol>







      <?php if(isset($_GET['overview'])) { ?>
      <h1>Overview</h1>
      <hr>
      <!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-comments"></i>
              </div>
              <div class="mr-5">Customers <b><?php echo $obj->count_customers(); ?></b></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="?viewcust">
              <span class="float-left">View customer details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5">Submitted gas <b><?php echo $obj->count_submitted_gas($agent_id); ?></b></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="?vgassubm">
              <span class="float-left">View submitted gas</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
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

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
      }

      if(preg_match('/^[0-9]{10}+$/', test_input($_POST['telno'])) && strlen($_POST['c_names'])>3) {
        $obj->register_customer($_POST['c_names'], $_POST['username'], $_POST['telno'], $_POST['address']); ?>
          <div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Customer is registered!</strong> 
    
          </div>

      <?php } else { ?>
          <div class='alert alert-danger'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>There is invalid number or Short name!</strong>
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
            <select class="form-control" id="examplePhone" name="address" required="">
            <optgroup>SOUTH</optgroup>
            <option value="HUYE">HUYE</option>
            <option value="GISAGARA">GISAGARA</option>
            <option value="NYANZA">NYANZA</option>
            <option value="MUHANGA">MUHANGA</option>
            <option value="RUHANGO">RUHANGO</option>
            <option value="KAMONYI">KAMONYI</option>
            <option value="NYARUGURU">NYARUGURU</option>
            <option value="NYAMAGABE">NYAMAGABE</option>
            <optgroup></optgroup>
            <option value="KICUKIRO">KICUKIRO</option>
            <option value="GASABO">GASABO</option>

        	</select>
          </div>

          <button type="submit" class="btn btn-primary btn-block" name="regcustomerbtn">Register</button>
        </form><hr>
        <center><a href="agent_home.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
      </div>
    </div>
    <?php } ?>










      <!-- Example DataTables Card-->
      <?php if(isset($_GET['viewcust'])) { ?>
      <div class="card mb-3">
        <div class="card-header">
          <h3><center><i class="fa fa-table"></i>&nbsp;All Customers</h3></center></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer names</th>
                  <th>Phone Number</th>
                  <th>Address</th>
                  <th colspan="2"><center>Action</center></th>
                </tr>
              </thead>
              
              <?php
              $stmt= $obj->view_customers();
              $num= 1;
              while($row= $stmt->FETCH(PDO::FETCH_ASSOC)) {
              ?>
              <tbody>
                <tr>
                  <td><?php echo $num; ?></td>
                  <td><?php echo $row['cust_names'];?></td>
                  <td><?php echo $row['phone_number'];?></td>
                  <td><?php echo $row['address'];?></td>
                  <td><center><a href="agent_home.php?del_cust=<?php echo $row['cust_id'];?>" class="btn btn-danger" onclick="return confirm('Are you sure u want to delete this?')">Delete</a></center></td>
                  <td>
                    <center>
                      <a href="agent_home.php?update_c=<?php echo $row['cust_id'];?>" class="btn btn-primary">Update</a>
                    </center>
                  </td>
                </tr>
              </tbody>
            <?php $num++; }  ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php 
      if(isset($_GET['del_cust'])) {
        if($obj->delete_customer($_GET['del_cust'])) {
          echo "<script>alert('CUSTOMER DELETED!');</script>";
          echo "<script>window.location='agent_home.php?viewcust'</script>";  
        }
      }
      ?>











    <?php if(isset($_GET['update_c'])) { 
      $stmtupd= $obj->read_one_customer($_GET['update_c']);
      $rowupd= $stmtupd->FETCH(PDO::FETCH_ASSOC);
    ?>
    <div class="card col-6 mx-auto mt-5" style="background-color: #eaf2f8!important">
      <div class="card-header text-center"><h3>Update a customer!</h3></div>

      <?php
      if(isset($_POST['update_btn'])) {
        if($obj->update_customer($_POST['c_names'], $_POST['username'], $_POST['telno'], $_POST['address'], $_GET['update_c'])) { 
          echo "<script>alert('UPDATED!');</script>";
          echo "<script>window.location='agent_home.php?viewcust'</script>";
      ?>

      <?php } else { ?>
          <div class='alert alert-danger'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Failed to be updated!</strong>
          </div>
      <?php }} ?>

      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1"><strong>Customer Names</strong></label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" name="c_names" value="<?php echo $rowupd['cust_names'];?>">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1"><strong>Username</strong></label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" name="username" value="<?php echo $rowupd['username'];?>">
          </div>

          <div class="form-group">
            <label for="examplePhone"><strong>Phone Number</strong></label>
            <input class="form-control" id="examplePhone" type="text" name="telno"  value="<?php echo $rowupd['phone_number'];?>">
          </div>

          <div class="form-group">
            <label for="examplePhone"><strong>Address</strong></label>
            <input class="form-control" id="examplePhone" type="text" name="address" value="<?php echo $rowupd['address'];?>">
          </div>

          <button type="submit" class="btn btn-primary btn-block" name="update_btn">Update</button>
        </form><hr>
      </div>
    </div>
    <?php } ?>
          

      <!-- Example DataTables Card-->
      <?php if(isset($_GET['gassubm'])) { ?>

      <div class="card mb-3">
        <div class="card-header">
          <h3><center><i class="fa fa-table"></i>&nbsp;Submit customer gas</h3></center></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Customer Names</th>
                  <th>Phone Number</th>
                  <th><center>Action</center></th>
                </tr>
              </thead>
              <?php
              $num= 1;
              $stmt= $obj->view_customers();
              while($row= $stmt->FETCH(PDO::FETCH_ASSOC)) {
              ?>
              <tbody>
                <tr>
                  <td><?php echo $num; ?></td>
                  <td><?php echo $row['cust_names'];?></td>
                  <td><?php echo $row['phone_number'];?></td>
                  <td>
                    <center>
                      <a href="agent_home.php?submitgas=<?php echo $row['cust_id'];?>" class="btn btn-primary">Submit Gas</a>
                    </center>
                  </td>
                </tr>
              </tbody>
            <?php $num++; } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>






    <?php if(isset($_GET['submitgas'])) { ?>
    <div class="card col-6 mx-auto mt-5" style="background-color: #eaf2f8!important">
      <div class="card-header text-center"><h3>Submit Gas!</h3></div>

      <?php
      if(isset($_POST['submitgasbtn'])) {
        if($obj->submit_gas($_POST['gasquantity'], $_POST['comment'], $_GET['submitgas'], $agent_id)) {
      ?>
          <div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong><center>Gas is submitted!</center></strong> 
          </div>

      <?php
      // Send Sms Simultaneously

      $stmtCust= $obj->view_cust_details($_GET['submitgas']);
      $rowCust= $stmtCust->FETCH(PDO::FETCH_ASSOC);

      $stmtAgent= $obj->read_one_agent($agent_id);
      $rowAgent= $stmtAgent->FETCH(PDO::FETCH_ASSOC);


      $sender = $agent_id;
      $agentPhone = $rowAgent['phone_number'];
      $agentNames = $rowAgent['agent_names'];
      $agentComment = $_POST['comment'];

      $recipid = $_GET['submitgas'];
      $recipUname= $rowCust['username'];
      $recipPhone= $rowCust['phone_number'];
      $recipPin= $rowCust['pin_number'];
      $gasqty= $_POST['gasquantity'];

      $obj->gas_submission_send_sms($agentPhone, $agentNames, $agentComment, $gasqty, $recipUname, $recipPhone, $recipPin);
      ?>



      <?php } else { ?>
          <div class='alert alert-danger'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong><center>Failed to be submitted!</center></strong>
          </div>
      <?php }} ?>

      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1"><strong>Gas Quantity (in kgs)</strong></label>
            <input class="form-control" id="exampleInputEmail1" type="number" aria-describedby="emailHelp" placeholder="Enter Quantity" name="gasquantity" required="">
          </div>


          <div class="form-group">
            <label for="exampleComment"><strong></strong></label>
            <textarea class="form-control" id="exampleComment" placeholder="Comment..." name="comment" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-block" name="submitgasbtn">Submit</button>
        </form><hr>
        <center><a href="agent_home.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
      </div>
    </div>
    <?php } ?>











      <!-- Example DataTables Card-->
      <?php if(isset($_GET['vgassubm'])) { ?>
      <div class="card mb-3">
        <div class="card-header">
          <h3><center><i class="fa fa-table"></i>&nbsp;All gas in store!</h3></center></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Customer names</th>
                  <th>Quantity</th>
                  <th>Comment</th>
                  <th>Agent Names</th>
                  <th>Date:</th>
                  <th colspan="2"><center>Action</center></th>
                </tr>
              </thead>
              
              <?php
              $stmt= $obj->view_gas_by_agent($agent_id);
              $num = 1;
              while($row= $stmt->FETCH(PDO::FETCH_ASSOC)) {
              ?>
              <tbody>
                <tr>
                  <td><?php echo $num;?></td>
                  <td>
                    <?php
                    $stmtC= $obj->read_one_customer($row['cust_id']);
                    $rowC= $stmtC->FETCH(PDO::FETCH_ASSOC);
                    echo $rowC['cust_names'];
                    ?>  
                  </td>
                  <td><?php echo $row['gas_quantity'];?> kgs</td>
                  <td><?php echo $row['comment'];?></td>
                  <td>
                    <?php
                    $stmtC= $obj->read_one_agent($row['agent_id']);
                    $rowC= $stmtC->FETCH(PDO::FETCH_ASSOC);
                    //echo $rowC['agent_names'];
                    echo "Me";
                    ?>  
                  </td>
                  <td><?php echo $row['date_submitted'];?></td>
                  <td>
                    <center>
                      <?php if($row['status']=='Unpaid') { ?>
                      <button class="btn btn-danger" disabled>Pending</button>
                      <?php } if($row['status']=='Paid') { ?>
                      <button class="btn btn-warning" disabled>Paid</button>
                      <?php } ?>
                      <!-- <a href=".php?dis_ag=<?php  $row['agent_id'];?>" class="btn btn-primary">Confirm</a> -->
                    </center>
                  </td>                  
                                    
                </tr>
              </tbody>
            <?php $num++; } ?>
              <tfoot>
                <tr>
                  <th colspan="5">
                    <center>Total gas quantity
                      <?php
                      $stmtqty= $obj->get_gas_quantity_by_agent($agent_id);
                      $rowqty= $stmtqty->FETCH(PDO::FETCH_ASSOC);
                      echo "(".$rowqty['total']." kgs)";
                      ?>
                    </center>
                </tr>
              </tfoot>

              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php 
      if(isset($_GET['del_cust'])) {
        if($obj->delete_customer($_GET['del_cust'])) {
          echo "<script>alert('CUSTOMER DELETED!');</script>";
          echo "<script>window.location='agent_home.php?viewcust'</script>";  
        }
      }
      ?>









      <!-- Example DataTables Card-->
      <?php if(isset($_GET['vpayments'])) { ?>
      <div class="card mb-3">
        <div class="card-header">
          <h3><center><i class="fa fa-table"></i>&nbsp;All payments!</h3></center></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Customer names</th>
                  <th>Paid amount</th>
                  <th>Date:</th>
                </tr>
              </thead>
              
              <?php
              $stmt= $obj->view_customer_payments($agent_id);
              $num = 1;
              while($row= $stmt->FETCH(PDO::FETCH_ASSOC)) {
              ?>
              <tbody>
                <tr>
                  <td><?php echo $num;?></td>
                  <td>
                    <?php
                    $stmtC= $obj->read_one_customer($row['cust_id']);
                    $rowC= $stmtC->FETCH(PDO::FETCH_ASSOC);
                    echo $rowC['cust_names'];
                    ?>  
                  </td>
                  <td><?php echo $row['amount'];?> rwf</td>
                  <td><?php echo $row['payment_date'];?></td>                                    
                </tr>
              </tbody>
            <?php $num++; } ?>
              <tfoot>
                <tr>
                  <th colspan="5">
                    <center>Total amount:
                      <?php
                      $stmtqty= $obj->get_payment_total_byagent($agent_id);
                      $rowqty= $stmtqty->FETCH(PDO::FETCH_ASSOC);
                      echo "(".$rowqty['amountTotal']." rwf)";
                      ?>
                    </center>
                </tr>
              </tfoot>

              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php 
      if(isset($_GET['del_cust'])) {
        if($obj->delete_customer($_GET['del_cust'])) {
          echo "<script>alert('CUSTOMER DELETED!');</script>";
          echo "<script>window.location='agent_home.php?viewcust'</script>";  
        }
      }
      ?>




















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
            <a class="btn btn-primary" href="agent_home.php?logout">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    
  </div>
</body>

</html>
