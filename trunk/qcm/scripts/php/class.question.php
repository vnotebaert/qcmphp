<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : Definition de la classe choix
 * 
 */
 
//chargement de la librairie commune :
require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
require_once($adresserepertoiresite.'/scripts/php/class.objet.php');
require_once($adresserepertoiresite.'/scripts/php/class.choix.php');
require_once($adresserepertoiresite.'/scripts/php/class.reponse.php');

  class question extends objet
{
    // Definition des proprietees 
    var $idquestion;
    var $idquestionnaire_rel;
    var $ordre;
    var $titre;
    var $intitule;
    var $solution;
    var $type;
    var $niveau;
    var $idutilisateur_auteur_rel;
    var $validation;
    var $idutilisateur_validateur_rel;  
    var $datecreation;
    var $datevalidation;  
    var $textevalidation;
    var $liste_choix = array(); 
     
    // Constructeur 
    function question() {
    	// Definition des variables globales :
    	global $prefixe;
    	global $langue;
    	global $utilisateur_connecte;
    	global $page_questionnaire;
    	global $page_choix;
    	
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_question";
 		$table_choix=$prefixe."_choix";
 		
 		// Initialisation de(s) argument(s) : 		
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0) $idquestion=$arguments[0];
 		if ($numargs > 1) $this->tableau_arguments=$arguments[1];
 		 		
  		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("titre","idutilisateur_auteur_rel");
 		// Champs du formulaire de creation :
 		$this->champs_formulaire=array("titre","intitule","type","ordre","solution");
 		// Champs caches du formulaire:
 		$this->champs_caches=array("idquestionnaire_rel");
     		
 		// Recherche de la question si l'on donne son identifiant :
		if (isset($idquestion)) 
		{	
	     	$question_choisie=requete_sql("select * FROM $this->table WHERE idquestion=$idquestion");
			$question_choisie=tableau_sql($question_choisie);
	    	$this->idquestion = $idquestion;
	    	$this->identifiant = $idquestion;
	    	$this->visible = $question_choisie["visible"];
	    	$this->idquestionnaire_rel = $question_choisie["idquestionnaire_rel"];  
	    	$this->ordre = $question_choisie["ordre"];  
	    	$this->titre = $question_choisie["titre"];  
	    	$this->intitule = $question_choisie["intitule"];
	    	$this->solution = $question_choisie["solution"];
	    	$this->type = $question_choisie["type"];
	    	$this->niveau = $question_choisie["niveau"];
	    	$this->idutilisateur_auteur_rel = $question_choisie["idutilisateur_auteur_rel"];
	    	$this->validation = $question_choisie["validation"];  
	    	$this->idutilisateur_validateur_rel = $question_choisie["idutilisateur_validateur_rel"];  
	    	$this->datecreation = $question_choisie["datecreation"];
	   		$this->datevalidation = $question_choisie["datevalidation"];  
	    	$this->textevalidation = $question_choisie["textevalidation"];
	    	$type_avec_choix= array("choix_unique","choix_unique_liste","choix_multiple","choix_multiple_liste");
	    	if (in_array($this->type,$type_avec_choix)) 
	    	{
	    		$liste_choix_sql=requete_sql("select * FROM $table_choix WHERE idquestion_rel='$idquestion' AND visible='1'");
	    		while($choix=tableau_sql($liste_choix_sql)) 
	    		{
	    			array_push($this->liste_choix,$choix);
	    		}
	    	}
	    }
	    
	    // Initialisation de la question si l'on ne donne pas d'indentifiant :
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
	
