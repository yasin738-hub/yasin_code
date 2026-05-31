
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>
<body>
    <!-- Image and text -->
<nav class="navbar navbar-light bg-light">
    <img src="../img/logo.jpeg" style="border-radius: 100px; width: 50px;" class="d-inline-block align-top" alt="">

  <a class="navbar-brand" href="#">
    yasin
  </a>
  </nav>
<main class="container m-auto" style="max-width: 720px; text-align:right;  ">
    
<?php
session_start();
if(isset($_SESSION['user'])){
if($_SESSION['user']->ROLE==="USER"){
echo'<form method="POST">
<a class="w-100 btn btn-light mb-3 mt-1" href="index.php"> عودة لصفحة الرئيسية</a>
<input class="form-control" type="text" name="text"/>
<button class="w-100 btn btn-warning mb-3" type="submit" name="add"> اضافه </button>
</form>';

require_once'../connectToDB.php';
$userId = $_SESSION['user']->ID;

if(isset($_POST['add'])){
$additem =$database->prepare("INSERT INTO todolist(text,userid,status) VALUES(:text,:userid,'no')");
$additem->bindParam("text",$_POST['text']);
$additem->bindParam("userid",$userId);
if($additem->execute()){
echo'<div class="alert alert-success mt-3 mb-3"> تم اضافة بنجاح </div>';
header("refresh:2;");
}
}
$todolist = $database->prepare("SELECT * FROM todolist WHERE userid = :id");
$todolist->bindParam("id",$userId);
$todolist->execute();
echo'<table class="table">';
echo'<tr>';
echo'<th>المهمة </th>';
echo'<th>الحالة</th>';
echo'<th>حذف</th>';
echo'</tr>';
foreach($todolist AS $item){
    echo'<form><tr>';
echo'<td>'.$item['text'].' </td>';
if($item['status']==="no"){
echo'<td>
<input type="hidden" name="statusValue" value="'.$item['status'].'"/>
<button class="btn btn-outline-warning" 
type="submit" name="status" value="'.$item['ID'].'">غير منجز</button></td>';
}elseif($item['status']==="yas"){
echo'<td>
<input type="hidden" name="statusValue" value="'.$item['status'].'"/>
<button class="btn btn-outline-success" 
type="submit" name="status" value="'.$item['ID'].'"> منجز</button></td>';
}

echo'<td><button class="btn btn-outline-danger" type="submit" name="remov" value="'.$item['ID'].'">حذف</button></td>';
echo'</tr></form>';


}
echo'</table>';
if(isset($_GET['status'])){
    if($_GET['statusValue']==="no"){
$updateStatus = $database->prepare("UPDATE todolist SET status ='yas' WHERE ID =:id");
$updateStatus->bindParam("id",$_GET['status']);
$updateStatus->execute();
header("location:todolist.php",true);
    }elseif($_GET['statusValue']==="yas"){
$updateStatus = $database->prepare("UPDATE todolist SET status ='no' WHERE ID =:id");
$updateStatus->bindParam("id",$_GET['status']);
$updateStatus->execute();
header("location:todolist.php",true);
    }
}
if(isset($_GET['remov'])){
$removItem = $database->prepare("DELETE FROM todolist WHERE ID =:id");
$removItem->bindParam("id",$_GET['remov']);
$removItem->execute();
header("location:todolist.php",true);
}
}
else{
    header("location:http://localhost/app1/login.php",true);
    die("");
}
}else{
    header("location:http://localhost/app1/login.php",true);
    die("");
}
if(isset($_POST['logout'])){
session_unset();
session_destroy();
header("location:http://localhost/app1/login.php",true);
}

?>

</main>
</body>
</html>