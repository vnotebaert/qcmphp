<?php
/*
 * Cree le 22 decembre 2007
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description :  contenu de la balise head  pour l'insertion de l'editeur wysiwyg xinha
 * 
 */
 ?><script type="text/javascript" charset="utf-8">
		_editor_url  = "./scripts/javascript/xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
		_editor_lang = "<? echo $langue;?>";      // And the language we need to use in the editor.
		_editor_skin = "";
	</script>
	<script type="text/javascript" src="./scripts/javascript/xinha/XinhaCore.js" charset="utf-8"></script>
	<script type="text/javascript" src="./scripts/javascript/xinha/XinhaConfig.js" charset="utf-8"></script>
<?
?>