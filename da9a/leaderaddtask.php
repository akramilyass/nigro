<?php
    session_start();
    if(!isset($_SESSION['worker'])){
        header('location:login.php');
        exit();
    }
    include 'inc/conn-db.php';

    $email = $_SESSION['worker']['email']; 
    $name = $_SESSION['worker']['name'];
    $group = $_SESSION['worker']['subworkergroup'];
    $companyName = $_SESSION['worker']['subworkercompanyname'];
    $jobtitle = $_SESSION['worker']['subworkerJobTitle'];
    $saley  = $_SESSION['worker']['subworkersalery'];
    $badj  = $_SESSION['worker']['subworkerbadj'];
    $currentTime = date('Y-m-d H:i:s');
    $currentDate = date('Y-m-d');
    
    $stm="SELECT * FROM $companyName WHERE subworkerEmail = '$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();
    $subworkersecondarygroup = $data['subworkersecondarygroup'];
//____________________add Task___________________________________________________
    if(isset($_POST['addTask'])){  
        include 'inc/conn-db.php';
        $TaskdbName = $companyName .'Tasks';

        $taskName = filter_var($_POST['taskName'],FILTER_SANITIZE_STRING);
        $taskDis = filter_var($_POST['taskDis'],FILTER_SANITIZE_STRING);
        $taskGroup = filter_var($_POST['taskGroup'],FILTER_SANITIZE_STRING);
        $currentDate = date("Y-m-d");
        // Use prepared statements to prevent SQL injection
        $stm = $conn->prepare("INSERT INTO $TaskdbName (date,TaskName,TaskDis,TaskGroup,TaskState) VALUES (?,?,?,?,'on progress')");
        $stm->bindParam(1, $currentDate, PDO::PARAM_STR);
        $stm->bindParam(2, $taskName, PDO::PARAM_STR);
        $stm->bindParam(3, $taskDis, PDO::PARAM_STR);
        $stm->bindParam(4, $taskGroup, PDO::PARAM_STR);
        
        // Execute the insert query
        $stm->execute();
        
        // You can return any relevant information or success status here
        
        // Example usage*/
        header('location:workerprofile.php');
        
    }

//____________________exract how data about all workers _________________________________________________________________
    /*   $stm = "SELECT * FROM users WHERE email = :email"; // Use a parameterized query to prevent SQL injection
        $q = $conn->prepare($stm);
        $q->bindParam(':email', $email); // Bind the email parameter
        $q->execute();

        $data = $q->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
        
        if ($data) {
            // Loop through the columns and count them
            $columnCount = 0;

            foreach ($data as $columnName => $columnValue) {
                echo "Column Name: $columnName, Value: $columnValue<br>";
                $columnCount++;
            }

            echo "Total Columns: $columnCount";
        } else {
            echo "No data found for the given email.";
        }
    */



?>

                






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./sass/addgroup.css">
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <title>add task</title>
</head>
<body>

    <a href="workerprofile.php">profile</a>

    <div class="container">
<!---------------add Tasks------------------------------------------------------------->
        <form class="addgroups" action="leaderaddtask.php" method="POST" >
            <div class="addtask">
                <h3>Add Task</h3>
                <div>
                    <label for="taskName">Enter the Task Name :</label>
                    <input type="text" id="taskName" name="taskName" placeholder="taskName" required >
                </div>
                <div>
                    <label for="taskDis">Enter the Task Discrebtion :</label>
                    <input type="text" id="taskDis" name="taskDis" placeholder="taskDis" required >
                </div>
                <div>
                    <label for="taskGroup">Task for Group</label>
                    <select name="taskGroup" id="taskGroup">
                    <?php
                        echo "<option class='group' value='".$_GET['myGroup']."' > " . $_GET['myGroup'] . "</option>";
                    ?>
                    </select>
                </div>
            </div>
            <button name="addTask" >Add Task</button>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/ScrollTrigger.min.js"></script>
    <script src="./script/profile.js"></script>
</body>
</html>













