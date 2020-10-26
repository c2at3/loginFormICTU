<?php 
include("connect_database.php");

function randFileName($len = 32){
    $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                .'0123456789!@#$%^&*()');
    shuffle($seed);
    $rand = '';
    foreach (array_rand($seed, $len) as $k) $rand .= $seed[$k];
        return $rand; 
    }

    function hashRandFileName($str){
        return sha1($str);
    }
    
    function addPHPextension($str){
        return $str.'.php';
    }
#http://localhost/ATW_Login/resetPass/af2ee0eb6b40b0488e251e125afb618be57ca518.php?email=tranbaquang001@gmail.com&username=quang99mt
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot password</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="assert/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="assert/css/style.css">
</head>
<body>

    <div class="main">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="assert/images/signup-image.jpg" alt="sing up image"></figure>
                </div>
                    <div class="signin-form">
                    <h2 class="form-title">Password retrieval</h2>
                        <form action="" method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="text" name="username" id="your_pass" placeholder="Username need to reset password"/>
                            </div>
                            <?php
                                if (isset($_POST['username'])){
                                    $pattern_user = '/^[A-Za-z0-9_]\w{7,25}/i';
                                    $username = strtolower($_POST['username']);
                                    if (preg_match($pattern_user, $username)){
                                        echo "<p style='color:green'>A new password has been sent to your email. Please check in your mailbox.</p>";
                                        $username = $_POST['username'];
                                        $stmt = $conn->prepare("SELECT count(username) FROM users WHERE username='$username'");
                                        $stmt->execute();
                                        $row_count = $stmt->fetchColumn();
                                        if ($row_count > 0){
                                            $stmt = $conn->prepare("SELECT username, email FROM users WHERE username=:username");
                                            $stmt->bindParam(':username', $username);
                                            $stmt->execute();
                                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($data as $row) {                    
                                            $file = addPHPextension(hashRandFileName(randFileName(64)));
                                            $uri = "http://$_SERVER[HTTP_HOST]/resetPass/".$file."?username=".$row['username']."&email=".$row['email']."";
                                            $uri = base64_encode($uri);
                                            #echo $uri;
                                            system("type This_I5_Fi13_t3xt_4_re56t_20455w0rd.txt > resetPass/".$file."");
                                            system("python test.py ".$row['username']." ".$file." ".$uri."");
                                            }
                                        }
                                    }
                                }
                            ?>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Send"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="assert/vendor/jquery/jquery.min.js"></script>
    <script src="assert/js/main.js"></script>
</body>
</html>