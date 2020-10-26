<?php
include("connect_database.php");
session_start();
header('Content-Type: text/html; charset=UTF-8');
    function login($conn){
        if (isset($_POST["username"]) && isset($_POST["password"])){
            $pattern_user = '/^[A-Za-z0-9_]\w{7,25}/i';
            $pattern_pass = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,}/i';
            $username = $_POST["username"];
            $username = strtolower($username);
            $pass = $_POST["password"];
            $defaultUser = array('administrator', 'support', 'root', 'postmaster', 'webmaster', 'security', 'admin');
            if (preg_match($pattern_user, $username) && preg_match($pattern_pass, $pass) || array_search($username, $defaultUser)) {
    
                $pass = md5($pass);

                $stmt = $conn->prepare("SELECT username FROM users WHERE username=:username AND password=:pass");
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":pass", $pass);
                $stmt->execute();
                $count = $stmt->rowCount();
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                if ($count) {
                    $_SESSION['username'] = $data->username;
                    echo "Xin chào " . $username . ". Bạn đã đăng nhập thành công.";
                    $actual_link = "http://$_SERVER[HTTP_HOST]/ATW_Login";
                    header('Location: '.$actual_link.'/home.php');
                    die();
                } else {
                    echo '<p style="color:red">* Tài khoản hoặc mật khẩu không chính xác.</p>';
                }
            } else {
                echo '<p style="color:red">* Tài khoản hoặc mật khẩu không chính xác.</p>';
            }
        }
        
    }
?>