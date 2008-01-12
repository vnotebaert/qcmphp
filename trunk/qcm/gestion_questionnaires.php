<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : gestion des questions
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
	include("include.HTML.head_content_xinha_editor.php");
	?>
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
			require_once($adresserepertoiresite.'/scripts/php/class.questionnaire.php');
			require_once($adresserepertoiresite.'/scripts/php/class.question.php');
			require_once($adresserepertoiresite.'/scripts/php/class.champ.php');
			
			if (isset($_POST['identifiant']) && isset($_POST["validation"])) 
			{
				$toto = new questionnaire($_POST['identifiant']);
				$toto->validation($_POST["validation"],$_POST["texte_validation"]);
			}
			if (isset($_GET['crea']) || isset($_GET['i']) || isset($_POST['ok']) || isset($_POST['identifiant'])) 
			{
				if (isset($_GET['i'])) $toto = new questionnaire($_GET['i']);
				elseif (isset($_POST['identifiant'])) $toto = new questionnaire($_POST['identifiant']);
				else $toto = new questionnaire();
				$toto->formulaire();
				if ($_POST["suppression"]!="1" && $_GET["suppression"]!="1")
				{
					$toto->liste_questions();
					$toto->formulaire_validation();
				}
			}
			else $utilisateur_connecte->auteur_questionnaire();
			?><!-- Fin module -->
		</div>
		<? include("pied_de_page.php"); ?>
	</div>
	<? include("include.listefonction.debut.php"); ?>
			<div class="dragableBox" id="lfonctions"><?
				if ($_POST["suppression"]!="1" && $_GET["suppression"]!="1")
				{
					?>
					<h3 class="fonctions"><span><? echo _FONCTION_SELECTION_TITRE; ?></span></h3>
					<!-- list of links begins here. There will be no more than 8 links per page -->
					<ul>
						<li><a href="index.php" title="<? echo _RETOUR_ACCUEIL_TITLE; ?>" accesskey="a"><? echo _RETOUR_ACCUEIL_LINK;?></a>&nbsp;</li><?
						if (isset($toto->identifiant))
						{
							?>
							<? if ($page_question!="") { ?><li><a href="<? echo $page_question; ?>?iq=<?echo $toto->identifiant; ?>" title="<? echo _CREATION_DE_QUESTION_TITLE; ?>" accesskey="c"><? echo _CREATION_DE_QUESTION_LINK ; ?></a>&nbsp;</li><? } ?>
							<? if ($page_questionnaire!="") { ?><li><a href="<? echo $page_questionnaire; ?>" title="<? echo _GESTION_DES_QUESTIONNAIRES_TITLE; ?>" accesskey="s"><? echo _GESTION_DES_QUESTIONNAIRES_LINK; ?></a>&nbsp;</li><? }
						}
						elseif (!isset($_GET['crea']))
						{
							if ($page_questionnaire!="") { ?><li><a href="<? echo $page_questionnaire; ?>?crea=1" title="<? echo _CREATION_DE_QUESTIONNAIRE_TITLE; ?>" accesskey="q"><? echo _CREATION_DE_QUESTIONNAIRE_LINK; ?></a>&nbsp;</li><? } 
						}
						else
						{
							if ($page_questionnaire!="") { ?><li><a href="<? echo $page_questionnaire; ?>" title="<? echo _GESTION_DES_QUESTIONNAIRES_TITLE; ?>" accesskey="s"><? echo _GESTION_DES_QUESTIONNAIRES_LINK; ?></a>&nbsp;</li><? } 
						}
					?>
					</ul>
					<?
				}
			?>
			</div>
		<? include("include.langue_selection_et_deconnexion.php"); ?>
	<? include("include.listefonction.fin.php"); ?>
</div>
<?
include("extra_div.php");
?>
</body>
</html>