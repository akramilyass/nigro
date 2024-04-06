<?php
    session_start();
    if(isset($_SESSION['user'])){
        header('location:profile.php');
        exit();
    }
    if(isset($_POST['submit'])){
        include 'inc/conn-db.php';
    $name=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $companyName=filter_var($_POST['company'],FILTER_SANITIZE_STRING);
    $password=filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $email=filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

    $errors=[];
    // validate name
    if(empty($name)){
        $errors[]="يجب كتابة الاسم";
    }elseif(strlen($name)>100){
        $errors[]="يجب ان لايكون الاسم اكبر من 100 حرف ";
    }

    // validate email
    if(empty($email)){
        $errors[]="يجب كتابة البريد الاكترونى";
    }elseif(filter_var($email,FILTER_VALIDATE_EMAIL)==false){
        $errors[]="البريد الاكترونى غير صالح";
    }

    $stm="SELECT email FROM users WHERE email ='$email'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();

    if($data){
        $errors[]="البريد الاكترونى موجود بالفعل";
    }

    $stmr="SELECT companyName FROM users WHERE companyName ='$companyName'";
    $qr=$conn->prepare($stmr);
    $qr->execute();
    $datar=$qr->fetch();
    if($datar){
        $errors[]="  الشركة موجودة بالفعل ";
    }


    // validate password
    if(empty($password)){
            $errors[]="يجب كتابة  كلمة المرور ";
    }elseif(strlen($password)<6){
        $errors[]="يجب ان لايكون كلمة المرور  اقل  من 6 حرف ";
    }



   // insert or errros 
   if(empty($errors)){
      // echo "insert db";
      $password=password_hash($password,PASSWORD_DEFAULT);
      $stm="INSERT INTO users (name,email,password,companyName) VALUES ('$name','$email','$password','$companyName')";
      $conn->prepare($stm)->execute();
      $_POST['name']='';
      $_POST['email']='';

      $_SESSION['user']=[
        "name"=>$name,
        "email"=>$email,
      ];
      header('location:profile.php');
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
    <title>register</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="nav">
                <a href="login.php">دخول</a>
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
                        echo "<h1>تسجيل الدخول</h1>";
                    }
                ?>
                
            </div>
        </div>
         <form class='form' dir="rtl" action="register.php" method="POST">
                
            <div class="div1" ><label for="name">أدخل اسمك</label><input type="text" value="<?php if(isset($_POST['name'])){echo $_POST['name'];} ?>" id="name" name="name" placeholder="الاسم"></div>
            <div class="div1" ><label for="company">أدخل اسم شركتك</label><input type="text" value="<?php if(isset($_POST['company'])){echo $_POST['company'];} ?>" id="company" name="company" placeholder="اسم الشركة"></div>

            <div class="div2"><label for="email">أدخل أيميل</label><input type="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"  id="email" name="email" placeholder="أيميل"></div>
            <div class="div3"><label for="password">أدخل كلة سر</label><input type="password" id="password" name="password" placeholder="كلة السر"></div>
            <button name="submit">تسجيل الدخول</button>
        </form>   
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js"></script>

    <script src="./script/register.js"></script>
</body>
</html>