<html>
	<head>	
		<script type="text/javascript">
			function mostarPreguntas(){
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function(){
					if(xmlhttp.readyState >= 0 && xmlhttp.readyState < 4){
						document.getElementById("intro").innerHTML = "cargando...";
					}else if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
						document.getElementById('intro').innerHTML = xmlhttp.responseText;
					}
				}
			xmlhttp.open("GET","ver_preguntas2.php",true);
			xmlhttp.send();
			}
		</script>
	</head>
	<body>
		<input type="button" name="preguntas" value="Ver Preguntas" onClick="mostarPreguntas()">
		<div id="mostar preguntas">
			<p id="intro">Aqui se mostraran las preguntas</p>
		</div>
	</body>
</html>