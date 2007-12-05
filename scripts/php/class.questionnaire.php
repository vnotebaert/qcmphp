<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : Definition de la classe choix
 * 
 */
 
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.objet.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
 

 class questionnaire extends objet
{
    // Definition des proprietees 
    var $idquestionnaire;
    var $idtheme_rel;
    var $titre;
    var $intitule;
    var $niveau;
    var $tempsminimum;
    var $tempsmaximum;
    var $idutilisateur_auteur_rel;
    var $validation;
    var $idutilisateur_validateur_rel;
    var $datecreation;
    var $datevalidation;
    var $textevalidation;
    var $liste_questions = array();
     
    // Constructeur 
    function questionnaire() {
    	// Definition des variables globales :
    	global $prefixe;
    	global $utilisateur_connecte;
    	global $page_questionnaire;
    	
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_questionnaire";
 		$this->table_question=$prefixe."_question";
 		
 		// Initialisation de(s) argument(s) : 		
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0) $idquestionnaire=$arguments[0];
 		if ($numargs > 1) $this->tableau_arguments=$arguments[1];
 		 		
  		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("titre","idutilisateur_auteur_rel");
 		// Champs du formulaire de creation :
 		$this->champs_formulaire=array("titre","intitule","tempsminimum","tempsmaximum","idtheme_rel");
 		// Lien de suppression :
		$this->lien_suppression=$page_questionnaire;
     		
 		// Recherche de la question si l'on donne son identifiant :
		if (isset($idquestionnaire)) 
		{	
	     	$questionnaire_choisie=requete_sql("SELECT * FROM $this->table WHERE idquestionnaire=$idquestionnaire");
			$questionnaire_choisie=tableau_sql($questionnaire_choisie);
	    	$this->idquestionnaire = $idquestionnaire;
	    	$this->identifiant = $idquestionnaire;
	    	$this->visible = $questionnaire_choisie["visible"];
	    	$this->titre = $questionnaire_choisie["titre"];
	    	$this->intitule = $questionnaire_choisie["intitule"];
	    	$this->tempsminimum = $questionnaire_choisie["tempsminimum"];
	    	$this->tempsmaximum = $questionnaire_choisie["tempsmaximum"];
	    	$this->idtheme_rel = $questionnaire_choisie["idtheme_rel"];
	    	$this->niveau = $questionnaire_choisie["niveau"];
	    	$this->idutilisateur_auteur_rel = $questionnaire_choisie["idutilisateur_auteur_rel"];
	    	$this->validation = $questionnaire_choisie["validation"];  
	    	$this->idutilisateur_validateur_rel = $questionnaire_choisie["idutilisateur_validateur_rel"];  
	    	$this->datecreation = $questionnaire_choisie["datecreation"];
	   		$this->datevalidation = $questionnaire_choisie["datevalidation"];  
	    	$this->textevalidation = $questionnaire_choisie["textevalidation"];
    		$liste_question_sql=requete_sql("SELECT * FROM $this->table_question WHERE idquestionnaire_rel='$idquestionnaire' AND visible='1' ORDER BY ordre");
    		while($question=tableau_sql($liste_question_sql)) 
    		{
    			array_push($this->liste_questions,$question);
    		}
	    }
	    
