<?php
include('database.php');
include('function.php');
$msg='';
if(isset($_SESSION['QR_USER_LOGIN'])){
   redirect('qr_codes.php');
}
if(isset($_POST['submit'])){
	$email=get_safe_value($con,$_POST['email']);
	$password=get_safe_value($con,$_POST['password']);
    $res=mysqli_query($con,"select*from users where email='$email'");
    if(mysqli_num_rows($res)>0){
       $row=mysqli_fetch_assoc($res);
       $status=$row['status'];
       if($status==0){
          $msg="Account deactivated";
       }else{
         $db_password=$row['password'];
         if(password_verify($password,$db_password)){
            $_SESSION['QR_USER_LOGIN']=true;
            $_SESSION['QR_USER_ID']=$row['id'];
            $_SESSION['QR_USER_NAME']=$row['name'];
            $_SESSION['QR_USER_ROLE']=$row['role'];
            redirect('profile.php');
         }else{
             $msg="enter corrrect password please";
         }

       }
    }else{
       $msg="please enter valid login details";
	}
	
}
?>
<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <body class="bg-dark">
            <div class="container">
            
            <div class="sufee-login d-flex align-content-center flex-wrap">
           
            <div class="login-content">
            <div class="login-form mt-120">
            <h3 style=color:green;text-align:center>Lazy Typing and Browsing Scan Me<h3>
            <img src="images/b.jpeg">
                      <form method="post">
                     <div class="form-group">
                       <b><label>Email</label></b>
                     <input type="text" name="email" class="form-control" placeholder="email" required>
                     </div>
                     <div class="form-group">
                     <b><label>Password</label></b>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                     </div>
                     <button type="submit" name="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
					</form>
					<div class="field_error"><?php echo $msg?></div>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>