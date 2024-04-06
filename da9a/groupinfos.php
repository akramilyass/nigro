<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
        exit();
    }
    include 'inc/conn-db.php';

    $groupName = $_COOKIE['groupName'];
//______workers data_____________________________________________________
    $workersCount = 0; 
    $email = $_SESSION['user']['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $companyname = $data['companyName'];
    $taskdbName = $companyname;

    $stm = $conn->prepare("SELECT * FROM $taskdbName");
    $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);


       

//___________________________tasks data_____________________________________________________
    $TasksCount = 0; 
    $stm = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stm->bindParam(':email', $email);
    $stm->execute();
    $dataa = $stm->fetch(PDO::FETCH_ASSOC);
    $dbName = $companyname.'Tasks';

    $stm = $conn->prepare("SELECT * FROM $dbName");
    $stm->execute();
    $dataa = $stm->fetchAll(PDO::FETCH_ASSOC);


//____________________add secondary Group_________________________________________________________________
if(isset($_POST['addsecondaryGroup'])){
    
    
    

    function createGroupDatabase(){
    include 'inc/conn-db.php'; 

    $email = $_SESSION['user']['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $companyname = $data['companyName'];

    $groupName = $_COOKIE['groupName'];
    // fetch data from the group


    


    $secondarygorupName = filter_var($_POST['gorupName'],FILTER_SANITIZE_STRING);
    $secondaryGroupdbName = $companyname .'Group'. $groupName.'SecondaryGroup'.$secondarygorupName;

    echo $secondaryGroupdbName ;
        
    $createTableQuery = "CREATE TABLE IF NOT EXISTS $secondaryGroupdbName (
        `id` INT NOT NULL AUTO_INCREMENT,
        `date` VARCHAR(250) NOT NULL,
        `mainGroupName` VARCHAR(250) NOT NULL,
        `GroupName` VARCHAR(250) NOT NULL,
        `Groupin` VARCHAR(250) NOT NULL,
        `Groupout` VARCHAR(250) NOT NULL,
        `mainGroupbag` VARCHAR(250) NOT NULL,
        `mainGroupcolor` VARCHAR(250) NOT NULL,
        `subGroupbag` VARCHAR(250) NOT NULL,
        `subGroupcolor` VARCHAR(250) NOT NULL,
        `workerName` VARCHAR(250) NOT NULL,
        `workerTimeIn` VARCHAR(250) NOT NULL,
        `workerTimeout` VARCHAR(250) NOT NULL,
        `workerState` VARCHAR(250) NOT NULL,
        PRIMARY KEY (`id`)
    )";
     $conn->prepare($createTableQuery)->execute();
        
        // Execute the table creation query
        if ($conn->exec($createTableQuery) !== false) {
            // Table creation was successful, check if it's the first time (no rows)
    
            $rowCountQuery = "SELECT COUNT(*) as count FROM $secondaryGroupdbName";
            $rowCount = $conn->query($rowCountQuery)->fetchColumn();
    
            if ($rowCount == 0) {
                // No rows exist, it's the first time, proceed to insert data
                $currentDate = date("Y-m-d");
                // Use prepared statements to prevent SQL injection
                $stm = $conn->prepare("INSERT INTO $secondaryGroupdbName
                 (date,mainGroupName, GroupName) VALUES (?,?, ?)");
                $stm->bindParam(1, $currentDate, PDO::PARAM_STR);
                $stm->bindParam(2, $groupName, PDO::PARAM_STR);
                $stm->bindParam(3, $secondarygorupName, PDO::PARAM_STR);
    
                // Execute the insert query
                $stm->execute();
    
                // You can return any relevant information or success status here
            } 
        } else {
            // Handle table creation failure
            echo "Table creation failed.";
        }
        
    }
    
    createGroupDatabase();
    header('location:groupinfos.php');

    function createmsgsDatabase(){
        $groupName = $_COOKIE['groupName'];
        $secondarygorupName = filter_var($_POST['gorupName'],FILTER_SANITIZE_STRING);
        $email = $_SESSION['user']['email'];
        include 'inc/conn-db.php';
        $stm="SELECT * FROM users WHERE email ='$email'";
        $q=$conn->prepare($stm);
        $q->execute();
        $data=$q->fetch(); 
        $companyName = $data['companyName'];

        $secondaryGroupdbName = $companyName.'msGroup'. $groupName.'SecondaryGroup'.$secondarygorupName;
        
        $createmsgsTableQuery = "CREATE TABLE IF NOT EXISTS $secondaryGroupdbName (
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
    header('location:groupinfos.php');

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
   
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <title>Group <?php echo $groupName ;?></title>
    <link rel="stylesheet" href="./sass/groupinfos.css">

</head>
<body>
    <input type="checkbox" name="nav-bar" id="nav-bar">
    <label class="main-nav-label" for="nav-bar"><i class="fa-solid fa-bars"></i></label>
    <header>
      <label class="nav-label" for="nav-bar"><i class="fa-solid fa-x"></i></label>
        <div class="user-info">
            <p class="users-comname" ><?php echo $companyname; ?></p>    
            <p class="users-comname" ><?php echo $groupName ;?></p>    
            
        </div>   
        <a href="profile.php">Dashbord</a> 
    </header>
    <div class="wraper">

        <form class="addgroups" action="groupinfos.php" method="POST" >
            <h3>Add secondery Group</h3>
            <div class="addgroup">
                    <label for="gorupName">Enter the group Name :</label>
                    <input type="text" id="gorupName" name="gorupName" placeholder="gorupName" required >
                  <button name="addsecondaryGroup" >Add </button>
            </div>
        </form> 
        <div class="secondery-groups">
            <div class="slider">

            
                <?php
                    //$secondarygorupName = filter_var($_POST['gorupName'],FILTER_SANITIZE_STRING);
                    $prefix = $companyname .'Group'. $groupName.'SecondaryGroup'.'%';
                    $stm = "SHOW TABLES LIKE ?";
                    $q = $conn->prepare($stm);
                    $q->execute([$prefix]);

                    $tables = $q->fetchAll(PDO::FETCH_COLUMN);

                    // Count the number of matching tables
                    $matchingTableCount = count($tables);
                    //  echo "Number Groups: $matchingTableCount<br><br><br>";

                    // Iterate through each matching table
                    foreach ($tables as $table) {
                        // Retrieve data from the 'GroupName' column for each table
                        $dataStm = "SELECT GroupName FROM $table";
                                $dataQ = $conn->prepare($dataStm);
                        $dataQ->execute();
                                        
                        // Use fetch instead of fetchAll to get only the first row
                        $rowData = $dataQ->fetch(PDO::FETCH_COLUMN);
                                        
                        // Output the 'GroupName' from the first row for each table
                    //  echo "Table: $table<br>";
                                
                        // Check if any rows were returned before echoing
                        if ($rowData !== false) {
                            echo "<div class='group secondarygroupname' data-id='{$rowData}'>";
                            echo "<p class='hi' >{$rowData}</p>";
                            echo "</div>";

                        } else {
                            echo "No data found.";
                        }
                                
                    }
                            
                ?>
            </div>
        </div> 
    
        <!---------------add secondery Groups------------------------------------------------------------->
         
        <div class="data">
                <div class="workers-count">
                
                    <?php foreach ($data as $row) :
                        // Check if the subworkergroup matches the specified $groupName
                        if ($row['subworkergroup'] == $groupName) :
                            $workersCount++;
                            $maingroupname = $companyname . 'Group' . $groupName;
                            $currentDate = date("Y-m-d");
                            // Use a prepared statement to avoid SQL injection
                            $stm = "SELECT * FROM $maingroupname WHERE workerEmail = :subworkerEmail AND date =:date";
                            $q = $conn->prepare($stm);
                            $q->bindParam(':subworkerEmail', $row['subworkerEmail']);
                            $q->bindParam(':date',  $currentDate);
                            $q->execute();
                            $dataae = $q->fetch(); // Assuming you only expect one row
                            
                            // Display data from the second query
                            ?>
                            <div class="worker" >
                                <p  ><?php echo $row['subworker']; ?>
                                    <?php if ($dataae) : ?>
                                        <span class="subworkername"><?php echo $dataae['workerState']; ?></span>
                                    <?php else : ?>
                                        <span class="subworkername">not yet</span>
                                    <?php endif; ?>
                                     
                                </p>
                            </div>
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                    <p>number of members in group <?php echo $groupName ;?> is <?php echo $workersCount  ;?></p>
                
                </div>

            <div class="tasks-count" >
                <h4>Tasks</h4>
                <?php foreach ($dataa as $row) :
                        
                        // Check if the subworkergroup matches the specified $groupName
                        if ($row['TaskGroup'] == $groupName) :
                        $TasksCount++; 
                    ?>
                        <div class="task" >
                            <p><?php echo $row['TaskName']; ?></p>
                            <p><?php echo $row['date']; ?></p>
                            <p class="TaskState" ><?php echo $row['TaskState']; ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <p>number of Tasks in group <?php echo $groupName ;?> is <?php echo $TasksCount  ;?></p>
            
            </div>            
        </div>  

        <div class="navigation">
                <ul>
                    <li class="list home active">
                        <a href="profile.php">
                            <span class="icon" ><img src="./assets/homeoutline.png" alt="" srcset=""></span>
                            
                        </a>
                    </li>
                    <div class="indecator"></div>
                </ul>
            </div>
    </div>

    <script src="./script/groupinfos.js"></script>
</body>
</html>