<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require_once "navbar.php"; ?>

<main class="container">
<?php
if(isset($_GET['code'])){


require_once'connectToDB.php';
$checkcode = $database->prepare("SELECT SECURITY_CODE FROM users WHERE SECURITY_CODE = :SECURITY_CODE");
$checkcode->bindParam("SECURITY_CODE",$_GET['code']);
$checkcode->execute();
if($checkcode->rowCount()>0){
$checkcode = $database->prepare("UPDATE users SET SECURITY_CODE = :NEWSECURITY_CODE,
ACTIVATED = true WHERE SECURITY_CODE =:SECURITY_CODE");
$security = md5(date('h:s:i'));
$checkcode->bindParam("NEWSECURITY_CODE",$security);    
$checkcode->bindParam("SECURITY_CODE",$_GET['code']);  
if($checkcode->execute()){
echo '<div class="alert alert-success" role="alert">
تم   التجقق من الحساب 
</div>';
echo"<a class='btn btn-warning' herf ='login.php'>تسجيل دخول</a>";

}
}else{
    echo '<div class="alert alert-danger" role="alert">
الرابط غير صالح   
      </div>';

}


}


?>
</main>
</body>
</html>