	//Affichage du formulaire d'une question (attention ne contient pas la balise form) :
    function formulaire_question()
    {
    	//Variable globale :
		global $langue;
		?>
    	<div id="form_question">
    		<div class="fielset">
				<?
				if(!isset($_POST["reponse"])) 
				{
					?><fieldset><legend><? echo($this->titre); ?></legend>
						<div id="question">
							<p><span class="question_intitule" lang="<? echo($langue); ?>"><? echo($this->intitule); ?></span></p>
							<?
							if ($this->type=="choix_multiple" || $this->type=="choix_unique") 
							{
								$i=0;
								?>
								<ul>
									<?
									foreach ($this->liste_choix as $valeur) 
									{
										if ($this->type=="choix_multiple") 
										{
											$i++;
											?>
											<li><input name="reponse[]" type="checkbox" value="<? echo($valeur["idchoix"]); ?>" tabindex="<? echo $i ?>" /><span class="titrechoix" lang="<? echo($langue); ?>"><? echo($valeur["titre"]) ?></span><span class="intitulechoix" lang="<? echo($langue); ?>"><? echo($valeur["intitule"]) ?></span>&nbsp;</li>
											<?
										}
										if ($this->type=="choix_unique")
										{
											?>
											<li><input name="reponse" type="radio" value="<? echo($valeur["idchoix"]); ?>" tabindex="1" /><? echo("<span class=\"titrechoix\" lang=\"$langue\">".$valeur["titre"]."</span><span class=\"intitulechoix\" lang=\"$this->langue\">".$valeur["intitule"]."</span>"); ?>&nbsp;</li>
											<?
										}
									}
									?>
								</ul>
								<?
							}
							if ($this->type=="choix_multiple_liste" || $this->type=="choix_unique_liste") 
							{
								$i=0;
								$$type_select="";
								if ($this->type=="choix_multiple_liste") 
								{
									$type_select="name=\"reponse[]\" MULTIPLE";
								}
								else 
								{
									$type_select="name=\"reponse\""; 
								}
								?>
								<select <? echo $type_select;?>><?
									foreach ($this->liste_choix as $clef=>$valeur) 
									{
										?><option value="<? echo($valeur["idchoix"]); ?>" >&nbsp;<span class="titrechoix" lang="<? echo $langue; ?>"><? echo(stripslashes($valeur["titre"])) ?></span><span class="intitulechoix" lang="<? echo $langue; ?>"><? echo(stripslashes($valeur["intitule"])) ?></span>&nbsp;</option><?
									}
									?>
								</select>
								<?
							}
							if ($this->type=="choix_mot")
							{
								?>
								<input name="reponse" type="text" value="" tabindex="1" />
								<?
							}		
							if ($this->type=="choix_texte")
							{
								?>
								<textarea rows ="5" cols="100" id="reponse_texte" name="reponse">&nbsp;</textarea>
								<?
							}		
							?>
						</div>
						<div class="bouton_cadre">
							<input type="submit" value="<? echo _BOUTON_OK ?>" />
							<input type="hidden" name="identifiant" value="<? echo $this->identifiant ?>" />
							<input type="reset" value="<? echo _BOUTON_RESET ?>" />
						</div>
						<?
					}
					if(isset($_POST["reponse"]))
					{
						$question_en_cours=new question($_POST["identifiant"]);
						?><fieldset><legend><? echo($question_en_cours->titre); ?></legend><?
						if (!is_array($_POST["reponse"]) && ($question_en_cours->type=="choix_unique" || $question_en_cours->type=="choix_unique_liste")) 
						{
							$idreponse_choisie=$_POST["reponse"];
							$reponse_choisie=new choix($idreponse_choisie);
							echo("<div class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1><p>". $reponse_choisie->intitule."</p></div>");
							if ($reponse_choisie->vraifaux=="1") {
								echo("<div class=\"bonne_reponse\"><p>"._BONNE_REPONSE."</p></div>"); 
							}
							else echo("<div class=\"mauvaise_reponse\"><p>"._MAUVAISE_REPONSE."</p></div>");
							
							$ch_reponse=new reponse($_POST["reponse"],"","",$question_en_cours->idquestion);
							$ch_reponse->enregistrer();
							echo("<div class=\"solution\"><H1>"._SOLUTION."</H1><p>".$question_en_cours->solution."</p></div>");
						}
						elseif ($question_en_cours->type=="choix_multiple" || $question_en_cours->type=="choix_multiple_liste")
						{
							for ($i=0;$i<count($_POST["reponse"]);$i++) 
							{
								$idreponse_choisie=$_POST["reponse"][$i];
								$reponse_choisie=new choix($idreponse_choisie);
								echo("<div class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1>". $reponse_choisie->intitule ."</div>");
								if ($reponse_choisie->vraifaux=="1") 
								{
									echo("<div class=\"bonne_reponse\"><p>"._BONNE_REPONSE."</p></div>"); 
								}
								else echo("<div class=\"mauvaise_reponse\"><p>"._MAUVAISE_REPONSE."</p></div>");
								
								$ch_reponse=new reponse($_POST["reponse"][$i],"","",$question_en_cours->idquestion);
								$ch_reponse->enregistrer();
							}
							echo("<div class=\"solution\"><H1>"._SOLUTION."</H1><p>".$question_en_cours->solution."</p></div>");
						}
						elseif ($question_en_cours->type=="choix_mot")
						{
							echo("<div class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1>". $_POST["reponse"] ."</div>");
							$ch_reponse=new reponse(0,$_POST["reponse"],"",$question_en_cours->idquestion);
							$ch_reponse->enregistrer();
							
							echo("<div class=\"solution\"><H1>"._SOLUTION_TEXTE."</H1><p>".$question_en_cours->solution."</p></div>");
						}
						elseif ($question_en_cours->type=="choix_texte")
						{
							echo("<div class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1>". $_POST["reponse"] ."</div>");
							$ch_reponse=new reponse(0,"",$_POST["reponse"],$question_en_cours->idquestion);
							$ch_reponse->enregistrer();
							
							echo("<div class=\"solution\"><H1>"._SOLUTION_TEXTE."</H1><p>".$question_en_cours->solution."</p></div>");
						}
					}
					?>
				</fieldset>
			</div>
		</div>
		<?
	}

