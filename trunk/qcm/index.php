<?php
/*
 * Cree le 15 mai 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description :  Page d'accueil de QCM_PHP
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
<body <? if ($utilisateur_connecte->_testauthentification!=2) 
{
	?> onload="Javascript : document.compte_utilisateur.compte.value=getCookie('compte')"<?
}
?>>
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
	<div id="module">
			<h3><span><? echo _TITRE_PRINCIPAL; ?></span></h3>
			<!-- Debut module -->
			<?
			
			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
 			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.questionnaire.php');
 			require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.environnement.php');
			
			$contexte=new environnement();
			if (!isset($_GET['num'])) $num=$contexte->question_au_hasard();
			else $num=$_GET['num'];
			if (is_numeric ($num))
			{
			$question=new question($num);
			$question->formulaire_question();
			}
			?>
			<!-- Fin module -->
	</div>
	<div id="participation">
			<h3><span><? echo _TITRE_PARTICIPATION; ?></span></h3>
			<p class="p1"><span><? echo _TEXTE_PARTICIPATION; ?></span></p>
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
				<h3 class="select"><span><? echo _FONCTION_SELECTION; ?></span></h3>
				<!-- list of links begins here. There will be no more than 8 links per page -->
				<ul>
					<? 
					if ($utilisateur_connecte->admin=="1" || count($utilisateur_connecte->idtheme_auteur)>0)
					{
						?>
						<? if ($page_questionnaire!="") { ?><li><a href="<? echo $page_questionnaire; ?>" title="<? echo _GESTION_DES_QUESTIONNAIRES_TITLE; ?>" accesskey="q"><? echo _GESTION_DES_QUESTIONNAIRES_LINK; ?></a>&nbsp;</li><? } ?>
						<? if ($page_question!="") { ?><li><a href="<? echo $page_question; ?>" title="<? echo _GESTION_DES_QUESTIONS_TITLE; ?>" accesskey="s"><? echo _GESTION_DES_QUESTIONS_LINK; ?></a>&nbsp;</li><? } ?>
						<?
					}
					?>
					<?
					if ($utilisateur_connecte->admin=="1")
					{
						?>
						<? if ($page_theme!="") { ?><li><a href="<? echo $page_theme; ?>" title="<? echo _GESTION_DES_THEMES_TITLE; ?>" accesskey="t"><? echo _GESTION_DES_THEMES_LINK; ?></a>&nbsp;</li><? } ?>
						<? if ($page_administration!="") { ?><li><a href="<? echo $page_administration; ?>" title="<? echo _ADMINISTRATION_TITLE; ?>" accesskey="d"><? echo _ADMINISTRATION_LINK; ?></a>&nbsp;</li><? } ?>
						<?
					}
					?>
				</ul>
			</div>

			<div id="larchives">
				<h3 class="archives"><span><? echo _STATISTIQUE_SELECTION; ?></span></h3>
				<ul>
					<li></li>
				</ul>
			</div>
			
			<div id="lresources">
				<h3 class="resources"><span><? echo _CONNEXION; ?></span></h3>
				<DIV id="compte_utilisateur">
					<FORM action="index.php" method="POST" name="compte_utilisateur">
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
						<?
						if ($utilisateur_connecte->_testauthentification!=2) 
						{
							?>
							<DIV id="compte_cadre">
								<SPAN><? echo _COMPTE; ?></SPAN><INPUT type="TEXT" name="compte" size="10" />
							</DIV>
							<DIV id="motdepasse_cadre">
								<SPAN><? echo _MOT_DE_PASSE; ?></SPAN><INPUT type="PASSWORD" name="motdepasse" size="10" />
							</DIV>
							<?
						}
						?>
						<DIV class="bouton_cadre">
						<INPUT type="submit" value="<? echo _BOUTON_OK; ?>" OnClick="setutilisateurconfig()" />
						</DIV>
						<?
						if ($utilisateur_connecte->_testauthentification!=2) 
						{
							?>
							<DIV id="creation_compte">
								<SPAN><a href="compte.php" title="<? echo _CREATION_COMPTE_TITLE; ?>" accesskey="c"><? echo _CREATION_COMPTE_LINK ; ?></a>&nbsp;</SPAN>
							</DIV>
							<?
						}
						if ($utilisateur_connecte!="") 
						{
							?>
							<ul>
								<li><? echo $utilisateur_connecte->authentification(); ?>&nbsp;</li>
								<?
								if (in_array($utilisateur_connecte->_testauthentification,array(2,1)))
								{
									?>
									<li><a href="compte.php?modif=1" title="<? echo _MODIFICATION_COMPTE_TITLE; ?>" accesskey="m"><? echo _MODIFICATION_COMPTE_LINK;?></a>&nbsp;</li>
									<?
								}
								?>
							</ul>
							<?
						}
						?>
					</FORM>
				</DIV>
			</DIV>
		</DIV>
	</DIV>
</DIV>
<?
include("extra_div.php");
?>
</body>
</html>