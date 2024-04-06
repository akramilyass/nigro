<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
        exit();
    }
    
//____________________add Group_________________________________________________________________
    if(isset($_POST['addGroup'])){
        include 'inc/conn-db.php';
        $gorupEndingTime = filter_var($_POST['gorupEndingTime'],FILTER_SANITIZE_STRING);
        $gorupStartingTime = filter_var($_POST['gorupStartingTime'],FILTER_SANITIZE_STRING);
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
                `Groupbadg` VARCHAR(250) NOT NULL,
                `Groupcolor` VARCHAR(250) NOT NULL,
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
                    $gorupStartingTime = filter_var($_POST['gorupStartingTime'], FILTER_SANITIZE_STRING);
                    $gorupbadg = filter_var($_POST['gorupbadg'],FILTER_SANITIZE_STRING);
                    $groupcolor = filter_var($_POST['groupcolor'],FILTER_SANITIZE_STRING);
                    $currentDate = date("Y-m-d");
                    // Use prepared statements to prevent SQL injection
                    $stm = $conn->prepare("INSERT INTO $GroupdbName
                     (date,GroupName, Groupin, Groupout,Groupbadg,Groupcolor) VALUES (?,?, ?, ?,?,?)");
                    $stm->bindParam(1, $currentDate, PDO::PARAM_STR);
                    $stm->bindParam(2, $groupBdName, PDO::PARAM_STR);
                    $stm->bindParam(3, $gorupStartingTime, PDO::PARAM_STR);
                    $stm->bindParam(4, $gorupEndingTime, PDO::PARAM_STR);
                    $stm->bindParam(5, $gorupbadg, PDO::PARAM_STR);
                    $stm->bindParam(6, $groupcolor, PDO::PARAM_STR);
        
                    // Execute the insert query
                    $stm->execute();
        
                    // You can return any relevant information or success status here
                } 
            } else {
                // Handle table creation failure
                echo "Table creation failed.";
            }
        }
        $groupBdName = $gorupName;
        createGroupDatabase($groupBdName);
        //__insert to company groups
        $currentDate = date("Y-m-d");
        $email = $_SESSION['user']['email'];
        include 'inc/conn-db.php';
        $stm="SELECT * FROM users WHERE email ='$email'";
        $q=$conn->prepare($stm);
        $q->execute();
        $data=$q->fetch(); 
        $companyName = $data['companyName'];
        $companyGroupBd = $companyName .'AllGroup';
        $stm="INSERT INTO  $companyGroupBd
            (date,GroupName)
             VALUES 
            ('$currentDate','$gorupName')";
        $conn->prepare($stm)->execute();
        

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
?>

<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="./sass/addgroup.css">
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <title>add group</title>
</head>
<body>
<a href="profile.php">Dashbord</a>
    <div class="container" >

<!---------------add Groups------------------------------------------------------------->
        <form class="addgroups" action="addgroup.php" method="POST" >
            <div class="addgroup">
                <h3>Add Main Group</h3>
                <div>
                    <label for="gorupName">Enter the group Name :</label>
                    <input type="text" id="gorupName" name="gorupName" placeholder="gorupName" required >
                </div>

                <div>
                    <label for="gorupStartingTime">Enter the group starting time :</label>
                    <select name="gorupStartingTime" id="gorupStartingTime" required>
                        <option value="1">01:00 AM</option>
                        <option value="2">02:00 AM</option>
                        <option value="3">03:00 AM</option>
                        <option value="4">04:00 AM</option>
                        <option value="5">05:00 AM</option>
                        <option value="6">06:00 AM</option>
                        <option value="7">07:00 AM</option>
                        <option value="8">08:00 AM</option>
                        <option value="9">09:00 AM</option>
                        <option value="10">10:00 AM</option>
                        <option value="11">11:00 AM</option>
                        <option value="12">12:00 AM</option>
                        
                        <option value="13">01:00 PM</option>
                        <option value="14">02:00 PM</option>
                        <option value="15">03:00 PM</option>
                        <option value="16">04:00 PM</option>
                        <option value="17">05:00 PM</option>
                        <option value="18">06:00 PM</option>
                        <option value="19">07:00 PM</option>
                        <option value="20">08:00 PM</option>
                        <option value="21">09:00 PM</option>
                        <option value="22">10:00 PM</option>
                        <option value="23">11:00 PM</option>
                        <option value="24">12:00 PM</option>
                    </select>
                </div>

                <div>
                    <label for="gorupEndingTime">Enter the group ending time :</label>
                    <select name="gorupEndingTime" id="gorupEndingTime" required>
                        <option value="1">01:00 AM</option>
                        <option value="2">02:00 AM</option>
                        <option value="3">03:00 AM</option>
                        <option value="4">04:00 AM</option>
                        <option value="5">05:00 AM</option>
                        <option value="6">06:00 AM</option>
                        <option value="7">07:00 AM</option>
                        <option value="8">08:00 AM</option>
                        <option value="9">09:00 AM</option>
                        <option value="10">10:00 AM</option>
                        <option value="11">11:00 AM</option>
                        <option value="12">12:00 AM</option>
                        
                        <option value="13">01:00 PM</option>
                        <option value="14">02:00 PM</option>
                        <option value="15">03:00 PM</option>
                        <option value="16">04:00 PM</option>
                        <option value="17">05:00 PM</option>
                        <option value="18">06:00 PM</option>
                        <option value="19">07:00 PM</option>
                        <option value="20">08:00 PM</option>
                        <option value="21">09:00 PM</option>
                        <option value="22">10:00 PM</option>
                        <option value="23">11:00 PM</option>
                        <option value="24">12:00 PM</option>
                    </select>
                </div>
                <div>
                    <label for="gorupbadg">Enter the group ending time :</label>
                    <select name="gorupbadg" id="gorupbadg" required>
                        <option value="circl">circl</option>
                        <option value="poly">poly</option>
                    </select>
                </div>
                <div>
                    <label for="groupcolor">Enter the group ending time :</label>
                    <select name="groupcolor" id="groupcolor" required>
                        <option value="red">red</option>
                        <option value="black">black</option>
                        <option value="green">green</option>
                        <option value="yellow">yellow</option>
                    </select>
                </div>
            </div>
            <button name="addGroup" >Add Group</button>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/ScrollTrigger.min.js"></script>
    <script >
        
//_______prevent spacing in input add group name


document.getElementById('gorupName').addEventListener('input', function(event) {
  // Get the input value
  var inputValue = event.target.value;

  // Remove any spaces from the input value
  var newValue = inputValue.replace(/\s/g, '');
  
  // Update the input field with the modified value
  event.target.value = newValue;
});
    </script>
</body>
</html>



