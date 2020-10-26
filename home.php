<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <?php 
        if (isset($_SESSION['username']) && $_SESSION['username']){
            echo 'Bạn đã đăng nhập với tên là '.$_SESSION['username']."<br/>";
            echo 'Click vào đây để <a href="logout.php">Logout</a>';
        }
        else{
            $actual_link = "http://$_SERVER[HTTP_HOST]/ATW_Login";
            header('Location: '.$actual_link.'/loginForm.php');
        }
        ?>
    </body>
</html>