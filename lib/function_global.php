<?
function enter($link){
$error = array();
if ($_POST['login'] !="" && $POST['password'] !="")
{
	$login = $_POST['login'];
	$password = $_POST['password'];
	$rez = mysqli_query($link,"SELECT * FROM users WHERE login='".$login."'");
	if (mysqli_num_rows($rez) == 1)
	{
		$row = mysqli_fetch_assoc($rez);
		if ($password == $row['password'])
		{

		setcookie ("login", $row['login'], time() + 50000);
		setcookie ("password", $row['password'], time() + 50000);
		$_SESSION['id'] = $row['id'];
		$id = $_SESSION['id'];
		lastAct($id,$link);
		return $error;
		}
		else
		{
		$error[] = "Неверный пароль";
		return $error;
		}
	}
	else
	{
		$error[] = "Неверный логин и пароль";
		return $error;
	}
}
else
{
	$error[] = "Поля не должны быть пустыми!";
	return $error;
}
}

function lastAct($id,$link){
$tm = time();
mysqli_query($link,"UPDATE users SET online='$tm', last_act='$tm' WHERE id='$id'");
}

function login($link){
ini_set ("session.use_trains_sid", true);
session_start();
if (isset($_SESSION['id']))
{
	if(isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{
		SetCookie("login", "", time() - 1, '/');
		SetCookie("password","", time() - 1, '/');
		setcookie("login", $_COOKIE['login'], time() + 50000, '/';
		setcookie("password", $_COOKIE['password'], time() + 50000, '/');
		$id = $_SESSION['id'];
		lastAct($id,$link);
		return true;
	}
	else
	{
		$rez = mysqli_query($link,"SELECT * FROM users WHERE id='{$_SESSION['id']}'");
		if (mysqli_num_rows($rez) == 1) 
		{
			$row = mysqli_fetch_assoc($rez);
			setcookie ("login", $row['login'], time()+50000, '/');
			setcookie ("password", $row['password'], time() + 50000, '/');
			$id = $_SESSION['id'];
			lastAct($id,$link);
			return true;
		}
		else
			return false;
	}
}
else
{
	if(isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{
		$rez = mysqli_query($link,"SELECT * FROM users WHERE login='{$_COOKIE['login']}'");
		$row = mysqli_fetch_assoc($rez);
			if(mysqli_num_rows($rez) == 1 && $row['password'] == $_COOKIE['password'])
			{
				$_SESSION['id'] = $row['id'];
				$id = $_SESSION['id'];
				lastAct($id,$link);
				return true;
			}
			else
			{
				SetCookie("login", "", time() - 360000, '/');
				SetCookie("password", "", time() - 360000, '/');
				return false;
			}
	}
	else
	{
		return false;
	}
}
}

function is_admin($id,$link){
$rez = mysqli_query($link,"SELECT prava FROM users WHERE id='$id'");
if (mysqli_num_rows($rez) == 1)
{
	$prava = mysqli_fetch_assoc($rez);
	if ($prava['prava'] == 1) return true;
	else return false;
}
else
	return false;
}

function out($link){
session_start();
$id = $_SESSION['id'];
mysqli_query($link,"UPDATE users SET online=0 WHERE id=$id");
unset($_SESSION['id']);
unset($_COOKIE['login']);
unset($_COOKIE['password']);
SetCookie("login", "");
SetCookie("password", "");
header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
}

?>