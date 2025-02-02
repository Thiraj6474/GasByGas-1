<?php

session_start();

require 'container/dbqueries.php';
$obj = new GasDelivery;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GDS Application</title>
  <!-- Bootstrap core CSS-->  <link rel="shortcut icon" href="icon/GAS10.jpg">

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>






<body class="bg-dark">
  <div class="container">


    <?php if(isset($_GET['manager'])) {
 
      if(isset($_POST['mloginbtn'])) {
          $stmt= $obj->manager_login();
          $row= $stmt->FETCH(PDO::FETCH_ASSOC);

          if($_POST['email']==$row['email'] && $_POST['password']==$row['password']){
            $_SESSION['stationUser'] = $row['username'];
            $_SESSION['user_id'] = $row['m_id'];
              echo "<script>window.location='manager_home.php'</script>";
            } else {
              echo "<script>alert('Incorrect username or password!')</script>";
              echo "<script>window.location='?manager'</script>";
          }
        }
    ?>


    <div class="card card-login mx-auto mt-5">
      <div class="card-header text-center"><h3>Station Manager Login</h3></div>
      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email" name="email">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password" name="password">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox">Remember Password</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="mloginbtn">Login</button>
        </form><hr>


        <div class="text-center">
          <a class="btn btn-success btn-block" href="stationlogin.php?register">Create Account</a><br>
          <center><a href="index.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
        </div>
      </div>
    </div>
    <?php } ?>







    <?php if(isset($_GET['agent'])) { 
 
      if(isset($_POST['agentloginbtn'])) {
          $stmt2= $obj->agent_login();
          $row2= $stmt2->FETCH(PDO::FETCH_ASSOC);

          if($_POST['username']==$row2['username'] && $_POST['password']==$row2['password']) {
            $_SESSION['agentUser'] = $row2['agent_names'];
            $_SESSION['user_id'] = $row2['agent_id'];
            echo "<script>window.location='agent_home.php?overview'</script>";
            } else {
            echo "<script>window.location='?agent&error'</script>";
          }
        }
    ?>

    <div class="card card-login mx-auto mt-5">
      <div class="card-header text-center"><h3>Agent Login</h3></div>


    <?php if(isset($_GET['error'])){ ?>
    <div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Incorrect username and Password</strong> 
    </div>
    <?php } ?>

      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter Username..." name="username">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password..." name="password">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox">Remember Password</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="agentloginbtn">Login</button>
        </form><hr>
        <center><a href="index.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
      </div>
    </div>
    <?php } ?>












    <?php if(isset($_GET['cust'])) { 
 
      if(isset($_POST['custbtn'])) {
          $stmt3= $obj->customer_login();
          $row3= $stmt3->FETCH(PDO::FETCH_ASSOC);

          if($_POST['phone_number']==$row3['phone_number'] && $_POST['pin_number']==$row3['pin_number']) {
            $_SESSION['custUser'] = $row3['cust_names'];
            $_SESSION['user_id'] = $row3['cust_id'];
            echo "<script>window.location='customer_home.php?hi'</script>";
            } else {
            echo "<script>window.location='?cust&error'</script>";
          }
        }
    ?>

    <div class="card card-login mx-auto mt-5">
      <div class="card-header text-center"><h3>Customer Login</h3></div>


    <?php if(isset($_GET['error'])){ ?>
    <div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Incorrect Tel.Number and Pin Number</strong> 
    </div>
    <?php } ?>

      <div class="card-body">
        <form method="POST">
          <div class="form-group">
            <label for="exampleInputEmail1">Tel. Number</label>
            <input class="form-control" id="exampleInputEmail1" type="text" aria-describedby="emailHelp" placeholder="Enter Tel Number..." name="phone_number">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Pin Number</label>
            <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Pin..." name="pin_number">
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox">Remember Password</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="custbtn">Login</button><hr>
          <a href="stationlogin.php?regcustomer" class="btn btn-success btn-block">Create account</a>

        </form><hr>
        <center><a href="index.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
      </div>
    </div>
    <?php } ?>










    <?php if(isset($_GET['regcustomer'])) { ?>
    <div class="card col-6 mx-auto mt-5" style="background-color: #eaf2f8!important">
      <div class="card-header text-center"><h3>Create account as a customer!</h3></div>

      <?php
      if(isset($_POST['regcustomerbtn'])) {

        function test_input($data) {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
      }

      if(preg_match('/^[0-9]{10}+$/', test_input($_POST['telno'])) && strlen($_POST['c_names'])>3) {
        $obj->register_customer_self($_POST['c_names'], $_POST['username'], $_POST['telno'], $_POST['address'], $_POST['pin_no']); ?>
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
                        <optgroup label="SOUTH">
              <option value="HUYE">HUYE</option>
              <option value="GISAGARA">GISAGARA</option>
              <option value="NYANZA">NYANZA</option>
              <option value="MUHANGA">MUHANGA</option>
              <option value="RUHANGO">RUHANGO</option>
              <option value="KAMONYI">KAMONYI</option>
              <option value="NYARUGURU">NYARUGURU</option>
              <option value="NYAMAGABE">NYAMAGABE</option>
            </optgroup>
            <optgroup label="EAST">
              <option value="GATSIBO">GATSIBO</option>
              <option value="NYAGATARE">NYAGATARE</option>
              <option value="KAYONZA">KAYONZA</option>
              <option value="RWAMAGANA">RWAMAGANA</option>
              <option value="KIREHE">KIREHE</option>
              <option value="NGOMA">NGOMA</option>
            </optgroup>
            <optgroup label="KIGALI">
              <option value="KICUKIRO">KICUKIRO</option>
              <option value="GASABO">GASABO</option>
              <option value="NYARUGENGE">NYARUGENGE</option>
            </optgroup>

          </select>
          </div>

          <div class="form-group">
            <label for="examplePin"><strong>Pin Number</strong></label>
            <input class="form-control" id="examplePin" type="text" placeholder="Pin..." name="pin_no" required/>
          </div>

          <button type="submit" class="btn btn-primary btn-block" name="regcustomerbtn">Register</button>
        </form><hr>
        <center><a href="stationlogin.php?cust" class="btn btn-warning btn-block">Customer Login</a></center>
      </div>
    </div>
    <?php } ?>













    <?php if(isset($_GET['register'])) { ?>

    <div class="card card-login mx-auto mt-5">
      <div class="card-header text-center"><h3>Create account!</h3></div>


      <?php
      if(isset($_POST['registerbtn'])) {
        if($obj->register_station_manager($_POST['username'], $_POST['email'], $_POST['telno'], $_POST['password'])) { ?>
          <div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>New Admin is registered!</strong> 
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

            <input type="hidden" value="STATION" name="username">


            <label for="exampleInputEmail1">Username</label>
            <input class="form-control" id="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
          </div>

          <div class="form-group">
            <label for="examplePhone">Phone Number</label>
            <input class="form-control" id="examplePhone" type="text" placeholder="Tel No" name="telno" required>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" id="exampleInputPassword1" type="password" placeholder="Password" name="password" required>
          </div>


          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox">Remember Password</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block" name="registerbtn">Register</button>
        </form><hr>
        <a href="?manager" class="btn btn-success btn-block">Back to Login</a><br>
        <center><a href="index.php" class="btn btn-secondary btn-block" style="width: 150px!important; ">Close</a></center>
      </div>
    </div>
    <?php } ?>










  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>