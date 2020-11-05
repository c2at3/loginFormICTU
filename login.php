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

                $stmt = $conn->prepare("SELECT username, email, date_created, date_expires, password FROM users WHERE username=:username AND password=:pass");
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":pass", $pass);
                $stmt->execute();
                $count = $stmt->rowCount();
                $data = $stmt->fetch(PDO::FETCH_OBJ);
                
                $username =  $data->username;
                $password = $data->password;
                $date_created = $data->date_created;
                $date_expires = $data->date_expires;
                $secs = strtotime($date_expires) - strtotime(date('Y-m-d'));
                $days = (int)($secs / 86400);
                if ($days <= 37){
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    echo '<p style="color:red">* Ôi bạn ơi, mật khẩu của bạn lỗi thời quá rồi, <a href="changePass.php">Đổi ngay</a> đi nhé. Mình tức mà mình nói Tiếng Việt luôn á !
                    <br>Hoặc <a href="loginForm.php">Quay lại</a> trang đăng nhập nhá. OK?</p>';
                    die();
                }
                if ($count) {
                    $_SESSION['username'] = $username;
                    #$_SESSION['password'] = $password;
                    $_SESSION['email'] = $data->email;
                    $_SESSION['date_created'] = $data->date_created;
                    $_SESSION['date_expires'] = $date_expires;
                    $_SESSION['passTime'] = $days;
                    $actual_link = "http://$_SERVER[HTTP_HOST]/ATW_Login";
                    header('Location: '.$actual_link.'/home.php');
                    die();
                } else {
                    echo '<p style="color:red">* Username or password is incorrect.</p>';
                }
            } else {
                echo '<p style="color:red">* Username or password is incorrect.</p>';
            }
        }
        
    }
?>