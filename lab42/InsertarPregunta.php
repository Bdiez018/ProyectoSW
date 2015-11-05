<?php
//antes de executar la query, algunas validation del form

	session_start();
	
	/*
	*   test_input
	*
	*   Parametros:
	*       $data: dato en entrada del formulario 
	*   Explicación:
	*   	trim: esta función devuelve una cadena con espacios en 
	*   	blanco eliminados desde el principio y el final de $data.
	*   	stripslashes: devuelve una cadena con barras invertidas quitó.
	*   	htmlspecialchars: convertir caracteres especiales a entidades HTML
	*   Return: cadena limpia
	*/

	function test_input($data) {
		$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}

	/*
	*   test_required_params
	*
	*   Explicación:
	*   	esta función comprueba si los datos obligatorios del formulario estan definen, y ellos no estan vacios.
	*   Return: TRUE si por lo menos un campo està empty, FALSE de otra manera
	*/

	function test_required_params()
	{
		return (empty($_POST['correo']) || empty($_POST['pass']));
	}

	/*
	*   test_respect_pattern
	*
	*   Explicación:
	*   	esta función comprueba si los patrones de algunos campos son correctos.
	*   Return: TRUE si por lo menos un campo no respeta el patrón, FALSE de otra manera
	*/

	function test_pattern_mail()
	{
		return (!preg_match( "/^([a-z][a-z]*)[0-9]{3}@ikasle.ehu.(es|eus)$/", $_POST['correo']));
	}

	/*
	*   test_other
	*
	*   Explicación:
	*   	esta función comprueba otras validaciones del formulario
	*   Return: FALSE si todo ha ido correctamente, TRUE de otra manera
	*/

	function test_other()
	{
		if( strlen($_POST['pass']) < 6 ) return true;	
		return false;
	}

	//comprobación si la session está aberta

	if(!isset($_SESSION['user']))
	{
		
		//comprobación si el metodo del form es lo mismo de Registro.html
		if(test_required_params() || test_pattern_mail() || test_other())
		{
			header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/Login.php");
		}
		
		//prueba comprobación
		
		$host = "mysql.hostinger.es";//host de la base de datos
		$user = "u302247169_bb";//usuarios de la base de datos
		$password = "yrKuTfQ0KY";//contrasena de la base de datos
		$dbname = "u302247169_quiz";//nombre base de datos

		$link = new mysqli($host, $user, $password, $dbname);//conneción a mysqli

		//prueba de connecion
 
		if (!$link) {
		    echo "No podemos conectar el db" . PHP_EOL;
		    echo "No podemos conectar el db - errno - " . mysqli_connect_errno() . PHP_EOL;
		    echo "No podemos conectar el db - error - " . mysqli_connect_error() . PHP_EOL;
		    exit(1);
		}

		//todos los campos son comprobados
		$mail = $link->real_escape_string($_POST['correo']);
		$pass = $link->real_escape_string($_POST['pass']);

		//cojer los datos desde las variables (POST o GET depiende desde el form)
		
		$query = "SELECT COUNT(*) FROM UsuarioVerFoto WHERE mail='$mail' AND pass='$pass'";
		
		$result;

		if(($result = $link->query($query)))
		{
			if($result->num_rows == 1)//al menos un usuario
			{
				$row = $result->fetch_row();
				if($row[0] == 1)
				{
					$_SESSION['user'] = $mail;
					
					//registración de la conexión del usuario en la BD
					
					//query que vamos a realizar

					$query_conexion = "INSERT INTO CONEXIONES (correo,hora) VALUES (?,now())";
			
					//comprobar la coretesa de la query o traves el metodo prepare
			
					$query_insert_obj_conexion = $link->prepare($query_conexion);
					
					if($query_insert_obj_conexion !== FALSE)
					{
						//la query no tiene ningun error
				
						//binds los parametros
						
						$query_insert_obj_conexion->bind_param("s",$_SESSION['user']);
				
						$result_execution_conexion = $query_insert_obj_conexion->execute();
				
						if($result_execution_conexion === FALSE)
						    echo "<p style='color:red;'>No podemos registrar la conexion! </p>" . mysqli_error($link);
				
					}else
					{
						echo "<p style='color:red;'>Error en la peticion para la DB! </p>" . mysqli_error($link);
					}
					
					//cerrar el objeto
				
					$query_insert_obj_conexion->close();
				}else
				{
					header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/Login.php?err=useropass");
				}	
			}
			else
			    header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/Login.php");	
		}
					
		$link->close();//siempre cerrar, cada conneccion es muy cara por la base de datos

	}
?>
<!-- 
	Asignatura: Sistemas Web
	Title: Laboratio 4 - Seguridad
	File: InsertarPregunta.php   
	BORJA DIEZ - SIMONE BRAZZO 
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Insertar Preguntas</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="jquery-1.11.3.min.js"></script>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
	</head>
	<body>
		<div id="cont_informatika_fakultatea"><img src="./informatika_fakultatea.jpg" alt="Informatika Fakultatea" title="Informatika Fakultatea"></img></div>
		<?php
			include('menu.html');
		?>
		<div id="form-container" style="text-align:center;">
			<h1>Insertar Pregunta</h1> 
			<form action="insert_pregunta.php" method="POST" id="form-login">
				<table class="tab" border="0">
				  <tr>
				    <td class="tab-td_1"><span class="field_name">Pregunta:</span></td>
				    <td class="tab-td_2"><span class="input_name">
				    	<span class="input_name">
				    		<textarea name="pregunta" value="pregunta" rows="4" cols="38" required></textarea>
				    	</span>
				    </td>
				  </tr>
				  <tr>
				    <td class="tab-td_1"><span class="field_name">Respuesta:</span></td>
				    <td class="tab-td_2">
				    	<span class="input_name">
				    		<textarea name="respuesta" value="respuesta" rows="4" cols="38" required></textarea>
				    	</span>
				    </td>
				  </tr>
				  <tr>
				    <td class="tab-td_1"><span class="field_name">Complegidad:</span></td>
				    <td>
				    <fieldset>
					    <legend>Seleccione una de las siguientes</legend>
					    <input type="radio" name="complegidad" value="1" checked="checked"/><label for="track">1</label><br />
					    <input type="radio" name="complegidad" value="2"  /><label for="event">2</label><br />
					    <input type="radio" name="complegidad" value="3" /><label for="message">3</label><br />
					    <input type="radio" name="complegidad" value="4" /><label for="message">4</label><br />
					    <input type="radio" name="complegidad" value="5" /><label for="message">5</label><br />
					</fieldset>
				    </td>
				  </tr>
				  <tr>
				    <td class="tab-td_1 collspan_2" colspan="2"><span><input type="submit" value="Envia" title="Vamos a insertar pregunta!"/></span></td>
				  </tr>
				  <?php
				      if(isset($_GET['insert']))
				      {
				          if(strcmp($_GET['insert'], "ok") == 0)
						  {
				  ?> 
				  		  <tr>
				  		  	  <td class="tab-td_1 collspan_2" colspan="2" style="color:blue;">Pregunta insertada</td>
				  		  </tr>
				  <?php
						  }else if(strcmp($_GET['insert'], "ko") == 0)
						  {
				  ?>
				  		  <tr>
				  		  	  <td class="tab-td_1 collspan_2" colspan="2" style="color:red;">Error en el insertar la pregunta</td>
				  		  </tr>
				  <?php
					      }
				      }
				  ?>
				</table>
			</form>
		</div>
	</body>
</html>