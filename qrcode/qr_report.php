<?php 
include('header.php');
check_auth();

if(isset($_GET['id']) && $_GET['id']>0){
   $condition="";
if($_SESSION['QR_USER_ROLE']==1){
   $condition="and added_by='". $_SESSION['QR_USER_ID']."'";
}
   $id=get_safe_value($con,$_GET['id']);
   $res=mysqli_query($con,"select count(*)as total_record,qr_traffic.*,qr_code.name from qr_traffic,qr_code 
   where qr_traffic.qr_code_id=qr_code.id and qr_code.id='$id' $condition group by qr_traffic.added_on_str");
   if(mysqli_num_rows($res)>0){
       while($row=mysqli_fetch_assoc($res)){
          $arr[]=$row;
       }
   }else{
      redirect('qr_codes.php');
   }
   $totalCount=0;
   foreach($arr as $list){
      $totalCount+=$list['total_record'];
   }
   $resDevice=mysqli_query($con,"select count(*)as total_record,device from qr_traffic
   where qr_code_id='$id' group by qr_traffic.device");
  $deviceChartsStr="";
       while($rowDevice=mysqli_fetch_assoc($resDevice)){
         $deviceChartsStr.="['".$rowDevice['device']."',".$rowDevice['total_record']."],";
        
       }
       $deviceChartsStr=rtrim($deviceChartsStr,",");

       $resOS=mysqli_query($con,"select count(*)as total_record,os from qr_traffic
   where qr_code_id='$id' group by qr_traffic.os");
  $osChartsStr="";
       while($rowOS=mysqli_fetch_assoc($resOS)){
         $osChartsStr.="['".$rowOS['os']."',".$rowOS['total_record']."],";
        
       }
       $osChartsStr=rtrim($osChartsStr,",");
   
       $resBrowser=mysqli_query($con,"select count(*)as total_record,browser from qr_traffic
   where qr_code_id='$id' group by qr_traffic.browser");
  $browserChartsStr="";
       while($rowBrowser=mysqli_fetch_assoc($resBrowser)){
         $browserChartsStr.="['".$rowBrowser['browser']."',".$rowBrowser['total_record']."],";
        
       }
       $browserChartsStr=rtrim($browserChartsStr,",");
   
   
   }
   
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawDeviceChart);
      google.charts.setOnLoadCallback(drawOSChart);
      google.charts.setOnLoadCallback(drawBrowserChart);
      function drawDeviceChart() {

var data = google.visualization.arrayToDataTable([
  ['Device', 'Users'],
  <?php echo $deviceChartsStr?>
  
]);
var options = {title: 'Devices'};
var chart = new google.visualization.PieChart(document.getElementById('device'));
chart.draw(data, options);
}

function drawOSChart() {

var data = google.visualization.arrayToDataTable([
  ['OS', 'Users'],
  <?php echo $osChartsStr?>
]);
var options = {title: 'OS'};
var chart = new google.visualization.PieChart(document.getElementById('os'));
chart.draw(data, options);
}

function drawBrowserChart() {

var data = google.visualization.arrayToDataTable([
  ['Browser', 'Users'],
  <?php echo $browserChartsStr?>
]);
var options = {title: 'Browser'};
var chart = new google.visualization.PieChart(document.getElementById('browser'));
chart.draw(data, options);
}


</script>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
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

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                            <h2>Total Count</h2>
                        <h3><?php echo $totalCount?></h3>
                        <button style=border-radius:8px;><h4><a href="qr_detail_report.php?id=<?php echo $id?>">Details Report</a></h4></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" id="device">
                              
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" id="os">
                              
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" id="browser">
                             
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                             
                        <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <th class="serial">#</th>
                                       
                                       <th>QR Code</th>
                                       
                                       <th>Date</th>
                                       <th>Count</th>
                                       
                                    </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                   $i=1;
                                   foreach($arr as $data){?>
                                 <tr>
                                     <td><?php echo $i++?></td> 
                                     <td><?php echo $data['name']?></td> 
                                     <td><?php echo $data['added_on_str']?></td>
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