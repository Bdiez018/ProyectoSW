<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<HTML>
	<BODY>
		<TABLE border="1">
		<THEAD>
			<TR><TH>COMPLEGIDAD</TH><TH>TEMA</TH><TH>PREGUNTA</TH> <TH>RESPUESTA</TH> </TR>
		</THEAD>
		<xsl:for-each select="/assessmentItems/assessmentItem">
		<TR>
			<TD>
				<FONT SIZE="3" COLOR="black" FACE="Verdana">
				<xsl:value-of select='@complexity'/> <BR/><!--ESTO ES PARA EL ATRIBUTO-->
				</FONT>
			</TD>
			<TD>
				<FONT SIZE="3" COLOR="black" FACE="Verdana">
				<xsl:value-of select='@subject'/> <BR/><!--ESTO ES PARA EL ATRIBUTO-->
				</FONT>
			</TD>
			<TD>
				<FONT SIZE="3" COLOR="black" FACE="Verdana">
				<xsl:value-of select="itemBody/p"/> <BR/>
				</FONT>
			</TD>
			<TD>
				<FONT SIZE="3" COLOR="black" FACE="Verdana">
				<xsl:value-of select="correctResponse/value"/> <BR/>
				</FONT>
			</TD>
			</TR>
		</xsl:for-each>
		</TABLE>
	</BODY>
</HTML>
</xsl:template>
</xsl:stylesheet>