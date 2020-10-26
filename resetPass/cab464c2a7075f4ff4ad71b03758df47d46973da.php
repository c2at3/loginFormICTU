<?php 
include("../connect_database.php");

function getFile(){
    #echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $uri = "$_SERVER[REQUEST_URI]";
    $arrURI = preg_split ("/\//", $uri);
    $count = count($arrURI) -1;
    $file = "$arrURI[$count]";
    $file = substr($file,0, 44);
    echo "$file";
    return $file;
}

function resetPass($conn){
    if (isset($_GET['username']) && isset($_GET['email'])){
        if (isset($_POST['password']) && isset($_POST['re_pass'])){
            $pattern_user = '/^[A-Za-z0-9_]\w{7,25}/i';
            $pattern_pass = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,}/i';
            $username = $_GET["username"];
            $pass = $_POST["password"];
            $re_pass = $_POST["re_pass"];
            $email = $_GET["email"];
            //UPDATE `users` SET username`=[value-2],`password`=[value-3],`email`=[value-4],`date_created`=[value-5],`date_expires`=[value-6] WHERE 1
            if (preg_match($pattern_user, $username) && preg_match($pattern_pass, $pass) && ($pass === $re_pass)){
                $stmt = $conn->prepare("SELECT count(username) FROM users WHERE username='$username'");
                    $stmt->execute();
                    $row_count = $stmt->fetchColumn();
                    if ($row_count > 0){
                        $pass = md5($pass);
                        $sql = "UPDATE `users` SET username=:username, password=:pass, email=:email, date_created=:date_created, date_expires=:date_expires WHERE username=:username";
                        $query = $conn->prepare($sql);
                        $query->bindParam(':username', $username);
                        $query->bindParam(':pass', $pass);
                        $query->bindParam(':email', $email);
                        $query->bindParam(':date_created', $date_created);
                        $query->bindParam(':date_expires', $date_expires);
                        $date_created = date('Y-m-d H:i:s');
                        $date_expires = date('Y-m-d H:i:s', strtotime($date_created.' + 45 days'));
                        #echo $sql;
                        $query->execute();
                        echo '<p style="color:green;">* Password change is completed.</p>';
                        system("del ".getFile()."");
                    } else {
                        echo '<p style="color:red;">* An error occurred, please try again later !</p>';
                    }
            } else {
                    echo '<p style="color:red;">* An error occurred, please try again later !</p>';
            }
        }
    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reset password</title>
        <link rel="stylesheet" href="../assert/fonts/material-icon/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="../assert/css/style.css">
        <script src="../assert/vendor/jquery/jquery.min.js"></script>
        <script src="../assert/js/main.js"></script>
</head>
<body>
    <div class="main">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="../assert/images/signup-image.jpg" alt="sing up image"></figure>
                    </div>
                    <div class="signin-form">
                        <h2 class="form-title">Reset password</h2>
                        <form action="" method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="username" onfocusout="CheckUsername()" value="<?php if(isset($_GET["username"])){echo $_GET["username"];}else{echo "?";}?>" placeholder="Username" pattern="^[A-Za-z0-9_]\w{8,25}" title="The username must be at least 8-25 characters, containing only latin characters, dashes, and numbers. The first character must be a letter and must not match special usernames such as: administrator, support, root, postmaster, webmaster, security,…." disabled/>
                            </div>
                            <p id="errorUser" style="font-size:12px; color:red; text-align:justify;display:none">*The username must be at least 8-25 characters, containing only latin characters, dashes, and numbers. The first character must be a letter and must not match special usernames such as: administrator, support, root, postmaster, webmaster, security,….</p>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/ value="<?php if(isset($_GET["email"])){echo $_GET["email"];}else{echo "?";}?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" onfocusout="CheckPassword()" id="password" placeholder="New password" placeholder="Password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Password must be at least 8 characters, contains only latin characters, dashes and numbers. Must include at least 2 groups of characters: uppercase, lowercase letters, numbers and characters especially." required/>
                            </div>
                            <p id="errorPass" style="font-size:12px; color:red; text-align:justify;display:none">*Password must be at least 8 characters, contains only latin characters, dashes and numbers. Must include at least 2 groups of characters: uppercase, lowercase letters, numbers and characters especially.</p>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="re_pass" onfocusout="CheckRePassword()" id="re_pass" placeholder="Confirm password" required/>
                            </div>
                            <p id="errorRePass" style="font-size:12px; color:red; text-align:justify;display:none">*The password does not match the one entered above.</p>
                            <?php resetPass($conn); ?>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" onmouseover="CheckAll()" class="form-submit" value="Send"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>