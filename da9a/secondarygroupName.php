<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
        exit();
    }
    $groupName = $_COOKIE['secondarygroupName'];


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group <?php echo $groupName ;?></title>
</head>
<body>
<header>
        <p>User name : <?php echo $_SESSION['user']['name']; ?></p>
        <p class="users-email" > user Email : <?php echo $_SESSION['user']['email']; ?></p>  
        <p class="users-comname" >Group <?php echo $groupName ;?></p>    
        <a href="profile.php">Dash bord</a>   
</header>
</body>
</html>