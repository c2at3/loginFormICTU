<?php 

include("connect_database.php");
include("register.php");
include("login.php");
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// foreach ($result as $row) {
//     echo $row['password'] . '<br>';
//     echo $row['username'] . '<br>';
//     echo $row['email'] . '<br>';
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="home/img/user.png">
    <title>Sign up</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="assert/fonts/material-icon/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assert/css/style.css">
    <!-- Main css -->
    <script src="assert/vendor/jquery/jquery.min.js"></script>
    <script src="assert/js/main.js"></script>
</head>
<body>

    <div class="main">
        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="index.php" method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" onfocusout="CheckUsername()" placeholder="Username" pattern="^[A-Za-z0-9_]\w{8,25}" title="The username must be at least 8-25 characters, containing only latin characters, dashes, and numbers. The first character must be a letter and must not match special usernames such as: administrator, support, root, postmaster, webmaster, security,…." required/>
                            </div>
                            <p id="errorUser" style="font-size:12px; color:red; text-align:justify;display:none">*The username must be at least 8-25 characters, containing only latin characters, dashes, and numbers. The first character must be a letter and must not match special usernames such as: administrator, support, root, postmaster, webmaster, security,….</p>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="password" onfocusout="CheckPassword()" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Password must be at least 8 characters, contains only latin characters, dashes and numbers. Must include at least 2 groups of characters: uppercase, lowercase letters, numbers and characters especially." required/>
                            </div>
                            <p id="errorPass" style="font-size:12px; color:red; text-align:justify;display:none">*Password must be at least 8 characters, contains only latin characters, dashes and numbers. Must include at least 2 groups of characters: uppercase, lowercase letters, numbers and characters especially.</p>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" onfocusout="CheckRePassword()" placeholder="Repeat your password"/>
                            </div>
                            <p id="errorRePass" style="font-size:12px; color:red; text-align:justify;display:none">*The password does not match the one entered above.</p>
                            <!--<div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                            </div>-->
                            <?php register($conn); ?>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" onmouseover="CheckAll()" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="assert/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="./loginForm.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>
