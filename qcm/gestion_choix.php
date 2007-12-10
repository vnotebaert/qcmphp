<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : gestion des choix
 * 
 */
/* css Zen Garden is a faboulous web site wisite them at http://www.csszengarden.com/ : A demonstration of what can be accomplished visually through CSS-based design.*/
/* css released under Creative Commons License - http://creativecommons.org/licenses/by-nc-sa/1.0/  */

//chargement de la librairie commune :
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//FR"
            "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
	<meta name="author" content="David MASSE">
	<meta name="keywords" content="<? echo _META_KEYWORDS; ?>">
	<meta name="description" content="<? echo _META_DESCRIPTION; ?>">
	<meta name="robots" content="all">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<title>QCM</title>
	<!-- to correct the unsightly Flash of Unstyled Content. http://www.bluerobot.com/web/css/fouc.asp -->
	<script type="text/javascript"></script>
	<style type="text/css" media="all">
		@import "default.css";
	</style>
	<script type="text/javascript">
		_editor_url  = "./scripts/javascript/xinha/"  // (preferably absolute) URL (including trailing slash) where Xinha is installed
		_editor_lang = "<? echo $langue;?>";      // And the language we need to use in the editor.
	</script>
	<script type="text/javascript" src="./scripts/javascript/xinha/XinhaCore.js"></script>
	<script type="text/javascript" src="./scripts/javascript/xinha/XinhaConfig.js"></script>
	<script type="text/javascript" language="javascript" src="./scripts/javascript/cookie.js"></script>
</head>
<body <? if ($utilisateur_connecte->_testauthentification!=2) 
{
	?> onload="Javascript : document.compte_utilisateur.compte.value=getCookie('compte')"<?
}
?>>
<div id="container">
<div id="intro">
	<div id="entete">
	<h1><span><? echo _TITRE_ENTETE; ?></span></h1>
	</div>
</div>

<div id="espaceprincipal">
	<div id="module">
			<!-- Debut module -->
			<?
			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.choix.php');
			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.champ.php');

			if (isset($_GET['ic']))	$toto = new choix($_GET['ic']);
			else $toto = new choix();
			if (isset($_GET['i']) || isset($_POST["idquestion_rel"]) || isset($toto->idquestion_rel)) 
			{
				if (isset($_POST["idquestion_rel"])) 
				{
					$_GET['i']=$_POST["idquestion_rel"];
				}
				if (isset($toto->idquestion_rel)) 
				{
					$_GET['i']=$toto->idquestion_rel;
				}
				$toto->formulaire("idquestion_rel",$_GET['i']);
			}
			else 
			{
				$toto->formulaire();
			}
			?>
			<!-- Fin module -->
	</div>
	<div id="pieddepage">

			<?
			include("pied_de_page.php");
			?>

	</div>
</div>

	
	<div id="listefonction">
		<!--extra div for flexibility - this list will probably be the trickiest spot you'll deal with -->
		<div id="listefonction2">

		<!-- If you're wondering about the extra &nbsp; at the end of the link, it's a hack to meet WCAG 1 Accessibility. -->
		<!-- I don't like having to do it, but this is a visual exercise. It's a compromise. -->
			<div id="lselect">
				<?
				if ($_POST["suppression"]!="1" && $_GET["suppression"]!="1")
				{
				?>
				<h3 class="select"><span><? echo _FONCTION_SELECTION; ?></span></h3>
				<!-- list of links begins here. There will be no more than 8 links per page -->
				<ul>
					<li><a href="index.php" title="<? echo _RETOUR_ACCUEIL_TITLE; ?>" accesskey="a"><? echo _RETOUR_ACCUEIL_LINK;?></a>&nbsp;</li>
					<? if ($page_question!="" && (isset($toto->identifiant) || isset($_GET['i']))) 
					{ 
						?><li><a href="<? echo $page_question; ?>?i=<?
						if (isset($toto->identifiant))
						{
							$toto = new choix($toto->identifiant);
							echo $toto->idquestion_rel;
						}
						else echo $_GET['i'];
						?>" title="<? echo _RETOUR_A_LA_QUESTION_TITLE; ?>" accesskey="q"><? echo _RETOUR_A_LA_QUESTION_LINK; ?></a>&nbsp;</li>
						<?
					}
					?>
				</ul>
				<?
				}
				?>
			</div>			
		</DIV>
	</DIV>
</DIV>
<?
include("extra_div.php");
?>
</body>
</html>