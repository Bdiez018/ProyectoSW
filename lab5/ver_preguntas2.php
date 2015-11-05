<!DOCTYPE html>
<html>
	<head>
    	<title>Preguntas</title>
    	<meta charset="UTF-8">
    	<link rel="stylesheet" type="text/css" href="style.css">
    	<link rel="stylesheet" type="text/css" href="table_style.css">
    	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
	</head>
	<body>
		<?php
		?>
		<div style="    text-align: center;width: 500px;margin: 0 auto;">
			<h1>Preguntas</h1>
			<?php
				
			session_start();
				
			//datos base de datos
					
			/*$host = "mysql.hostinger.es";//host de la base de datos
			$user = "u302247169_bb";//usuarios de la base de datos
			$password = "yrKuTfQ0KY";//contrasena de la base de datos
			$dbname = "u302247169_quiz";//nombre base de datos*/
			
			$host = "localhost";//host de la base de datos
			$user = "root";//usuarios de la base de datos
			$password = "";//contrasena de la base de datos
			$dbname = "quiz";//nombre base de datos
			
			$link = new mysqli($host, $user, $password, $dbname);//conneción a mysqli
	
			//prueba de connecion
			if (!$link) {
			    echo "No podemos conectar el db" . PHP_EOL;
			    echo "No podemos conectar el db - errno - " . mysqli_connect_errno() . PHP_EOL;
			    echo "No podemos conectar el db - error - " . mysqli_connect_error() . PHP_EOL;
			    exit(1);
			}
			/*  WHERE mail =.'$_SESSION['user']'.*/
			if(isset($_SESSION['user'])){
				$query = "SELECT pregunta, complegidad FROM preguntas ORDER BY complegidad ASC";
			
				if($results = $link->query($query))
				{
					if($results->num_rows > 0){
					?>
					<p>Estas son las preguntas:</p>
					<table style="text-align: center;display: inline-block;" cellspacing='0'>
						<tr><th>Pregunta</th><th>Complegidad</th></tr><!-- Table Header -->
					<?php
						$change_style = false;
						while ($row = $results->fetch_row()){
					?>
							<tr <?php if($change_style) echo "class='even'"; ?>><td><?php echo $row[0]?></td><td><?php echo $row[1]?></td></tr>
					<?php	
							$change_style = !$change_style;
						}
					?>
					</table>
					<?php				
					}
				}
				$link->close();//siempre cerrar el link, cada conneccion es muy cara por la base de datos
			}else{
				echo '<h1>No estas logeado, no te la jueges</h1>';
			}
			?>	

		</div>
	</body>
</html>