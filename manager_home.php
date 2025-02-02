<?php
session_start();


if(!isset($_SESSION['stationUser'])) {
  echo "<script>alert('ACCESS DENIED!');</script>";
  echo "<script>window.location='stationlogin.php?manager'</script>"; 
}


$user = $_SESSION['stationUser'];

require 'container/dbqueries.php';
$obj = new GasDelivery;

if(isset($_GET['logout'])) {
  $obj->manager_logout();
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
    <a class="navbar-brand" href="index.html">Manager Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
          <a class="nav-link" href="manager_home.php?overview">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">View Statistics</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Add agent">
          <a class="nav-link" href="?regagent">
            <i class="fa fa-fw fa-area-chart"></i>
            <span class="nav-link-text">Register agent</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="View Agents">
          <a class="nav-link" href="?viewagents">
            <i class="fa fa-fw fa-edit"></i>
            <span class="nav-link-text">View agents</span>
          </a>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="View Agents">
          <a class="nav-link" href="?vgassubm">
            <i class="fa fa-fw fa-edit"></i>
            <span class="nav-link-text">View submitted gas</span>
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
            <i class="fa fa-fw fa-sign-out"></i><?php echo $user;?>(Logout)</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">

    <?php if(!isset($_GET['overview'])) { ?>      
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Manager</li>
      </ol>
    <?php } ?>







      <?php if(isset($_GET['overview'])) { ?>
      <h1>Gas station statistics</h1>
      <hr>
      <!-- Icon Cards-->
      <div class="row">

        <div class="col-xl-6 col-lg-6 mb-5">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5">All agents <button class="btn btn-md btn-danger"><?php echo $obj->count_agents_nocond(); ?></button></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View agent details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-5">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-book"></i>
              </div>
              <div class="mr-5">All customers <button class="btn btn-md btn-danger"><?php echo $obj->count_customers(); ?></button></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View customer details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>


        <div class="col-xl-6 col-lg-6 mb-5">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-list"></i>
              </div>
              <div class="mr-5">All gas submitted <button class="btn btn-md btn-danger"><?php echo $obj->count_submittedgas_nocond();?></button></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View all gas submitted</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <div class="col-xl-6 col-lg-6 mb-5">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-book"></i>
              </div>
              <div class="mr-5">All paid Requests <button class="btn btn-md btn-danger"><?php echo $obj->count_paidgas_nocond();?></button></div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="#">
              <span class="float-left">View paid gas requests</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>


      </div>
    </div>
    <?php } ?>









    <?php if(isset($_GET['regagent'])) { ?>
    <div class="card col-6 mx-auto mt-5" style="background-color: #eaf2f8!important">
      <div class="card-header text-center"><h3>Register new agent!</h3></div>


      <?php
      if(isset($_POST['registerbtn'])) {
        if($obj->register_agent($_POST['agent_names'], $_POST['username'], $_POST['telno'], $_POST['address'], $_POST['password'])) { ?>
          <div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Agent is registered!</strong> 
          </div>

      <?php } else { ?>
          <div class='alert alert-danger'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Failed to be registered!</strong> 
          </div>
      <?php }} ?>


    <?php if(isset($_GET['error'])){ ?>
    <div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Incorrect username and Password</strong> 
    </div>
    <?php } ?>

      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1"><strong>Agent Names</strong></label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter names" name="agent_names">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1"><strong>Username</strong></label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter Username" name="username">
          </div>

          <div class="form-group">
            <label for="examplePhone"><strong>Phone Number</strong></label>
            <input class="form-control" id="examplePhone" type="text" placeholder="Tel No" name="telno">
          </div>

          <div class="form-group">
            <div class="form-group">
            <label for="examplePhone"><strong>Address(District)</strong></label>
            <select class="form-control" id="examplePhone" name="address" required="">
            <optgroup></optgroup>
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
            <option value="NYARUGENGE">NYARUGENGE</option>
          </select>
          </div>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1"><strong>Password</strong></label>
            <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password..." name="password">
          </div>

          <button type="submit" class="btn btn-primary btn-block" name="registerbtn">Register</button>
        </form><hr>
        <center><a href="manager_home.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
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
              $stmt= $obj->view_gas();
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
                    echo $rowC['agent_names'];
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
                      /*$stmtqty= $obj->get_gas_whole_quantity();
                      $rowqty= $stmtqty->FETCH(PDO::FETCH_ASSOC);
                      echo "(".$rowqty['total']." kgs)";*/
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
      <?php if(isset($_GET['viewagents'])) { ?>
      <div class="card mb-3">
        <div class="card-header">
          <h3><i class="fa fa-table"></i>&nbsp;All Agents</h3></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Names</th>
                  <th>Username</th>
                  <th>Phone Number</th>
                  <th>Address</th>
                  <th colspan="2"><center>Action</center></th>
                </tr>
              </thead>
              
              <?php
              $stmt= $obj->view_agents();
              while($row= $stmt->FETCH(PDO::FETCH_ASSOC)) {
              ?>
              <tbody>
                <tr>
                  <td><?php echo $row['agent_names'];?></td>
                  <td><?php echo $row['username'];?></td>
                  <td><?php echo $row['phone_number'];?></td>
                  <td><?php echo $row['address'];?></td>
                  <td><center><a href="manager_home.php?del_ag=<?php echo $row['agent_id'];?>" class="btn btn-danger" onclick="return confirm('Are you sure u want to delete this?')">Delete</a></center></td>
                  <td>
                    <center>
                      <?php if($row['status']=='0') { ?>
                      <a href="manager_home.php?enable_ag=<?php echo $row['agent_id'];?>" class="btn btn-primary">Enable</a>
                      <?php } else { ?>
                      <a href="manager_home.php?dis_ag=<?php echo $row['agent_id'];?>" class="btn btn-warning">Disable</a>
                      <?php } ?>
                    </center>
                  </td>
                </tr>
              </tbody>
            <?php } ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php } 

      if(isset($_GET['del_ag'])) {
        if($obj->delete_agent($_GET['del_ag'])) {
          echo "<script>alert('AGENT DELETED!');</script>";
          echo "<script>window.location='manager_home.php?viewagents'</script>";  
        }
      }

      if(isset($_GET['dis_ag'])) {
        if($obj->disable_agent($_GET['dis_ag'])) {
          echo "<script>alert('AGENT IS DISABLED!');</script>";
          echo "<script>window.location='manager_home.php?viewagents'</script>";  
        }
      }

      if(isset($_GET['enable_ag'])) {
        if($obj->enable_agent($_GET['enable_ag'])) {
          echo "<script>alert('AGENT IS ENABLED!');</script>";
          echo "<script>window.location='manager_home.php?viewagents'</script>";  
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
            <a class="btn btn-primary" href="manager_home.php?logout">Logout</a>
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
  </div>
</body>

</html>
