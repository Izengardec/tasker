<?php
require_once 'connection.php';
$comp="";
if(isset($_POST['submit'])){
	if ($_POST['login']!='' and $_POST['email']!='' and $_POST['task']!=''){
		$link2=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link2));
		mysqli_set_charset($link2,"utf8");
		$query="INSERT INTO `Tasks`(`name`, `email`, `task`) VALUES ('".strip_tags($_POST['login'])."','".strip_tags($_POST['email'])."','".strip_tags($_POST['task'])."')";
		$result2=mysqli_query($link2,$query)or die("Ошибка запроса".mysqli_error($link2));
		$comp="Запрос выполнен успешно.";
		mysqli_close($link2);
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
			<a href="loginForm.php" class="btn btn-outline-primary">LOGIN</a>
        <form method="post">
					<input type="text" name="login" class="form-control" placeholder="Ваше имя" style="margin: 5px;" required>
					<input type="email" name="email" class="form-control" placeholder="Ваш email" style="margin: 5px;" required>
					<input type="text" name = "task" class="form-control"  placeholder="Ваше задание" style="margin: 5px;" required>
					<input type="submit" class="btn btn-primary" name="submit">
        </form>
				<?php
					if ($comp!=""){
						echo "<div class='alert alert-success'>".$comp."</div>";
					}
				 ?>
				<form method="post">
					<input type="submit" class="btn btn-primary" name="logSort" style="margin: 5px;" value="Сортировка по имени">
					<input type="submit" class="btn btn-primary"  name="emailSort" style="margin: 5px;" value="Сортировка по email">
					<input type="submit" class="btn btn-primary" name = "taskSort" style="margin: 5px;" value="Сортировка по готовности">
        </form>

				<?php
				$link=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link));
				mysqli_set_charset($link,"utf8");
				$query="SELECT * FROM `Tasks`LIMIT ".($_GET['page']*3)." , 3";
				if ((isset($_POST['logSort']) && $_COOKIE['typeSort']!=1) || (!$_COOKIE['dblClickSort'] && $_COOKIE['typeSort']==1 && (isset($_POST['logSort'])) ))
				{
					$_COOKIE['dblClickSort']=true;
					$_COOKIE['typeSort']=1;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`name` ASC LIMIT ".($_GET['page']*3)." , 3";
				}
				else if ($_COOKIE['typeSort']==1 && $_COOKIE['dblClickSort'] && isset($_POST['logSort']))
				{
					$_COOKIE['dblClickSort']=false;
					$_COOKIE['typeSort']=1;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`name` DESC LIMIT ".($_GET['page']*3)." , 3";
				}
				else if ($_COOKIE['typeSort']==1 && $_COOKIE['dblClickSort'])
				{
					$_COOKIE['dblClickSort']=true;
					$_COOKIE['typeSort']=1;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`name` ASC LIMIT ".($_GET['page']*3)." , 3";
				}
				else if ($_COOKIE['typeSort']==1 && !$_COOKIE['dblClickSort'])
				{
					$_COOKIE['dblClickSort']=false;
					$_COOKIE['typeSort']=1;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`name` DESC LIMIT ".($_GET['page']*3)." , 3";
				}

				 if ((isset($_POST['emailSort']) && $_COOKIE['typeSort']!=2) || (!$_COOKIE['dblClickSort'] && $_COOKIE['typeSort']==2 && (isset($_POST['emailSort'])) ))
				{
					$_COOKIE['dblClickSort']=true;
					$_COOKIE['typeSort']=2;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`email` ASC LIMIT ".($_GET['page']*3)." , 3 ";
				}
				else if ($_COOKIE['typeSort']==2 && $_COOKIE['dblClickSort'] && isset($_POST['emailSort']))
				{
					$_COOKIE['typeSort']=2;
					$_COOKIE['dblClickSort']=false;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`email` DESC LIMIT ".($_GET['page']*3)." , 3 ";
				}
				else if ($_COOKIE['typeSort']==2 && $_COOKIE['dblClickSort'])
				{
					$_COOKIE['dblClickSort']=true;
					$_COOKIE['typeSort']=2;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`email` ASC LIMIT ".($_GET['page']*3)." , 3";
				}
				else if ($_COOKIE['typeSort']==2 && !$_COOKIE['dblClickSort'])
				{
					$_COOKIE['dblClickSort']=false;
					$_COOKIE['typeSort']=2;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`email` DESC LIMIT ".($_GET['page']*3)." , 3";
				}

				if ((isset($_POST['taskSort']) && $_COOKIE['typeSort']!=3) || (!$_COOKIE['dblClickSort'] && $_COOKIE['typeSort']==3 && (isset($_POST['taskSort'])) ))
				{
					$_COOKIE['dblClickSort']=true;
					$_COOKIE['typeSort']=3;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`status` DESC LIMIT ".($_GET['page']*3)." , 3";
				}
				else if ($_COOKIE['typeSort']==3 && $_COOKIE['dblClickSort'] && isset($_POST['taskSort']))
				{
					$_COOKIE['typeSort']=3;
					$_COOKIE['dblClickSort']=false;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`status` ASC LIMIT ".($_GET['page']*3)." , 3";
				}
				else if ($_COOKIE['typeSort']==3 && $_COOKIE['dblClickSort'])
				{
					$_COOKIE['dblClickSort']=true;
					$_COOKIE['typeSort']=3;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`status` DESC LIMIT ".($_GET['page']*3)." , 3";
				}
				else if ($_COOKIE['typeSort']==3 && !$_COOKIE['dblClickSort'])
				{
					$_COOKIE['dblClickSort']=false;
					$_COOKIE['typeSort']=3;
					$query="SELECT * FROM `Tasks` ORDER BY `Tasks`.`status` ASC LIMIT ".($_GET['page']*3)." , 3";
				}


				setcookie('typeSort',	$_COOKIE['typeSort']);
				setcookie('dblClickSort',	$_COOKIE['dblClickSort']);
					$result=mysqli_query($link,$query)or die("Ошибка запроса".mysqli_error($link));
					?>
					<div style="width:100%">
						<?php
						$link2=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link2));
						$query="SELECT * FROM `Tasks`";
						$result2=mysqli_query($link2,$query)or die("Ошибка запроса".mysqli_error($link2));
						mysqli_close($link2);
						$countPages=(mysqli_num_rows($result2)/3);
								for($i=0;$i<$countPages;$i++){
									echo "<a href='index.php?page=".$i."' class='btn btn-primary'>".($i+1)."</a>" ;
								}
						 ?>
					</div>
					<?php
					echo "<table class='table table-bordered table-striped'>";

						for($i=0;$i<3;$i++){
							$row=mysqli_fetch_row($result);
							if ($row[1]!="") {
								echo "<tr><th>".$row[1]."</th><th>".$row[2]."</th><th>".$row[3]."</th><th>".($row[4] == 1 ? "Готово" : "В процессе")."</th></tr>";
							}

						}
					echo "</table>";
				mysqli_close($link);
				?>
    </body>
	</html>
