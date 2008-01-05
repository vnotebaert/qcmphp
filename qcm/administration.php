<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : gestion des themes par un administrateur
 * 
 */
/* css Zen Garden is a faboulous web site wisite them at http://www.csszengarden.com/ : A demonstration of what can be accomplished visually through CSS-based design.*/
/* css released under Creative Commons License - http://creativecommons.org/licenses/by-nc-sa/1.0/  */

//chargement de la librairie commune :
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
include("include.HTML.html_definition.php");
?>
<head>
	<? include("include.HTML.head_content1.php"); ?>
</head>
<body>
<div id="container">
	<div id="intro">
		<div id="entete">
			<h1><span><? echo _TITRE_ENTETE; ?></span></h1>
		</div>
	</div>
	<div id="espaceprincipal">
		<div id="module"><!-- Debut module --><?
			if ($utilisateur_connecte->admin=="1")
			{
				if ($_GET["zip"]=="1" || $_POST["zip"]=="1")
				{
					require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.zip.php');
					$interdit=array("CVS","SVN",".svn","svn");
					$filtre=array("db","bac","tmp","zip","project","index");
					$zipTest = new zipfile();
					$zipTest -> link_repertoire("qcm_".date("Ymd"),"",$interdit,$filtre,1);
				}
				?>Welcome in administration<?
			}
			else 
			{
			echo _NOT_ADMIN_GO_BACK_TO_INDEX;
			}
			?><!-- Fin module -->
		</div>			
		<? include("pied_de_page.php"); ?>
	</div>
	<? include("include.listefonction.debut.php"); ?>
				<div class="dragableBox" id="lfonctions">
					<h3 class="fonctions"><span><? echo _FONCTION_SELECTION_TITRE; ?></span></h3>
					<!-- list of links begins here. -->
					<ul>
						<li><a href="index.php" title="<? echo _RETOUR_ACCUEIL_TITLE; ?>" accesskey="a"><? echo _RETOUR_ACCUEIL_LINK;?></a>&nbsp;</li>
					</ul>
				</div>
				<? include("include.authentification.php"); ?>
		<?
		include("include.listefonction.fin.php"); 
		include("include.listefonction2.debut.php"); 
		?>
				<? include("include.langue_selection.php"); ?>
				<? include("include.statistiques.php"); ?>
		<? include("include.listefonction2.fin.php"); ?>
</div>
<?
include("extra_div.php");
?>
</body>
</html>