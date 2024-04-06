
<?php
    session_start();

    if (isset($_SESSION['worker'])) {
        header('location:workerprofile.php');
        exit();
    }

    if (isset($_POST['submit'])) {
        include 'inc/conn-db.php';

        $companyName = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        $errors = [];

        // validate email
        if (empty($email)) {
            $errors[] = "يجب كتابة البريد الإلكتروني";
        }

        // validate password
        if (empty($password)) {
            $errors[] = "يجب كتابة كلمة المرور";
        }
        $stm = "SELECT * FROM $companyName WHERE subworkerEmail = :email";
        $q = $conn->prepare($stm);
        $q->bindParam(':email', $email);
        $q->execute();
        $data = $q->fetch();
        // insert or errors
        if (!$data) {
            $errors[] = "خطأ في تسجيل الدخول";
        }
        if (empty($errors)) {
            $savedpassword = $data['subworkerPassword'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            if (!$password=$savedpassword) {
                $errors[] = "خطأ في تسجيل الدخول";
            } else {
                $_SESSION['worker'] = [
                    "name" => $data['subworker'],
                    "subworkergroup" => $data['subworkergroup'],
                    "subworkercompanyname" => $data['subworkercompanyname'],
                    "subworkerJobTitle" => $data['subworkerJobTitle'],
                    "subworkersalery" => $data['subworkersalery'],
                    "subworkerbadj" => $data['subworkerbadj'],
                    "email" => $email,
                ];
                header('location:workerprofile.php');
            }
        }
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="./sass/index.css">
    <script src="https://kit.fontawesome.com/c0712c6de3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./sass/login.css">
    <title>login</title>
</head>
<body>

    <div class="container">
        <div class="header">
            <div class="nav">
                <a href="index.php">الصفحة الرئيسية</a>
            </div>
            <div class="logo">
            <img src="./assets/logo.png" alt="" srcset="">
            </div>
            <div class="info">
                <?php 
                    if(isset($errors)){
                        if(!empty($errors)){
                            
                            foreach($errors as $msg){
                                echo "<p>".$msg . "</p>";
                                break;
                            }
                        }
                    }
                    else{
                        echo "<h1> ابدأ العمل </h1>";
                    }
                ?>
                
            </div>
        </div>
        <form class="form" dir="rtl" action="workerlogin.php" method="POST">
                <?php 
                    if(isset($errors)){
                        if(!empty($errors)){
                            foreach($errors as $msg){
                                echo $msg . "<br>";
                            }
                        }
                    }
                ?>
                 <div class="div1"><label for="company">أدخل اسم الشركة التي تعمل فيها</label><input type="text"  id="company" name="company" required placeholder="اسم الشركة"></div>
                <div class="div1"><label for="email">أدخيل الايميل الخاص بك</label><input type="text" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" id="email" name="email" required placeholder="الايميل"></div>
                    <div class="div2"><label for="password">أدخل كلمة السر</label><input type="password" id="password" name="password"  required placeholder="كلمة السر"></div>
                    <button name="submit">ابدأ العمل</button>
                 
        </form>
    </div>



    




    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>

    <script src="./script/login.js"></script>
</body>
</html>