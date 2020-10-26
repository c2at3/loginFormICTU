<?php
function register($conn){
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["re_pass"])){
        $pattern_user = '/^[A-Za-z0-9_]\w{7,25}/i';
        $pattern_pass = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{7,}/i';
        $username = $_POST["username"];
        $username = strtolower($username);
        $pass = $_POST["password"];
        $email = $_POST["email"];
        $re_pass = $_POST["re_pass"];
        $defaultUser = array('administrator', 'support', 'root', 'postmaster', 'webmaster', 'security', 'admin');
        if (preg_match($pattern_user, $username) && preg_match($pattern_pass, $pass) && ($pass === $re_pass) && !array_search($username, $defaultUser)) {
            $stmt = $conn->prepare("SELECT count(username) FROM users WHERE username='$username'");
            $stmt->execute();
            $row_count = $stmt->fetchColumn();
            if ($row_count == 0){
                $pass = md5($pass);
                $sql = "INSERT INTO `users`(`username`, `password`, `email`, `date_created`, `date_expires`) VALUES (:username, :pass, :email, :date_created, :date_expires)";
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
                echo '<p style="color:green;">*Tài khoản '.$username.' đã được kích hoạt</p>';
            } else {
                echo '<p style="color:red;">*Tài khoản '.$username.' đã tồn tại trên hệ thống !</p>';
            }
        } else {
            echo '<p style="color:red;">*Có lỗi xảy ra, vui lòng thử lại sau !</p>';
        }
    
    }
}
?>