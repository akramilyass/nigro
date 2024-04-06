<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('location:profile.php');
        exit();
    }
    if(isset($_POST['submit'])){
        include 'inc/conn-db.php';
    $password=filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

    $errors=[];
    

    // validate email
    if(empty($email)){
        $errors[]="يجب كتابة البريد الاكترونى";
    }


    // validate password
    if(empty($password)){
            $errors[]="يجب كتابة  كلمة المرور ";
    }
    // insert or errros 
        if(empty($errors)){
    
        // echo "check db";

        $stm="SELECT * FROM users WHERE email ='$email'";
        $q=$conn->prepare($stm);
        $q->execute();
        $data=$q->fetch();
        if(!$data){
        $errors[] = "خطأ فى تسجيل الدخول";
        }else{
            
            $password_hash=$data['password']; 
            
            if(!password_verify($password,$password_hash)){
                $errors[] = "خطأ فى تسجيل الدخول";
            }else{
                $_SESSION['user']=[
                    "name"=>$data['name'],
                    "email"=>$email,
                ];
                header('location:profile.php');

            }
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
                <a href="register.php">تسجيل الدخول</a>
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
                        echo "<h1> الدخول</h1>";
                    }
                ?>
                
            </div>
        </div>
        <form class='form' dir="rtl" action="login.php" method="POST">
             

                <div class="div1">
                    <label for="email">أدخل الايميل</label>
                    <input type="text" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" id="email" name="email" placeholder="الايميل">
                </div>
                <div class="div2">
                    <label for="password">كلمة السر</label>
                    <input type="password" id="password" name="password" placeholder="كلة السر">
                </div>
                <button name="submit">دخول</button>
        </form>
    </div>



    




    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>

    <script src="./script/login.js"></script>
</body>
</html>