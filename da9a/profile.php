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
            `subworkersecondarygroup` VARCHAR(50) NOT NULL ,
            `subworkermsgroupbd` VARCHAR(50) NOT NULL ,
            `subworkersecondarymsggroupbd` VARCHAR(50) NOT NULL ,
            `subworkercompanyname` VARCHAR(50) NOT NULL ,
            `subworkerEmail` VARCHAR(50) NOT NULL ,
            `subworkerPassword` VARCHAR(50) NOT NULL ,
            `subworkerJobTitle` VARCHAR(50) NOT NULL ,
            `subworkersalery` VARCHAR(50) NOT NULL ,
            `subworkerPhoneNumber` VARCHAR(50) NOT NULL ,
            `subworkerId` VARCHAR(50) NOT NULL ,
            `subworkerbadj` VARCHAR(50) NOT NULL ,
            `subworkersubbadj` VARCHAR(50) NOT NULL ,
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







//______Creat a data base for Tasks foreach user _______________________________________    
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



//______Creat a data base for Groups foreach user _______________________________________    
function createGroupDatabase(){
    $email = $_SESSION['user']['email'];
    include 'inc/conn-db.php';
    $stm="SELECT * FROM users WHERE email ='$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch(); 
    $companyName = $data['companyName'];

    $GroupdbName = $companyName .'AllGroup';
    
    $createTableQuery = "CREATE TABLE IF NOT EXISTS $GroupdbName (
        `id` INT NOT NULL AUTO_INCREMENT,
        `date` VARCHAR(250) NOT NULL,
        `GroupName` VARCHAR(250) NOT NULL,
        PRIMARY KEY (`id`)
    )";
    $conn->exec($createTableQuery);
}
createGroupDatabase();
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

    $currentDate = date("Y-m-d");
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
                `workerEmail` VARCHAR(250) NOT NULL,
                `workerjobTitle` VARCHAR(250) NOT NULL,
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
      /* $stm = "SELECT * FROM users WHERE email = :email"; // Use a parameterized query to prevent SQL injection
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
        }*/
    



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
    //-handl delet worker
    if (isset($_GET['delete'])) {
        $companyName = $data['companyName'];
        $workerId = $_GET['delete'];
        $stm = "DELETE FROM $companyName WHERE id = '$workerId'";
        $conn->prepare($stm)->execute();
        header('location:profile.php');
    }
    //-handl delet task
    if (isset($_GET['deletetask'])) {
        $companyNametask = $data['companyName'].'Tasks';
        $taskId = $_GET['deletetask'];
        $stm = "DELETE FROM $companyNametask WHERE id = '$taskId'";
        $conn->prepare($stm)->execute();
        header('location:profile.php');
    }
