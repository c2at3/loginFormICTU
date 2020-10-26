<?php session_start(); 

if (isset($_SESSION['username'])){
    unset($_SESSION['username']); // xóa session login
    $actual_link = "http://$_SERVER[HTTP_HOST]/ATW_Login";
    header('Location: '.$actual_link.'/loginForm.php');
}
?>