<?php
include('database.php');
include('function.php');
unset($_SESSION['QR_USER_LOGIN']);
unset($_SESSION['QR_USER_ID']);
unset($_SESSION['QR_USER_NAME']);
unset($_SESSION['QR_USER_ROLE']);
redirect('login.php');

?>