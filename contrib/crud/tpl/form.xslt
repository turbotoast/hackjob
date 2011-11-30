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
		
	<xsl:template match="fields" mode="crud.form">
		<form method="post">
			<xsl:attribute name="action"><xsl:value-of select="concat($basepath, '/', $crud_slug, '/', /root/description/app/slug, '/save/')" /></xsl:attribute>
			<ol>
				<xsl:apply-templates mode="crud.form" />
			</ol>
			<xsl:apply-templates select="/root/model/id" mode="crud.id" />
			<button type="submit">Speichern</button>
		</form>
	</xsl:template>
	
	<xsl:template match="id" mode="crud.id">
		<input type="hidden" name="crud[id]">
			<xsl:attribute name="value"><xsl:value-of select="." /></xsl:attribute>
		</input>
	</xsl:template>
	
	<xsl:template match="HackJob_Contrib_CRUD_Field" mode="crud.form">
		<li>
			<label>
				<xsl:attribute name="for">crud_<xsl:value-of select="field" /></xsl:attribute>
				<xsl:value-of select="name" />
			</label>
			<xsl:apply-templates select="." mode="crud.form.field" />
		</li>
	</xsl:template>
	
	<xsl:template match="HackJob_Contrib_CRUD_Field[type = 'text']" mode="crud.form.field">
		<input type="text" class="text">
			<xsl:attribute name="name">crud[<xsl:value-of select="field" />]</xsl:attribute>
			<xsl:attribute name="id">crud_<xsl:value-of select="field" /></xsl:attribute>
			<xsl:attribute name="value">
				<xsl:apply-templates select="/root/model/*[name() = current()/field]" />
			</xsl:attribute>
			<xsl:if test="editable='false'"><xsl:attribute name="disabled">disabled</xsl:attribute></xsl:if>
		</input>
	</xsl:template>
	
	<xsl:template match="HackJob_Contrib_CRUD_Field[type = 'textarea']" mode="crud.form.field">
		<textarea>
			<xsl:attribute name="name">crud[<xsl:value-of select="field" />]</xsl:attribute>
			<xsl:attribute name="id">crud_<xsl:value-of select="field" /></xsl:attribute>
			<xsl:if test="editable='false'"><xsl:attribute name="disabled">disabled</xsl:attribute></xsl:if>
			<xsl:choose>
				<xsl:when test="/root/model/*[name() = current()/field]">	
					<xsl:apply-templates select="/root/model/*[name() = current()/field]" />
				</xsl:when>
				<xsl:otherwise>
					&#160;
				</xsl:otherwise>
			</xsl:choose>
		</textarea>
	</xsl:template>
	
</xsl:stylesheet>