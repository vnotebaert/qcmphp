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
require_once('conf.site.inc.php');
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
		<div id="preambule">
			<h3><span><? echo _TITRE_PREAMBULE; ?></span></h3>
			<p class="p1"><span><? echo _TEXTE_PREAMBULE; ?></span></p>
		</div>
	</div>
	<div id="espaceprincipal">
		<div id="module">
			<!-- Debut module -->
			<?
			include("include.theme_liste.php");
			?>
			<!-- Fin module -->
		</div>
		<? include("pied_de_page.php"); ?>
	</div>
	<? include("include.listefonction.debut.php"); ?>
			<div class="dragableBox" id="lfonctions">
				<h3 class="fonctions"><span><? echo _FONCTION_SELECTION_TITRE; ?></span></h3>
				<!-- list of links begins here. There will be no more than 8 links per page -->
				<ul>
					<?
					if ($utilisateur_connecte->admin=="1")
					{
						?>
						<? if ($page_questionnaire!="") { ?><li><a href="<? echo $page_questionnaire; ?>" title="<? echo _GESTION_DES_QUESTIONNAIRES_TITLE; ?>" accesskey="q"><? echo _GESTION_DES_QUESTIONNAIRES_LINK; ?></a>&nbsp;</li><? } ?>
						<? if ($page_question!="") { ?><li><a href="<? echo $page_question; ?>" title="<? echo _GESTION_DES_QUESTIONS_TITLE; ?>" accesskey="s"><? echo _GESTION_DES_QUESTIONS_LINK; ?></a>&nbsp;</li><? } ?>
						<? if ($page_theme!="") { ?><li><a href="<? echo $page_theme; ?>" title="<? echo _GESTION_DES_THEMES_TITLE; ?>" accesskey="t"><? echo _GESTION_DES_THEMES_LINK; ?></a>&nbsp;</li><? } ?>
						<? if ($page_administration!="") { ?><li><a href="<? echo $page_administration; ?>" title="<? echo _ADMINISTRATION_TITLE; ?>" accesskey="d"><? echo _ADMINISTRATION_LINK; ?></a>&nbsp;</li><? } ?>
						<?
					} 
					else if (count($utilisateur_connecte->idtheme_auteur)>0)
					{
						?>
						<? if ($page_questionnaire!="") { ?><li><a href="<? echo $page_questionnaire; ?>" title="<? echo _GESTION_DES_QUESTIONNAIRES_TITLE; ?>" accesskey="q"><? echo _GESTION_DES_QUESTIONNAIRES_LINK; ?></a>&nbsp;</li><? } ?>
						<?
					}
					else
					{
					}
					?>
					<li><a href="<?echo $page_a_propos; ?>" title="<? echo _A_PROPOS_TITLE ?>" accesskey="d"><? echo _A_PROPOS_LINK ?></a>&nbsp;</li>				</ul>
			</div>
			<? include("include.theme_favori_selection.php"); ?>
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