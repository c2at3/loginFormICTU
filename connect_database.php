<?php 
    $hostName = 'localhost';
    $dbName = 'atw_login';
    $userName = 'root';
    $password = '';
    
    $conn = new PDO("mysql:host=$hostName;dbname=$dbName", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>