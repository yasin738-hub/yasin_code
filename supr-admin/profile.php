<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
   
<main   style="text-align: right; direction: rtl; max-width:760px;  margin:auto;">

<?php
session_start();
if(isset($_SESSION['user'])){
   if($_SESSION['user']->ROLE ==="SUPR-ADMIN"){

   
    echo'
    <form method="POST">
    <div class=" shadow p-2">الاسم :</div>
    
       <input class="form-control mb-1" type="text" value="'.$_SESSION['user']->NAME.'" name="name"/>
   <div class=" shadow  p-2"> العمر : </div>
       <input class="form-control mb-1" type="date"  value="'.$_SESSION['user']->AGE.'" name="age"/>
   <div class=" shadow  p-2"> العمر كلمه المرور : </div>
       <input class="form-control mb-1" type="text"  value="'.$_SESSION['user']->PASSWORD.'" name="password"/>

       <button class="w-100 btn btn-warning" type="submit"  value="'.$_SESSION['user']->ID.'" name="update">تحديث</button>
       <a class="w-100 btn btn-light mt-1" href="index.php">العودة للصفحه الرئسيه</a>
    </form>';

if(isset($_POST['update'])){
require_once'../connectToDB.php';
$update =$database->prepare("UPDATE users SET NAME =:name ,AGE = :age , PASSWORD = :password WHERE ID =:id");
$update->bindParam("name",$_POST['name']);
$update->bindParam("age",$_POST['age']);
$update->bindParam("password",$_POST['password']);
$update->bindParam("id",$_POST['update']);
if($update->execute()){
echo'<div class="alert alert-success mt-3">تم التعديل</div>';
$user = $database->prepare("SELECT * FROM users WHERE ID = :id");
$user->bindParam("id",$_POST['update']);
$user->execute();
$_SESSION['user'] = $user->fetchObject();
header("refresh:2;");
}else{
   echo'حدث خاء اثناء التعدل';
}
}
}else{
session_unset();
session_destroy();
header("location:http://localhost/app1/login.php",true);
}
}else{
session_unset();
session_destroy();
header("location:http://localhost/app1/login.php",true);
}
?>
</main>

</body>
</html>