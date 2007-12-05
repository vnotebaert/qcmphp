<?php
/*
 * Cree le 23 decembre 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description :  Gestion d'un compte utilisateur pour QCM
 * 
 */
/* css Zen Garden is a faboulous web site wisite them at http://www.csszengarden.com/ : A demonstration of what can be accomplished visually through CSS-based design.*/
/* css released under Creative Commons License - http://creativecommons.org/licenses/by-nc-sa/1.0/  */

//chargement de la librairie commune :
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');

//chargement des regles pour la creation de compte :
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');

$confirmation_mot_de_passe=new regle("0","Confirmation_mot_de_passe");
$confirmation_email=new regle("0","Confirmation_email");

//initialisation du message pour l'utilisateur :
$utilisateur_connecte->message="";

//creation de l'utilisateur si $_GET['crea'] est egale a 2 :
if ($_GET['crea']=="2")
{
	$tableau_utilisateur= array();
	foreach ($_POST as $key=>$value)
	{
		$tableau_utilisateur[$key]=$value;
	}
	$utilisateur_connecte=new utilisateur(0,0,$tableau_utilisateur);
	$utilisateur_connecte->enregistrer();
}

//activation d'un compte utilisateur :
if (isset($_GET['act']))
{
	$utilisateur_connecte = new utilisateur(0,0,0,$_GET['I']);
	$utilisateur_connecte->activation($_GET['act']);
}

//modification de l'utilisateur si l'identifiant de l'utilisateur est connu et que l'ancien mot de passe est le bon :
$test = false;
if (isset($utilisateur_connecte->identifiant) && isset($_POST['ancienmotpasse']) && substr(MD5($_POST['ancienmotpasse']),0,20)==$utilisateur_connecte->motpasse)
{
	$test=true;
	foreach ($_POST as $key=>$value)
	{
		if (array_key_exists($key,$utilisateur_connecte->proprietes))
		{
			$utilisateur_connecte->$key=$value;
		}
	}
	$utilisateur_connecte->setmotpasse($_POST['motpasse']);
	$utilisateur_connecte->enregistrer();
	$_SESSION['utilisateur']=serialize($utilisateur_connecte);
	$utilisateur_connecte->message=_LA_MODIFICATION_DU_COMPTE_C_EST_BIEN_DEROULEE;
}
//message d'erreur si mauvais mot de passe :
if (!$test && isset($utilisateur_connecte->identifiant) && isset($_POST['ancienmotpasse']) && substr(MD5($_POST['ancienmotpasse']),0,20)!=$utilisateur_connecte->motpasse)
{
	$utilisateur_connecte->message=_MAUVAIS_ANCIEN_MOT_DE_PASSE;
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//FR"
            "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" >
	<meta name="author" content="David MASSE" >
	<meta name="keywords" content="<? echo _META_KEYWORDS; ?>" >
	<meta name="description" content="<? echo _META_DESCRIPTION; ?>" >
	<meta name="robots" content="all" >
	<meta http-equiv="Content-Script-Type" content="text/javascript" >
	<title>QCM</title>
	<!-- to correct the unsightly Flash of Unstyled Content. http://www.bluerobot.com/web/css/fouc.asp -->
	<script type="text/javascript"></script>
	<?
	if ($_GET['crea']!="2" && !isset($_GET['act']))
	{
	?>
	<script type="text/javascript" language="javascript">
	<!--
	function controle_compte(){
		var test=true;
		var message_erreur="<? echo _MESSAGE_D_ERREUR; ?>";
		if(document.compte_utilisateur.compte.value == "")
		{
			message_erreur+="<? echo _COMPTE_VIDE; ?>";
	   		document.compte_utilisateur.compte.focus();
		   	test=false;
  		}
		<?
		if (isset($utilisateur_connecte->identifiant))
		{
			?>if(document.compte_utilisateur.ancienmotpasse.value == "")
		{
			message_erreur+="<? echo _ANCIEN_MOT_DE_PASSE_VIDE; ?>";
	   		document.compte_utilisateur.ancienmotpasse.focus();
		   	test=false;
  		}<?
		}
		?>
		
  		if(document.compte_utilisateur.motpasse.value == "")
		{
			message_erreur+="<? echo _MOT_DE_PASSE_VIDE; ?>";
	   		document.compte_utilisateur.motpasse.focus();
		   	test=false;
  		}
  		if(document.compte_utilisateur.email.value == "")
		{
			message_erreur+="<? echo _EMAIL_VIDE; ?>";
	   		document.compte_utilisateur.email.focus();
		   	test=false;
  		}
  		if(document.compte_utilisateur.compte.value.length>100)
  		{
  			message_erreur+="<? echo _COMPTE_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.compte_utilisateur.compte.focus();
		   	test=false;
  		}
  		if(document.compte_utilisateur.email.value.length>100)
  		{
  			message_erreur+="<? echo _EMAIL_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.compte_utilisateur.email.focus();
		   	test=false;
  		}
  		if(document.compte_utilisateur.nom.value.length>100)
  		{
  			message_erreur+="<? echo _NOM_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.compte_utilisateur.nom.focus();
		   	test=false;
  		}
  		if(document.compte_utilisateur.prenom.value.length>100)
  		{
  			message_erreur+="<? echo _PRENOM_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.compte_utilisateur.prenom.focus();
		   	test=false;
  		}
  		if(document.compte_utilisateur.pseudonyme.value.length>100)
  		{
  			message_erreur+="<? echo _PSEUDONYME_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.compte_utilisateur.pseudonyme.focus();
		   	test=false;
  		}
  		
  		var emailreg=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9]+)*$/;
  		if(!emailreg.test(document.compte_utilisateur.email.value))
		{
			message_erreur+="<? echo _EMAIL_INVALIDE; ?>";
	   		document.compte_utilisateur.email.focus();
		   	test=false;
  		}
		<?
		if ($confirmation_mot_de_passe->valeur==1 || isset($utilisateur_connecte->identifiant))
		{
			?>if (document.compte_utilisateur.motpasse.value!=document.compte_utilisateur.motdepasseconfirmation.value) 
			{
				test=false;
				message_erreur+="<? echo _CONFIRMATION_DE_MOT_DE_PASSE_INCORRECTE ; ?>";
			}
			<?
		}
		if ($confirmation_email->valeur==1)
		{
			?>if (document.compte_utilisateur.email.value!=document.compte_utilisateur.emailconfirmation.value)
			{
				test=false;
				message_erreur+="<? echo _CONFIRMATION_D_EMAIL_INCORRECTE ; ?>";
			}
		<?
		}
		?>if (test==true) document.compte_utilisateur.submit();
		else alert(message_erreur);
	}
	//-->
	</script>
	<?
	}
	?><style type="text/css" media="all">
		@import "default.css";
	</style>
