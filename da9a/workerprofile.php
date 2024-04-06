<?php 
    session_start();
    if(!isset($_SESSION['worker'])){
        header('location:workerlogin.php');
        exit();
    }
    include 'inc/conn-db.php';
    $email = $_SESSION['worker']['email']; 
    $name = $_SESSION['worker']['name'];
    $group = $_SESSION['worker']['subworkergroup'];
    $companyname = $_SESSION['worker']['subworkercompanyname'];
    $jobtitle = $_SESSION['worker']['subworkerJobTitle'];
    $saley  = $_SESSION['worker']['subworkersalery'];
    $badj  = $_SESSION['worker']['subworkerbadj'];
    $currentTime = date('Y-m-d H:i:s');
    $currentDate = date('Y-m-d');
    
    $stm="SELECT * FROM $companyname WHERE subworkerEmail = '$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();
    $subworkersecondarygroup = $data['subworkersecondarygroup'];









    //___________get primery group infos __________________
    $GroupdbName = $companyname . 'Group' . $group;
    $stmt = "SELECT * FROM $GroupdbName";
    $qq = $conn->prepare($stmt);
    $qq->execute();
    $datat = $qq->fetch(PDO::FETCH_ASSOC);





    //____________daily info insert________________

    $GroupdbName = $companyname . 'Group' . $group;
    $currentDate = date('Y-m-d');
    $stmm = "SELECT * FROM $GroupdbName WHERE date = :currentDate AND workerEmail = :email";
    $qu = $conn->prepare($stmm);
    $qu->bindParam(':currentDate', $currentDate);
    $qu->bindParam(':email', $email);
    $qu->execute();

    $data = $qu->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if there is any data
    if (empty($data)) {
        // Access the 'workerState' from the first row of the result
        $stm="INSERT INTO $GroupdbName 
        (date,workerName,workerEmail,workerjobTitle,workerTimeIn,workerTimeout,workerState)
        VALUES 
        ('$currentDate','$name','$email','$jobtitle','$currentTime','not yet','not yet')";
        $conn->prepare($stm)->execute();
        header('location:workerprofile.php');
        
    } 


    //_________________check in logic____________________________________________________________
    /*if(isset($_POST['chekin'])){
        $GroupdbName = $companyname . 'group' . $group;
        $currentDate = date('Y-m-d');
        $stmm = "SELECT workerState FROM $GroupdbName WHERE date ='$currentDate' AND workerEmail ='$email' ";
        $qu = $conn->prepare($stmm);
        $qu->execute();

        $Data = $qu->fetch(PDO::FETCH_ASSOC);
        echo $Data;
        /*
            $stm="INSERT INTO $GroupdbName 
                (date,workerName,workerEmail,workerjobTitle,workerTimeIn,workerTimeout,workerState)
                VALUES 
                ('$currentDate','$name','$email','$jobtitle','$currentTime','still on work','on work')";
            $conn->prepare($stm)->execute();
            header('location:workerprofile.php');



    }*/
    if(isset($_POST['chekin'])){
        $GroupdbName = $companyname . 'Group' . $group;
        $currentDate = date('Y-m-d');
        $stmm = "SELECT * FROM $GroupdbName WHERE date = :currentDate AND workerEmail = :email";
        $qu = $conn->prepare($stmm);
        $qu->bindParam(':currentDate', $currentDate);
        $qu->bindParam(':email', $email);
        $qu->execute();

        $data = $qu->fetchAll(PDO::FETCH_ASSOC);

        // Check if there is any data
        if ($data[0]['workerState']=='Present') {
           // echo '<script>alert("you already Present")</script>';
            //header('location:workerprofile.php');
            
        }elseif($data[0]['workerState']=='on work')
        {
           // echo '<script>alert("you already in")</script>';
            header('location:workerprofile.php');
        }else{
            $stm=" UPDATE $GroupdbName SET
            `workerTimeIn`='$currentTime',
            `workerState`='on work' 
            WHERE date ='$currentDate' AND workerEmail ='$email'
        ";
            $conn->prepare($stm)->execute();
            header('location:workerprofile.php');
        }
    }


    //_________________check out logic____________________________________________________________

    /*
    if(isset($_POST['chekout'])){
        $GroupdbName = $companyname . 'group' . $group;
        $currentDate = date('Y-m-d');
        $stm=" UPDATE $GroupdbName SET
            `workerTimeout`='$currentTime',
            `workerState`='Present' 
            WHERE date ='$currentDate' AND workerEmail ='$email'
        ";
    $conn->prepare($stm)->execute();
    header('location:workerprofile.php');
    }*/
    if(isset($_POST['chekout'])){
        $GroupdbName = $companyname . 'Group' . $group;
        $currentDate = date('Y-m-d');
        $stmm = "SELECT * FROM $GroupdbName WHERE date = :currentDate AND workerEmail = :email";
        $qu = $conn->prepare($stmm);
        $qu->bindParam(':currentDate', $currentDate);
        $qu->bindParam(':email', $email);
        $qu->execute();

        $data = $qu->fetchAll(PDO::FETCH_ASSOC);

        // Check if there is any data
        if ($data[0]['workerState']=='Present') {
          //  echo '<script>alert("you already Present")</script>';
            //header('location:workerprofile.php');
            
        } else {
            if($data[0]['workerState']=='Present'){
              //  echo '<script>alert("you already out")</script>';
            }else{
                $stm=" UPDATE $GroupdbName SET
                `workerTimeout`='$currentTime',
                `workerState`='Present' 
                WHERE date ='$currentDate' AND workerEmail ='$email'
            ";
            $conn->prepare($stm)->execute();
            header('location:workerprofile.php');
            }
            
        }
    }
    //_______________________SEND MSGS_______________________________________________________
    if(isset($_POST['send'])){
        $currentDate = date("Y-m-d");
        $currentTimestamp = time(); // Get the current timestamp
        $timeString = date("H:i:s", $currentTimestamp);
        $sendermsg = filter_var($_POST['sendmsg'],FILTER_SANITIZE_STRING);
        $groupmasgsdbName = $companyname .'msgsGroup'.$group;

        $stm="INSERT INTO $groupmasgsdbName
         (date,sendername,sendermsg,sendertime,senderemail)
          VALUES 
          ('$currentDate','$name','$sendermsg','$timeString','$email')";
        $conn->prepare($stm)->execute();   
        header('location:workerprofile.php'); 
    }
    //_______________________SEND MSGS second_______________________________________________________
    if(isset($_POST['seconderymsgsend'])){
        $groupmasgsdbName =  $companyname.'msGroup'. $group.'SecondaryGroup'.$subworkersecondarygroup;
        $currentDate = date("Y-m-d");
        $currentTimestamp = time(); // Get the current timestamp
        $timeString = date('H:i:s');
        $sendermsg = filter_var($_POST['sendmsg'],FILTER_SANITIZE_STRING);

        $stm="INSERT INTO $groupmasgsdbName
         (date,sendername,sendermsg,sendertime,senderemail)
          VALUES 
          ('$currentDate','$name','$sendermsg','$timeString','$email')";
        $conn->prepare($stm)->execute();   
        header('location:workerprofile.php'); 
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="./sass/workerprofile.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fingerprintjs2/2.1.0/fingerprint2.min.js"></script>
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title><?php echo $name.' '. $companyname  ?></title>
</head>
<body>
    
    <div class="contenair">
        <nav>
            <!--<label class="nav-label" for="nav-bar"><i class="fa-solid fa-x"></i></label>
            <ul>
                <li><p><?php //echo $name  ?></p></li>
                <li><p><?php //echo $email ?></p></li>
                <li><p id="groupin" ><?php //echo $datat['Groupin'] ?> </p></li>
                <li><p id="groupout" ><?php //echo $datat['Groupout'] ?> </p></li>
                <li><p><?php //echo $companyname ?> </p><p> <?php //echo $jobtitle ?></p></li>

                
            </ul>  --> 
            <div class="puket">
                <ul class="groupleader-dash">
                    <li>
                        <p><?php 

                        if($datat['Groupbadg'] ==='circl'){
                            echo '
                            <svg width="30" height="30" viewBox="0 0 190 190" fill="red" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="95" cy="95" r="95" fill="'.$datat['Groupbadg'].'"/>
                            </svg>
                            
                            
                            
                            
                            ';
                        }?></p>
                    </li>
                    <li>
                        <p>
                        <?php 
                            if($badj==='Leader'){
                            echo '<img src="./assets/mainbadg.png"  alt=""> ';
                            }else{
                                echo 'worker';
                            }
                            
                        ?>
                        </p>
                    </li>
                    <li>
                    <?php
                        if($badj==='Leader'){
                        echo '<button class="leaderaddtaskbtn" data-group="'.$group.'">add Tssk</button>  ';
                        }
                        ?>
                    </li>
                </ul>
                
            
                <form action="workerprofile.php" class="dash-form" method="POST">
                    <button name="chekin" id='checkin' ><img class="img" src="./assets/scan.png" alt="" srcset=""></button>
                </form> 
                
                <form class="dash-form" action="workerprofile.php" method="POST">
                    <button name="chekout" ><img class="img" src="./assets/chekout.png" alt="" srcset=""></button>
                </form> 
                <a href="workerlogout.php">logout</a>  
            </div>
             
        </nav>

        <div class="dash">
            <div class="tasks">
                <h2>tasks</h2>
                <form class="tasks-form" action="workerprofile.php" method="GET">
                    <?php
                        include 'inc/conn-db.php';
                        $taskdbName = $companyname . 'Tasks';
                        $stmt = $conn->prepare("SELECT * FROM $taskdbName ");
                        $stmt->execute();
                        $allTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                        if(isset($_GET['myVariable'])){
                            $taskdbName = $companyname . 'Tasks';
                            
                            // Check if the task exists in the database
                            $stmt = $conn->prepare("SELECT * FROM $taskdbName WHERE TaskName = :TaskName");
                            $stmt->bindParam(':TaskName', $_GET['myVariable']);
                            $stmt->execute();
                            $existingTask = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                            if ($existingTask) {
                                // Update the task's state to 'done'
                                $stmt = $conn->prepare("UPDATE $taskdbName SET TaskState = 'done' WHERE TaskName = :TaskName");
                                $stmt->bindParam(':TaskName', $_GET['myVariable']);
                                $stmt->execute();
                                // Redirect to workerprofile.php
                                header('Location: workerprofile.php');
                                exit();
                            } else {
                                // Task not found in the database
                        
                                // Redirect to workerprofile.php
                                header('Location: workerprofile.php');

                            }
                        }
                        
                        
                        
                    ?>

                    <?php foreach ($allTasks as $task): ?>
                            <?php
                            // Check if the task's TaskGroup is equal to the specified $group
                            if ($task['TaskGroup'] == $group):
                            ?>
                                <div class="displayed">
                                    <div class="first-row">
                                        
                                        <p class="task"><?php echo $task['TaskName']; ?></p>
                                        <p class="TaskState"><?php echo $task['TaskState']; ?></p>
                                        
                                    </div>
                                    <div class="second-row">
                                        <p class="task"><?php echo $task['TaskDis']; ?></p>
                                        <button name="taskdone" class="taskdonebtn" data-Task="<?php echo $task['TaskName']; ?>" >done</button>
                                    </div>
                                    
                                </div>
                            <?php endif; ?>
                    <?php endforeach;?>


                    
                </form>
            </div>       
        </div>
        <div class="contact-wraper">
            <div class="bg"><img src="./assets/cibwhite.png" alt="" srcset=""></div>
            <div class="bgg"><img src="./assets/cibwhite.png" alt="" srcset=""></div>
            <div class="contact main ">
                <div class="msg-show">
                    <?php
                        //include 'teamhelp.php';
                        include 'inc/conn-db.php';
                        $groupmasgsdbName = $companyname .'msgsGroup'.$group;
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
                <form action="workerprofile.php" method="post">
                    <div class="input">
                        <input type="text" name="sendmsg" class="sen-dmsg" id="sendmsg" placeholder="Write a messge" >
                    </div>
                    <div class='btn'><button name="send"><img src="./assets/send.png" alt="" srcset=""></button></div>
                </form>
            </div>
            <?php if ($subworkersecondarygroup !='none'): ?>
            <div class="contact second show">
                <div class="msg-show">
                    <?php
                        //include 'teamhelp.php';
                        include 'inc/conn-db.php';
                        $groupmasgsdbName = $companyname.'msGroup'. $group.'SecondaryGroup'.$subworkersecondarygroup;
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

                <form action="workerprofile.php" method="post">
                    <div class="input">
                        <input type="text" name="sendmsg" class="sen-dmsg" id="sendmsg" placeholder="Write a messge" >
                    </div>
                    <div class='btn' ><button name="seconderymsgsend"><img src="./assets/send.png" alt="" srcset=""></button></button></div>
                </form>
            </div>
            <?php endif; ?>
        </div>
            <div class="navigation">
                <ul>
                    <li class="list members main-nav-label ">
                        <a href="#">
                            <span class="icon" ><img src="./assets/user.png" alt="" srcset=""></span>
                            <span class="text" >members</span>
                        </a>
                    </li>
                    
                    <li class="list message maingroup  btnformaingroup">
                        <a href="#">
                            <span class="icon" ><img src="./assets/chatbuble.png" alt="" srcset=""></span>
                            <span class="text" >messegs</span>
                        </a>
                    </li>
                    <li class=" home active">

                        <a href="#">
                            <?php
                                    $GroupdbName = $companyname . 'Group' . $group;
                                    $currentDate = date('Y-m-d');
                                    $stmm = "SELECT * FROM $GroupdbName WHERE date = :currentDate AND workerEmail = :email";
                                    $qu = $conn->prepare($stmm);
                                    $qu->bindParam(':currentDate', $currentDate);
                                    $qu->bindParam(':email', $email);
                                    $qu->execute();
                            
                                    $data = $qu->fetchAll(PDO::FETCH_ASSOC);
                            
                                    // Check if there is any data
                                    if ($data[0]['workerState']=='not yet') {
                                        echo '<span class="icon orange" data-state="you have to chekin" ><img src="./assets/scan.png" alt="" srcset=""></span>';
                                        
                                    }elseif($data[0]['workerState']=='on work'){
                                        include 'inc/conn-db.php';
                                        $taskdbName = $companyname . 'tasks';
                                        $GroupdbName = $companyname . 'Group' . $group;

                                            include 'inc/conn-db.php';
                                            $taskdbName = $companyname . 'Tasks';
                                            $stmt = $conn->prepare("SELECT * FROM $taskdbName ");
                                            $stmt->execute();
                                            $allTasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            $foundInProgressTask = false;

                                            foreach ($allTasks as $task) {
                                                if ($task['TaskState'] === 'on progress') {
                                                    $foundInProgressTask = true;
                                                    break; // Break the loop once a task with 'on progress' is found
                                                }
                                            }

                                            if ($foundInProgressTask) {
                                                echo '<span class="icon orange " data-state="you have a task"><img src="./assets/task.png" alt="" srcset=""></span>';
                                            } else {
                                                echo '<span class="icon yellow "data-state="you have to chekout" ><img src="./assets/chekout.png" alt="" srcset=""></span>';
                                            }
                                            
                                    } elseif($data[0]['workerState']=='Present'){
                                        echo '<span class="icon green" data-state="you have completed your day"><img src="./assets/done.png" alt="" srcset=""></span>';
                                    }
                                        
                                    
                                        
                                    
                             
                            ?>
                            
                        </a>
                    </li>
                    <li class="list call main-dash-label">
                        <a href="#">
                            <span class="icon" ><img src="./assets/tasks.png" alt="" srcset=""></span>
                            <span class="text" >tasks</span>
                        </a>
                    </li>
                    <li class="list setings secondgroup btnforsecondgroup">
                        <a href="#">
                            <span class="icon" ><img src="./assets/chatbuble.png" alt="" srcset=""></span>
                            <span class="text" >settings</span>
                        </a>
                    </li>
                    
                </ul>
            </div>
    </div>
    <script src="./script/workerprofile.js"></script>
</body>
</html>