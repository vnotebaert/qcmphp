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
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');

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
		<div id="module">
			<!-- Debut module -->
			<?
			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.choix.php');
			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.champ.php');
			
			if (isset($_POST['identifiant']) && isset($_POST["validation"])) 
			{
				$toto = new question($_POST['identifiant']);
				$toto->validation($_POST["validation"],$_POST["texte_validation"]);
			}
			if (isset($_GET['iq']) || isset($_GET['crea']) || isset($_GET['i']) || isset($_POST['ok']) || isset($_POST['identifiant'])) 
			{
				if (isset($_GET['i'])) $toto = new question($_GET['i']);
				elseif (isset($_POST['identifiant'])) $toto = new question($_POST['identifiant']);
				else $toto = new question();
				if (isset($_GET['iq']) || isset($_POST["idquestionnaire_rel"]) || isset($toto->idquestionnaire_rel))
				{
					if(isset($_POST["idquestionnaire_rel"])) 
					{
						$_GET['iq']=$_POST["idquestionnaire_rel"];
					}
					if(isset($toto->idquestionnaire_rel)) 
					{
						$_GET['iq']=$toto->idquestionnaire_rel;
					}
					$toto->formulaire("idquestionnaire_rel",$_GET['iq']);
				}
				else
				{
					$toto->formulaire();
				}
				if ($_POST["suppression"]!="1" && $_GET["suppression"]!="1")
				{
					$toto->liste_choix();
					$toto->formulaire_validation();
				}
			}
			else $utilisateur_connecte->auteur_question();
			?>
			<!-- Fin module -->
		</div>
		<?	include("pied_de_page.php"); ?>
	</div>
	<? include("include.listefonction.debut.php"); ?>
			<div class="dragableBox" id="lfonctions"><?
				if ($_POST["suppression"]!="1" && $_GET["suppression"]!="1")
				{
					?>
					<h3 class="fonctions"><span><? echo _FONCTION_SELECTION_TITRE; ?></span></h3>
					<!-- list of links begins here. There will be no more than 8 links per page -->
					<ul>
						<li><a href="index.php" title="<? echo _RETOUR_ACCUEIL_TITLE; ?>" accesskey="a"><? echo _RETOUR_ACCUEIL_LINK;?></a>&nbsp;</li>
						<?
						if (isset($toto->identifiant))
						{
							$toto = new question($toto->identifiant);
							?>
							<? if ($page_choix!="") { ?><li><a href="<? echo $page_choix; ?>?i=<?echo $toto->identifiant; ?>" title="<? echo _CREATION_DUN_CHOIX_TITLE; ?>" accesskey="c"><? echo _CREATION_DUN_CHOIX_LINK ; ?></a>&nbsp;</li><? } ?>
							<? if ($page_questionnaire!="") { ?><li><a href="<? echo $page_questionnaire; ?>?i=<?echo $toto->idquestionnaire_rel; ?>" title="<? echo _RETOUR_AU_QUESTIONNAIRE_TITLE; ?>" accesskey="s"><? echo _RETOUR_AU_QUESTIONNAIRE_LINK; ?></a>&nbsp;</li><? } ?>
							<? if ($page_question!="") { ?><li><a href="<? echo $page_question; ?>" title="<? echo _GESTION_DES_QUESTIONS_TITLE; ?>" accesskey="s"><? echo _GESTION_DES_QUESTIONS_LINK; ?></a>&nbsp;</li><? } ?>
							<?
						}
						elseif (!isset($_GET['crea']))
						{
							if ($page_questionnaire!="" && !isset($_GET['iq']))
							{ 
								?><li><a href="<? echo $page_questionnaire; ?>?crea=1" title="<? echo _CREATION_DE_QUESTIONNAIRE_TITLE; ?>" accesskey="q"><? echo _CREATION_DE_QUESTIONNAIRE_LINK; ?></a>&nbsp;</li><? 
							}   
							elseif ($page_question!="" && $page_questionnaire!="" && isset($_GET['iq'])) 
							{
								?><li><a href="<? echo $page_question; ?>?iq=<? echo $_GET['iq']; ?>" title="<? echo _CREATION_DE_QUESTION_TITLE; ?>" accesskey="q"><? echo _CREATION_DE_QUESTION_LINK; ?></a>&nbsp;</li><?
								?><li><a href="<? echo $page_questionnaire; ?>?i=<? echo $_GET['iq']; ?>" title="<? echo _RETOUR_AU_QUESTIONNAIRE_TITLE; ?>" accesskey="s"><? echo _RETOUR_AU_QUESTIONNAIRE_LINK; ?></a>&nbsp;</li><? 
							} 
						}
						else
						{
							if ($page_question!="") { ?><li><a href="<? echo $page_question; ?>" title="<? echo _GESTION_DES_QUESTIONS_TITLE; ?>" accesskey="s"><? echo _GESTION_DES_QUESTIONS_LINK; ?></a>&nbsp;</li><? } 
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