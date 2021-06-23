<?php 
include('header.php');
check_auth();

   $condition="";
if($_SESSION['QR_USER_ROLE']==1){
   $condition="and added_by='". $_SESSION['QR_USER_ID']."'";
}
  
   $res=mysqli_query($con,"select count(qr_traffic.qr_code_id)as total_record,qr_traffic.qr_code_id, qr_traffic.added_on_str,qr_code.name from qr_traffic,qr_code where qr_traffic.qr_code_id=qr_code.id group by qr_traffic.qr_code_id,qr_traffic.added_on_str ORDER BY `qr_traffic`.`added_on_str` ASC");
   if(mysqli_num_rows($res)>0){
       while($row=mysqli_fetch_assoc($res)){
          $arr[]=$row;
       }
   }
   
         
  
 ?>
 
  
 <div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card" >
                        <div class="card-body">
                           <h4 class="box-title">QR Report </h4>
                           
                        </div>
                        <div class="card-body--">
                        
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
        
        <div class="content">
            <div class="animated fadeIn">
            <div class="row">
                    
                    
                  
                  
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                             
                        <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       
                                     
                                       
                                       <th>Date</th>
                                       <th>Qr_code Name</th>
                                       <th>Qr_code ID</th>
                                       <th>TotalCount</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                   $i=1;
                                   foreach($arr as $data){?>
                                 <tr>
                                     <td><?php echo $i++?></td> 
                                     
                                     <td><?php echo $data['added_on_str']?></td>
                                     <td><?php echo $data['name']?></td>
                                     <td><?php echo $data['qr_code_id']?></td>   
                                     <td><?php echo $data['total_record']?></td> 
                                     
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