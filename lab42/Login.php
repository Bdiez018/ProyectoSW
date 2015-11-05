<!-- 
	Asignatura: Sistemas Web
	Title: Laboratio 4 - Seguridad
	File: login.php  
	BORJA DIEZ - SIMONE BRAZZO 
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
		<script type="text/javascript" src=""></script><!-- Libreria JQuery 1.11.3 restricta -->
		<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
		<meta charset="UTF-8">
		<meta name="description" content="Login">
		<meta name="keywords" content="HTML5,Login">
		<meta name="author" content="Borja Diez, Simone Brazzo">
	</head>
	<body>
		<div id="cont_informatika_fakultatea"><img src="./informatika_fakultatea.jpg" alt="Informatika Fakultatea" title="Informatika Fakultatea"></img></div>
		<?php
			include('menu.html');
		?>
		<div id="form-container">
			<h1>Login</h1>
			<form action="InsertarPregunta.php" method="POST" id="form-login">
				<table class="tab" border="0">
				  <tr>
				    <td class="tab-td_1"><span class="field_name">Correo:</span></td>
				    <td class="tab-td_2"><span class="input_name"><input type="email" title="Correo" name="correo"  required /></span></td>
				  </tr>
				  <tr>
				    <td class="tab-td_1"><span class="field_name">Password:</span></td>
				    <td class="tab-td_2"><span class="input_name"><input type="password" minlength="6" name="pass" required /></span>
				    </td>
				  </tr>
				  <tr>
				    <td class="tab-td_1 collspan_2" colspan="2"><span><input type="submit" value="Envia" title="Vamos a insertar pregunta!"/></span></td>
				  </tr>
				  <?php
				      if(isset($_GET['err']))
				      {
				      	  if(strcmp($_GET['err'], "useropass") == 0)
				      	  {
				  ?>
					  <tr>
					  	<td class="tab-td_2 collspan_2" colspan="2"><p style="color:red;font-size:bold;">Usuario o contraseña incorrecto</p></td>
					  </tr>
				  <?php
						  }
				      }
			      ?>
			      <tr>
				    <td class="tab-td_2 collspan_2" colspan="2"><a href="layout.html">Volver a layout.html</a></td>
				  </tr>
				  <tr>
				    <td class="tab-td_2 collspan_2" colspan="2"><p id="authors">&copy; 2015 Borja Diez - Simone Brazzo</p></td>
				  </tr>
				</table>
			</form>
		</div>
	</body>
</html>