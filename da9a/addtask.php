<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
        exit();
    }
    include 'inc/conn-db.php';
//________creat data base forech user
    $email = $_SESSION['user']['email'];
    $stm="SELECT * FROM users WHERE email ='$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();    
    function createUserDatabase($UserName){
        include 'inc/conn-db.php';

        
        $dbName =$UserName;
        $createTableQuery= "CREATE TABLE IF NOT EXISTS $dbName (
            `id` INT NOT NULL AUTO_INCREMENT ,
            `subworker` VARCHAR(50) NOT NULL ,
            `subworkergroup` VARCHAR(50) NOT NULL ,
            `subworkercompanyname` VARCHAR(50) NOT NULL ,
            `subworkerEmail` VARCHAR(50) NOT NULL ,
            `subworkerPassword` VARCHAR(50) NOT NULL ,
            `subworkerJobTitle` VARCHAR(50) NOT NULL ,
            `subworkersalery` VARCHAR(50) NOT NULL ,
            `subworkerPhoneNumber` VARCHAR(50) NOT NULL ,
            `subworkerId` VARCHAR(50) NOT NULL ,
            
            PRIMARY KEY (`id`))";
            $conn->exec($createTableQuery);
            // Close the connection to the master database                
            // $recivednoti = $orders["Notification"];
            //  echo $orders;
                return $dbName;
                return $db; 
                return $orders; 
    }
    $UserName=filter_var($data['companyName'],FILTER_SANITIZE_STRING);
    //$$UserName = $_SESSION['user']['name'];
    $userbdName = createUserDatabase($UserName);







//______Creat a data base for Tasks foreach user_______________________________________    
    function createTaskDatabase(){
        $email = $_SESSION['user']['email'];
        include 'inc/conn-db.php';
        $stm="SELECT * FROM users WHERE email ='$email'";
        $q=$conn->prepare($stm);
        $q->execute();
        $data=$q->fetch(); 
        $companyName = $data['companyName'];

        $TaskdbName = $companyName .'Tasks';
        
        $createTableQuery = "CREATE TABLE IF NOT EXISTS $TaskdbName (
            `id` INT NOT NULL AUTO_INCREMENT,
            `date` VARCHAR(250) NOT NULL,
            `TaskName` VARCHAR(250) NOT NULL,
            `TaskDis` VARCHAR(250) NOT NULL,
            `TaskGroup` VARCHAR(250) NOT NULL,
            `TaskState` VARCHAR(250) NOT NULL,
            PRIMARY KEY (`id`)
        )";
        $conn->exec($createTableQuery);
    }
    createTaskDatabase();

//________________add Worker_____________________________________________________________________
    if(isset($_POST['addWorker'])){
        $CompanyName = $data['companyName'];
        $workerName  = filter_var($_POST['workerName'],FILTER_SANITIZE_STRING);
        $workerGroup  = filter_var($_POST['workergroup'],FILTER_SANITIZE_STRING);
        $workersalery = filter_var($_POST['workersalery'],FILTER_SANITIZE_STRING);
        $workerjobtitle = filter_var($_POST['workerjobtitle'],FILTER_SANITIZE_STRING);
        $workerpassword = filter_var($_POST['workerpassword'],FILTER_SANITIZE_STRING);
        $hashedPassword = password_hash($workerpassword, PASSWORD_DEFAULT);
        $workeremail = filter_var($_POST['workeremail'],FILTER_SANITIZE_STRING);
        $workerphone = filter_var($_POST['workerphone'],FILTER_SANITIZE_STRING);
        $stm="INSERT INTO $UserName 
            (subworker,subworkergroup,subworkercompanyname,subworkerEmail,subworkerPassword,subworkerJobTitle,subworkersalery,subworkerPhoneNumber,subworkerId)
             VALUES 
            ('$workerName','$workerGroup','$CompanyName','$workeremail','$hashedPassword','$workerjobtitle','$workersalery','$workerphone','not yet')";
        $conn->prepare($stm)->execute();
        header('location:profile.php');
        /*`workername` VARCHAR(250) NOT NULL,
        `workeremail` VARCHAR(250) NOT NULL,
        `workerpassword` VARCHAR(250) NOT NULL,
        `workerage` VARCHAR(250) NOT NULL,
        `workerjobtitle` VARCHAR(250) NOT NULL,
        `workerlate` VARCHAR(250) NOT NULL,
        `workerworktime` VARCHAR(250) NOT NULL,
        `workerchekin` VARCHAR(250) NOT NULL,
        `workerchekout` VARCHAR(250) NOT NULL,
        `workerapsent` VARCHAR(250) NOT NULL,*/
    }


