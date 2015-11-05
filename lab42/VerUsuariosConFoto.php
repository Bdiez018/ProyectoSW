<!DOCTYPE html><!-- Declaración tipología documento -->
<!-- Sistemas Web, formularios Laboratio 4 - Seguridad - BORJA DIEZ - SIMONE BRAZZO -->
<html>
    <title>Ver Usuarios</title>
    <head>
	    <meta charset="UTF-8">
	    <meta name="description" content="Usuarios Base de Datos">
	    <meta name="keywords" content="Usuarios">
		<meta name="author" content="Borja Diez, Simone Brazzo">
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
	</head>
	<body>
		<div style="text-align: center;" id="cont_informatika_fakultatea"><img src="./informatika_fakultatea.jpg" alt="Informatika Fakultatea" title="Informatika Fakultatea"></img></div>
		<?php
			include('menu.html');
		?>
		<h1>Listado Completo Usuarios</h1>
		<p>Nuevo usuario?<a href="Registro.html">Regístrese ahora</a></p>
		<?php

			$host = "mysql.hostinger.es";//host de la base de datos
			$user = "u302247169_bb";//usuarios de la base de datos
			$password = "yrKuTfQ0KY";//contrasena de la base de datos
			$dbname = "u302247169_quiz";//nombre base de datos

			$link = new mysqli($host, $user, $password, $dbname);

			//prueba de conneción con la BD

			if (!$link) {
			    echo "No podemos conectar el db" . PHP_EOL;
			    echo "No podemos conectar el db - errno - " . mysqli_connect_errno() . PHP_EOL;
			    echo "No podemos conectar el db - error - " . mysqli_connect_error() . PHP_EOL;
			    exit();
			}

			//query que queremos realizar

			$query = "SELECT mail, nombre, telefono, especialidad, interes , foto FROM UsuarioVerFoto";

			$result;

			if(($result = $link->query($query))) // realizar y almacenar query
			{
				//si todo a ido bien

				if($result->num_rows > 0) //al menos un usuario
				{
				?>
					<table id="table-usuarios" border="1px">
						<tr>
							<th>Mail</th><th>Nombre</th><th>Telefono</th><th>Especialidad</th><th>Interes</th><th>Foto</th>
						</tr>
						<?php
						while($row = $result->fetch_row()) //iteración para cada resultado en la BD
						{
						?>
							<tr>
								<td><?php echo $row[0]; ?></td><td><?php echo $row[1]; ?></td><td><?php echo $row[2]; ?></td><td><?php echo $row[3]; ?></td><td><?php echo $row[4]; ?></td>
								<td><?php echo '<img style="width:200px;height:auto;" src="data:image/png;base64,'.base64_encode( $row[5] ).'"/>'; ?></td>
							</tr>
						<?php	
						}
						?>
					</table>
				<?php
				}else
				{
					//ningun usuario en la BD
				?>
					<p style="color:red;">Ningun usuario en la base de datos</p>
		<?php
				}
			}

			$link->close();//siempre cerrar el link, cada conneccion es muy cara por la base de datos
		?>
	</body>
</html>