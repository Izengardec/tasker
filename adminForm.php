<?php

require_once 'connection.php';
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
      <form method="post" action="loginForm.php">
        <input type="submit" class="btn btn-outline-primary" name = "logout" value="Logout" style="margin: 5px;">
      </form>
				<form method="post">
          <input type="submit" class="btn btn-primary" name="logSort" value="Сортировка по имени" style="margin: 5px;">
					<input type="submit" class="btn btn-primary"  name="emailSort" value="Сортировка по email" style="margin: 5px;">
					<input type="submit" class="btn btn-primary" name = "taskSort" value="Сортировка по готовности" style="margin: 5px;">
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

				 if ((isset($_POST['emailSort']) && $_COOKIE['typeSort']!=2) || (!$_COOKIE['dblClickSort'] && $_COOKIE['typeSort']==2 && (isset($_POST['logSort'])) ))
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

				if ((isset($_POST['taskSort']) && $_COOKIE['typeSort']!=3) || (!$_COOKIE['dblClickSort'] && $_COOKIE['typeSort']==3 && (isset($_POST['logSort'])) ))
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
				echo "<form method='post'>
        <table class='table table-bordered table-striped'>";

					for($i=0;$i<3;$i++){
						$row=mysqli_fetch_row($result);
            if (isset($_POST['submit'])){
              if ($_COOKIE['login']!=0){
                if ($_POST["text".$i]!=$row[3] || $_POST["chk".$i]!=($row[4] == 1 ? "on" : "")){
                  $link2=mysqli_connect($host,$user,$password,$database) or die("Ошибка".mysqli_error($link2));
              		mysqli_set_charset($link2,"utf8");
                  if ($_POST["text".$i]!=$row[3]){
              		    $query="UPDATE `Tasks` SET `task`='".$_POST['text'.$i]."(изменено Администратором)',`status`=".($_POST["chk".$i]== '' ? 0 : 1)." WHERE id=".$row[0].";";
                      $row[3]=strip_tags($_POST['text'.$i]."(изменено Администратором)");
                    } else {
                      $row[3]=strip_tags($_POST['text'.$i]);
                      $query="UPDATE `Tasks` SET `status`=".($_POST["chk".$i]== '' ? 0 : 1)." WHERE id=".$row[0].";";
                    }
              		$result2=mysqli_query($link2,$query)or die("Ошибка запроса".mysqli_error($link2));

                  $row[4]=($_POST["chk".$i]== '' ? 0 : 1);
                  echo $_POST["chk".$i];
              		mysqli_close($link2);
                }
              } else {
                header ('Location: loginForm.php');
              }
            }
						if ($row[1]!="") {
							echo "<tr><th>".$row[1]."</th><th>".$row[2]."</th><th><input type='text' class='form-control'  name='text".$i."' value='".$row[3]."' required></th><th>".($row[4] == 1 ? "<input name='chk".$i."' type='checkbox' value='on' checked>" : "<input name='chk".$i."' type='checkbox'>")."</th></tr>";
						}

					}
				echo "</table>
				<input type='submit' class='btn btn-primary' name='submit'>
				</form>";
				mysqli_close($link);
				?>
    </body>
	</html>
