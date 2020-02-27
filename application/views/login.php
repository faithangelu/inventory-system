<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url(); ?>assets/themes/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/themes/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/themes/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
    <div class="login-logo d-flex justify-content-center">
      <a href="<?php echo base_url('auth'); ?>"><b></b></a>
      <img src="<?php echo base_url(); ?>/assets/images/logo.png"/>
    </div>     
      <div class="card-body">   
        <span class="text-danger" ><?php echo validation_errors(); ?>  </span>

        <span class="text-danger" ><?php if(!empty($errors)) {
          echo $errors;
        } ?>     </span>
        <form action="<?php echo base_url('auth/login') ?>" method="post">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="register.html">Register an Account</a>
          <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/themes/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/themes/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/themes/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
