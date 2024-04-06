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
    $taskbdname = $UserName .'Tasks';

    $stm = "SELECT * FROM $taskbdname";
    $q = $conn->prepare($stm);
    $q->execute();

    $dataa = $q->fetchAll(PDO::FETCH_ASSOC);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./sass/alltasks.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <link rel="manifest" href="manifest.json">
    <title>All tasks</title>
</head>
<body>   
<a class="dash" href="profile.php">Dashbord</a>

                <div class="workers-tasks">
                    
                    <div class="names-section">
                        <h4>tasks Names </h4>
                        <div class="names">
                        <?php
                            foreach ($dataa as $task) {

                                echo "<p>" . $task['TaskName'] . " ";
                                echo "" . $task['date'] . " ";
                                echo "" . $task['TaskGroup'] . " ";
                                echo "<span class='taskk' >" . $task['TaskState'] . "</span></p> ";
                                // You can echo other task details as needed
                            }
                        ?>                    
                        </div>

                    </div> 
                
                </div>
                
            <script>
                var TaskStates = document.querySelectorAll('.taskk');

                TaskStates.forEach(function(TaskState) {
                let TaskStateValue = TaskState.textContent;
                if(TaskStateValue=='done'){
                    TaskState.style.color="green";
                }else if(TaskStateValue=='on progress'){
                    TaskState.style.color="red"
                }
                });

            </script>        
</body>
</html>