<?php
/*
 * Cree le 29 dec. 2007
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : gestion des themes par un administrateur
 * 
 */

//chargement de la librairie commune :
require_once('conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');

//chargement de la definition du type de document HTML
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
			if ($utilisateur_connecte!="" && in_array($utilisateur_connecte->_testauthentification,array(2,1)))
			{
				require_once($adresserepertoiresite.'/scripts/php/class.questionnaire.php');
				if (isset($_GET["v"]) || isset($_POST["v"]))
				{
					if (isset($_GET["v"]))
					{
						$v=$_GET["v"];
					}
					if (isset($_POST["v"]))
					{
						$v=$_POST["v"];
					}
					$questionnaire = new questionnaire($v);
					if (isset($_POST["val"])) 
					{
						$val=$_POST["val"];
					}
					else 
					{
						$val=0;
					}
					$questionnaire->qcm($val);
				}
				else 
				{
					echo _AUCUN_QUESTIONNAIRE_SELECTIONNE_RETOUR_A_L_ACCEUIL_CONSEILLE;
				}
			}
			else 
			{
				echo _NON_CONNECTE_IL_FAUT_ETRE_CONNECTE_POUR_VOIR_UN_QUESTIONNAIRE;
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
				<? include("include.langue_selection.php"); ?>
				<? include("include.statistiques.php"); ?>
	<? include("include.listefonction.fin.php"); ?>
</div>
<?
include("extra_div.php");
?>
</body>
</html>