<?php
	header('Content-Type: text/html; charset=UTF-8');
	mysql_connect("mysql.hostinger.es","u998980514_god","sistemasweb") or die(mysql_error());
	mysql_select_db("u998980514_quiz") or die(mysql_error());
	echo'<table border=1 align="center"> <tr><th>Nombre</th><th>Correo</th><th>Especialidad</th><th>Foto</th></tr>';
	$sql=mysql_query("SELECT * from usuario");
	while($linea=mysql_fetch_array($sql)){
		echo'<tr><td>'.$linea['nombre'].'</td><td>'.$linea['email'].'</td><td>'.$linea['especialidad'].'</td><td>'.$linea['foto'].'</td></tr>';
	}
	echo'</table>';
?>