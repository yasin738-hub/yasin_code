<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اعادة تعين كلمه المرور</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <?php require_once "navbar.php"; ?>
    <main class="contanier m-auto" style="max-width: 720px; width:100%; margin-top:50px !important; text-aling: center; ">
    <?php 
    if(!isset($_GET['code'])){
  echo'<form method="POST">
        <div class="p-3 shadow">اكتب الايميل  </div>
        <input class="form-control" type="text" name="email"/>
        <button class="btn btn-warning w-100 mt-3" type="submit" name="resetpass" >ارسال رابط التحقق</button>
      </form>';
} elseif(isset($_GET['code'])&& isset($_GET['email'])){
echo'<form method="POST">
    <div class="p-3 shadow">ضع كلمة مرور جديدة</div>
    <input class="form-control" type="text" name="pass" required />
    <button class="btn btn-warning w-100 mt-3" type="submit" name="newpass">تعدل</button>
   </form> ';
}
?>


<?php

if(isset($_POST['resetpass'])){
    require_once'connectToDB.php';
    $chckemail =$database->prepare("SELECT EMAIL,SECURITY_CODE FROM users WHERE EMAIL = :email");
    $chckemail->bindParam("email",$_POST['email']);
    $chckemail->execute();
    if($chckemail->rowCount()>0){
        require_once "mail.php";
        $user = $chckemail->fetchObject();
        $mail->addAddress($_POST['email']);
        $mail->Subject ="تحقق من البريد";
        $mail->Body ='<h1> شكرن لتسجيلك في موقعنة </h1><br>'.
        '<a href="http://localhost/app1/reset.php?email='.$_POST['email'].'&code='.$user->SECURITY_CODE.'">
        http://localhost/app1/reset.php?email='.$_POST['email'].'&code='.$user->SECURITY_CODE.'</a>';

$mail->setFrom( "samyasyn738@gmail.com","yasin");
$mail->send();
echo'<div class="alert alert-success mt-1">تم ارسال رابط التحقق</div>';
    }else{
        echo'<div class="alert alert-warning mt-1">البريد غير صالح</div>';
    }

}
if(isset($_POST['newpass'])){
    $username = "root"; 
    $password = "";
    $database = new PDO("mysql:host=localhost;dbname=oodb;charset=utf8",$username,$password);
    $updeta = $database->prepare("UPDATE users SET PASSWORD = :password WHERE EMAIL = :email");
    $updeta->bindParam("password",$_POST['pass']);
    $updeta->bindParam("email",$_GET['email']);

    if($updeta->execute()){
        echo'<div class="alert alert-success mt-1"> تم التحديث </div>';

    }
}

?>
</main>
</body>
</html>