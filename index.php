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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GT App</title>
  <link rel="shortcut icon" href="icon/GAS10.jpg">
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/animate.css">
  <link href="css/prettyPhoto.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet" />
</head>

<body>
  <header>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse.collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand">
              <a href="#"><h1><span>GAS DELIVERY</span> Information managment system</h1></a>
            </div>
          </div>

          <div class="navbar-collapse collapse">
            <div class="menu">
              <ul class="nav nav-tabs" role="tablist">
                
                <li role="presentation"><a href="stationlogin.php?manager" class="active"><span class="glyphicon glyphicon-book"></span>&nbsp;Manager Login</a></li>
                <li role="presentation"><a href="stationlogin.php?agent" class="active"><span class="glyphicon glyphicon-book"></span>&nbsp;Agent Login</a></li>

                <li role="presentation"><a href="stationlogin.php?cust" class="active"><span class="glyphicon glyphicon-book"></span>&nbsp;Customer</a></li>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <section id="main-slider" class="no-margin">
    <div class="carousel slide">
      <div class="carousel-inner">
        <div class="item active" style="background-image:url(images/1.jpg)">
          <div class="container">
            <div class="row slide-margin">
              <div class="col-sm-6">
                <div class="carousel-content">
                  <h2 class="animation animated-item-1">Welcome <span>on GAS DELIVERY SYSTEM </span></h2>
                  <p class="animation animated-item-2">You can send a submit and receive your Gas whenever and wherever you want.</p>
                </div>
              </div>

              <div class="col-sm-6 hidden-xs animation animated-item-4">
                <div class="slider-img">
          <img src="images/2.png" class="img-responsive">
                </div>
              </div>

            </div>
          </div>
        </div>
        <!--/.item-->
      </div>
      <!--/.carousel-inner-->
    </div>
    <!--/.carousel-->
  </section>
  
  <!-- Modal-->
  <div class="modal fade" id="addPage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="request.php" method="post">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel">SUBMIT</h4>
      </div>
      <div class="modal-body">
      
      <div class="form-group row">
        <label for="inputPage" class="col-sm-4 col-form-label" style="color:#000000;">Confirmation Number</label>
        <div class="col-sm-12">
        <input name="customer_name" type="text" class="form-control" id="inputPage" placeholder="Enter Phone Number" required>
        </div>
      </div>
      
    </div><!--The End-->
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <input type="submit" class="btn btn-primary" value="Submit " name="submit">
      </div>
      </form>
    </div>
    </div>
  </div>
  <!-- addPage-->

  <footer>
    <div class="footer">
      <div class="container">

        <div class="col-md-4 col-md-offset-4">
          <div class="copyright">
            <center>Copyright 2024  &copy; Gas Delivery System</center>
          </div>
        </div>
      </div>

      <div class="pull-right">
        <a href="#home" class="scrollup"><i class="fa fa-angle-up fa-3x"></i></a>
      </div>
    </div>
  </footer>


  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="js/jquery-2.1.1.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.prettyPhoto.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/functions.js"></script>

</body>

</html>
