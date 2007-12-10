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
				<DIV class="champ">
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
		?>
		<div id="form_questionnaire">
			<script type="text/javascript" language="javascript">
				<!--
				<?
				//Calcul des identifiants des questions precedante et suivante
				$prec=$val-1;
				if ($prec<0) {$prec=0;}
				$suiv=$val+1;
				if (isset($_POST["reponse"]))
				{
					$suiv=$suiv-1;
				}
				if ($suiv+1>$this->nbquestion_nonrep()) {$suiv=$suiv-1;}
				
				if($prec!=$val)
				{
					?>
					function fprec(){
						document.formulaire_qcm.val.value = "<? echo $prec;?>";
						document.formulaire_qcm.submit();
					}
					<?
				}
				if($suiv!=$val || isset($_POST["reponse"]))
				{
					?>
					function fsuiv(){
						document.formulaire_qcm.val.value = "<? echo $suiv;?>";
						document.formulaire_qcm.submit();
					}
					<?
				}
				?>
				//-->
			</script>
			<FORM action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="POST" name="formulaire_qcm">
	    		<div id="fielset">
					<fieldset><legend><? echo($this->titre); ?></legend>
						<div id="intitule_questionnaire">
							<H3><span><? echo $this->intitule ;?></span></H3>
						</div><?
						//Chargement de la norme de presentation du site (n question(s) par questionnaire):
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
							$score=$this->score_qcm();
							echo "Score : ".$score[4]."<br/>" ;
							?>
							<img src="scorequestionnnaire.php?i=<? echo $this->identifiant; ?>u=<? echo $idutilisateur; ?>" />
							<?
						}
						?><div class="bouton_cadre"><?
						if($prec!=$val && !isset($_POST["reponse"]))
						{
							?><input type="button" value="<? echo _QUESTION_PRECEDANTE ?>" OnClick="fprec()" /> <?
						}
						if ($suiv!=$val && !isset($_POST["reponse"]))
						{
							?><input type="button" value="<? echo _QUESTION_SUIVANTE ?>" OnClick="fsuiv()"/>
							<?
						}
						if (isset($_POST["reponse"]))
						{
							?><input type="button" value="<? echo _QUESTION_SUIVANTE ?>" OnClick="fsuiv()"/>
							<?
						}
						?></div>
						<INPUT TYPE="hidden" name="val" value="0">
					</fieldset>
				</div>
			</FORM>
		</div>
		<?
	}
	
	//nombre total de questions , nombre de reponse vrai , nombre de reponse fausse, somme des scores des reponses
	// !! cette fonction ne doit etre appelee que pour un questionnaire totalement complete !!
    function score_qcm()
    {
    	// Declaration des variables:
    	global $idutilisateur;

		//Creation de variables temporaires:
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.reponse.php');
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.choix.php');
		
    	$vquestion= new question();
		$vreponse= new reponse();
		$vchoix= new choix();
		

    	// Recherche du nombre total de question auquelles l'utilisateur a repondu
    	$select_sql_texte1="SELECT COUNT(*)
		FROM $vquestion->table AS T1, $vreponse->table AS T2 
		WHERE T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur'
		AND T1.idquestionnaire_rel='$this->identifiant';";
    	$select_sql1=requete_sql($select_sql_texte1);
    	$nb_question_rep=tableau_sql($select_sql1);
    	$nb_question_rep=$nb_question_rep[0];
		$score[0]=$nb_question_rep;
		$score[1]=$select_sql_texte1;
		
		//Recherche du nombre de question vrai et fausse et somme des scores
    	$select_sql_texte2="SELECT SUM(IF(T3.vraifaux='1',1,0)), SUM(IF(T3.vraifaux='0',1,0)), SUM(T3.valeur)
		FROM $vquestion->table AS T1, $vreponse->table AS T2, $vchoix->table AS T3 
		WHERE T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur'
		AND T1.idquestionnaire_rel='$this->identifiant' AND T3.idchoix=T2.idchoix_rel GROUP BY T1.idquestionnaire_rel;";
    	$select_sql2=requete_sql($select_sql_texte2);
    	$nb_question_rep_vrai_fausse_score=tableau_sql($select_sql2);
    	$nb_question_rep_vrai=$nb_question_rep_vrai_fausse_score[0];
    	$nb_question_rep_fausse=$nb_question_rep_vrai_fausse_score[1];
    	$nb_score=$nb_question_rep_vrai_fausse_score[2];
		$score[2]=$nb_question_rep_vrai;
		$score[3]=$nb_question_rep_fausse;
		$score[4]=$nb_score;
		$score[5]=$select_sql_texte2;
		
		return $score;
	}

}
?>