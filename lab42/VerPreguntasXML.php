<?php
	$xslDoc = new DOMDocument();
    $xslDoc->load("preguntas_tabla.xsl");

    $xmlDoc = new DOMDocument();
    $xmlDoc->load("preguntas.xml");

    $proc = new XSLTProcessor();
    $proc->importStylesheet($xslDoc);
    echo $proc->transformToXML($xmlDoc);
?>