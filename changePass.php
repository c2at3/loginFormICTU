<?php 
include("connect_database.php");
session_start();
function changePass($conn){
    if (isset($_POST['username']) && isset($_POST['oldPassword']) && isset($_POST['password']) && isset($_POST['re_pass'])){
        $pattern_user = '/^[A-Za-z0-9_]\w{7,25}/i';
        $pattern_pass = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,}/i';
        $username = $_POST["username"];
        $pass = $_POST["password"];
        $re_pass = $_POST["re_pass"];
        $oldPassword = $_POST["oldPassword"];
        //UPDATE `users` SET username`=[value-2],`password`=[value-3],`email`=[value-4],`date_created`=[value-5],`date_expires`=[value-6] WHERE 1
        if (preg_match($pattern_user, $username) && preg_match($pattern_pass, $pass) && ($pass === $re_pass)){
            if (md5($oldPassword) === $_SESSION['password']){
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
                    $email = $_SESSION['email'];
                    $date_created = date('Y-m-d H:i:s');
                    $date_expires = date('Y-m-d H:i:s', strtotime($date_created.' + 45 days'));
                    #echo $sql;
                    $query->execute();
                    system("python mail_changePass.py ".$email." ".$username."");
                    $path = session_save_path();
                    echo $path;
                    if (isset($_SESSION['username'])){
                        unset($_SESSION['username']); // xóa session login
                        $files = glob($path.'\*'); // get all file names
                        foreach($files as $file){ // iterate files
                            if(is_file($file))
                            #echo $file;
                            system("del ".$file.""); // delete file
                        }
                    }
                    echo '<p style="color:green;">* Password change is completed.</p><script>window.location.replace("http://localhost/ATW_login/loginForm.php");</script>';
                    
                }
            } else {
                echo '<p style="color:red;">* Old password is incorrect.</p>';
            }
        } else {
            echo '<p style="color:red;">*An error occurred, please try again later !</p>';
        }
    }
}

?>

<?php if (isset($_SESSION['username']) && $_SESSION['username']){ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Profile for
        <?php echo $_SESSION['username'];?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="home/sheet/bootstrap.css">
    <link rel="stylesheet" href="home/sheet/ionicons.min.css">
    <link rel="stylesheet" href="home/sheet/mine.css">
    <link rel="icon" href="home/img/user.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,700" rel="stylesheet">
    <script src="home/javascript/myscript.js"></script>
    <script src="assert/js/main.js"></script>
    <style>
        .form-control {
            border-radius: 0px;
            padding: 0.3rem 0.50rem;
            border: none;
            border-bottom: 1px solid #999;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 116px;">
        <form action="" method="POST" id="changePass">
            <div class="row">
                <div class="col-11 mx-auto profile">
                    <div class="py-3 px-2 px-lg-4 py-lg-5">

                        <div class="row">
                            <div class="avatarBox col-12 col-lg-5">
                                <img src="home/img/4.png" class="img-fluid">
                            </div>

                            <div class="infoBox col-12 col-lg-6 mt-2 mt-lg-0">
                                <p class="sayHi"><a href="./home.php" style="color:white">Profile</a></p>

                                <div class="name">
                                    <p><span>Welcome</span>
                                        <?php echo $_SESSION['username'];?>
                                    </p>
                                    <p class="s">Active
                                        <span class="ion-ios-checkmark-outline"></span>
                                    </p>
                                </div>
                                <hr>
                                <div class="detailInfo">
                                    <div class="row my-2">
                                        <div class="col-lg-4 col-12 boldd">Username : </div>
                                        <div class="col-lg-8 col-12 b">
                                        <input type="text" name="username" value="<?php echo $_SESSION['username'];?>" style="display:none">
                                            <?php echo $_SESSION['username'];?>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-4 col-12 boldd">Old Password :</div>
                                        <div class="col-lg-8 col-12 b">
                                            <input type="password" class="form-control" name="oldPassword" placeholder="Old password" required>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-lg-4 col-12 boldd">New password :</div>
                                        <div class="col-lg-8 col-12 b">
                                            <input type="password" class="form-control" id="password" name="password" onfocusout="CheckPassword()" placeholder="New password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,}" title="Password must be at least 8 characters, contains only latin characters, dashes and numbers. Must include at least 2 groups of characters: uppercase, lowercase letters, numbers and characters especially." required/>
                                        </div>
                                    </div>
                                    <p id="errorPass" style="font-size:12px; color:red; text-align:justify;display:none">*Password must be at least 8 characters, contains only latin characters, dashes and numbers. Must include at least 2 groups of characters: uppercase, lowercase letters, numbers and characters especially.</p>
                                    <div class="row">
                                        <div class="col-lg-4 col-12 boldd">Re-New password :</div>
                                        <div class="col-lg-8 col-12 b">
                                            <input type="password" class="form-control" id="re_pass"  name="re_pass" onfocusout="CheckRePassword()" placeholder="Repeat your password" required>
                                        </div>
                                    </div>
                                    <p id="errorRePass" style="font-size:12px; color:red; text-align:justify;display:none">*The password does not match the one entered above.</p>
                                    <?php changePass($conn); ?>
                                    <input type="submit" id="submitChange" value="Change" style="display:none">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-11 mx-auto bg-danger contact text-center" style="background: linear-gradient(to right, rgb(232 120 67), rgb(232 131 131));">
                    <div class="social col-12">
                        <a onclick="document.getElementById('submitChange').click();" ">
                            <span class="ml-lg-3" style="cursor:pointer">Change</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<?php } else{ 
	$actual_link = "http://$_SERVER[HTTP_HOST]/ATW_Login ";
	header('Location: '.$actual_link.'/loginForm.php'); }?>
<footer>
</footer>

</html>