//____________________add Group_________________________________________________________________
    if(isset($_POST['addGroup'])){
        
        $gorupEndingTime = filter_var($_POST['gorupEndingTime'],FILTER_SANITIZE_STRING);
        $gorupEndingTimer = filter_var($_POST['endtimer'],FILTER_SANITIZE_STRING);
        $gorupStartingTime = filter_var($_POST['gorupStartingTime'],FILTER_SANITIZE_STRING);
        $gorupStartingTimer = filter_var($_POST['starttimer'],FILTER_SANITIZE_STRING);
        $gorupName = filter_var($_POST['gorupName'],FILTER_SANITIZE_STRING);
        function createGroupDatabase($groupBdName){
            $email = $_SESSION['user']['email'];
            include 'inc/conn-db.php';
            $stm="SELECT * FROM users WHERE email ='$email'";
            $q=$conn->prepare($stm);
            $q->execute();
            $data=$q->fetch(); 
            $companyName = $data['companyName'];

            $GroupdbName = $companyName . 'Group' . $groupBdName;
            
            $createTableQuery = "CREATE TABLE IF NOT EXISTS $GroupdbName (
                `id` INT NOT NULL AUTO_INCREMENT,
                `date` VARCHAR(250) NOT NULL,
                `GroupName` VARCHAR(250) NOT NULL,
                `Groupin` VARCHAR(250) NOT NULL,
                `Groupout` VARCHAR(250) NOT NULL,
                `workerName` VARCHAR(250) NOT NULL,
                `workerTimeIn` VARCHAR(250) NOT NULL,
                `workerTimeout` VARCHAR(250) NOT NULL,
                `workerState` VARCHAR(250) NOT NULL,
                PRIMARY KEY (`id`)
            )";
        
            // Execute the table creation query
            if ($conn->exec($createTableQuery) !== false) {
                // Table creation was successful, check if it's the first time (no rows)
        
                $rowCountQuery = "SELECT COUNT(*) as count FROM $GroupdbName";
                $rowCount = $conn->query($rowCountQuery)->fetchColumn();
        
                if ($rowCount == 0) {
                    // No rows exist, it's the first time, proceed to insert data
        
                    $gorupEndingTime = filter_var($_POST['gorupEndingTime'], FILTER_SANITIZE_STRING);
                    $gorupEndingTimer = filter_var($_POST['endtimer'], FILTER_SANITIZE_STRING);
                    $gorupStartingTime = filter_var($_POST['gorupStartingTime'], FILTER_SANITIZE_STRING);
                    $gorupStartingTimer = filter_var($_POST['starttimer'], FILTER_SANITIZE_STRING);
                    $currentDate = date("Y-m-d");
                    // Use prepared statements to prevent SQL injection
                    $stm = $conn->prepare("INSERT INTO $GroupdbName (date,GroupName, Groupin, Groupout) VALUES (?,?, ?, ?)");
                    $stm->bindParam(1, $currentDate, PDO::PARAM_STR);
                    $stm->bindParam(2, $groupBdName, PDO::PARAM_STR);
                    $stm->bindParam(3, $gorupStartingTime, PDO::PARAM_STR);
                    $stm->bindParam(4, $gorupEndingTime, PDO::PARAM_STR);
        
                    // Execute the insert query
                    $stm->execute();
        
                    // You can return any relevant information or success status here
                } 
            } else {
                // Handle table creation failure
                echo "Table creation failed.";
            }
        }
        
        // Example usage
        $groupBdName = $gorupName;
        createGroupDatabase($groupBdName);

        function createmsgsDatabase(){
            $email = $_SESSION['user']['email'];
            $gorupName = filter_var($_POST['gorupName'],FILTER_SANITIZE_STRING);
            include 'inc/conn-db.php';
            $stm="SELECT * FROM users WHERE email ='$email'";
            $q=$conn->prepare($stm);
            $q->execute();
            $data=$q->fetch(); 
            $companyName = $data['companyName'];
    
            $groupmasgsdbName = $companyName .'msgsGroup'.$gorupName;
            
            $createmsgsTableQuery = "CREATE TABLE IF NOT EXISTS $groupmasgsdbName (
                `id` INT NOT NULL AUTO_INCREMENT,
                `date` VARCHAR(250) NOT NULL,
                `sendername` VARCHAR(250) NOT NULL,
                `sendermsg` VARCHAR(250) NOT NULL,
                `sendertime` VARCHAR(250) NOT NULL,
                `senderemail` VARCHAR(250) NOT NULL,
                PRIMARY KEY (`id`)
            )";
            $conn->exec($createmsgsTableQuery);
        }
        createmsgsDatabase();
        header('location:profile.php');
    }

