<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
	version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns="http://www.w3.org/1999/xhtml">
	
	<xsl:output
		method="xml" 
		indent="yes" 
		encoding="UTF-8" 
		omit-xml-declaration="yes"
		doctype-public="-//W3C//DTD XHTML 1.1//EN" 
		doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" />
		
	<xsl:param name="crud_slug" />
	<xsl:param name="basepath" />
		
	<xsl:template match="/">
		<xsl:call-template name="base" />
	</xsl:template>
	
	<xsl:template name="base">
		<html>
			<head>
				<title>HackJob CRUD</title>
				<link rel="stylesheet" type="text/css">
					<xsl:attribute name="href"><xsl:value-of select="concat($basepath, '/', $crud_slug, '/media/crud.css')" /></xsl:attribute>
				</link>
			</head>
			<body>
				<xsl:apply-templates select="/root/descriptions" mode="crud.navigation" />
				<div id="wrapper">
					<xsl:call-template name="crud.content" />
				</div>
			</body>
		</html>
	</xsl:template>
	
	<xsl:template match="descriptions" mode="crud.navigation">
		<ul class="navigation">
			<li>
				<a>
					<xsl:attribute name="href"><xsl:value-of select="concat($basepath, '/', $crud_slug, '/')"/></xsl:attribute>
					Start
				</a>
			</li>
			<xsl:apply-templates select="*" mode="crud.navigation" />
		</ul>
	</xsl:template>
	
	<xsl:template match="descriptions/*" mode="crud.navigation">
		<li>
			<a>
				<xsl:attribute name="href"><xsl:value-of select="concat($basepath, '/', $crud_slug, '/', app/slug, '/')"/></xsl:attribute>
				<xsl:value-of select="app/name" />
			</a>
		</li>
	</xsl:template>
	
	<xsl:template name="crud.content">
		<h1>HackJob CRUD</h1>
		<p>Bitte wählen Sie auf der linken Seite eine Applikation aus.</p>
	</xsl:template>
</xsl:stylesheet>