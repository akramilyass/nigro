
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
    
    $errors=[];
    if(isset($_POST['addWorker'])){
        $workeremail = filter_var($_POST['workeremail'],FILTER_SANITIZE_STRING);
        $stm="SELECT subworkerEmail FROM $UserName WHERE subworkerEmail ='$workeremail'";
        $q=$conn->prepare($stm);
        $q->execute();
        $data=$q->fetch();

        if($data){
            $errors[]="البريد الاكترونى موجود بالفعل";
        }else{
            $email = $_SESSION['user']['email'];
            include 'inc/conn-db.php';
            $stm="SELECT * FROM users WHERE email ='$email'";
            $q=$conn->prepare($stm);
            $q->execute();
            $datas=$q->fetch(); 
            $CompanyName = $datas['companyName'];
            $workerName  = filter_var($_POST['workerName'],FILTER_SANITIZE_STRING);
            $workerGroup  = filter_var($_POST['workergroup'],FILTER_SANITIZE_STRING);
            $workersalery = filter_var($_POST['workersalery'],FILTER_SANITIZE_STRING);
            $workerjobtitle = filter_var($_POST['workerjobtitle'],FILTER_SANITIZE_STRING);
            $workerpassword = filter_var($_POST['workerpassword'],FILTER_SANITIZE_STRING);
            $hashedPassword = password_hash($workerpassword, PASSWORD_DEFAULT);
            $workeremail = filter_var($_POST['workeremail'],FILTER_SANITIZE_STRING);
            $workerphone = filter_var($_POST['workerphone'],FILTER_SANITIZE_STRING);
            if(isset($_COOKIE['secondarygroupName'])){
                $worekersecondarygroup = $_COOKIE['secondarygroupName'];
                $stm="INSERT INTO $UserName 
                (subworker,subworkergroup,subworkersecondarygroup,subworkermsgroupbd,subworkersecondarymsggroupbd,subworkercompanyname,subworkerEmail,subworkerPassword,subworkerJobTitle,subworkersalery,subworkerPhoneNumber,subworkerId,subworkerbadj,subworkersubbadj)
                VALUES 
                ('$workerName','$workerGroup','$worekersecondarygroup','subworkermsgroupbd','subworkersecondarymsggroupbd','$CompanyName','$workeremail','$workerpassword','$workerjobtitle','$workersalery','$workerphone','not yet','worker','not yet')";
                $conn->prepare($stm)->execute();
                header('location:profile.php');
            }else{
            $stm="INSERT INTO $UserName 
                (subworker,subworkergroup,subworkersecondarygroup,subworkermsgroupbd,subworkersecondarymsggroupbd,subworkercompanyname,subworkerEmail,subworkerPassword,subworkerJobTitle,subworkersalery,subworkerPhoneNumber,subworkerId,subworkerbadj,subworkersubbadj)
                VALUES 
                ('$workerName','$workerGroup','none','subworkermsgroupbd','subworkersecondarymsggroupbd','$CompanyName','$workeremail','$workerpassword','$workerjobtitle','$workersalery','$workerphone','not yet','worker','worker')";
                $conn->prepare($stm)->execute();
                header('location:profile.php'); 
            }
        }

        
        
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
    <title>Add member</title>
</head>
<body>
<a href="profile.php">Dashbord</a>
    <div class="container">
<!---------------add Workers------------------------------------------------------------->
        <form class="addgroups" action="addworker.php" method="POST" >
            <div class="addWorker">
                <h3>Add worker</h3>
                <div>
                    <label for="workerName">Enter the worker Name :</label>
                    <input type="text" id="workerName" name="workerName" placeholder="workerName" value="<?php if(isset($_POST['workerName'])){echo $_POST['workerName'];} ?>" required >
                </div>

                <div>
                    <label for="workerphone">Enter the worker phone number  :</label>
                    <input type="number" id="workerphone" name="workerphone" value="<?php if(isset($_POST['workerphone'])){echo $_POST['workerphone'];} ?>" placeholder="workerphone" required >
                </div>

                <div>
                    <label for="workeremail" class='<?php  if(!empty($errors)){echo"red";}?>'>Enter the worker email  :</label>
                    <input type="text" id="workeremail" name="workeremail" value="<?php if(isset($_POST['workeremail'])){echo $_POST['workeremail'];} ?>" placeholder="workeremail" required >
                </div>
                <div>
                    <label for="workerpassword">Enter the worker password  :</label>
                    <input type="password" id="workerpassword" name="workerpassword" value="<?php if(isset($_POST['workerpassword'])){echo $_POST['workerpassword'];} ?>" placeholder="workerpassword" required >
                </div>

                <div>
                    <label for="workerjobtitle">Enter the worker job title  :</label>
                    <input type="text" id="workerjobtitle" name="workerjobtitle" value="<?php if(isset($_POST['workerjobtitle'])){echo $_POST['workerjobtitle'];} ?>"  placeholder="workerjobtitle" required >
                </div>
<!--
                <div>
                    <label for="workersalery">Enter the worker salery  :</label>
                    <input type="number" id="workersalery" name="workersalery" placeholder="workersalery" required >
                    <select name="currency" id="currency">
                        <option value="AM">AED</option>
                        <option value="PM">USD</option>
                        <option value="PM">EURO</option>
                        <option value="PM">DA</option>
                    </select>
                </div>-->
                <div>
                    <label for="workergroup">Enter the worker group  :</label>
                    <select name="workergroup" id="workergroup">
                    <?php
                        
                            $prefix = $UserName.'Group'. '%';
                            $stm = "SHOW TABLES LIKE ?";
                            $q = $conn->prepare($stm);
                            $q->execute([$prefix]);

                            $tables = $q->fetchAll(PDO::FETCH_COLUMN);

                            // Count the number of matching tables
                            $matchingTableCount = count($tables);
                            echo "Number Groups: $matchingTableCount<br><br><br>";
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
                                        echo "<option class='group " . $rowData['mainGroupName'] . " " . $groupname . "' data-value='$groupname' value='$G' > " . $rowData['mainGroupName'] . " - " . $groupname . "</option>";
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
                        <?php 
                            if(isset($_COOKIE['maingroupName'])){
                                $maingroupName = $_COOKIE['maingroupName'];
                            
                                echo '<select name="workerseconderygroup" id="workerseconderygroup">';
                                
                                echo "<option class='group' value='$G' > " . $maingroupName . " </option>";
        

                                        
                                echo'</select>';
                            }
                        ?>
                </div>
            </div>
            <button name="addWorker" >Add worker</button>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/ScrollTrigger.min.js"></script>
    <script defer>
        
                

        var workergroupSelect = document.getElementById('workergroup');

        workergroupSelect.addEventListener('click', function() {
            // Get the selected option
            var selectedOption = workergroupSelect.options[workergroupSelect.selectedIndex];

            // Access the data-value attribute value using dataset
            var dataValue = selectedOption.dataset.value;

            // Check if data-value is present
            if (dataValue) {
                // Set the cookie
                console.log('Setting cookie:', dataValue);
                document.cookie = `secondarygroupName=${dataValue}`;
               // location.reload();
            } else {
                // Remove the cookie
                console.log('Removing cookie');
                document.cookie = 'secondarygroupName=; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
                //document.cookie = 'secondarygroupName=; expires=Thu, 01 Jan 1970 00:00:00 UTC;';

              //  document.cookie = 'secondarygroupName=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/addworker.php;';
               // location.reload();
            }
        });
        // Get all cookies

    </script>

</body>
</html>