//____________________add Task___________________________________________________
    if(isset($_POST['addTask'])){  
        include 'inc/conn-db.php';
        $stm="SELECT * FROM users WHERE email ='$email'";
        $q=$conn->prepare($stm);
        $q->execute();
        $data=$q->fetch(); 
        $companyName = $data['companyName'];
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
        header('location:profile.php');
        
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



//________________________exract data About tasks__________
    $stm="SELECT * FROM users WHERE email ='$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch(); 
    $companyName = $data['companyName'];
    $TaskdbName = $companyName .'Tasks';

    $stmt = "SELECT * FROM $TaskdbName";
    $qq = $conn->prepare($stmt);
    $qq->execute();
    $dataa = $qq->fetchAll(PDO::FETCH_ASSOC);  // Use fetchAll() to get all rows as an associative array
    $TaskCount = 0;
    foreach ($dataa as $Task) {
       // echo $Task['TaskState'];
        $TaskCount++;
    }
    
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

    <a href="profile.php">Dashbord</a>

    <div class="container">
<!---------------add Tasks------------------------------------------------------------->
        <form class="addgroups" action="addtask.php" method="POST" >
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
                             $prefix = $UserName.'Group'. '%';
                            $stm = "SHOW TABLES LIKE ?";
                            $q = $conn->prepare($stm);
                            $q->execute([$prefix]);

                            $tables = $q->fetchAll(PDO::FETCH_COLUMN);

                            // Count the number of matching tables
                            $matchingTableCount = count($tables);
                           // echo "Number Groups: $matchingTableCount<br><br><br>";
                                
                            // Iterate through each matching table
                            foreach ($tables as $table) {
                                // Get all columns from the table
                                $columnsStm = "SHOW COLUMNS FROM $table";
                                $columnsQ = $conn->prepare($columnsStm);
                                $columnsQ->execute();
                            
                                // Fetch all columns for the table
                                $allColumns = $columnsQ->fetchAll(PDO::FETCH_COLUMN);
                            
                                // Check if 'mainGroupName' column exists in the result
                                if (in_array('mainGroupName', $allColumns)) {
                                    // If 'mainGroupName' column exists, select it along with 'GroupName'
                                    $dataStm = "SELECT mainGroupName, GroupName FROM $table";
                                } else {
                                    // If 'mainGroupName' column doesn't exist, select only 'GroupName'
                                    $dataStm = "SELECT GroupName FROM $table";
                                }
                            
                                $dataQ = $conn->prepare($dataStm);
                                $dataQ->execute();
                            
                                $rowData = $dataQ->fetch(PDO::FETCH_ASSOC);
                               // $worekersecondarygroup = isset($rowData['mainGroupName']) ? $rowData['GroupName'] : 'none';
                                if ($rowData !== false) {
                                    // Check if 'mainGroupName' exists in the result
                                

                                    if (isset($rowData['mainGroupName'])) {
                                        $G = $rowData['mainGroupName'];
                                        // Display both 'mainGroupName' and 'GroupName' in the option
                                        $groupname = $rowData['GroupName'];
                                      //  echo "<option class='group " . $rowData['mainGroupName'] . " " . $groupname . "' data-value='$groupname' value='$G' > " . $rowData['mainGroupName'] . " - " . $groupname . "</option>";
                                    } else {
                                        // Display only 'GroupName' in the option
                                        $G = $rowData['GroupName'];
                                        echo "<option class='group' value='{$G}' > " . $rowData['GroupName'] . "</option>";
                                    }
                                } else {
                                    echo "No data found for table $table.<br>";
                                }
                            
                                echo "<br>";
                            }
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













