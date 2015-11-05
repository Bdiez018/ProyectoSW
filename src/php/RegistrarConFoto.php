<?php
	header('Content-Type: text/html; charset=UTF-8');
	function comprobar_parametros(){
		if(empty($_POST['nameyapp'])||empty($_POST['correo'])||empty($_POST['password'])||empty($_POST['tel'])||empty($_POST['espec'])){
			return false;
		}else{
			return true;
		}
	}
	$nombre=$_POST['nameyapp'];
	$email=$_POST['correo'];
	$telefono=$_POST['tel'];
	$especialidad=$_POST['espec'];
	$pass=$_POST['password'];
	$interes=$_POST['interes'];
	
	$img_log=true;
	$carpeta_img="/ProyectoSW/src/imgUser/";
	list($nick,$dominio)=split("@",$email);
	$imageFileType = pathinfo(basename($_FILES['foto']['name']),PATHINFO_EXTENSION);
	$path_final=$carpeta_img . $nick . "." . $imageFileType;
	if(file_exists($path_final)){
		echo '<h1 color="red">La imagen ya existe, usuario repetido</h1>';
		$img_log=false;
	}
	/**/
	if (move_uploaded_file($_FILES["foto"]["tmp_name"], $path_final)) {
        echo "The file ". $nick . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
	
/*	$mysqli= new mysqli ("mysql.hostinger.es","u998980514_god","sistemasweb","u998980514_quiz");
	if($mysql-> mysqli_connect_errno())
	{
		echo"Fallo al conectar con la base de datos".$mysql-> mysqli_connect_errno();
		exit(1);		
	}*/
?>