</head>
<body>
<div id="container">
	<div id="intro">
		<div id="entete">
			<h1><span><? echo _TITRE_ENTETE; ?></span></h1>
			<h2><span><? echo _SOUS_TITRE_ENTETE; ?></span></h2>
		</div>
	</div>
	<div id="espaceprincipal">
		<h3><span><?
		if (!isset($utilisateur_connecte->identifiant)) echo _CREATION_COMPTE;
		if (isset($utilisateur_connecte->identifiant)) echo _MODIFICATION_COMPTE;
		?></span></h3>
		<DIV id="compte_utilisateur"><?
			if (isset($utilisateur_connecte->identifiant) && $_GET['crea']!=2 && !isset($_GET['act'])) echo "<p class=\"p1\"><SPAN>".$utilisateur_connecte->authentification()."</SPAN></p>";
			if ((isset($utilisateur_connecte->identifiant) || $_GET['crea']==2) && $utilisateur_connecte->message!="") echo "<p class=\"p1\"><SPAN>".$utilisateur_connecte->message."</SPAN></p>";
			if ($_GET['crea']!="2" && !isset($_GET['act']))
			{ ?> 
			<FORM action="compte.php<?
			if (!isset($utilisateur_connecte->identifiant)) echo "?crea=2";
			?>" method="POST" name="compte_utilisateur">
				<DIV id="compte_cadre">
					<DIV class="intitule_champ"><SPAN><? echo _COMPTE_LOGIN; ?></SPAN></DIV>
					<DIV class="champ"><INPUT type="TEXT" name="compte" size="10" tabindex="1" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->compte\" READONLY ";
					}
					?>/></DIV>
				</DIV>
				<?
				if (isset($utilisateur_connecte->identifiant))
				{?> 
					<DIV id="ancien_motpasse_cadre">
						<DIV class="intitule_champ"><SPAN><? echo _ANCIEN_MOT_PASSE; ?></SPAN></DIV>
						<DIV class="champ"><INPUT type="PASSWORD" name="ancienmotpasse" size="10" tabindex="2" /></DIV>
					</DIV><?
				}
				?> 
				<DIV id="motpasse_cadre">
					<DIV class="intitule_champ"><SPAN><? echo _MOT_DE_PASSE_COMPTE; ?></SPAN></DIV>
					<DIV class="champ"><INPUT type="PASSWORD" name="motpasse" size="10" tabindex="3"/></DIV>
					<?
					if ($confirmation_mot_de_passe->valeur==1 || isset($utilisateur_connecte->identifiant))
					{
						?>
						<DIV class="intitule_champ"><SPAN><? echo _MOT_DE_PASSE_CONFIRMATION; ?></SPAN></DIV>
						<DIV class="champ"><INPUT type="PASSWORD" name="motdepasseconfirmation" size="10"/></DIV><?
					}
					?> 
				</DIV>
				<DIV id="email_cadre">
					<DIV class="intitule_champ"><SPAN><? echo _EMAIL; ?></SPAN></DIV>
					<DIV class="champ"><INPUT type="TEXT" name="email" size="10" tabindex="4" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->email\" ";
					}
					?>/></DIV><?
					if ($confirmation_email->valeur==1)
					{
						?> 
						<DIV class="intitule_champ"><SPAN><? echo _EMAIL_CONFIRMATION; ?></SPAN></DIV>
						<DIV class="champ"><INPUT type="TEXT" name="emailconfirmation" size="10" <?
						if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
						{
							echo "value=\"$utilisateur_connecte->email\" ";
						}
						?>/></DIV><?
					}
					?> 
				</DIV>
				<DIV id="nom_cadre">
					<DIV class="intitule_champ"><SPAN><? echo _NOM; ?></SPAN></DIV>
					<DIV class="champ"><INPUT type="TEXT" name="nom" size="10" tabindex="5" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->nom\" ";
					}
					?>/></DIV>
				</DIV>
				<DIV id="prenom_cadre">
					<DIV class="intitule_champ"><SPAN><? echo _PRENOM; ?></SPAN></DIV>
					<DIV class="champ"><INPUT type="TEXT" name="prenom" size="10" tabindex="6" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->prenom\" ";
					}
					?>/></DIV>
				</DIV>
				<DIV id="pseudonyme_cadre">
					<DIV class="intitule_champ"><SPAN><? echo _PSEUDONYME; ?></SPAN></DIV>
					<DIV class="champ"><INPUT type="TEXT" name="pseudonyme" size="10" tabindex="7" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->pseudonyme\" ";
					}
					?>/></DIV>
				</DIV>
				<DIV id="message_champs_obligatoires">
					<SPAN><? echo _CHAMPS_OBLIGATOIRES; ?></SPAN>
				</DIV>
				<DIV id="description_cadre">
				<script type="text/javascript" language="Javascript1.2"><!-- // load htmlarea
				_editor_url = "scripts/javascript/";                     // URL to htmlarea files
				var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
				if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
				if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
				if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
				if (win_ie_ver >= 5.5) {
				  document.write('<script src="' +_editor_url+ 'editor.js"');
				  document.write(' language="Javascript1.2"><\/script>');  
				} else { document.write('<script>function editor_generate() { return false; }<\/script>'); }
				// --></script>
				<DIV class="intitule_champ"><SPAN><? echo _DESCRIPTION; ?></SPAN></DIV>
				<DIV class="champ">
				<textarea rows ="5" cols="100" id="description_texte" name="description" tabindex="8"><?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo $utilisateur_connecte->description;
					}
					?></textarea>
				</DIV>
				<script type="text/javascript" language="javascript1.2">
				var config = new Object();    // create new config object

				config.debug = 0;
				
				// NOTE:  You can remove any of these blocks and use the default config!
				
				config.toolbar = [
				    ['fontname'],
				    ['fontsize'],
				    ['fontstyle'],
				    ['linebreak'],
				    ['bold','italic','underline','separator'],
				    ['strikethrough','subscript','superscript','separator'],
				    ['justifyleft','justifycenter','justifyright','separator'],
				    ['OrderedList','UnOrderedList','Outdent','Indent','separator'],
				    ['forecolor','backcolor','separator'],
				    ['HorizontalRule','Createlink','InsertImage','htmlmode','separator'],
				    ['about','popupeditor'],
				//  ['help'],
				];
				
				config.fontnames = {
				    "Arial":           "arial, helvetica, sans-serif",
				    "Courier New":     "courier new, courier, mono",
				    "Georgia":         "Georgia, Times New Roman, Times, Serif",
				    "Tahoma":          "Tahoma, Arial, Helvetica, sans-serif",
				    "Times New Roman": "times new roman, times, serif",
				    "Verdana":         "Verdana, Arial, Helvetica, sans-serif",
				    "impact":          "impact",
				    "WingDings":       "WingDings"
				};
				config.fontsizes = {
				    "1 (8 pt)":  "1",
				    "2 (10 pt)": "2",
				    "3 (12 pt)": "3",
				    "4 (14 pt)": "4",
				    "5 (18 pt)": "5",
				    "6 (24 pt)": "6",
				    "7 (36 pt)": "7"
				};
				
				config.fontstyles = [   // make sure classNames are defined in the page the content is being display as well in or they won't work!
				  { name: "headline",     className: "headline",  classStyle: "font-family: arial black, arial; font-size: 28px; letter-spacing: -2px;" },
				  { name: "arial red",    className: "headline2", classStyle: "font-family: arial black, arial; font-size: 12px; letter-spacing: -2px; color:red" },
				  { name: "verdana blue", className: "headline4", classStyle: "font-family: verdana; font-size: 18px; letter-spacing: -2px; color:blue" }
				];
				
				editor_generate('description_texte',config);
				</script>
				</DIV>
				<DIV id="autrescontacts_cadre">
				<DIV class="intitule_champ"><SPAN><? echo _AUTRES_CONTACTS; ?></SPAN></DIV>
				<DIV class="champ">
				<textarea rows ="5" cols="100" id="autrescontacts_texte" name="autrescontacts" tabindex="9"><?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo $utilisateur_connecte->autrescontacts;
					}
					?></textarea>
				</DIV>
				<script type="text/javascript" language="javascript1.2">
				editor_generate('autrescontacts_texte',config);
				</script>
				</DIV>
				<DIV class="bouton_cadre">
					<INPUT type="button" value="<? echo _BOUTON_OK; ?>" OnClick="controle_compte()" />
					<INPUT type="reset" value="<? echo _BOUTON_RESET; ?>" />
				</DIV>
			</FORM>
		</DIV>
	</DIV>
	<?
	}
	?> 
	<div id="pieddepage">
		<?
		include("pied_de_page.php");
		?> 
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
					<li><a href="index.php" title="<? echo _RETOUR_ACCUEIL_TITLE; ?>" accesskey="a"><? echo _RETOUR_ACCUEIL_LINK;?></a>&nbsp;</li>
				</ul>
			</div>
			<div id="lresources">
				<h3 class="resources"><span><? echo _LANGUE_SELECTION; ?></span></h3>
				<FORM action="compte.php" method="GET" name="langue_choisie">
				<DIV id="langue_cadre">
					<SPAN><? echo _CHOISIR_LANGUE; ?></SPAN>
					<SELECT name="langue">
					<?
					$langues_dispo=langue_possible();
					foreach ($langues_dispo as $valeur) {
						echo "<OPTION value=\"".$valeur."\"";
						if ($langue==$valeur) echo " SELECTED";
						echo ">".$valeur."</OPTION>\n";
						}
					?>
					</SELECT>
					<DIV class="bouton_cadre"><?
					foreach ($_GET as $key=>$value)
					{
						if ($key!="langue") 
						{ ?> 
							<INPUT type="hidden" value="<? echo $value; ?>" name="<? echo $key; ?>" />
							<?
						}
					}
					?><INPUT type="submit" value="<? echo _BOUTON_OK; ?>" />
					</DIV>
				</DIV>
				</FORM>
			</div>	
		</DIV>
	</DIV>


<?
include("extra_div.php");
?>
</DIV>
</body>
</html>