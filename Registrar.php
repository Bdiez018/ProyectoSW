<?php
	header('Content-Type: text/html; charset=UTF-8');
	mysql_connect("mysql.hostinger.es","u998980514_god","sistemasweb") or die(mysql_error());
	mysql_select_db("u998980514_quiz") or die(mysql_error());
	$sql="INSERT INTO usuario(nombre,email,pass,telefono,especialidad,interes) VALUES ('$_POST[nameyapp]','$_POST[correo]','$_POST[password]','$_POST[tel]','$_POST[espec]','$_POST[interes]')";
	if(!mysqli_query($sql)){
		die('Error:' .mysqli_error());
	}
	echo "1 registro añadido";
	mysql_close();
?>
<html>
<body>
<BR>
<a href="VerUsuarios.php">Ver usuarios de la BD</a>';  
</body>
</html>