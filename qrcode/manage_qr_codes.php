<?php 
include('header.php');
check_auth();

$msg="";
$name="";
$link="";
$color="";
$size="";
$id=0;
$condition="";
$isAdmin='yes';
if($_SESSION['QR_USER_ROLE']==1){
   $condition="and added_by='". $_SESSION['QR_USER_ID']."'";
   $getUserInfo=getUserInfo($_SESSION['QR_USER_ID']);
   $getUserTotalQR=getUserTotalQR($_SESSION['QR_USER_ID']);
   $isAdmin='no';
}
$password_required="required";
if(isset($_GET['id'])&& $_GET['id']>0){
   $id=get_safe_value($con,$_GET['id']);
   $res=mysqli_query($con,"select * from qr_code where id='$id' $condition");
   if(mysqli_num_rows($res)>0){
   $row=mysqli_fetch_assoc($res);
   $name=$row['name'];
   $link=$row['link'];
   $color=$row['color'];
   $size=$row['size'];
   
   }else{
      redirect('user.php');
   }
}
if(isset($_POST['submit'])){
   $name=get_safe_value($con,$_POST['name']);
   $link=get_safe_value($con,$_POST['link']);
   $color=get_safe_value($con,$_POST['color']);
   $size=get_safe_value($con,$_POST['size']);
   $added_by=$_SESSION['QR_USER_ID'];
   $status=1;
   $added_on=date('Y-m-d h:i:s');
  
   if($id>0){
      
      mysqli_query($con,"update qr_code set name='$name',link='$link',color='$color',size='$size' where id='$id' $condition");
   }else{
      mysqli_query($con,"insert into qr_code(name,link,color,size,added_by,status,added_on)
      values('$name','$link','$color','$size','$added_by','$status','$added_on')");
   }

redirect('qr_codes.php');
     
   }



?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Manage QR</strong></div>
                        <div class="card-body card-block">
                        <form method="post">
                           <div class="form-group"><label  class=" form-control-label">Name</label>
                           <input type="text" name="name" placeholder="Enter your name" class="form-control" required value="<?php echo $name?>"></div>
                           <div class="form-group"><label  class=" form-control-label">Link</label>
                           <input type="text" name="link"  placeholder="link" class="form-control" required value="<?php echo $link?>"></div>
                           <div class="form-group"><label  class=" form-control-label">Color</label>
                           <select name="color" required class=" form-control">
                           <option value="">select color</option>
                           <?php
                           $colorSql=mysqli_query($con,"select * from color where status=1 order by color asc");
                           while($colorRow=mysqli_fetch_assoc($colorSql)){
                              $is_selected="";
                              if($colorRow['color']==$color){
                                 $is_selected="selected";
                              }
                              echo '<option value="'.$colorRow['color'].'" '.$is_selected.'>'.$colorRow['color'].'</option>';
                           }
                           ?>
                           </select>
                           <div class="form-group"><label  class=" form-control-label">Size</label>
                           <select name="size" required class=" form-control">
                           <option value="">select size</option>
                           <?php
                           $sizeSql=mysqli_query($con,"select * from size where status=1 order by size asc");
                           while($sizeRow=mysqli_fetch_assoc($sizeSql)){
                              $is_selected="";
                              if($sizeRow['size']==$size){
                                 $is_selected="selected";
                              }
                              echo '<option value="'.$sizeRow['size'].'" '.$is_selected.'>'.$sizeRow['size'].'</option>';
                           }
                           ?>
                           </select>
                           </br>
                           <?php 
                           if($id==0 && $isAdmin=='no'){
                              if($getUserInfo['total_qr']>$getUserTotalQR['total_qr']){
                                 ?>
                                 <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                           <?php
                           }else{
                              echo "<span style=color:red;>QR  code Limit Completed</span>";
                           }
                           }else{
                              ?>
                             
                              <button id="payment-button" type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                           <span id="payment-button-amount">Submit</span>
                           </button>
                           <?php
                           }
                           ?>
                           
                        </div>
                        </form>
                        <div id="result"><?php echo $msg?></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>       
<?php include('footer.php')?>
        