?>

                






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./sass/profile.css">
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <title>PROFILE</title>
</head>
<body>
    <input type="checkbox" name="nav-bar" id="nav-bar">
    <label class="main-nav-label" for="nav-bar"><i class="fa-solid fa-bars"></i></label>
    <header >
       
        <div class="user-info">
            <p class="user-name" ><?php echo $_SESSION['user']['name']; ?></p>
            <p class="users-email" ><?php echo $_SESSION['user']['email']; ?></p>
            <p class="users-comname" ><?php echo $data['companyName']; ?></p>    
                          
        </div>
        <a href="logout.php">Logout</a> 
    </header>
    <div class="wraper">
        <div class="logo"><img src="./assets/logowhite.png" alt="" srcset=""></div>
        <div class="dashbord">
            <div class="dash-header">
                <div class="info-display">
                    <p class="info-title"></p>
                    <h1 class="info-data">HI</h1>
                </div>
                
                <div class="count">
                    
                    <div class="countgroups">
                        <img src="./assets/chart.png" alt="" srcset="">
                        <p>Groups</p>
                        
                        <p class="groupnumber span"><?php
                            $companyGroupBd = $UserName .'AllGroup';
                            $stmt = "SELECT * FROM  $companyGroupBd ";
                            $qq = $conn->prepare($stmt);
                            $qq->execute();
                            $tables = $qq->fetchAll(PDO::FETCH_COLUMN);
                            // Count the number of matching tables
                            $matchingTableCount = count($tables);
                            echo $matchingTableCount;

                        ?></p>
                     
                    </div>
                    <div class="workers-count">
                        <img src="./assets/userr.png" alt="" srcset="">
                        <p>Members</p>  
                        <p class="workernumber span" ><?php
                            $stm = "SELECT * FROM $UserName";
                            $q = $conn->prepare($stm);
                            $q->execute();

                            $rowCount = $q->rowCount(); // Get the number of rows

                            echo '<span >'. $rowCount.'</span>';

                            
                        ?></p>
                    </div>
                    <div class="tasks-count ">
                        <img src="./assets/star.png" alt="" srcset="">
                        <p>Tasks</p>
                        <p class="tasknumber span"><?php echo $TaskCount ; ?></p>
                        
                    </div>
                </div>
            </div>

            
            <div class="nav show " >
                <div class="nav-section">
                    <div class="buttons">
                        <button class='addmemberbtn' ><img src="./assets/plus.png" alt="" srcset="">add member</button>
                        <button class='addgroupbtn'><img src="./assets/box.png" alt="" srcset="">add group</button>
                        <button class='addtaskbtn' ><img src="./assets/bord.png" alt="" srcset="">add task</button>  
                        <button><img src="./assets/badg.png" alt="" srcset="">add badg</button>
                        <button class='delletworker'><img src="./assets/x.png" alt="" srcset="">delete worker</button>
                        <button ><img src="./assets/msg.png" alt="" srcset="">messges</button>  
                        <button><img src="./assets/heart.png" alt="" srcset="">favorate</button>
                        <button><img src="./assets/magic.png" alt="" srcset="">add leader</button>            
                    </div>

                </div>    
                <div class="groups-section">
                    <div class="slider">
                        <?php
                            $prefix = $UserName.'Group'. '%';
                            $stm = "SHOW TABLES LIKE ?";
                            $q = $conn->prepare($stm);
                            $q->execute([$prefix]);

                            $tables = $q->fetchAll(PDO::FETCH_COLUMN);

                            // Count the number of matching tables
                            $matchingTableCount = count($tables);
                            //  echo "Number Groups: $matchingTableCount<br><br><br>";

                            // Iterate through each matching table
                            foreach ($tables as $table) {
                                // Check if the table has a column named 'mainGroupName'
                                $checkColumnStm = "SHOW COLUMNS FROM $table LIKE 'mainGroupName'";
                                $checkColumnQ = $conn->prepare($checkColumnStm);
                                $checkColumnQ->execute();
                                $columnExists = $checkColumnQ->fetch(PDO::FETCH_COLUMN);
                            
                                if ($columnExists) {
                                    // The table has 'mainGroupName' column, skip the rest of the code
                                    continue;
                                }
                                $dataStm = "SELECT * FROM $table";
                                $dataQ = $conn->prepare($dataStm);
                                $dataQ->execute();

                                // Fetch the first row from the initial query
                                $rowData = $dataQ->fetch(PDO::FETCH_ASSOC);

                                if ($rowData) {
                                    // Assuming $UserName is a variable with a specific value
                                    $userbdname = $UserName;
                                    $groupName = $rowData["GroupName"];

                                    //__count workers

                                    // Query the second table using parameters
                                    $secondTableStm = "SELECT * FROM $userbdname WHERE subworkergroup = :groupName";
                                    $secondTableQ = $conn->prepare($secondTableStm);
                                    $secondTableQ->bindParam(':groupName', $groupName);
                                    $secondTableQ->execute();

                                    // Get the number of rows found in the second query
                                    $rowCount = $secondTableQ->rowCount();



                                    //__count tasks not done 
                                    $tasksbdname = $UserName.'Tasks';
                                    $taskTableStm = "SELECT TaskState FROM $tasksbdname WHERE TaskGroup = :groupName ";
                                    $taskTableQ = $conn->prepare($taskTableStm);
                                    $taskTableQ->bindParam(':groupName', $groupName);
                                    $taskTableQ->execute();

                                    // Get the number of rows found in the second query
                                    $taskdonecount=0;
                                    $tasknotdonecount=0;
                                    while ($row = $taskTableQ->fetch(PDO::FETCH_ASSOC)) {
                                        $taskState = $row['TaskState'];
                                    
                                        if ($taskState === 'done') {
                                            $taskdonecount++;
                                        } elseif ($taskState === 'on progress') {
                                            $tasknotdonecount++;
                                        }
                                    }
                                    // Output the 'GroupName' from the first row for each table
                                    echo "<div class='group groupname' data-id='{$groupName}'>";
                                   
                                        // Output the count of rows from the second table
                                        echo "<p class='workernum' >$rowCount</p>";
                                        echo "<p class='hi'>{$groupName}</p>";
                                            echo "<div class='t' >";
                                                echo "<div class='tt' >";
                                                    echo "<p class='taskdonenum' >/$taskdonecount</p>";
                                                    echo "<p class='tasknotdonenum' > $tasknotdonecount</p>";
                                                echo "</div>";
                                                echo "<div class='persentage' >";
                                                    if ($tasknotdonecount > 0) {
                                                        $completionPercentage = $taskdonecount / ($taskdonecount + $tasknotdonecount) * 100;
                                                        echo "<p >";
                                                            echo round($completionPercentage, 2) . "%";
                                                        echo "</p>";

                                                        echo "<p class='ruler' >";
                                                        echo "<span class='ruler-fill' >";
                                                            echo round($completionPercentage, 2) . "%";

                                                        echo "</span>";
                                                        echo "</p>";
                                                    } else {
                                                        echo "<p >"; // Handle the case where there are no tasks (all tasks are done).
                                                            echo "100%"; 
                                                        echo "</p>"; 
                                                        echo "<p class='ruler' >";
                                                        echo "<span class='ruler-fill' >";                                                
                                                            echo "100%"; 
                                                        echo "</span>";
                                                        echo "</p>"; 
                                                    }
                                                echo "</div>";
                                            echo "</div>";
                                            
                                            
                                        
                                    echo "</div>";
                                } else {
                                    echo "No data found.";
                                }

                            
                            
                            }
                            
                    
                        ?>  
                    </div>
                
                </div>
            </div>
            <div class="taskswraper hide">
                <div class="tasks">
                        <h3>Tasks</h3>
                        <?php
                            //___________________________tasks data_____________________________________________________
                            $companyname = $data['companyName'];
                            $dbName = $companyname.'Tasks';

                            $stmaaaaa = $conn->prepare("SELECT * FROM $dbName");
                            $stmaaaaa->execute();
                            $dataa = $stmaaaaa->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($dataa as $row) {
                            
                            // Check if the subworkergroup matches the specified $groupName
                        ?>
                        <div class="task" >
                            <p><?php echo $row['TaskName']; ?></p>
                                    
                            <p class="TaskState" ><?php echo $row['TaskState']; ?></p>
                            <p class="date" ><?php echo $row['date']; ?></p>
                            <a class="a" href="profile.php?deletetask=<?php echo $row['id'] ;?>" class="deleteButton"><img src="./assets/xw.png" alt="" srcset=""> </a>
                        </div>
                        <?php }?>
                </div>
            </div>
            <div class="workerswraper hide">
                <div class="workers-data">  
                    <div class="names-section">
                        <div class="names">
                            <?php
                            $stm = "SELECT * FROM $UserName";
                            $q = $conn->prepare($stm);
                            $q->execute();

                            $rowCount = $q->rowCount();
                                if ($rowCount > 0) {
                                    // Loop through all the fetched data
                                    while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
                                        // Access and echo the data from the second column
                                       echo'<div class="worker" data-id="'.$data[array_keys($data)[7]].' ">' ;
                                    
                                            echo '<p class="worker-name" > '. $data[array_keys($data)[1]] .' </p>';
                                            
                                            echo '<p class="worker-job" > '. $data[array_keys($data)[9]] .' </p>';
                                        echo'</div>' ;
                                    }
                                } else {
                                    echo "No workers yet.";
                                }
                            ?>                    
                        </div>

                    </div> 
                
                </div>
            </div>                  
            <div class="workerdelletswraper hide">
                <div class="workers-data">  
                    <div class="names-section">
                        <div class="names">
                            <?php
                            $stm = "SELECT * FROM $UserName";
                            $q = $conn->prepare($stm);
                            $q->execute();

                            $rowCount = $q->rowCount();
                                if ($rowCount > 0) {
                                    // Loop through all the fetched data
                                    while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
                                        // Access and echo the data from the second column
                                       echo'<div  data-id="'.$data[array_keys($data)[0]].' ">' ;
                                    
                                            echo '<p class="worker-name" > '. $data[array_keys($data)[1]] .' </p>';
                                            
                                            echo '<p class="worker-job" > '. $data[array_keys($data)[9]] .' </p>';
                                            echo '<a class="a" href="profile.php?delete=' . $data[array_keys($data)[0]] . '" class="deleteButton"><img src="./assets/x.png" alt="" srcset=""> </a>';
                                            
                                        echo'</div>' ;
                                    }
                                } else {
                                    echo "No workers yet.";
                                }
                            ?>                    
                        </div>

                    </div> 
                
                </div>
            </div>
            <div class="msgs hide">
                <div class="div">
                    <?php
                      include 'inc/conn-db.php';
                               $prefix = $companyName . 'msg';
                               $query = "SHOW TABLES LIKE :prefix";
                               $stmt = $conn->prepare($query);
                               $stmt->bindValue(':prefix', $prefix . '%', PDO::PARAM_STR);
                               $stmt->execute();
                           
                               $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
                           
                               foreach ($result as $tableName) {
                                    
                                   // Retrieve data from each table
                                   $selectQuery = "SELECT * FROM $tableName";
                                   $selectStmt = $conn->prepare($selectQuery);
                                   $selectStmt->execute();
                                   $tableData = $selectStmt->fetchAll(PDO::FETCH_ASSOC);
                                    echo "<p class='groupName' data-groupname='".$tableName."' >".$tableName."</p>" ;
                                   // Process or display the data as needed
                                   
                               }
                    ?> 
                </div>
                
            </div>
            <div class="navigation">
                <ul>
                    <li class="list members ">
                        <a href="#">
                            <span class="icon" ><img src="./assets/user.png" alt="" srcset=""></span>
                            <span class="text" >members</span>
                        </a>
                    </li>
                    
                    <li class="list msgbtn">
                        <a href="#">
                            <span class="icon" ><img src="./assets/chatbuble.png" alt="" srcset=""></span>
                            <span class="text" >messegs</span>
                        </a>
                    </li>
                    <li class="list home active">
                        <a href="#">
                            <span class="icon" ><img src="./assets/homeoutline.png" alt="" srcset=""></span>
                            <span class="text" >Home</span>
                        </a>
                    </li>
                    <li class="list call">
                        <a href="#">
                            <span class="icon" ><img src="./assets/tasks.png" alt="" srcset=""></span>
                            <span class="text" >tasks</span>
                        </a>
                    </li>
                    <li class="list setings">
                        <a href="#">
                            <span class="icon" ><img src="./assets/settingsoutline.png" alt="" srcset=""></span>
                            <span class="text" >settings</span>
                        </a>
                    </li>
                    <div class="indecator"></div>
                </ul>
            </div>
            
        </div>  
    </div>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/ScrollTrigger.min.js"></script>
    <script src="./script/profile.js"></script>
</body>
</html>