    // Validation d'une question
    function validation($val,$texte)
    {
    	// Declaration des variables:
    	global $utilisateur_connecte;
    	
    	if (in_array($val,array("1","0")))
    	{
    		// Calcule de la requete :
 			$sql_requete_validation="UPDATE $this->table SET validation='".$val."', textevalidation='".htmlspecialchars($texte,ENT_QUOTES)."', datevalidation='".time()."',  idutilisateur_validateur_rel='".$utilisateur_connecte->identifiant."' WHERE ".$this->champ_identifiant."='".$this->identifiant."';";
  			// Lancement de la mise a jour de l objet correspondant :
  			$sql_resultat=requete_sql($sql_requete_validation);
  			return $this->identifiant;
    	}
    	else return false;
    }
    
    // formulaire de validation ou devalidation d'une question
    function formulaire_validation()
    {
    	// Declaration des variables :
    	global $utilisateur_connecte;
    	
		if (isset($this->identifiant) && $utilisateur_connecte->admin=="1")
		{
			if (isset($this->validation))
			{
				?>
				<script type="text/javascript">
					function fvalidation()
					{
						document.getElementById('formulaire_validation').validation.value = "1";
						document.getElementById('formulaire_validation').submit();
					}
					function devalidation()
					{
						document.getElementById('formulaire_validation').validation.value = "0";
						document.getElementById('formulaire_validation').submit();
					}
				</script>
				<?
			}
			?>
			<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" id="formulaire_validation">
				<div class="intitule_champ"><span><? echo _TEXTE_VALIDATION; ?> :</span></div>
				<div class="champ">
					<span>					
					<textarea rows ="5" cols="100" id="validation_texte" name="texte_validation"><?
					echo $this->textevalidation;
					?></textarea>
					</span>
				</div>
				<div class="intitule_champ"><span><? echo _VALIDATION; ?> :</span></div>
				<div class="champ"><input type="text" readonly="readonly" disabled="disabled" size="1" value="<? echo $this->validation; ?>" />
				</div>
				<div class="bouton_cadre">
					<input type="hidden" name="identifiant" value="<? echo $this->identifiant; ?>" />
					<?
					if (isset($this->validation))
					{
						?>
						<input type="button" value="<? echo _BOUTON_VALIDER; ?>" onclick="fvalidation()" />
						<input type="hidden" name="validation" value="0" />
						<input type="button" value="<? echo _BOUTON_DEVALIDER; ?>" onclick="devalidation()" />
						<?
					}
					?>
				</div>
			</form>
			<?
		}
    }

    // Mise en forme des choix relatifs a la question
    function liste_choix()
    {
    	// Declaration des variables :
    	global $utilisateur_connecte;
    	global $page_choix;
		global $adresserepertoiresite;
		
		//Chargement de la librairie commune :
		require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
		
		if (isset($this->identifiant))
		{
			//assure l'initialisation de l'objet question et de ses choix
			$temp= new question($this->identifiant);
			if (is_array($temp->liste_choix) && count($temp->liste_choix)>0)
			{
				echo _LISTE_CHOIX;
				echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/prototype.js\"  charset=\"utf-8\"></script>";
				echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/tablekit.js\" charset=\"utf-8\"></script>";
				echo "\n<div class=\"tableau\"><table id=\"liste_question\" class=\"sortable resizable\">";
				echo "<tr>" .
						"<th>"._MODIFICATION."</th>" .
						"<th>"._SUPPRESSION."</th>" .
						"<th>"._TITRE."</th>" .
						"<th>"._INTITULE."</th>" .
						"<th>"._VALEUR."</th>" .
						"<th>"._VRAI_FAUX."</th>" .
					"</tr>\n";
				foreach($temp->liste_choix as $valeur)
				{
					echo "<tr>" .
							"<td><a href=\"".$page_choix."?ic=".$valeur['idchoix']."\" >"._MODIFIER."</a>&nbsp;</td>" .
							"<td><a href=\"".$page_choix."?ic=".$valeur['idchoix']."&amp;suppression=1\" >"._SUPPRIMER."</a>&nbsp;</td>";
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
					//debut cellule
					echo"<td>";
					if (strlen($valeur['valeur'])>0)
					{
						echo $valeur['valeur'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</td>";
					//fin cellule
					//debut cellule
					echo"<td>";
					if (strlen($valeur['vraifaux'])>0)
					{
						echo $valeur['vraifaux'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</td>";
					//fin cellule
					//fin ligne
					echo "</tr>\n";
				}
				//fin tableau
				echo "</table></div>\n";
			}
		}
    }
}
?>