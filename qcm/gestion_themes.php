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
			if ($utilisateur_connecte->admin=="1")
			{
				require_once($adresserepertoiresite.'/scripts/php/class.theme.php');
				require_once($adresserepertoiresite.'/scripts/php/class.champ.php');
				require_once($adresserepertoiresite.'/scripts/php/class.environnement.php');
				
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
				?><img src="image.arbo_theme.php" alt="<? echo _ARBO_THEME ; ?>" /><?
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
								?><li><a href="<? echo $page_theme."?p=".$_GET['p']."&amp;maj=1"; ?>" title="<? echo _MAJ_DES_THEMES_TITLE; ?>" accesskey="m"><? echo _MAJ_DES_THEMES_LINK; ?></a>&nbsp;</li><? 
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