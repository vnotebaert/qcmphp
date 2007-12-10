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
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.choix.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.reponse.php');

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
	     	$question_choisie=requete_sql("SELECT * FROM $this->table WHERE idquestion=$idquestion");
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
	    		$liste_choix_sql=requete_sql("SELECT * FROM $table_choix WHERE idquestion_rel='$idquestion' AND visible='1'");
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
    function formulaire_question()
    {
    	//Variable globale :
		global $langue;
		?>
    	<div id="form_question">
    		<div id="fielset">
				<fieldset><legend><? echo($this->titre); ?></legend>
					<?
		    		if(!isset($_POST["reponse"])) 
		    		{
		    			?>
						<form name="question" action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>?num=<? echo($this->idquestion); ?>" method="post">
							<div id="question">
								<p><span id="question_intitule" class="question_intitule" lang="<? echo($langue); ?>"><? echo($this->intitule); ?></span></p>
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
									<SELECT <? echo $type_select;?>><?
										foreach ($this->liste_choix as $clef=>$valeur) 
										{
											?><OPTION value="<? echo($valeur["idchoix"]); ?>" >&nbsp;<span class="titrechoix" lang="<? echo $langue; ?>"><? echo(stripslashes($valeur["titre"])) ?></span><span class="intitulechoix" lang="<? echo $langue; ?>"><? echo(stripslashes($valeur["intitule"])) ?></span>&nbsp;</OPTION><?
										}
										?>
									</SELECT>
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
									<TEXTAREA rows ="5" cols="100" id="reponse_texte" name="reponse">&nbsp;</TEXTAREA>
									<?
								}		
								?>
							</div>
							<div class="bouton_cadre"><input type="submit" value="<? echo _BOUTON_OK ?>" /> <input type="reset" value="<? echo _BOUTON_RESET ?>" /></div>
						</form><?
					}
					if(isset($_POST["reponse"]))
					{
						if (!is_array($_POST["reponse"]) && ($this->type=="choix_unique" || $this->type=="choix_unique_liste")) 
						{
							$idreponse_choisie=$_POST["reponse"];
							$reponse_choisie=new choix($idreponse_choisie);
							echo("<DIV class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1><p>". $reponse_choisie->intitule."</p></DIV>");
							if ($reponse_choisie->vraifaux=="1") {
								echo("<DIV class=\"bonne_reponse\"><p>"._BONNE_REPONSE."</p></DIV>"); 
							}
							else echo("<DIV class=\"mauvaise_reponse\"><p>"._MAUVAISE_REPONSE."</p></DIV>");
							
							$ch_reponse=new reponse($_POST["reponse"],"","",$this->identifiant);
							$ch_reponse->enregistrer();
							echo("<DIV class=\"solution\"><H1>"._SOLUTION."</H1><p>".$this->solution."</p></DIV>");
						}
						elseif ($this->type=="choix_multiple" || $this->type=="choix_multiple_liste")
						{
							for ($i=0;$i<count($_POST["reponse"]);$i++) 
							{
								$idreponse_choisie=$_POST["reponse"][$i];
								$reponse_choisie=new choix($idreponse_choisie);
								echo("<DIV class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1>". $reponse_choisie->intitule ."</DIV>");
								if ($reponse_choisie->vraifaux=="1") 
								{
									echo("<DIV class=\"bonne_reponse\"><p>"._BONNE_REPONSE."</p></DIV>"); 
								}
								else echo("<DIV class=\"mauvaise_reponse\"><p>"._MAUVAISE_REPONSE."</p></DIV>");
								
								$ch_reponse=new reponse($_POST["reponse"][$i],"","",$this->identifiant);
								$ch_reponse->enregistrer();
							}
							echo("<DIV class=\"solution\"><H1>"._SOLUTION."</H1><p>".$this->solution."</p></DIV>");
						}
						elseif ($this->type=="choix_mot")
						{
							for ($i=0;$i<count($_POST["reponse"]);$i++) 
							{
								echo("<DIV class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1>". nl2br(htmlentities($_POST["reponse"],ENT_QUOTES)) ."</DIV>");
								$ch_reponse=new reponse(0,nl2br(htmlentities($_POST["reponse"],ENT_QUOTES)),"",$this->identifiant);
								$ch_reponse->enregistrer();
							}
							echo("<DIV class=\"solution\"><H1>"._SOLUTION_TEXTE."</H1><p>".$this->solution."</p></DIV>");
						}
						elseif ($this->type=="choix_texte")
						{
							for ($i=0;$i<count($_POST["reponse"]);$i++) 
							{
								echo("<DIV class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1>". $_POST["reponse"] ."</DIV>");
								$ch_reponse=new reponse(0,"",$_POST["reponse"],$this->identifiant);
								$ch_reponse->enregistrer();
							}
							echo("<DIV class=\"solution\"><H1>"._SOLUTION_TEXTE."</H1><p>".$this->solution."</p></DIV>");
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
    
    // Formulaire de validation ou devalidation d'une question
    function formulaire_validation()
    {
    	// Declaration des variables :
    	global $utilisateur_connecte;
    	
		if (isset($this->identifiant) && $utilisateur_connecte->admin=="1")
		{
			if (isset($this->validation))
			{
				?>
				<script type="text/javascript" language="javascript">
					function fvalidation()
					{
						document.formulaire_validation.validation.value = "1";
						document.formulaire_validation.submit();
					}
					function devalidation()
					{
						document.formulaire_validation.validation.value = "0";
						document.formulaire_validation.submit();
					}
				</script>
				<?
			}
			?>
			<FORM action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="POST" name="formulaire_validation">
				<INPUT type="HIDDEN" name="identifiant" value="<? echo $this->identifiant; ?>" />
				<DIV class="intitule_champ"><SPAN><? echo _TEXTE_VALIDATION; ?> :</SPAN></DIV>
				<DIV class="champ">
					<SPAN>					
					<TEXTAREA rows ="5" cols="100" id="validation_texte" name="texte_validation"><?
					echo $this->textevalidation;
					?></TEXTAREA>
					</SPAN>
				</DIV>
				<DIV class="intitule_champ"><SPAN><? echo _VALIDATION; ?> :</SPAN></DIV>
				<DIV class="champ"><INPUT TYPE="text" READONLY DISABLED SIZE="1" VALUE="<? echo $this->validation; ?>" />
				</DIV>
				<DIV class="bouton_cadre">
				<?
				if (isset($this->validation))
				{
					?>
					<INPUT type="button" value="<? echo _BOUTON_VALIDER; ?>" OnClick="fvalidation()" />
					<INPUT type="HIDDEN" name="validation" value="0" />
					<INPUT type="button" value="<? echo _BOUTON_DEVALIDER; ?>" OnClick="devalidation()" />
					<?
				}
				?>
				</DIV>
			</FORM>
			<?
		}
    }

    // Mise en forme des choix relatifs a la question
    function liste_choix()
    {
    	//chargement de la librairie commune :
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');

    	// Declaration des variables :
    	global $utilisateur_connecte;
    	global $page_choix;
		
		if (isset($this->identifiant))
		{
			//assure l'initialisation de l'objet question et de ses choix
			$temp= new question($this->identifiant);
			if (is_array($temp->liste_choix) && count($temp->liste_choix)>0)
			{
				echo _LISTE_CHOIX;
				echo "\n<DIV id=\"tableau\"><TABLE>";
				echo "<TR>" .
						"<TH>"._MODIFICATION."</TH>" .
						"<TH>"._SUPPRESSION."</TH>" .
						"<TH>"._TITRE."</TH>" .
						"<TH>"._INTITULE."</TH>" .
						"<TH>"._VALEUR."</TH>" .
					"</TR>\n";
				foreach($temp->liste_choix as $valeur)
				{
					echo "<TR>" .
							"<TD><a href=\"".$page_choix."?ic=".$valeur['idchoix']."\" >"._MODIFIER."</a>&nbsp;</TD>" .
							"<TD><a href=\"".$page_choix."?ic=".$valeur['idchoix']."&suppression=1\" >"._SUPPRIMER."</a>&nbsp;</TD>";
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
					//debut cellule
					echo"<TD>";
					if (strlen($valeur['valeur'])>0)
					{
						echo $valeur['valeur'];
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
}
?>