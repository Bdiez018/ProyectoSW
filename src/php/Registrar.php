<?php
	header('Content-Type: text/html; charset=UTF-8');
	mysql_connect("mysql.hostinger.es","u998980514_god","sistemasweb") or die(mysql_error());
	mysql_select_db("u998980514_quiz") or die(mysql_error());
	$sql="INSERT INTO usuario(nombre,email,pass,telefono,especialidad,interes) VALUES ('$_POST[nameyapp]','$_POST[correo]','$_POST[password]','$_POST[tel]','$_POST[espec]','$_POST[interes]')";
	if(!mysql_query($sql)){
		die('Error:' .mysql_error());
	}
	mysql_close();
?>
<html>
	<body>
		<h1>Usuario registrado</h1>
		<BR>
		<a href="VerUsuarios.php">Ver usuarios de la BD</a>';  
	</body>
</html>