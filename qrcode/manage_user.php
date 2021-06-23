<?php 
include('header.php');
check_auth();
check_admin_auth();
$msg="";
$name="";
$email="";
$password="";
$total_qr="";
$total_hit="";
$id=0;
$password_required="required";
if(isset($_GET['id'])&& $_GET['id']>0){
   $id=get_safe_value($con,$_GET['id']);
   $res=mysqli_query($con,"select * from users where id='$id'");
   if(mysqli_num_rows($res)>0){
   $row=mysqli_fetch_assoc($res);
   $name=$row['name'];
   $email=$row['email'];
   $password=$row['password'];
   $total_qr=$row['total_qr'];
   $total_hit=$row['total_hit'];
   $password_required="";
   }else{
      redirect('user.php');
   }
}
if(isset($_POST['submit'])){
   $name=get_safe_value($con,$_POST['name']);
   $email=get_safe_value($con,$_POST['email']);
   $password=password_hash(get_safe_value($con,$_POST['password']),PASSWORD_DEFAULT);
   $total_qr=get_safe_value($con,$_POST['total_qr']);
   $total_hit=get_safe_value($con,$_POST['total_hit']);
   $role=1;
   $status=1;
   $added_on=date('Y-m-d h:i:s');
   $email_sql="";
   if($id>0){
      $email_sql=" and id!='$id'";
   }
   if(mysqli_num_rows(mysqli_query($con,"select * from users where email='$email' $email_sql"))>0){
      $msg="email id used";
   }else{
      if($id>0){
         $password_sql="";
         if($password!=''){
            $password_sql=",password='$password'";
         }
         mysqli_query($con,"update users set name='$name',email='$email',total_qr='$total_qr',total_hit='$total_hit'$password_sql where id='$id'");
      }else{
         mysqli_query($con,"insert into users(name,email,password,total_qr,total_hit,role,status,added_on)
         values('$name','$email','$password','$total_qr','$total_hit','$role','$status','$added_on')");
      }
  
   redirect('user.php');
   }
}


?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Manage User</strong></div>
                        
                        <div class="card-body card-block">
                        <form method="post">
                           <div class="form-group"><label  class=" form-control-label">Name</label>
                           <input type="text" name="name"required placeholder="Enter your name" class="form-control" value="<?php echo $name?>"></div>
                           <div class="form-group"><label  class=" form-control-label">Email</label>
                           <input type="text" name="email" required placeholder="Email" class="form-control"  value="<?php echo $email?>"></div>
                           <div class="form-group"><label  class=" form-control-label">Password</label>
                           <input type="password" name="password"  placeholder="password" class="form-control <?php echo $password_required?>"></div>
                           <div class="form-group"><label  class=" form-control-label">Total QR Codes</label>
                           <input type="text" name="total_qr" id="Total QR Codes" placeholder="Total QR codes" class="form-control"  value="<?php echo $total_qr?>"></div>
                           <div class="form-group"><label  class=" form-control-label">Total QR Hits</label>
                           <input type="text" name="total_hit" id="Total QR Hits" placeholder="Total QR Hits" class="form-control"  value="<?php echo $total_hit?>"></div>
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
        