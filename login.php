<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<main class="container mt 3" dir="rtl" style="text-align: right !important;">
<form method="POST">
    <p class="font-weight-bold">البريد</p>
    <input class="form-control mt-3" type="email" name="email" required/>
    <p class="font-weight-bold">كلمه المرور</p>
    <input class="form-control mt-3" type="password" name="password" required/>
    <a href="reset.php">نسيت كلمه المرور</a><br>
    <button class="btn btn-outline-dark mt-3" type="submit" name="login">تسجيل دخول</button>
    <a class="btn btn-warning mt-3"  href="reg.php"> انشا حساب</a>
</form>
<?php
if(isset($_POST['login'])){
require_once'connectToDB.php';
$login = $database->prepare("SELECT * FROM users WHERE EMAIL = :EMAIL AND PASSWORD = :PASSWORD");
$login->bindParam("EMAIL",$_POST['email']);
$pass = sha1($_POST['password']);
$login->bindParam("PASSWORD",$pass);
$login->execute();
if($login->rowCount()===1){

    $user = $login->fetchObject();
    if($user->ACTIVATED ==1){
    session_start();
    $_SESSION['user'] = $user;
    if($user->ROLE==="USER"){
        header("location:user/index.php",true);
    }else if($user->ROLE==="ADMIN"){
        header("location:admin/index.php",true);
    }else if($user->ROLE==="SUPR-ADMIN"){
        header("location:supr-admin/index.php",true);
    }    
    }else{
        echo '<div class="alert alert-danger" role="alert">يرجا تفغيل البريد</div>';

    }
}else{
    echo'كلمه المرور او اسم المستخدم غير صحيحة';
}
}




?>
</main>