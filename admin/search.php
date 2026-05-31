
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<nav class="navbar navbar-light bg-light">
    <img src="../img/logo.jpeg" style="border-radius: 100px; width: 50px;" class="d-inline-block align-top" alt="">

  <a class="navbar-brand" href="#">
    yasin
  </a>
  </nav>
<main   style="text-align: right; direction: rtl; max-width:760px;  margin:auto;">
<?php
session_start();
if(isset($_SESSION['user'])){
if($_SESSION['user']->ROLE==="ADMIN"){
echo'<form method="GET">
    <input class="form-control" type="text" name="search" placeholder="حبث عن......"required />
    <button class="btn btn-warning w-100 mt-3" type="submit" name="searchbtn">بحث</button>
</form>';

if(isset($_GET['searchbtn'])){
require_once'../connectToDB.php';
$searchresult = $database->prepare("SELECT * FROM users WHERE NAME LIKE :name OR EMAIL LIKE :email");
$searchvalue = "%".$_GET['search']."%";
$searchresult->bindParam("name",$searchvalue);
$searchresult->bindParam("email",$searchvalue);
$searchresult->execute();
echo'<table class="table">';
echo'<tr>';
echo'<th>الاسم</th>';
echo'<th>البريد</th>';
echo'<th>حذف</th>';
echo'<th>تعديل</th>';
echo'</tr>';
foreach($searchresult AS $item){
echo'<tr>';
echo'<td>'.$item['NAME'].'</td>';
echo'<td>' .$item['EMAIL'].'</td>';
echo'<td><form method="GET"><button class="btn btn-outline-danger" type="submit" name="remove" value="'.$item['ID'].'">حذف</button></form></td>';
echo'<td><form method="GET"><button class="btn btn-dark" type="submit" name="edit" value="'.$item['ID'].'">تعديل</button></form></td>';

echo'</tr>';
}
echo'</table>';
}
if(isset($_GET['remove'])){
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost;dbname=oodb;charset=utf8",$username,$password);
$removeitem =$database->prepare("DELETE FROM todolist  WHERE userid =:userid");
$removeitem->bindParam("userid",$_GET['remove']);
$removeitem->execute();
$removeUser =$database->prepare("DELETE FROM users  WHERE ID =:userid");
$removeUser->bindParam("userid",$_GET['remove']);
if($removeUser->execute()){
echo'<div class="alert alert-info">تم الحذف بنجاح </div>';
header("Refresh:2;url=:search.php;");
}

}
if(isset($_GET['edit'])){
session_status();
$_SESSION['userid'] = $_GET['edit'];
header("location:http://localhost/app1/admin/edituser.php");
}
}else{
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
