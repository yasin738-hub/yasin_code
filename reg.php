

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>re</title>
</head>
<body>
  <?php require_once "navbar.php"; ?>


<div class="container" dir="rtl" style="text-align: right !important;">
<form method="POST">
    
:الاسم <input class="form-control" type="text" name="name" required/>
<br>
:تارخ الميلاد <input class="form-control" type="date" name="age" required/>
<br>
:الايميل <input class="form-control" type="email" name="email" required/>
<br>
:كلمة المرور <input class="form-control" type="text" name="password" required/>
<br>
<button class="btn btn-dark" type="submit" type="submit" name="reg">تسجيل</button>
<a class="btn btn-warning" type="submit" href="login.php">لدي حساب </a>
</form>

</div>

<?php
require_once'connectToDB.php';
if(isset($_POST['reg'])){
$checkemile = $database->prepare("SELECT * FROM users WHERE EMAIL = :EMAIL");
$email = $_POST['email'];
$checkemile->bindParam("EMAIL",$email);
$checkemile->execute();
if($checkemile->rowCount()>0){
            echo '<div class="alert alert-danger" role="alert">
        هذا حساب سابقا مستخدم
      </div>';
}else{
$name =$_POST['name'] ;
$pass = sha1($_POST['password']) ;
$email =$_POST['email'] ;
$age =$_POST['age'] ;
$addUser = $database->prepare("INSERT INTO users(NAME,AGE,EMAIL,PASSWORD,SECURITY_CODE,ROLE)
 VALUES(:NAME,:AGE,:EMAIL,:PASSWORD,:SECURITY_CODE,'USER')");
$addUser->bindParam("NAME",$name);
$addUser->bindParam("AGE",$age);
$addUser->bindParam("EMAIL",$email);
$addUser->bindParam("PASSWORD",$pass);
$security = md5(date('h:s:i'));
$addUser->bindParam("SECURITY_CODE",$security);
if($addUser->execute()){
echo '<div class="alert alert-success" role="alert">
تم إنشاء حساب بنجاح 
</div>';
require_once "mail.php";
$mail->addAddress($email);
$mail->Subject ="رسالة التحقق من البريد ";
$mail->Body ='<h1> شكرن لتسجيلك في موقعنة </h1>'
."<div> رابط التدقق من الحساب </div>".
"<a  href ='http://localhost/app1/actev.php?code=".$security."'>"
."http://localhost/app1/actev.php"."?code".$security."</a>";
$mail->setFrom( "samyasyn738@gmail.com","yasin");
$mail->send();

}else{
echo '<div class="alert alert-success" role="alert">
فشل إنشاء حساب  
</div>'; 
}

}
 
  }
       
?>

</body>
</html>