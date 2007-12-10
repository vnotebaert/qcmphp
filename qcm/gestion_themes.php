<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : gestion des themes par un administrateur
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
	<meta http-equiv="Content-Language" content="fr-FR" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta name="author" content="David MASSE">
	<meta name="keywords" content="<? echo _META_KEYWORDS; ?>">
	<meta name="description" content="<? echo _META_DESCRIPTION; ?>">
	<meta name="robots" content="all">
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
	<script type="text/javascript" language="javascript">
	<!--
	function setutilisateurconfig(){
		// create an instance of the Date object
		var now = new Date();
		// fix the bug in Navigator 2.0, Macintosh
		fixDate(now);
		// cookie expires in one year
		now.setTime(now.getTime() + 365*24*60*60*1000);
		<? if ($utilisateur_connecte->_testauthentification!=2)
		{
			?>if (! document.compte_utilisateur.compte)
			{
				var compte=document.compte_utilisateur.compte.value;
				setCookie('compte', compte, now, "", "", false);
			}<?
		}
		?>
		var langue=document.compte_utilisateur.langue.value;
		setCookie('langue', langue, now, "", "", false);
	}
	//-->
	</script>
</head>
<body>
<DIV id="container">
<div id="intro">
	<div id="entete">
	<h1><span><? echo _TITRE_ENTETE; ?></span></h1>
	</div>
</div>
<div id="espaceprincipal">
	<div id="module"><!-- Debut module --><?
			if ($utilisateur_connecte->admin=="1")
			{
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.theme.php');
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.champ.php');
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.environnement.php');
				
				if (isset($_POST['identifiant'])) 
				{
					$toto = new theme($_POST['identifiant']);
				}
				if (isset($_GET['crea']) || isset($_GET['i']) || isset($_POST['ok']) || isset($_POST['identifiant'])) 
				{
					if (isset($_GET['i'])) $toto = new theme($_GET['i']);
					elseif (isset($_POST['identifiant'])) $toto = new theme($_POST['identifiant']);
					else $toto = new theme();
					$toto->formulaire();
				}
				else if (isset($_GET['maj']))
				{
					$environnement= new environnement();
					$environnement->mise_a_jour_theme();
					$environnement->liste_themes($_GET['p']);
				}
				else if (isset($_GET['schema']))
				{
				?><img src="arbo_theme.php"><?
				}
				else 
				{
					$environnement= new environnement();
					$environnement->liste_themes($_GET['p']);
				}
			}
			else 
			{
			echo _NOT_ADMIN_GO_BACK_TO_INDEX;
			}
			?><!-- Fin module --></div>
	<div id="pieddepage"><?
			include("pied_de_page.php");
			?></div>
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
					<?
					if (!isset($_GET['crea']) && $utilisateur_connecte->admin=="1")
					{
						if ($page_theme!="" && !isset($_GET['iq'])) 
						{ 
							?><li><a href="<? echo $page_theme; ?>?crea=1" title="<? echo _CREATION_DE_THEME_TITLE; ?>" accesskey="q"><? echo _CREATION_DE_THEME_LINK; ?></a>&nbsp;</li> <? 
						} 
					}
					if(isset($_GET['i']) && $utilisateur_connecte->admin=="1")
					{
						$vi=$toto->idtheme_rel;
						if ($page_theme!="" && $vi!="") 
						{
							?><li><a href="<? echo $page_theme;
							echo "?p=$vi";
							?>" title="<? echo _GESTION_DES_THEMES_TITLE; ?>" accesskey="t"><? echo _GESTION_DES_THEMES_LINK; ?></a>&nbsp;</li><? 
						} 
					}
					if(isset($_GET['p']) && $utilisateur_connecte->admin=="1")
					{
						if ($page_theme!="") 
						{
							?><li><a href="<? echo $page_theme."?p=".$_GET['p']."&maj=1"; ?>" title="<? echo _MAJ_DES_THEMES_TITLE; ?>" accesskey="m"><? echo _MAJ_DES_THEMES_LINK; ?></a>&nbsp;</li><? 
						} 
					}
					if((isset($_POST['identifiant'])|| isset($_POST['ok'])) && $utilisateur_connecte->admin=="1")
					{
						if ($page_theme!="") 
						{
							?><li><a href="<? echo $page_theme;
							$vi=$toto->idtheme_rel;
							echo "?p=$vi";?>" title="<? echo _GESTION_DES_THEMES_TITLE; ?>" accesskey="t"><? echo _GESTION_DES_THEMES_LINK; ?></a>&nbsp;</li><? 
						} 
					}
					if (!isset($_GET['i'])&& isset($_GET['crea']) && $utilisateur_connecte->admin=="1") 
					{
						if ($page_theme!="") { ?><li><a href="<? echo $page_theme;?>" title="<? echo _GESTION_DES_THEMES_TITLE; ?>" accesskey="t"><? echo _GESTION_DES_THEMES_LINK; ?></a>&nbsp;</li><? } 
					}
					if ($utilisateur_connecte->admin=="1")
					{
						?>
						<li><a href="<? echo $page_theme;?>?schema=1" title="<? echo _SCHEMA_DES_THEMES_TITLE; ?>" accesskey="s"><? echo _SCHEMA_DES_THEMES_LINK; ?></a>&nbsp;</li>
						<li><a href="<? echo $page_theme;?>" title="<? echo _RACINE_DES_THEMES_TITLE; ?>" accesskey="r"><? echo _RACINE_DES_THEMES_LINK; ?></a>&nbsp;</li>
						<?
					}
					?></ul><?
				}
				?>
			</div>
			<div id="lresources">
				<h3 class="resources"><span><? echo _CONNEXION; ?></span></h3>
				<DIV id="compte_utilisateur">
					<FORM action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST" name="compte_utilisateur">
						<DIV id="langue_cadre">
							<SPAN><? echo _LANGUE_SELECTION; ?></SPAN>
							<SELECT name="langue">
							<?
							$langues_dispo=langue_possible();
							foreach ($langues_dispo as $valeur) {
								echo "<OPTION value=".$valeur;
								if ($langue==$valeur) echo " SELECTED";
								echo ">".$valeur."</OPTION>\n";
								}
							?>
							</SELECT>
						</DIV>
						<DIV class="bouton_cadre">
						<INPUT type="submit" value="<? echo _BOUTON_OK; ?>" OnClick="setutilisateurconfig()" />
						</DIV>
						<?
						if ($utilisateur_connecte!="") 
						{
							?>
							<ul>
								<li><? echo $utilisateur_connecte->authentification(); ?>&nbsp;</li>
							</ul><?
						}
						?></FORM>
				</DIV>
		</div>
	</div>
</DIV>
<?
include("extra_div.php");
?>
</body>
</html>