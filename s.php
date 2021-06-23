<?php
include('qrcode/database.php');
include('qrcode/function.php');
include('lib/BrowserDetection.php');
include('lib/Mobile_detect.php');


if(isset($_GET['id']) && $_GET['id']>0){
    $id=get_safe_value($con,$_GET['id']);
    $res=mysqli_query($con,"select added_by,link from qr_code where id='$id' and status='1'");
    if(mysqli_num_rows($res)>0){
        $row=mysqli_fetch_assoc($res);
        $link=$row['link'];
        $added_by=$row['added_by'];
        $getUserInfo=getUserInfo($added_by);
        if($getUserInfo['total_hit']!=0){
        $totalUserQRHitListRes=getUserTotalQRHit($added_by);
        if($getUserInfo['total_hit']<($totalUserQRHitListRes['total_hit']+1)){
            die('something went wrong');
        }
        }
        $device="";
        $os="";
        $detect= new Mobile_detect();
        $browserObj=new Wolfcast\BrowserDetection;
        $browser=$browserObj->getName();

        if($detect->isMobile()){
            $device="Mobile";
        }elseif($detect->isTablet()){
            $device="Tablet";
        }else{
            $device="PC";
        }
        if($detect->isiOS()){
            $os="iOS";
        }elseif($detect->isAndroidOS()){
            $os="AndroidOS";
        }else{
            $os="Window";
        }

        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $result=curl_exec($ch);
        curl_close($ch);
        $result=json_decode($result,true);
        $city=$result['city'];
        $state=$result['regionName'];
        $country=$result['country'];
        $ip_address=$result['query'];
        $added_on=date('Y-m-d h:i:s');
        $added_on_str=date('Y-m-d');
        mysqli_query($con,"insert into qr_traffic(qr_code_id,device,os,browser,city,state,country,added_on,ip_address,added_on_str)
        values('$id','$device','$os','$browser','$city','$state','$country','$added_on','$ip_address','$added_on_str')");
        redirect($link);
    }else{
        die('something went wrong');
    }
}

?>