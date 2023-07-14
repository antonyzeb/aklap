<?php
require_once('conn.php');
error_reporting(0);
session_start();
if(isset($_SESSION['user'])) {
  header('location: index.php');  
}
?>

 <?php 

include 'helpers/Format.php';

$fm=new Format();


header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache"); 
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
header("Cache-Control: max-age=2592000");

 $errors = array();

if($_POST) { 
	  $username = $fm->validation($_POST['user']);
	  $password = $fm->validation($_POST['pass']);
      $user = $conn->real_escape_string($username);
      $pass = $conn->real_escape_string($password);

     if(empty($user) || empty($pass)) {
          if($user == "") {
            $errors[] = "Username is required";
          } 

          if($pass == "") {
            $errors[] = "Password is required";
          }
      }else {
      	// $usermd5=md5($user);
      	$sql1 = $conn->query("SELECT username FROM tbl_user WHERE username = '$user'");
      	if ($sql1->num_rows>0) {
      		$sql = $conn->query("SELECT password FROM tbl_user WHERE username = '$user'");
            $data = $sql->fetch_assoc();
            $hash = $data['password'];
            $pass1 = password_verify($pass,$hash);
             if($pass1){
                $sesi = $conn->query("SELECT * FROM tbl_user WHERE username='$user'");
                  $value = $sesi->fetch_assoc();
                  // set session
                  $_SESSION['user'] = $value['name'];
                  $_SESSION['id'] = $value['id'];
                  header('location: index.php');

                }else{
                   $errors[] = "Incorrect password";
                }
      	}else{
      		$errors[] = "Incorrect username";
      	}

            

    }
} //tutup post
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>FIFO Apps - Login</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  		
		      <form class="form-login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

		        <h2 class="form-login-heading">Masuk Sekarang</h2>

		        <div class="login-wrap">
		        	<div class="messages">
	              <?php if($errors) {
	                foreach ($errors as $key => $value) {
	                  echo '<div class="alert alert-danger" role="alert">
	                  <i class="glyphicon glyphicon-exclamation-sign"></i>
	                  '.$value.'</div>';                    
	                  }
	                } ?>
	            </div>
		            <input type="text" class="form-control" name="user" placeholder="User ID" autofocus>
		            <br>
		            <input type="password" class="form-control" name="pass" placeholder="Password">
		            <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> Lupa Password?</a>
		
		                </span>
		            </label>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> Masuk</button>
		            <hr>
		            
		    
		
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="button">Submit</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/city-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
