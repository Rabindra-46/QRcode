<?php
$pwd="admin";
echo password_hash($pwd,PASSWORD_DEFAULT);
?>
select count(*)as total, year(added_on_str)as year,week(added_on_str,'%b')as week from qr_traffic group by week(added_on_str) ORDER BY `added_on_str` ASC
select year(added_on_str)as year,week(added_on_str,'%b')as week,count(qr_code_id)as total from qr_traffic group by week(added_on_str) ORDER BY `added_on_str` ASC