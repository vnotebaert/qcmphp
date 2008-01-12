<?php
/*
 * Cree le 23 decembre 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  Gestion d'un compte utilisateur pour QCM
 * 
 */
/* css Zen Garden is a faboulous web site wisite them at http://www.csszengarden.com/ : A demonstration of what can be accomplished visually through CSS-based design.*/
/* css released under Creative Commons License - http://creativecommons.org/licenses/by-nc-sa/1.0/  */

//chargement de la librairie commune :
require_once('conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');

//chargement des regles pour la creation de compte :
require_once($adresserepertoiresite.'/scripts/php/class.regle.php');

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
include("include.HTML.html_definition.php");
?>
<head>
	<? 
	include("include.HTML.head_content1.php");
	include("include.HTML.head_content_xinha_editor.php");
	?>
	<?
	if ($_GET['crea']!="2" && !isset($_GET['act']))
	{
	?>
	<script type="text/javascript">
	<!--
	function controle_compte(){
		var test=true;
		var message_erreur="<? echo _MESSAGE_D_ERREUR; ?>";
		if(document.getElementById('compte_utilisateur_form').compte.value == "")
		{
			message_erreur+="<? echo _COMPTE_VIDE; ?>";
	   		document.getElementById('compte_utilisateur_form').compte.focus();
		   	test=false;
  		}
		<?
		if (isset($utilisateur_connecte->identifiant))
		{
			?>if(document.getElementById('compte_utilisateur_form').ancienmotpasse.value == "")
		{
			message_erreur+="<? echo _ANCIEN_MOT_DE_PASSE_VIDE; ?>";
	   		document.getElementById('compte_utilisateur_form').ancienmotpasse.focus();
		   	test=false;
  		}<?
		}
		?>
		
  		if(document.getElementById('compte_utilisateur_form').motpasse.value == "")
		{
			message_erreur+="<? echo _MOT_DE_PASSE_VIDE; ?>";
	   		document.getElementById('compte_utilisateur_form').motpasse.focus();
		   	test=false;
  		}
  		if(document.getElementById('compte_utilisateur_form').email.value == "")
		{
			message_erreur+="<? echo _EMAIL_VIDE; ?>";
	   		document.getElementById('compte_utilisateur_form').email.focus();
		   	test=false;
  		}
  		if(document.getElementById('compte_utilisateur_form').compte.value.length>100)
  		{
  			message_erreur+="<? echo _COMPTE_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.getElementById('compte_utilisateur_form').compte.focus();
		   	test=false;
  		}
  		if(document.getElementById('compte_utilisateur_form').email.value.length>100)
  		{
  			message_erreur+="<? echo _EMAIL_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.getElementById('compte_utilisateur_form').email.focus();
		   	test=false;
  		}
  		if(document.getElementById('compte_utilisateur_form').nom.value.length>100)
  		{
  			message_erreur+="<? echo _NOM_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.getElementById('compte_utilisateur_form').nom.focus();
		   	test=false;
  		}
  		if(document.getElementById('compte_utilisateur_form').prenom.value.length>100)
  		{
  			message_erreur+="<? echo _PRENOM_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.getElementById('compte_utilisateur_form').prenom.focus();
		   	test=false;
  		}
  		if(document.getElementById('compte_utilisateur_form').pseudonyme.value.length>100)
  		{
  			message_erreur+="<? echo _PSEUDONYME_LIMITE_A_CENT_CARACTERE; ?>";
	   		document.getElementById('compte_utilisateur_form').pseudonyme.focus();
		   	test=false;
  		}
  		
  		var emailreg=/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9]+)*$/;
  		if(!emailreg.test(document.getElementById('compte_utilisateur_form').email.value))
		{
			message_erreur+="<? echo _EMAIL_INVALIDE; ?>";
	   		document.getElementById('compte_utilisateur_form').email.focus();
		   	test=false;
  		}
		<?
		if ($confirmation_mot_de_passe->valeur==1 || isset($utilisateur_connecte->identifiant))
		{
			?>if (document.getElementById('compte_utilisateur_form').motpasse.value!=document.getElementById('compte_utilisateur_form').motdepasseconfirmation.value) 
			{
				test=false;
				message_erreur+="<? echo _CONFIRMATION_DE_MOT_DE_PASSE_INCORRECTE ; ?>";
			}
			<?
		}
		if ($confirmation_email->valeur==1)
		{
			?>if (document.getElementById('compte_utilisateur_form').email.value!=document.getElementById('compte_utilisateur_form').emailconfirmation.value)
			{
				test=false;
				message_erreur+="<? echo _CONFIRMATION_D_EMAIL_INCORRECTE ; ?>";
			}
		<?
		}
		?>if (test==true) document.getElementById('compte_utilisateur_form').submit();
		else alert(message_erreur);
	}
	//-->
	</script>
	<?
	}
	?>
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
		<div id="compte_utilisateur"><?
			if (isset($utilisateur_connecte->identifiant) && $_GET['crea']!=2 && !isset($_GET['act'])) 
			{
				echo "<p class=\"p1\"><span>".$utilisateur_connecte->authentification()."</span></p>";
			}
			if ((isset($utilisateur_connecte->identifiant) || $_GET['crea']==2) && $utilisateur_connecte->message!="") 
			{
				echo "\n<p class=\"p2\"><span>".$utilisateur_connecte->message."</span></p>";
			}
			if ($_GET['crea']!="2" && !isset($_GET['act']))
			{ ?> 
			<form action="compte.php<?
			if (!isset($utilisateur_connecte->identifiant)) echo "?crea=2";
			?>" method="post" id="compte_utilisateur_form">
				<div id="compte_cadre">
					<div class="intitule_champ"><span><? echo _COMPTE_LOGIN; ?></span></div>
					<?
					//gestion du numero d'index :
					$vtabindex=1;
					?>
					<div class="champ"><input type="text" name="compte" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->compte\" readonly=\"readonly\" ";
					}
					?>/></div>
				</div>
				<?
				if (isset($utilisateur_connecte->identifiant))
				{?> 
					<div id="ancien_motpasse_cadre">
						<div class="intitule_champ"><span><? echo _ANCIEN_MOT_PASSE; ?></span></div>
						<div class="champ"><input type="password" name="ancienmotpasse" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>" /></div>
					</div><?
				}
				?> 
				<div id="motpasse_cadre">
					<div class="intitule_champ"><span><? echo _MOT_DE_PASSE_COMPTE; ?></span></div>
					<div class="champ"><input type="password" name="motpasse" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>"/></div>
					<?
					if ($confirmation_mot_de_passe->valeur==1 || isset($utilisateur_connecte->identifiant))
					{
						?>
						<div class="intitule_champ"><span><? echo _MOT_DE_PASSE_CONFIRMATION; ?></span></div>
						<div class="champ"><input type="password" name="motdepasseconfirmation" size="20" tabindex="<? echo $vtabindex; $vtabindexi++;?>"/></div><?
					}
					?> 
				</div>
				<div id="email_cadre">
					<div class="intitule_champ"><span><? echo _EMAIL; ?></span></div>
					<div class="champ"><input type="text" name="email" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->email\" ";
					}
					?>/></div><?
					if ($confirmation_email->valeur==1)
					{
						?> 
						<div class="intitule_champ"><span><? echo _EMAIL_CONFIRMATION; ?></span></div>
						<div class="champ"><input type="text" name="emailconfirmation" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>" <?
						if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
						{
							echo "value=\"$utilisateur_connecte->email\" ";
						}
						?>/></div><?
					}
					?> 
				</div>
				<div id="avatarurl_cadre">
					<div class="intitule_champ"><span><? echo _URL_AVATAR; ?></span></div>
					<div class="champ"><input type="text" name="avatarurl" class="avatarurl" size="40" tabindex="<? echo $vtabindex; $vtabindex++;?>" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->avatarurl\" ";
					}
					?>/></div>
					<?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1)) && $utilisateur_connecte->avatarurl!="") 
					{
						//chargement de l'environnement pour la fonction de balise image :
						require_once($adresserepertoiresite.'/scripts/php/class.environnement.php');
						$toto = new environnement();
						$toto->image($utilisateur_connecte->avatarurl,"","avatarcompte");
						echo "\n";
					}
					?>
				</div>
				<div id="nom_cadre">
					<div class="intitule_champ"><span><? echo _NOM; ?></span></div>
					<div class="champ"><input type="text" name="nom" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->nom\" ";
					}
					?>/></div>
				</div>
				<div id="prenom_cadre">
					<div class="intitule_champ"><span><? echo _PRENOM; ?></span></div>
					<div class="champ"><input type="text" name="prenom" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->prenom\" ";
					}
					?>/></div>
				</div>
				<div id="pseudonyme_cadre">
					<div class="intitule_champ"><span><? echo _PSEUDONYME; ?></span></div>
					<div class="champ"><input type="text" name="pseudonyme" size="20" tabindex="<? echo $vtabindex; $vtabindex++;?>" <?
					if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
					{
						echo "value=\"$utilisateur_connecte->pseudonyme\" ";
					}
					?>/></div>
				</div>
				<div id="message_champs_obligatoires">
					<span><? echo _CHAMPS_OBLIGATOIRES; ?></span>
				</div>
				<div id="description_cadre">
				<div class="intitule_champ"><span><? echo _DESCRIPTION; ?></span></div>
					<div class="champ">
					<textarea rows ="5" cols="100" id="description_texte" name="description" tabindex="<? echo $vtabindex; $vtabindex++;?>"><?
						if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
						{
							echo $utilisateur_connecte->description;
						}
						?></textarea>
					</div>
				</div>
				<div id="autrescontacts_cadre">
				<div class="intitule_champ"><span><? echo _AUTRES_CONTACTS; ?></span></div>
					<div class="champ">
					<textarea rows ="5" cols="100" id="autrescontacts_texte" name="autrescontacts" tabindex="<? echo $vtabindex; $vtabindex++;?>"><?
						if (in_array($utilisateur_connecte->_testauthentification,array(2,1))) 
						{
							echo $utilisateur_connecte->autrescontacts;
						}
						?></textarea>
					</div>
				</div>
				<div class="bouton_cadre">
					<input type="button" value="<? echo _BOUTON_OK; ?>" onclick="controle_compte()" />
					<input type="reset" value="<? echo _BOUTON_RESET; ?>" />
				</div>
			</form>
		</div>
		<?
		}
		?> 
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
			<script type="text/javascript">
				<!--
				function setlangueconfig(){
					// create an instance of the Date object
					var now = new Date();
					// fix the bug in Navigator 2.0, Macintosh
					fixDate(now);
					// cookie expires in one year
					now.setTime(now.getTime() + 365*24*60*60*1000);
					var langue=document.GetElementById('langue_choisie_form').langue.value;
					setCookie('langue', langue, now, "", "", false);
				}
				//-->
			</script>
			<div class="dragableBox" id="llangue_selection">
				<h3 class="langue_selection"><span><? echo _LANGUE_SELECTION_TITRE; ?></span></h3>
				<ul>
					<li>
						<div id="langue_selection">
							<form action="compte.php" method="get" id="langue_choisie_form">
								<div id="langue_cadre">
									<span><? echo _CHOISIR_LANGUE; ?></span>
									<select name="langue">
										<?
										$langues_dispo=langue_possible();
										foreach ($langues_dispo as $valeur) {
											echo "<option value=\"".$valeur."\"";
											if ($langue==$valeur) echo " selected=\"selected\"";
											echo ">".$valeur."</option>\n";
											}
										?>
									</select>
									<div class="bouton_cadre"><?
										foreach ($_GET as $key=>$value)
										{
											if ($key!="langue") 
											{ 
												?> 
												<input type="hidden" value="<? echo $value; ?>" name="<? echo $key; ?>" />
												<?
											}
										}
										?><input type="submit" value="<? echo _BOUTON_OK; ?>" />
									</div>
								</div>
							</form>
						</div>
					</li>
				</ul>
			</div>	
		<? include("include.listefonction.fin.php"); ?>
</div>
<?
include("extra_div.php");
?>
</body>
</html>