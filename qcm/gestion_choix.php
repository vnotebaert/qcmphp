<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : gestion des choix
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
			<? include("include.langue_selection_et_deconnexion.php"); ?>
	<? include("include.listefonction.fin.php"); ?>
</div>
<?
include("extra_div.php");
?>
</body>
</html>