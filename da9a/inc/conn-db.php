<?php
$dbHost="localhost";
$dbUser="root";
$dbPass="";
$dbName="mememoir";
try{
    //$conn= new PDO("mysql:host=$dbHost;dbname=$dbName",$dbUser,$dbPass);
    //$conn=mysqli_connect($dbHost,$dbName,$dbPass,$dbUser);
   // echo "success";

    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

