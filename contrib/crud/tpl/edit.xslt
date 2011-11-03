<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
	version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns="http://www.w3.org/1999/xhtml">

	<xsl:import href="index.xslt" />
	<xsl:include href="form.xslt" />
	
	<xsl:output
		method="xml" 
		indent="yes" 
		encoding="UTF-8" 
		omit-xml-declaration="yes"
		doctype-public="-//W3C//DTD XHTML 1.1//EN" 
		doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" />
		
	<xsl:template name="crud.content">
		<h1>Bearbeiten</h1>
		<xsl:apply-templates select="/root/description/fields" mode="crud.form" />
	</xsl:template>
</xsl:stylesheet>