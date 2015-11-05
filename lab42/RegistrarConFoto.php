<!DOCTYPE html><!-- Declaración tipología documento -->
<!-- Sistemas Web, formularios Laboratio 4 - Seguridad BORJA DIEZ - SIMONE BRAZZO -->
<html>
<head>
    <title>Registrar</title>
    <meta charset="UTF-8">
	<meta name="description" content="Registrar">
	<meta name="keywords" content="HTML5">
	<meta name="author" content="Borja Diez, Simone Brazzo">
</head>
<body>
<?php

	//antes de executar la query, algunas validation del form

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
		return (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['pass']) || empty($_POST['tel']) || empty($_POST['espec']) || empty($_FILES['imgfile']));
	}

	/*
	*   test_respect_patterns
	*
	*   Explicación:
	*   	esta función comprueba si los patrones de algunos campos son correctos.
	*   Return: TRUE si por lo menos un campo no respeta el patrón, FALSE de otra manera
	*/

	function test_respect_patterns()
	{
		return ( !preg_match( "/([a-zA-Z][a-zA-Z]*) ([a-zA-Z][a-zA-Z]*) ([a-zA-Z][a-zA-Z]*)/", $_POST['nombre'] ) || !preg_match( "/^([a-z][a-z]*)[0-9]{3}@ikasle.ehu.(es|eus)$/", $_POST['correo'] ) || !preg_match( "/^[0-9]{9}/", $_POST['tel'] ) );
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
		if( (strcmp($_POST['espec'], "otr") !== 0) && (strcmp($_POST['espec'], "hdw") !== 0) && (strcmp($_POST['espec'], "cmp") !== 0) && (strcmp($_POST['espec'], "ingsft") !== 0)) return true;
		if( strcmp($_POST['espec'], "otr") === 0 )
			if( strlen($_POST['otra']) === 0)
				return true;		
		return false;
	}

	//comprobación si el metodo del form es lo mismo de Registro.html

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{

		$nombre = NULL;
		$email = NULL;
		$pass  = NULL;
		$telefono  = NULL;
		$interes  = NULL;
		$foto = NULL;

		//bloquear todo si se faltan algunos datos, la foto no es obligatoria

		if (test_required_params()) 
		{
	    	echo "<p style='color:red;'>Se faltan algunos campos obligatorios</p>";
	    	exit(1);
	    }
	    else if(test_respect_patterns() || test_other())
	    {
	    	echo "<p style='color:red;'>Patterns no son corectos</p>";
	    	exit(1);
		} else {
		    $nombre = test_input($_POST["nombre"]);
			$email = test_input($_POST['correo']);
			$pass  = test_input($_POST['pass']);
			$telefono  = test_input($_POST['tel']);
			
			$especialidad = $_POST['espec'];

			if(strcmp($especialidad,"otr") === 0)
				$especialidad = $_POST['otra'];
			else
				$especialidad = $_POST['espec'];

			if(!empty($_POST['interes']))
				$interes  = test_input($_POST['interes']);
			else
				$interes = "";
		}	

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

		//cojer los datos desde las variables (POST o GET depiende desde el form)

		$query = "INSERT INTO UsuarioVerFoto (nombre,mail,pass,telefono,especialidad,interes,foto) VALUES (?,?,?,?,?,?,?)";

		//comprobar la coretesa de la query o traves el metodo prepare

		$query_insert_obj = $link->prepare($query);

		if($query_insert_obj !== FALSE)
		{
			//la query no tiene ningun error

			//binds los parametros
			
			$query_insert_obj->bind_param("sssissb",$nombre,$email,$pass,$telefono,$especialidad,$interes,$foto_blob);

			//cojer la imagen desde el formulario

			$foto = $_FILES['imgfile'];

			$foto_blob = NULL;

			//control el tamano de la foto, si el tamano es demasiado grande la query no se executa, se bloquea todo

			if(($foto['size']) > 500000)
			{
				echo "<p style='color:red;'>Tamano de la foto demasiamo grande!Limit 500Kb</p>";
				$query_insert_obj->close();
				$link->close();//siempre cerrar, cada conneccion es muy cara por la base de datos
				exit(1);
			}else
			{
				//tamaño correcto
				$filecontent;
				if(($filecontent = file_get_contents($foto['tmp_name'])) !== false)
				{
					$query_insert_obj->send_long_data(6, $filecontent);//insertar todos los bits de la imagen en el parametro 6 de la quety
				}
				else
				{
					echo "<p style='color:red;'>Algunos errores en el nombre del fichero</p>";
					exit(1);
				}

			}

			$result_execution = $query_insert_obj->execute();

			if($result_execution === FALSE)
				echo "<p style='color:red;'>No podemos executar la query: </p>" . mysqli_error($link);
			else if($result_execution === TRUE)
				echo "<p>Ensertar corecto de los datos, </p><a href='VerUsuariosConFoto.php' name='Listado formulario'>Ver listado compledo usuarios</a>";

			//cerrar la declaración

			$query_insert_obj->close();
		}else
		{
			echo "<p style='color:red;'>Error en preparar la query: </p>" . mysqli_error($link);
		}

		$link->close();//siempre cerrar el link, cada conneccion es muy cara por la base de datos

	}else
	{
		echo "<p style='color:red;'>No approvado el form. </p>";
	}
?>
<body>
<html>