<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
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
 		$this->champs_formulaire=array("titre","intitule","niveau","tempsminimum","tempsmaximum","idtheme_rel");
 		// Lien de suppression :
		$this->lien_suppression=$page_questionnaire;
     		
 		// Recherche de la question si l'on donne son identifiant :
		if (isset($idquestionnaire)) 
		{	
	     	$questionnaire_choisie=requete_sql("select * FROM $this->table WHERE idquestionnaire=$idquestionnaire");
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
    		$liste_question_sql=requete_sql("select * FROM $this->table_question WHERE idquestionnaire_rel='$idquestionnaire' AND visible='1' ORDER BY ordre");
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
    
    // formulaire de validation ou devalidation d'une question
    function formulaire_validation()
    {
    	// Declaration des variables :
    	global $utilisateur_connecte;
    	global $page_question;
    	
		if (isset($this->identifiant) && $utilisateur_connecte->admin=="1")
		{
			?><script type="text/javascript">
			<!--
			<?
			if (isset($this->validation))
			{
				?>
				function fvalidation(){
					document.getElementById('formulaire_validation').validation.value = "1";
					document.getElementById('formulaire_validation').submit();
				}
				function devalidation(){
					document.getElementById('formulaire_validation').validation.value = "0";
					document.getElementById('formulaire_validation').submit();
				}
				<?
			}
			?>
			//-->
			</script>
			<form action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="post" id="formulaire_validation">
				<div class="intitule_champ"><span><? echo _TEXTE_VALIDATION; ?> :</span></div>
				<div class="champ">
					<textarea rows ="5" cols="100" id="validation_texte" name="texte_validation"><?
					echo $this->textevalidation;
					?></textarea>
				</div>
				<div class="intitule_champ"><span><? echo _VALIDATION; ?> :</span></div>
				<div class="champ"><input type="text" readonly="readonly" disabled="disabled" size="1" value="<? echo $this->validation; ?>" />
				</div>
				<div class="bouton_cadre">
					<input type="hidden" name="identifiant" value="<? echo $this->identifiant; ?>" />
					<input type="button" value="<? echo _BOUTON_VALIDER; ?>" onclick="fvalidation()" />
					<input type="hidden" name="validation" value="0" />
					<input type="button" value="<? echo _BOUTON_DEVALIDER; ?>" onclick="devalidation()" />
				</div>
			</form>
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
				echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/prototype.js\"  charset=\"utf-8\"></script>";
				echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/tablekit.js\" charset=\"utf-8\"></script>";
				echo "\n<div class=\"tableau\"><table id=\"liste_question\" class=\"sortable resizable\">";
				echo "<tr>" .
						"<th>"._MODIFICATION."</th>" .
						"<th>"._SUPPRESSION."</th>" .
						"<th>"._ORDRE."</th>" .
						"<th>"._TITRE."</th>" .
						"<th>"._INTITULE."</th>" .
						"<th>"._VALIDATION."</th>" .
						"<th>"._VALIDATION_DATE."</th>" .
					"</tr>\n";
				foreach($temp->liste_questions as $valeur)
				{
					echo "<tr>" .
							"<td><a href=\"".$page_question."?i=".$valeur['idquestion']."\" >"._MODIFIER."</a>&nbsp;</td>" .
							"<td><a href=\"".$page_question."?i=".$valeur['idquestion']."&amp;suppression=1\" >"._SUPPRIMER."</a>&nbsp;</td>";
					
					//debut cellule
					echo"<td>";
					if (strlen($valeur['ordre'])>0)
					{
						echo $valeur['ordre'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</td>";
					//fin cellule
					
					//debut cellule
					echo "<td>";
					if (strlen($valeur['titre'])>0)
					{
						echo $valeur['titre'];
					}
					else {
					echo "&nbsp;";
					}
					//fin cellule
					echo "</td>";
					
					//debut cellule
					echo"<td>";
					if (strlen($valeur['intitule'])>0)
					{
						echo $valeur['intitule'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</td>";
					//fin cellule
					//Gestion de l'affichage de la validation :
					//chargement des regles pour le format des dates :
					require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
					
					$format_date=new regle("0","format_date");
					
					if ($valeur['datevalidation']=="0") echo "<td>"._NON_TRAITEE.$valeur['validation']."</td><td>&nbsp;</td>";
					else echo "<td><a href=\"#\" title=\"".stripslashes($valeur['textevalidation'])."\">"._RESULTAT.$valeur['validation']."</a></td><td>"._TRAITEE_LE.date($format_date->valeur,$valeur['datevalidation'])."</td>";
					//fin ligne
					echo "</tr>\n";
				}
				//fin tableau
				echo "</table></div>\n";
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

    	$select_sql="select COUNT(*)
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

    	$select_sql="select T1.$vtemp->champ_identifiant 
		FROM $vtemp->table AS T1 
		LEFT JOIN $vreponse->table AS T2 ON (T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur' AND T2.visible='1')
		WHERE T2.idreponse IS NULL AND T1.visible='1' AND T1.idquestionnaire_rel='$this->identifiant' AND T1.validation='1'
		ORDER BY T1.ordre LIMIT $val, 1;";
    	$select_sql=requete_sql($select_sql);
    	$nieme_question=tableau_sql($select_sql);
    	return $nieme_question[$vtemp->champ_identifiant];
	}
	
	// formulaire du questionnaire  a partir de la nieme question
    function qcm($val = 0)
    {
    	// Declaration des variables:
    	global $idutilisateur;
		
		//En tete du QCM :
		?>
		<div id="form_questionnaire">
			<script type="text/javascript">
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
						if (document.getElementById("formulaire_qcm").reponse!=undefined && document.getElementById("formulaire_qcm").reponse.value==undefined)
						{
							document.getElementById('formulaire_qcm').val.value = "<? echo $prec;?>";
						}
						document.getElementById('formulaire_qcm').submit();
					}
					<?
				}
				if($suiv!=$val || isset($_POST["reponse"]))
				{
					?>
					function fsuiv(){
						if (document.getElementById("formulaire_qcm").reponse!=undefined && document.getElementById("formulaire_qcm").reponse.value==undefined)
						{
							document.getElementById('formulaire_qcm').val.value = "<? echo $suiv;?>";
						}
						document.getElementById('formulaire_qcm').submit();
					}
					<?
				}
				?>
				//-->
			</script>
			<form action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="post" id="formulaire_qcm">
	    		<div class="fielset">
					<fieldset><legend><? echo($this->titre); ?></legend>
						<div id="intitule_questionnaire">
							<? echo $this->intitule ;?>
						</div><?
						//Creation de variables temporaires:
						require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
						require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.reponse.php');
						
				    	$vtemp= new question();
						$vreponse= new reponse();
						
						// Recherche de la nieme question pour laquelle l'utilisateur n'a pas encore repondu:
						$select_sql="select T1.* 
						FROM $vtemp->table AS T1 
						LEFT JOIN $vreponse->table AS T2 ON (T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur' AND T2.visible='1')
						WHERE T2.idreponse IS NULL AND T1.visible='1' AND T1.idquestionnaire_rel='$this->identifiant' AND T1.validation='1'
						ORDER BY T1.ordre LIMIT $val, 1;";
						$select_sql=requete_sql($select_sql);
						if (compte_sql($select_sql)>0)
						{
							//affichage de la question voulue non encore repondue
							if (!isset($_GET['num'])) 
							{
								$question_sql=tableau_sql($select_sql);
								$num=$question_sql[$vtemp->champ_identifiant];
							}
							$question=new question($num);
							$question->formulaire_question();
						}
						else
						{
							//affichage du score de l'utilisateur pour ce questionnaire
							$score=$this->score_qcm();
							
							//calcul de l'angle de l'arc de reponse(s) fausse(s)
							if($score[0]>0)
							{
								$rapport_total_sur_faux=$score[3]/$score[0];
							}
							else
							{
								$rapport_total_sur_faux=0;
							}
							$vanglefaux=360*$rapport_total_sur_faux;
							$vpctvrai=(1-$rapport_total_sur_faux);
							$vpctvrai=$vpctvrai*100;
							
							// French notation
							$nombre_format_francais = number_format($vpctvrai, 2, ',', ' ');
							$vtextepctvrai=$nombre_format_francais."%";
							$vtextevrai=_REPONSES_VRAI.$score[2]."/".$score[0];
							
							//calcul de l'angle de l'arc du score
							if (($score[7]-$score[6])!=0)
							{
								$rapport_score_ecart=($score[4]-$score[6])/($score[7]-$score[6]);
							}
							else
							{
								$rapport_score_ecart=0;
							}
							$vanglescore=360*(1-$rapport_score_ecart);
							$vpctscore=$rapport_score_ecart;
							$vpctscore=$vpctscore*100;
							
							// French notation
							$nombre_format_francais_score = number_format($vpctscore, 2, ',', ' ');
							$vtextepctscore=$nombre_format_francais_score."%";
							$vtextescore=_SCORE.$score[4]."/".$score[7];
							$vtextescoremin=_MIN.$score[6];
							
							//texte alternatif pour l'image :
							$vtexte_alt=$vtextevrai." ==> ".$vtextepctvrai."  / ".$vtextescore." ==> ".$vtextepctscore." (".$vtextescoremin.")";
							?>
							
							<img src="image.scorequestionnaire.php?i=<? echo $this->identifiant; ?>&amp;u=<? echo $idutilisateur; ?>" alt="<? echo $vtexte_alt; ?>" />
							
							<?
						}
						?><div class="bouton_cadre"><?
						//Calcul du nombre de question(s) restante(s)
						$nombre_question=$this->nbquestion_nonrep();
						//Affichage des boutons de suivi du questionnaire
						if($prec!=$val && !isset($_POST["reponse"]) && $nombre_question>0)
						{
							?><input type="button" value="<? echo _QUESTION_PRECEDANTE ?>" onclick="fprec()" /> <?
						}
						if ($suiv!=$val && !isset($_POST["reponse"]) && $nombre_question>0)
						{
							?><input type="button" value="<? echo _QUESTION_SUIVANTE ?>" onclick="fsuiv()"/>
							<?
						}
						if (isset($_POST["reponse"]) && $nombre_question>0)
						{
							?><input type="button" value="<? echo _QUESTION_SUIVANTE ?>" onclick="fsuiv()"/>
							<?
						}
						if (isset($_POST["reponse"]) && $nombre_question==0)
						{
							?><input type="button" value="<? echo _RESULTAT_QUESTIONNAIRE ?>" onclick="fsuiv()"/>
							<?
						}
						?><input type="hidden" name="val" value="0" /><input type="hidden" name="v" value="<? echo $this->identifiant ;?>" />
						</div>
					</fieldset>
				</div>
			</form>
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
    	$select_sql_texte1="select COUNT(*)
		FROM $vquestion->table AS T1, $vreponse->table AS T2 
		WHERE T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur'
		AND T1.idquestionnaire_rel='$this->identifiant' AND T2.visible='1';";
    	$select_sql1=requete_sql($select_sql_texte1);
    	$nb_question_rep=tableau_sql($select_sql1);
    	$nb_question_rep=$nb_question_rep[0];
		$score[0]=$nb_question_rep;
		$score[1]=$select_sql_texte1;
		
		//Recherche du nombre de question vrai et fausse et somme des scores
    	$select_sql_texte2="select SUM(IF(T3.vraifaux='1',1,0)), SUM(IF(T3.vraifaux='0',1,0)), SUM(T3.valeur)
		FROM $vquestion->table AS T1, $vreponse->table AS T2, $vchoix->table AS T3 
		WHERE T1.idquestion=T2.idquestion_rel AND T2.idutilisateur_rel='$idutilisateur'
		AND T1.idquestionnaire_rel='$this->identifiant' AND T3.idchoix=T2.idchoix_rel AND T2.visible='1' GROUP BY T1.idquestionnaire_rel;";
    	$select_sql2=requete_sql($select_sql_texte2);
    	$nb_question_rep_vrai_fausse_score=tableau_sql($select_sql2);
    	$nb_question_rep_vrai=$nb_question_rep_vrai_fausse_score[0];
    	$nb_question_rep_fausse=$nb_question_rep_vrai_fausse_score[1];
    	$nb_score=$nb_question_rep_vrai_fausse_score[2];
		$score[2]=$nb_question_rep_vrai;
		$score[3]=$nb_question_rep_fausse;
		$score[4]=$nb_score;
		$score[5]=$select_sql_texte2;

		//Recherche du score min et score max du questionnaire
    	$select_sql_texte3="select MIN(T3.valeur), MAX(T3.valeur)
		FROM $vquestion->table AS T1, $vchoix->table AS T3 
		WHERE T1.idquestionnaire_rel='$this->identifiant' AND T1.idquestion=T3.idquestion_rel AND T3.visible='1' AND T1.visible='1' GROUP BY T1.idquestion;";
		$select_sql3=requete_sql($select_sql_texte3);
		$score_min=0;
		$score_max=0;
		while($valeur_score_min_max=tableau_sql($select_sql3)) 
		{
			$score_min+=$valeur_score_min_max[0];
			$score_max+=$valeur_score_min_max[1];
		}
    	$score[6]=$score_min;
		$score[7]=$score_max;
		$score[8]=$select_sql_texte3;
		
		return $score;
	}

}
?>