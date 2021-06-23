<?php 
include('header.php');
check_auth();
$msg="";
   $id=$_SESSION['QR_USER_ID'];
   $res=mysqli_query($con,"select * from users where id='$id'");
   if(mysqli_num_rows($res)>0){
   $row=mysqli_fetch_assoc($res);
   $name=$row['name'];
   $email=$row['email'];
   $total_qr=$row['total_qr'];
   $total_hit=$row['total_hit'];
   }else{
      redirect('user.php');
   }

if(isset($_POST['submit'])){
   $name=get_safe_value($con,$_POST['name']);
   $password=password_hash(get_safe_value($con,$_POST['password']),PASSWORD_DEFAULT);
   
      
         $password_sql="";
         if($password!=''){
            $password_sql=",password='$password'";
         }
         mysqli_query($con,"update users set name='$name' $password_sql where id='$id'");
  
   redirect('user.php');
   }



?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Profile</strong></div>
                        
                        <div class="card-body card-block">
                        <form method="post">
                           <div class="form-group"><label  class=" form-control-label">Name</label>
                           <input type="text" name="name"required placeholder="Enter your name" class="form-control" value="<?php echo $name?>"></div>
                           <div class="form-group"><label  class=" form-control-label">Email</label>
                           <input type="text" name="email" required placeholder="Email" class="form-control"  value="<?php echo $email?>"disabled></div>
                           <div class="form-group"><label  class=" form-control-label">Password</label>
                           <input type="password" name="password"  placeholder="password" class="form-control"></div>
                           <?php $getUserInfo=getUserInfo($_SESSION['QR_USER_ID']);
                               if($getUserInfo['role']==1){ 
                                 ?>
                           <div class="form-group"><label  class=" form-control-label">Total QR Codes</label>
                           <input type="text" name="total_qr" id="Total QR Codes" placeholder="Total QR codes" class="form-control"  value="<?php echo $total_qr?>"disabled></div>
                           <div class="form-group"><label  class=" form-control-label">Total QR Hits</label>
                           <input type="text" name="total_hit" id="Total QR Hits" placeholder="Total QR Hits" class="form-control"  value="<?php echo $total_hit?>"disabled></div>
                           <?php } ?>
                           <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                        </div>
                        </form>
                        <div id="result"><?php echo $msg?></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>       
<?php include('footer.php')?>
        