<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location:login.php');
        exit();
    }
    include 'inc/conn-db.php';
    $workerName = $_COOKIE['workerName'];
    $email = $_SESSION['user']['email'];
    $stm="SELECT * FROM users WHERE email ='$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();
    $UserName=filter_var($data['companyName'],FILTER_SANITIZE_STRING);


    $stmt = $conn->prepare("SELECT * FROM $UserName WHERE subworkerEmail = '$workerName'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $result['id'];
    $subworkergroup = $result['subworkergroup'];
    $subworkerJobTitle = $result['subworkerJobTitle'];
    $subworkersalery = $result['subworkersalery'];
    $subworkerPhoneNumber = $result['subworkerPhoneNumber'];
    $subworkerbadj = $result['subworkerbadj'];
    // Handle deletion of a worker
    if (isset($_GET['delete'])) {
        $workerId = $_GET['delete'];
        $stm = "DELETE FROM $UserName WHERE id = '$workerId'";
        $conn->prepare($stm)->execute();
        header('location:allworkers.php');
    }
// exract all data from his group 
    $GroupdbName = $UserName . 'Group' . $subworkergroup;
    $stmt = $conn->prepare("SELECT * FROM $GroupdbName WHERE workerEmail = :workerName");
    $stmt->bindParam(':workerName', $workerName, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['addbaj'])) {
        
        /* `id`='[value-1]',
         `subworker`='[value-2]',
         `subworkergroup`='[value-3]',
         `subworkercompanyname`='[value-4]',
         `subworkerEmail`='[value-5]',
         `subworkerPassword`='[value-6]',
         `subworkerJobTitle`='[value-7]',
         `subworkersalery`='[value-8]',
         `subworkerPhoneNumber`='[value-9]',
         `subworkerId`='[value-10]',*/
         $stm = "UPDATE $UserName SET
          `subworkerbadj`='Leader' WHERE id = '$id'";
         $conn->prepare($stm)->execute();         
          header('location:workerinfos.php');
    }
    if (isset($_POST['removbaj'])) {
        
        /* `id`='[value-1]',
         `subworker`='[value-2]',
         `subworkergroup`='[value-3]',
         `subworkercompanyname`='[value-4]',
         `subworkerEmail`='[value-5]',
         `subworkerPassword`='[value-6]',
         `subworkerJobTitle`='[value-7]',
         `subworkersalery`='[value-8]',
         `subworkerPhoneNumber`='[value-9]',
         `subworkerId`='[value-10]',*/
         $stm = "UPDATE $UserName SET
          `subworkerbadj`=' $subworkergroup worker' WHERE id = '$id' ";
         $conn->prepare($stm)->execute();         
          header('location:workerinfos.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./sass/workerinfos.css">
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <title><?php echo $workerName ; ?></title>
</head>
<body>
    

    <div class="infos" >
       <p><?php echo $workerName ; ?></p> 
       <p><?php echo $subworkerPhoneNumber ; ?></p> 
       <p><?php echo $subworkersalery ; ?></p> 
       <p><?php echo $subworkerJobTitle ; ?></p> 
       <p>Group of <?php echo $subworkergroup ; ?></p> 
       <p><?php echo $subworkerbadj ; ?></p> 
       
       
    </div>
    <div class="wraper">
        <form class="nav" action="workerinfos.php" method="POST">
            <button name="addbaj" ><img src="./assets/magic.png" alt="" srcset="">تعيين كقائد</button>
            <button name="removbaj" ><img src="./assets/box.png" alt="" srcset="">ازالة كقائد</button>
            <a class="a" href="workerinfos.php?delete=<?php echo $id; ?>" class="deleteButton"><img src="./assets/x.png" alt="" srcset=""> ازالة</a>
        </form>
        <div class="cont">
            <div class="day-infos">
                <?php
                    foreach ($result as $row) {
                        $currentDate = date('Y-m-d');
                        if ($row['date']==$currentDate){
                            if($row['workerState']=='on work'){
                                echo '<p>'.''.$workerName .' is '.$row['workerState'].' ' .'</p>'; 
                            }
                            if($row['workerState']=='Present'){
                                echo '<p>'.''.$workerName .' leaved at '.$row['workerTimeout'].'</p>'; 
                            }
                        }
                        
                    }
                ?>
            </div>
            <div class="all-infos" >
                <?php
                        foreach ($result as $row) {
                            echo "<p> " . $row['date'] .' was '. $row['workerState'] . "</p> ";
                        }
                ?>
            </div>             
        </div>

        <div class="dash-dir">
            <a class="dash" href="profile.php"><img src="./assets/homeoutline.png" alt="" srcset=""></a>
        </div>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/ScrollTrigger.min.js"></script>
    <script src="./script/workerinfos.js"></script>
</body>
</html>

