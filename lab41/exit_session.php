<?php
	session_start();
	$_SESSION = array();
	session_destroy();
	header("location: http://sistemaswebsimonebrazzo.hol.es/Lab4Seguridad/Login.php");
?>
