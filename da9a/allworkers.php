<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
        exit();
    }
    include 'inc/conn-db.php';
    $email = $_SESSION['user']['email'];
    $stm="SELECT * FROM users WHERE email ='$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch(); 
    $UserName=filter_var($data['companyName'],FILTER_SANITIZE_STRING);
        $stm = "SELECT * FROM $UserName";
        $q = $conn->prepare($stm);
        $q->execute();

        $rowCount = $q->rowCount();

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="./sass/index.css">

    <link rel="stylesheet" href="./sass/allworkers.css">
    <title>All worker</title>
</head>
<body>   
<a href="profile.php">Dashbord</a>

                <div class="workers-data">
                    
                    <div class="names-section">
                        <h4>workers Names </h4>
                        <div class="names">
                        <?php

                            

                                if ($rowCount > 0) {
                                    // Loop through all the fetched data
                                    while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
                                        // Access and echo the data from the second column
                                        echo '<div class="worker" data-id="'.$data[array_keys($data)[1]].' ">';
                                        echo '<span  > '. $data[array_keys($data)[1]] .' </span>';
                                        echo '<span data-id="'.$data[array_keys($data)[2]].' " > from group of  '. $data[array_keys($data)[2]] .' </span> <br>';
                                        echo '</div>';
                                    }

                                } else {
                                    echo "No workers yet.";
                                }
                            ?>                    
                        </div>

                    </div> 
                
                </div>
                -
    <script src="./script/allworkers.js"></script>
</body>
</html>