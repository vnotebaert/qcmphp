<?php
/*
 * Cree le 15 mai 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  Page d'accueil de QCM_PHP
 * 
 */
/* css Zen Garden is a faboulous web site wisite them at http://www.csszengarden.com/ : A demonstration of what can be accomplished visually through CSS-based design.*/
/* css released under Creative Commons License - http://creativecommons.org/licenses/by-nc-sa/1.0/  */

//chargement de la librairie commune :
require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');

//chargement de la definition du type de document HTML
include("include.HTML.html_definition.php");
?>
<head>
	<? 
	//chargement du contenu de la balise head :
	include("include.HTML.head_content1.php");
	?>
</head>
<body>
<div id="container">
	<div id="intro">
		<div id="entete">
			<h1><span><? echo _TITRE_ENTETE; ?></span></h1>
			<h2><span><? echo _SOUS_TITRE_ENTETE; ?></span></h2>
		</div>
		<div id="resume">
			<p class="p1"><span><? echo _RESUME_PRINCIPAL; ?></span></p>
		</div>
		<div id="preambule">
			<h3><span><? echo _TITRE_PREAMBULE; ?></span></h3>
			<p class="p1"><span><? echo _TEXTE_PREAMBULE; ?></span></p>
		</div>
	</div>
	<div id="espaceprincipal">
		<div id="participation">
			<h3><span><? echo _TITRE_PARTICIPATION; ?></span></h3>
			<p class="p1"><span><? echo _TEXTE_PARTICIPATION; ?></span></p>
		</div>
		<? include("pied_de_page.php"); ?>
	</div>
	<? include("include.listefonction.debut.php"); ?>
			<div class="dragableBox" id="lfonctions">
				<h3 class="fonctions"><span><? echo _FONCTION_SELECTION_TITRE; ?></span></h3>
				<!-- list of links begins here. There will be no more than 8 links per page -->
				<ul>
					<li><a href="index.php" title="<? echo _RETOUR_ACCUEIL_TITLE; ?>" accesskey="a"><? echo _RETOUR_ACCUEIL_LINK;?></a>&nbsp;</li>
				</ul>
			</div>
			<? include("include.authentification.php"); ?>
			<? include("include.langue_selection.php"); ?>
			<? include("include.statistiques.php"); ?>
	<? include("include.listefonction.fin.php"); ?>
</div>
<?
include("extra_div.php");
?>
</body>
</html>