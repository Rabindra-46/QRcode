<?php 
include('header.php');
check_auth();
$condition="";
if($_SESSION['QR_USER_ROLE']==1){
   $condition="and added_by='". $_SESSION['QR_USER_ID']."'";
}
if(isset($_GET['type']) && $_GET['type']=='download'){
   $link="https://chart.apis.google.com/chart?cht=qr&chs=".$_GET['chs']."&chco=".$_GET['chco']."&chl=".$_GET['chl'];
   header('Content-type: application/x-file-to-save');
   header('Content-Disposition: attachmnet;filename='.time().'.jpg');
   ob_end_clean();
   readfile($link);
}

if(isset($_GET['status'])&& $_GET['status']!='' && isset($_GET['id']) && $_GET['id']>0){
   $status=get_safe_value($con,$_GET['status']);
   $id=get_safe_value($con,$_GET['id']);
   
   if($status=="active"){
      $status=1;
   }else{
      $status=0;
      
   }
   
   mysqli_query($con,"update qr_code set status='$status' where id='$id' $condition ");
   redirect('qr_codes.php');
}
$res=mysqli_query($con,"select qr_code.*, users.email from qr_code,users where 1 and qr_code.added_by=users.id $condition order by users.added_on desc");
?>
         <div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">QR CODES </h4>
                          <button style=border-radius:8px;> <h5 class="box-title"><a href="manage_qr_codes.php">Add Qr Codes</a></h5></button>
                        </div>
                        <div class="card-body--">
                        <?php if(mysqli_num_rows($res)>0){?>
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       <th>Name</th>
                                       <th>QR Code</th>
                                       <th>link</th>
                                       <th>Added_by</th>
                                       <th>Added on</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                    $i=1;
                                    while($row=mysqli_fetch_assoc($res)){?>
                                 <tr>
                                       
                                       <td><?php echo $i++?></td>
                                       <td><?php echo $row['name']?><br/>
                                      
                                       <button style=border-radius:8px;><a href="qr_report.php?id=<?php echo $row['id']?>">Report</a></td></button>
                                       <td> 
                                       <a target="_blank" href="https://chart.apis.google.com/chart?cht=qr&chs=<?php echo $row['size']?>&chco=<?php echo $row['color']?>&chl=<?php echo $qr_file_path?>?id=<?php echo $row['id']?>">
                                       <img src="https://chart.apis.google.com/chart?cht=qr&chs=<?php echo $row['size']?>&chco=<?php echo $row['color']?>&chl=<?php echo $qr_file_path?>?id=<?php echo $row['id']?>" width="100px"/></a>
                                       
                                      
                                       <a class="nav-link" href="?type=download&url=&chs=<?php echo $row['size']?>&chco=<?php echo $row['color']?>&chl=<?php echo $qr_file_path?>?id=<?php echo $row['id']?>">
                                       <i class="fa fa-download"></i></a>
                                      
                                       </td>
                                       <td> <?php echo $row['link']?></td>
                                       <td>
                                       <?php
                                       if($_SESSION['QR_USER_ROLE']==0) {?>
                                      <b><?php echo $row['email']?></b><br/>
                                       <?php } ?>
                                       </td>
                                       <td><?php echo getCustomDate($row['added_on'])?></td>

                                       <td>
                                          <a href="manage_qr_codes.php?id=<?php echo $row['id']?>">Edit</a>
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
        