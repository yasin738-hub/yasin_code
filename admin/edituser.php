<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-light bg-light">
    <img src="../img/logo.jpeg" style="border-radius: 100px; width: 50px;" class="d-inline-block align-top" alt="">

  <a class="navbar-brand" href="#">
    yasin
  </a>
  </nav>
<main   style="text-align: right; direction: rtl; max-width:760px;  margin:auto;">

<?php
session_start();
require_once'../connectToDB.php';


if(isset($_SESSION['userid'])){
$user = $database->prepare("SELECT * FROM users WHERE ID =:id");
$user->bindParam("id",$_SESSION['userid']);
$user->execute();
$user = $user->fetchObject();
    echo'
    <form method="POST">
    <div class=" shadow p-2">الاسم :</div>
    
       <input class="form-control mb-1" type="text" value="'.$user->NAME.'" name="name"/>
   <div class=" shadow  p-2"> العمر : </div>
       <input class="form-control mb-1" type="date"  value="'.$user->AGE.'" name="age"/>';
       echo'<select class="form-control mb-1" name="activated" >';
       if($user->ACTIVATED =="1"){
        echo'<option value="'.$user->ACTIVATED.'">الحساب مفعل</option>';
       }else{
        echo'<option value="'.$user->ACTIVATED.'">الحساب غيرف مفعل </option>';
       }
       echo'<option value="0">الغاء التفعيل</option>
            <option value="1">تفعيل</option>
        </select>';
       echo '<button class="w-100 btn btn-warning" type="submit"  value="'.$user->ID.'" name="update">تحديث</button>
       <a class="w-100 btn btn-light mt-1" href="index.php">العودة للصفحه الرئسيه</a>
 
        </form>';
 if(isset($_POST['update'])){
    $updateuser = $database->prepare("UPDATE users SET NAME =:name ,AGE =:age 
    , ACTIVATED = :activated WHERE ID =:id");
    $updateuser->bindParam("name",$_POST['name']);
    $updateuser->bindParam("age",$_POST['age']);
    $updateuser->bindParam("activated",$_POST['activated']);
    $updateuser->bindParam("id",$_SESSION['userid']);
    $updateuser->execute();
    header("location:edituser.php");

 }  
}

?>
</main>
</body>
</html>