	    // Initialisation du questionnaire si l'on ne donne pas d'indentifiant :
 		else {
	 		if (!isset($this->datecreation) || $this->datecreation=="") 
	 		{
	 			$this->datecreation=time();
	 		}
	 		if (!isset($this->idutilisateur_auteur_rel) || $this->idutilisateur_auteur_rel=="" || !is_numeric($this->idutilisateur_auteur_rel) || intval($this->idutilisateur_auteur_rel)!= $this->idutilisateur_auteur_rel) 
	 		{
	 			$this->idutilisateur_auteur_rel=$utilisateur_connecte->identifiant;
	 		}
			if (!isset($this->validation) || $this->validation=="" || !is_numeric($this->validation) || intval($this->validation)!= $this->validation) 
	 		{
	 			$this->validation=0;
	 		}
 		}
    } 
     
    // Definition des methodes

	// Validation d'un questionnaire
    function validation($val,$texte)
    {
    	// Declaration des variables:
    	global $utilisateur_connecte;
    	
    	if (in_array($val,array("1","0")))
    	{
    		// Calcule de la requete :
 			$sql_requete_validation="UPDATE $this->table SET validation='".$val."', textevalidation='".htmlspecialchars($texte,ENT_QUOTES)."', datevalidation='".time()."',  idutilisateur_validateur_rel='".$utilisateur_connecte->identifiant."' WHERE ".$this->champ_identifiant."='".$this->identifiant."';";
 			$sql_requete_validation2="UPDATE $this->table_question SET validation='".$val."', textevalidation='".htmlspecialchars($texte,ENT_QUOTES)."', datevalidation='".time()."',  idutilisateur_validateur_rel='".$utilisateur_connecte->identifiant."' WHERE idquestionnaire_rel='".$this->identifiant."';";
  			// Lancement de la mise a jour des objets correspondant :
  			$sql_resultat=requete_sql($sql_requete_validation);
  			$sql_resultat2=requete_sql($sql_requete_validation2);
  			return $this->identifiant;
    	}
    	else return false;
    }
    
    // Suppression d'un questionnaire
    function supprimer()
    {
    	// Heritage:
    	parent::supprimer();
    	
    	// Calcule de la requete :
  		$sql_requete_suppression="UPDATE $this->table_question SET visible='0' WHERE idquestionnaire_rel='".$this->identifiant."';";
  		// Lancement de la mise a jour de l objet correspondant :
  		$sql_resultat=requete_sql($sql_requete_suppression);
    }
    
    // Formulaire de validation ou devalidation d'une question
    function formulaire_validation()
    {
    	// Declaration des variables :
    	global $utilisateur_connecte;
    	global $page_question;
    	global $editor;
    	
		if (isset($this->identifiant) && $utilisateur_connecte->admin=="1")
		{
			?><script type="text/javascript" language="javascript">
			<!--
			<?
			if (isset($this->validation))
			{
				?>
				function fvalidation(){
					document.formulaire_validation.validation.value = "1";
					document.formulaire_validation.submit();
				}
				function devalidation(){
					document.formulaire_validation.validation.value = "0";
					document.formulaire_validation.submit();
				}
				<?
			}
			?>
			//-->
			</script>
			<FORM action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="POST" name="formulaire_validation">
				<INPUT type="HIDDEN" name="identifiant" value="<? echo $this->identifiant; ?>" />
				<DIV class="intitule_champ"><SPAN><? echo _TEXTE_VALIDATION; ?> :</SPAN></DIV>
				<DIV class="champ"><? 	
					if ($editor!="xinha")
					{
					?>
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
					
					editor_generate('validation_texte',config);
					</script>
					<?
					}
					?>
					<textarea rows ="5" cols="100" id="validation_texte" name="texte_validation" value=""><?
					echo $this->textevalidation;
					?></textarea>
				</DIV>
				<DIV class="intitule_champ"><SPAN><? echo _VALIDATION; ?> :</SPAN></DIV>
				<DIV class="champ"><INPUT TYPE="text" READONLY DISABLED SIZE="1" VALUE="<? echo $this->validation; ?>" />
				</DIV>
				<DIV class="bouton_cadre">
					<INPUT type="button" value="<? echo _BOUTON_VALIDER; ?>" OnClick="fvalidation()" />
					<INPUT type="HIDDEN" name="validation" value="0" />
					<INPUT type="button" value="<? echo _BOUTON_DEVALIDER; ?>" OnClick="devalidation()" />
				</DIV>
			</FORM>
			<?
		}
    }

    // Mise en forme des choix relatifs a la question
    function liste_questions()
    {
    	//chargement de la librairie commune :
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');

    	// Declaration des variables :
    	global $utilisateur_connecte;
    	global $page_question;
		
		if (isset($this->identifiant))
		{
			//assure l'initialisation de l'objet question et de ses choix
			$temp= new questionnaire($this->identifiant);
			if (is_array($temp->liste_questions) && count($temp->liste_questions)>0)
			{
				echo _LISTE_QUESTIONS;
				echo "\n<DIV id=\"tableau\"><TABLE>";
				echo "<TR>" .
						"<TH>"._MODIFICATION."</TH>" .
						"<TH>"._SUPPRESSION."</TH>" .
						"<TH>"._VALIDATION."</TH>" .
						"<TH>"._ORDRE."</TH>" .
						"<TH>"._TITRE."</TH>" .
						"<TH>"._INTITULE."</TH>" .
					"</TR>\n";
				foreach($temp->liste_questions as $valeur)
				{
					echo "<TR>" .
							"<TD><a href=\"".$page_question."?i=".$valeur['idquestion']."\" >"._MODIFIER."</a>&nbsp;</TD>" .
							"<TD><a href=\"".$page_question."?i=".$valeur['idquestion']."&amp;suppression=1\" >"._SUPPRIMER."</a>&nbsp;</TD>";
					//Gestion de l'affichage de la validation :
					//chargement des regles pour le format des dates :
					require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
					
					$format_date=new regle("0","Format_date");
					
					if ($valeur['datevalidation']=="0") echo "<TD>"._NON_TRAITEE.$valeur['validation']."</TD>";
					else echo "<TD>"._TRAITEE_LE.date($format_date->valeur,$valeur['datevalidation']).". <a href=\"#\" TITLE=\"".stripslashes($valeur['textevalidation'])."\">"._RESULTAT.$valeur['validation']."</a></TD>";
					
					//debut cellule
					echo"<TD>";
					if (strlen($valeur['ordre'])>0)
					{
						echo $valeur['ordre'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</TD>";
					//fin cellule
					
					//debut cellule
					echo "<TD>";
					if (strlen($valeur['titre'])>0)
					{
						echo $valeur['titre'];
					}
					else {
					echo "&nbsp;";
					}
					//fin cellule
					echo "</TD>";
					
					//debut cellule
					echo"<TD>";
					if (strlen($valeur['intitule'])>0)
					{
						echo $valeur['intitule'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</TD>";
					//fin cellule
					//fin ligne
					echo "</TR>\n";
				}
				//fin tableau
				echo "</TABLE></DIV>\n";
			}
		}
    }

	//Nombre de questions non répondu d'un questionnaire
    function nbquestion_nonrep()
    {
    	// Declaration des variables:
    	global $idutilisateur;

    	// Recherche de la nieme question pour laquelle l'utilisateur n'a pas encore repondu:
		//Creation de variables temporaires:
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.reponse.php');
		
    	$vtemp= new question();
		$vquestionnaire= $this;
		$vreponse= new reponse();

    	$select_sql="SELECT COUNT(*)
		FROM $vtemp->table AS T1 
		LEFT JOIN $vreponse->table AS T2 ON (T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur' AND T2.visible='1')
		WHERE T2.idreponse IS NULL AND T1.visible='1' AND T1.idquestionnaire_rel='$this->identifiant' AND T1.validation='1';";
    	$select_sql=requete_sql($select_sql);
    	$nb_question_non_rep=tableau_sql($select_sql);
    	return $nb_question_non_rep[0];
	}

	// Question suivante d'un questionnaire
    function nieme_question($val = 0)
    {
    	// Declaration des variables:
    	global $idutilisateur;
		
		// Recherche de la nieme question pour laquelle l'utilisateur n'a pas encore repondu:
		//Creation de variables temporaires:
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.reponse.php');
		
    	$vtemp= new question();
		$vquestionnaire= $this;
		$vreponse= new reponse();

    	$select_sql="SELECT T1.$vtemp->champ_identifiant 
		FROM $vtemp->table AS T1 
		LEFT JOIN $vreponse->table AS T2 ON (T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur' AND T2.visible='1')
		WHERE T2.idreponse IS NULL AND T1.visible='1' AND T1.idquestionnaire_rel='$this->identifiant' AND T1.validation='1'
		ORDER BY T1.ordre LIMIT $val, 1;";
    	$select_sql=requete_sql($select_sql);
    	$nieme_question=tableau_sql($select_sql);
    	return $nieme_question[$vtemp->champ_identifiant];
	}
	
	// Formulaire du questionnaire  a partir de la nieme question
    function qcm($val = 0)
    {
    	// Declaration des variables:
    	global $idutilisateur;
		
		//En tete du QCM :
		?><div id="form_questionnaire">
		<script type="text/javascript" language="javascript">
			<!--
			<?
			$prec=$val-1;
			if ($prec<0) {$prec=0;}
			$suiv=$val+1;
			if ($suiv+1>$this->nbquestion_nonrep()) {$suiv=$suiv-1;}
			?>
			function fprec(){
				document.formulaire_qcm.val.value = "<? echo $prec;?>";
				document.formulaire_qcm.submit();
			}
			function fsuiv(){
				document.formulaire_qcm.val.value = "<? echo $suiv;?>";
				document.formulaire_qcm.submit();
			}
			//-->
			</script>
			<FORM action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="POST" name="formulaire_qcm">
    		<div id="fielset">
				<fieldset><legend><? echo($this->titre); ?></legend>
				<div id="intitule_questionnaire">
				<H3><span><? echo $this->intitule ;?></span></H3>
				</div><?
				//Chargement de la norme de présentation du site (n question(s) par questionnaire):
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
				$nb_question_formulaire_qcm=new regle("0","Nombre_question_formulaire_qcm");
				
				//Creation de variables temporaires:
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.reponse.php');
				
		    	$vtemp= new question();
				$vreponse= new reponse();
				
				// Recherche de la nieme question pour laquelle l'utilisateur n'a pas encore repondu:
				$select_sql="SELECT T1.* 
				FROM $vtemp->table AS T1 
				LEFT JOIN $vreponse->table AS T2 ON (T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur' AND T2.visible='1')
				WHERE T2.idreponse IS NULL AND T1.visible='1' AND T1.idquestionnaire_rel='$this->identifiant' AND T1.validation='1'
				ORDER BY T1.ordre LIMIT $val, $nb_question_formulaire_qcm->valeur;";
				$select_sql=requete_sql($select_sql);
				if (compte_sql($select_sql)>0)
				{
					if ($nb_question_formulaire_qcm->valeur==1)
					{
						if (!isset($_GET['num'])) 
						{
							$question_sql=tableau_sql($select_sql);
							$num=$question_sql[$vtemp->champ_identifiant];
						}
						$question=new question($num);
						$question->formulaire_question();
					}
				}
				else
				{
					?>
					<img src="scorequestionnnaire.php?i=<? echo $this->identifiant; ?>u=<? echo $idutilisateur; ?>" />
					<?
				}
				?><div class="bouton_cadre"><input type="button" value="<? echo _QUESTION_PRECEDANTE ?>" OnClick="fprec()" /> <input type="button" value="<? echo _QUESTION_SUIVANTE ?>" OnClick="fsuiv()"/></div>
				<INPUT TYPE="hidden" name="val" value="0">
				</FORM>
				</fieldset>
			</div>
		</div>
		<?
	}

}
?>