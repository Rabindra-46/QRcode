<?php 
include('header.php');
check_auth();

if(isset($_GET['id']) && $_GET['id']>0){
   $condition="";
if($_SESSION['QR_USER_ROLE']==1){
   $condition="and added_by='". $_SESSION['QR_USER_ID']."'";
}
   $id=get_safe_value($con,$_GET['id']);
   $res=mysqli_query($con,"select qr_traffic.*,qr_code.name from qr_traffic,qr_code 
   where qr_traffic.qr_code_id=qr_code.id and qr_code.id='$id' $condition");
   if(mysqli_num_rows($res)>0){
       while($row=mysqli_fetch_assoc($res)){
          $arr[]=$row;
       }
   }else{
      redirect('qr_codes.php');
   }
}
   ?>
         <div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">QR Report </h4>
                           <button style=border-radius:8px;><h4><a href="qr_report.php?id=<?php echo $id?>" class="box-title">Back</h4></button>
                        </div>
                        <div class="card-body--">
                        
                           </div>
                        </div>
                     </div>
                  </div>
               </div> 
               <div class="orders">
               <div class="row">
                  <div class="col-12">
                     <div class="card">
                        <div class="card-body" id="">
                        <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                            
                                       
                                       <th>Device</th>
                                       <th>OS</th>
                                       <th>Browser</th>
                                       <th>City</th>
                                       <th>State</th>
                                       <th>Country</th>
                                       <th>ip_address</th>
                                       
                                       
                                    </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                   $i=1;
                                   foreach($arr as $data){?>
                                 <tr>
                                     <td><?php echo $i++?></td> 
                                     <td><?php echo $data['device']?></td> 
                                     <td><?php echo $data['os']?></td>
                                     <td><?php echo $data['browser']?></td>
                                     <td><?php echo $data['city']?></td>
                                     <td><?php echo $data['state']?></td>
                                     <td><?php echo $data['country']?></td>
                                     <td><?php echo $data['ip_address']?></td>
                                     
                                    </tr>
                                   <?php }?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        </div>
                     </div>
                  </div>
               </div>
               </div>
		  </div>
          <?php include('footer.php')?>
        