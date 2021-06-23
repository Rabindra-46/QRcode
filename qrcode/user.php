<?php 
include('header.php');
check_auth();
check_admin_auth();
if(isset($_GET['status'])&& $_GET['status']!='' && isset($_GET['id']) && $_GET['id']>0){
   $status=get_safe_value($con,$_GET['status']);
   $id=get_safe_value($con,$_GET['id']);
   
   if($status=="active"){
      $status=1;
   }else{
      $status=0;
      
   }
   
   mysqli_query($con,"update users set status='$status' where id='$id'");
   redirect('user.php');
}
$res=mysqli_query($con,"select * from users where role='1' order by added_on desc")
?>
         <div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Users </h4>
                           <button style=border-radius:8px;><h5 class="box-title"><a href="manage_user.php">Add Users</a></h5></button>
                        </div>
                        <div class="card-body--">
                        <?php if(mysqli_num_rows($res)>0){?>
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       <th>Name</th>
                                       <th>Email</th>
                                       <th>Total QR/Total used</th>
                                       <th>Total Hit/Total used</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $i=1;
                                    while($row=mysqli_fetch_assoc($res)){
                                       $getUserTotalQR=getUserTotalQR($row['id']);
                                       $totalUserQRHitListRes=getUserTotalQRHit($row['id']);
                                       ?>
                                 <tr>
                                       
                                       <td><?php echo $i++?></td>
                                       <td><?php echo $row['name']?> </td>
                                       <td> <?php echo $row['email']?></td>
                                       <td><?php echo $row['total_qr']?>/<?php echo  $getUserTotalQR['total_qr']?></td>
                                       <td><?php echo $row['total_hit']?>/<?php echo   $totalUserQRHitListRes['total_hit']?></td>
                                       <td>
                                          <a href="manage_user.php?id=<?php echo $row['id']?>">Edit</a>
                                          &nbsp;
                                         <?php 
                                         $status="active";
                                         $strStatus="deactive";
                                         if($row['status']==1){
                                            $status="deactive";
                                            $strStatus="active";
                                         }
                                         ?>
                                          <a href="?id=<?php echo $row['id']?>&status=<?php echo $status?>"><?php echo $strStatus?></a>
                                          &nbsp;
                                       </td>
                                    </tr>
                                    <?php }?>
                                 </tbody>
                              </table>
                           </div>
                           <?php }else{
                              echo"no data found";
                           }
                           ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		  </div>
          <?php include('footer.php')?>
        