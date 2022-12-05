<html>
<head>
<meta charset="utf-8" />
<title>Mysite</title>
</head>
<body>
<div>
<?
if (!$UID){
	if (count($error) !=0) echo '<h5>'.$error[0].'</h5>';
	echo
<form action="/" method="post">
Логин: <input type="text" name="login" required/>

Пароль: <input type="password" name="password" required/>
<input type="submit" value="Войти" name="log_in" />

</form>
';
}
   else
	include ('./main/main.php');
?>
</div>
</body>
</html>