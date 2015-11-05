<!DOCTYPE html><!-- Declaración tipología documento -->
<!-- Sistemas Web, formularios Laboratio 4 - Seguridad - BORJA DIEZ - SIMONE BRAZZO -->
<html>
    <title>Preguntas</title>
    <meta charset="UTF-8">
	<body>
		<h1>Estas son las preuntas de nuestra BD</h1>
		<?php
			header('Content-Type: text/html; charset=UTF-8');
			
		/*	$host = "mysql.hostinger.es";//host de la base de datos
			$user = "u998980514_god";//usuarios de la base de datos
			$password = "sistemasweb";//contrasena de la base de datos
			$dbname = "u998980514_quiz";//nombre base de datos*/
			
			$host = "localhost";//host de la base de datos
			$user = "root";//usuarios de la base de datos
			$password = "";//contrasena de la base de datos
			$dbname = "quiz";//nombre base de datos
			
			$acceso = new mysqli($host,$user,$password,$dbname);
			
			if(!$acceso){
				echo "No podemos conectar el db" . PHP_EOL;
				echo "No podemos conectar el db - errno - " . mysqli_connect_errno() . PHP_EOL;
				echo "No podemos conectar el db - error - " . mysqli_connect_error() . PHP_EOL;
			}
			
			$query = "SELECT pregunta, complegidad FROM preguntas order by complegidad ASC";
			
			$resultado= $acceso->query($query);
			if($resultado->num_rows > 0){
				echo 'hay al menos uno';
			}else{
				echo 'no hay nada';
			}
		?>
			<p>estas son las preguntas</p>
			<select name="preguntas">
			<?php
			while ($row = $resultado->fetch_row()){
			?>
				<option><?php echo $row[1]?>---<?php echo $row[0]?></option>
			<?php	
			}
			?>
			</select>
	</body>
</html>
		
