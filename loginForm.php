<?php
  require_once 'connection.php';
  setcookie('login',0);
  $_COOKIE['login']=0;
    $link2=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link2));
    mysqli_set_charset($link2,"utf8");
    $err="";
    if (isset($_POST['checkLog']))
    {
      $query="SELECT `login`, `password`, `typeOfUser` FROM `UsersDB` WHERE password='".$_POST['password']."' and login='".$_POST['login']."'";
      $result2=mysqli_query($link2,$query)or die("Ошибка запроса".mysqli_error($link2));
      if (mysqli_num_rows($result2)!=0){
        $_COOKIE['login']=1;
        setcookie('login',1);
        header ('Location: adminForm.php');  // перенаправление на нужную страницу
        exit();    // прерываем работу скрипта, чтобы забыл о прошлом
      } else{
        $err="Введены некорректные данные.";
      }
    }


 ?>
<html>
<head>
<meta charset="utf-8">
        <title>TASKER</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
<form method="post">
  <div class="form-group" method="post">
    <label for="exampleInputEmail1">Email address</label>
    <input name="login" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
  </div>
  <?php
    if ($err!=''){
      echo "<div class='alert alert-danger' role='alert'>
  <strong>".$err."</div>";
    }
   ?>
  <input name="checkLog" type="submit" class="btn btn-primary">
  <a href="index.php">Вернуться к просмотру</a>
</form>
</body>
</html>
