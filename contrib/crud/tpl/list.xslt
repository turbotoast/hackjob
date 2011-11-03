<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet 
	version="1.0" 
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
	xmlns="http://www.w3.org/1999/xhtml">

	<xsl:import href="index.xslt" />
	
	<xsl:output
		method="xml" 
		indent="yes" 
		encoding="UTF-8" 
		omit-xml-declaration="yes"
		doctype-public="-//W3C//DTD XHTML 1.1//EN" 
		doctype-system="http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" />
		
	<xsl:template name="crud.content">
		<h1>Liste</h1>
		<xsl:apply-templates select="/root/description/allowNew[text() = 'true']" />
		<xsl:apply-templates select="/root/list[count(*) &gt; 0]" />
	</xsl:template>
	
	<xsl:template match="allowNew">
		<a>
			<xsl:attribute name="href"><xsl:value-of select="concat($basepath, '/', $crud_slug, '/', /root/description/app/slug, '/new/')" /></xsl:attribute>
			Hinzufügen
		</a>
	</xsl:template>
	
	<xsl:template match="list">
		<table>
			<thead>
				<tr>
					<xsl:apply-templates select="/root/description/fields/HackJob_Contrib_CRUD_Field[showInList = 'true']" mode="crud.tablehead" />
					<th>
						Funktionen
					</th>
				</tr>
			</thead>
			<tbody>
				<xsl:apply-templates select="/root/list/*" mode="crud.tablebody" />
			</tbody>
		</table>
	</xsl:template>
	
	<xsl:template match="list/*" mode="crud.tablebody">
		<tr>
			<xsl:for-each select="*">
				<xsl:variable name="nodename"><xsl:value-of select="name()" /></xsl:variable>
				<xsl:if test="/root/description/fields/HackJob_Contrib_CRUD_Field[field = $nodename and showInList = 'true']">
					<td><xsl:value-of select="." /></td>
				</xsl:if>
			</xsl:for-each>
			<td>
				<a>
					<xsl:attribute name="href"><xsl:value-of select="concat($basepath, '/', $crud_slug, '/', /root/description/app/slug, '/edit/', id, '/')" /></xsl:attribute>
					Edit
				</a>
				<a>
					<xsl:attribute name="href"><xsl:value-of select="concat($basepath, '/', $crud_slug, '/', /root/description/app/slug, '/del/', id, '/')" /></xsl:attribute>
					Del
				</a>
			</td>
		</tr>
	</xsl:template>
	
	<xsl:template match="HackJob_Contrib_CRUD_Field" mode="crud.tablehead">
		<th>
			<xsl:value-of select="name" />
		</th>
	</xsl:template>
	
	<xsl:template match="list/*">
		<xsl:value-of select="handle" />
	</xsl:template>
</xsl:stylesheet>