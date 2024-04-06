<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
        exit();
    }
    if(!isset($_COOKIE['msgsgroupName'])){
        header('location:profile.php');
        exit();
    }
    include 'inc/conn-db.php';
    $email = $_SESSION['user']['email'];
    $name = $_SESSION['user']['name'];
    $stm="SELECT * FROM users WHERE email ='$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();  


    if(isset($_POST['send'])){
        include 'inc/conn-db.php';
        $currentDate = date("Y-m-d");
        $currentTimestamp = time(); // Get the current timestamp
        $timeString = date("H:i:s", $currentTimestamp);
        $sendermsg = filter_var($_POST['sendmsg'],FILTER_SANITIZE_STRING);
        $groupmasgsdbName = $_COOKIE['msgsgroupName'];

        $stm="INSERT INTO $groupmasgsdbName
         (date,sendername,sendermsg,sendertime,senderemail)
          VALUES 
          ('$currentDate','$name','$sendermsg','$timeString','$email')";
        $conn->prepare($stm)->execute();   
        header('location:profilemsgs.php'); 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="./sass/profilemsgs.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fingerprintjs2/2.1.0/fingerprint2.min.js"></script>
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <title>Msg</title>
</head>
<body>
    
    <div class="contenair">
        <div class="contact-wraper">
            <div class="nav">
                <ul>
                    <li><h2 class='groupName' ><?php echo $_COOKIE['msgsgroupName']; ?></h2></li>
                    <li><a href="profile.php">لوحة التحكم</a></li>
                </ul>
                

            </div>
            <div class="contact main ">
                <div class="msg-show">
                    <?php
                        //include 'teamhelp.php';
                        include 'inc/conn-db.php';
                        $groupmasgsdbName = $_COOKIE['msgsgroupName'];
                        
                        $stmt = $conn->prepare("SELECT * FROM $groupmasgsdbName");
                        $stmt->execute();

                        $mesges = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                    ?>

                    <div class="msg-display">
                        <?php foreach($mesges as $mesge):?>
                            <div class="displayed" >
                                <p class="infos" ><span><?php echo $mesge['sendername'];?></span><span><?php echo $mesge['sendertime'];?></span> <span><?php echo $mesge['date'];?></span> </p>
                                <p><?php // echo $mesge['senderemail'];?></p>
                                <p class="msg" ><?php echo $mesge['sendermsg'];?></p>                                  

                            </div> 
                        <?php endforeach;?>                
                    </div>
                </div>
                <form action="profilemsgs.php" method="post">
                    <div class="input">
                        <input type="text" name="sendmsg" class="sen-dmsg" id="sendmsg" placeholder="Write a messge" >
                    </div>
                    <div class='btn'><button name="send"><img src="./assets/send.png" alt="" srcset=""></button></div>
                </form>
            </div>
        </div>
    </div>
    <script src="./script/profilemsgs.js"></script>
</body>
</html>