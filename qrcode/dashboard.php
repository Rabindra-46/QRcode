<?php 
include('header.php');
check_auth();

   $condition="";
if($_SESSION['QR_USER_ROLE']==1){
   $condition="and added_by='". $_SESSION['QR_USER_ID']."'";
}
  
   $res=mysqli_query($con,"select count(qr_traffic.qr_code_id)as total_record,qr_traffic.qr_code_id, qr_traffic.added_on_str,qr_code.name from qr_traffic,qr_code where qr_traffic.qr_code_id=qr_code.id group by qr_traffic.qr_code_id,qr_traffic.added_on_str ORDER BY `qr_traffic`.`added_on_str` ASC
   ");
   if(mysqli_num_rows($res)>0){
       while($row=mysqli_fetch_assoc($res)){
          $arr[]=$row;
       }
   }
      $totalCount=0;
      foreach($arr as $list){
         $totalCount+=$list['total_record'];
      }

   
      
   
      $resMonth=mysqli_query($con,"select date_format(added_on_str,'%b %y')as month,count(qr_code_id)as total from qr_traffic group by month(added_on_str) ORDER BY `added_on_str` ASC");
     $monthChartsStr="";
          while($rowMonth=mysqli_fetch_assoc($resMonth)){
            $monthChartsStr.="['".$rowMonth['month']."',".$rowMonth['total']."],";
           
          }
          $monthChartsStr=rtrim($monthChartsStr,",");

     
          $resWeek=mysqli_query($con,"select count(*)as total, year(added_on_str)as year,week(added_on_str,'%b')as week from qr_traffic group by week(added_on_str) ORDER BY `added_on_str` ASC");
          $weekChartsStr="";
               while($rowWeek=mysqli_fetch_assoc($resWeek)){
                 $weekChartsStr.="['".$rowWeek['week']."',".$rowWeek['total']."],";
                
               }
               $weekChartsStr=rtrim($weekChartsStr,",");
     
         

 
         
  
 ?>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.load('current', {'packages':['bar']});
      google.charts.load("current", {packages:["calendar"]});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawMonthChart);
      google.charts.setOnLoadCallback(drawWeekChart);
     
      
      function drawMonthChart() {

var data = google.visualization.arrayToDataTable([
  ['Month', 'Users'],
  <?php echo $monthChartsStr?>
  
]);
var options = {title: 'Data of QR Scanned per month'};
var chart = new google.visualization.PieChart(document.getElementById('month'));
chart.draw(data, options);
}  

   function drawChart() {
       var dataTable = new google.visualization.DataTable();
       dataTable.addColumn({ type: 'date', id: 'Date' });
       dataTable.addColumn({ type: 'number', id: 'Won/Loss' });
       dataTable.addRows([
         <?php
            $show=mysqli_query($con,"select * from qr_traffic");
            while($found=mysqli_fetch_array($show)){ 
                $qr_code_id = $found['qr_code_id'];
                $added_on_str = $found['added_on_str'];

                $sd = date_parse_from_format("Y-n-d", $added_on_str);
                $year = $sd["year"];
                $month = $sd["month"] - 1;
                $day = $sd["day"];  

                    $febs=mysqli_query($con,"SELECT COUNT(*) FROM qr_traffic WHERE added_on_str = '$added_on_str'");
                    $row = mysqli_fetch_array($febs);
                    $counts = $row[0];

        ?>

          [ new Date(<?php echo $year; ?>, <?php echo $month; ?>, <?php echo $day; ?>),  <?php echo $counts; ?> ],

        <?php } ?>
        ]);

       var chart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

       var options = {
         title: "Qr code Scanned",
         height: 350,
         calendar: {
      cellColor: {
        stroke: '#76a7fa',
        strokeOpacity: 0.5,
        strokeWidth: 1,
      }
    }
       };

       chart.draw(dataTable, options);
   }
 
  
   function drawWeekChart() {

var data = google.visualization.arrayToDataTable([
  ['week', 'total'],
  <?php echo $weekChartsStr?>
  
]);
var options = {
          chart: {
            title: 'Data of QR Scanned per week',
            subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'vertical' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('week'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

   

</script>

  
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
                    
                    <div class="col-lg-4" >
                        <div class="card" >
                            <div class="card-body">
                            <h2>Total QR Hit Count</h2>
                        <h3><?php echo $totalCount?></h3>
                        <button style=border-radius:8px;><h4  ><a  href="qr_detail.php">Details Report</a></h4></button>
                        
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                            <h2>Total User Count</h2>
                            <?php 
                           
                              $res=mysqli_query($con,"select count(*) from users where role='1'");
                           
                                  $row=mysqli_fetch_assoc($res);
                                   foreach($row as $value){
                                      echo '<h3>'.$value. '</h3>';
                                   }
                                     
                               
                            ?>
                            
                      
                        
                            </div>
                        </div>
                    </div>


                    
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                            <h2>Total QR Created</h2>
                           
                            <?php 
                           
                           $res=mysqli_query($con,"select count(id) from qr_code");
                        
                               $row=mysqli_fetch_assoc($res);
                                foreach($row as $value){
                                   echo '<h3>'.$value. '</h3>';
                                }
                                  
                            
                         ?>
                        
                            </div>
                        </div>
                    </div>
                   
                    
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" id="month">
                            
                        
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" id="week">
                            
                        
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" id="calendar_basic">
                            
                        
                            </div>
                        </div>
                    </div>
                    
                  
                  
                
		  </div>
          <?php include('footer.php')?>