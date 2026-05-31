<?php
session_start();
if(isset($_POST['logout'])){
session_unset();
session_destroy();
header("Location:http://localhost/app1/login.php");


exit;

}
if(!isset($_SESSION['user']) || $_SESSION['user']->ROLE !=="USER"){
header("Location:http://localhost/app1/login.php");
exit;
}
?>

<!DOCTYPE html>
<html>
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

  <a class="navbar-brand" href="#">yasin</a>
  

</nav>
<main class="container m-auto" style="max-width: 720;">
      <div class="shadow-lg p-3 mt-5 mb-1 bg-white rounded">hello<?php echo $_SESSION['user']->NAME; ?></div>
      <a class="btn btn-light p-2 mb-1 shadow w-100" href="profile.php">تعدل الملف الشخصي</a>
      <a class="btn btn-light p-2 mb-1 shadow w-100" href="todolist.php"> اضافه مهام  </a>
<form method='POST'><button class='btn btn-danger w-100' type='submit' name='logout'>تسجل خروج</button></form>
</main>
</body>
</html>