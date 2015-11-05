<?php
	header('Content-Type: text/html; charset=utf-8');
	//empeza la session
	session_start();
	
	/*
	*   test_required_params
	*
	*   Explicación:
	*   	esta función comprueba si los datos obligatorios del formulario estan definen, y ellos no estan vacios.
	*   Return: TRUE si por lo menos un campo està empty, FALSE de otra manera
	*/

	function test_required_params()
	{
		return (empty($_POST['pregunta']) || empty($_POST['respuesta']) || empty($_POST['complegidad']));
	}
	
	//comprobacón si el utente tiene una session valida
	
	if(isset($_SESSION['user']))
	{
		
		//comprobación si el metodo del form es lo mismo de Registro.html
		if(test_required_params())
		{
			header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4Seguridad/Login.php");
		}
				
		//datos base de datos
				
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
						
		$pregunta = $link->real_escape_string($_POST['pregunta']);
		$respuesta = $link->real_escape_string($_POST['respuesta']);
		$complegidad = $_POST['complegidad'];
		
		//query que vamos a realizar

		$query = "INSERT INTO preguntas (mail,pregunta,respuesta,complegidad) VALUES (?,?,?,?)";

		//comprobar la coretesa de la query o traves el metodo prepare

		$query_insert_obj = $link->prepare($query);
		

		if($query_insert_obj !== FALSE)
		{
			//la query no tiene ningun error

			//binds los parametros
			
			$correo = $_SESSION['user'];
			
			echo "$pregunta<br>$respuesta<br>$complegidad<br>";
			
			$query_insert_obj->bind_param("ssss",$correo,$pregunta,$respuesta,$complegidad);

			$result_execution = $query_insert_obj->execute();
			
			//cerrar la declaración

			$query_insert_obj->close();
			
			//comprobación risultados

			if($result_execution)
			{
				//registración de la acción del usuario en la BD
			
				//variables para la query
				
				$correo = $_SESSION['user'];
						
				$id_conn = session_id();
				
				$tipo_acc = 'ins';
			
				$ip_connexion = $_SERVER['REMOTE_ADDR'];
				
				//query que vamos a realizar
	
				$query_accion = "INSERT INTO ACCIONES (id_conn,correo,tipo,hora,dir_ip) VALUES ('$id_conn','$correo','$tipo_acc',now(),'$ip_connexion')";
								
				$link->query($query_accion);
				
				$link->close();//siempre cerrar el link, cada conneccion es muy cara por la base de datos
				
				/*
				 * GESTIÓN XML - LABORATORIO 4 XML
				 */
				
				//gestión de el fichero XML, cuando todo he hizo bien con la BD
				
				$xml_file = simplexml_load_file("preguntas.xml");
				
				if($xml_file === FALSE)
					header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/InsertarPregunta.php?insert=ko");
				else{
					
					//crear un nuevo elemento hijo de el nodo radix
					
					$assessmentItem = $xml_file->addChild("assessmentItem");
					
					$assessmentItem->addAttribute("complexity",$complegidad);
					
					$assessmentItem->addAttribute("subject","Web");
					
					//crear los otros nodos de conseguencia
					
					$itemBody = $assessmentItem->addChild("itemBody");
					
					$itemBody->addChild("p",$pregunta);
					
					$correctResponse = $assessmentItem->addChild("correctResponse");
					
					$correctResponse->addChild("value",$respuesta);
					
					$xml_file->asXML('preguntas.xml');
					
				}
				
				header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/InsertarPregunta.php?insert=ok");	
			
			}
			else
				header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/InsertarPregunta.php?insert=ko");
			
		}else
		{
			header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/InsertarPregunta.php?insert=ko");
		}

		$link->close();//siempre cerrar el link, cada conneccion es muy cara por la base de datos
		
		
	}else
	{
	    header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4XML/Login.php");	
	}
?>