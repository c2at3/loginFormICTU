<?php session_start(); 
$path = session_save_path();
echo $path;
if (isset($_SESSION['username'])){
    unset($_SESSION['username']); // xóa session login
    $files = glob($path.'\*'); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file))
            echo $file;
            system("del ".$file.""); // delete file
    }
    $actual_link = "http://$_SERVER[HTTP_HOST]/ATW_Login";
    header('Location: '.$actual_link.'/loginForm.php');
}
?>