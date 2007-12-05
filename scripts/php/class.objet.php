<?php
/*
 * Cree le 20 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : Definition de la classe objet a la base de toutes les classes
 * 
 */

require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
 
  class objet 
{
	// Definition des proprietes :
	var $classe;
	var $methodes = array();
	var $proprietes = array();
	var $visible;
	var $table;
	var $champs = array();
	var $champs_obligatoires = array();
	var $champs_uniques = array();
	var $champs_formulaire = array();
	var $champs_caches = array();
	var $champ_identifiant;
	var $identifiant;
	var $message;
	
	// Definition du constructeur :
	function objet() 
	{
		$this->classe=get_class($this);
		$this->proprietes=get_class_vars($this->classe);
		$this->methodes=get_class_methods($this->classe);
		
		// Verification de l'existance de la table :
		$test_table=true;
		$liste_des_tables=array();
    	$table_sql=requete_sql("SHOW tables;");
	    while($table_temp=tableau_sql($table_sql)) 
	    {
	    	array_push($liste_des_tables,$table_temp[0]);
	    }
	    if (!in_array($this->table,$liste_des_tables))
    	{
    		$test_table=false;
    	}
		
		//Recherche des champs :
		if ($test_table)
		{
			$requete=requete_sql("SHOW COLUMNS FROM $this->table");
			while($temp=tableau_sql($requete))
	    	{
	    		array_push($this->champs,$temp["Field"]);
	    		/*
				$tableau_temp = array();
				foreach ($temp as $clef=>$valeurtemp)
				{
					if (!is_numeric($clef)) $tableau_temp[$clef]=$valeurtemp;
				}
				*/
			}
			//Definition de l'identifiant de la classe :
			$this->champ_identifiant="id".$this->classe;
 		}
	    if (isset($this->tableau_arguments) && is_array($this->tableau_arguments))
		{
			foreach ($this->tableau_arguments as $key => $valeur) 
	 		{
	 			if (in_array($this->$key,$this->proprietes)) $this->$key = $valeur;
	 		}
		}

	}
		
    // Definition des methodes : 
	function set() {
		// Initialisation des arguments:
		$arguments = func_get_args();
		if (isset($arguments[0]) && trim($arguments[0]) != '') $propriete=$arguments[0];
     	if (isset($arguments[1]) && trim($arguments[1]) != '') $valeur=$arguments[1];

		if (!isset($propriete) && !isset($valeur)) {
			die(_LA_FONCTION_SET_ET_DE_LA_FORME_SET_PROP_VAL);
		}
		elseif (!isset($propriete)) {
			die(_PRECISER_LA_PROPRIETE);
		}
		elseif (!isset($valeur)) {
			die(_PRECISER_LA_VALEUR);
		}
		
		if (array_key_exists($propriete,$this->proprietes)) {
			$this -> $propriete = $valeur;
		}
		else {
			die(_PROPRIETE.$propriete._INCONNUE_SUR_CETTE_CLASSE);
		}
	}
	
	//Mise à jour de l'objet en fonction d'un tableau de valeur du type propriete=>valeur :
	function update($tableau_valeur)
	{
		if (isset($tableau_valeur) && is_array($tableau_valeur))
		{
 			foreach ($tableau_valeur as $key => $valeur) 
	 		{
			$this->$key = $valeur;
	 		}
		}
	}
	
	function enregistrer()
	{
    	// Definition des variables globales :
    	global $prefixe;
		
		// Initialisation du message :
		$this->message="";
		
		// Verification de l'existance de la table :
		$test_table=true;
		$liste_des_tables=array();
    	$table_sql=requete_sql("SHOW tables;");
	    while($table_temp=tableau_sql($table_sql)) 
	    {
	    	array_push($liste_des_tables,$table_temp[0]);
	    }
	    if (!in_array($this->table,$liste_des_tables))
    	{
    		echo _TABLE.$this->table._INEXISTANTE_POUR_LA_CLASSE.$this->classe;
    		$test_table=false;
    	}
    	
    	if ($test_table==true)
    	{
    		// Enregistrement en base :	 		
	 		if (isset($this->identifiant) && is_numeric($this->identifiant) && intval($this->identifiant)== $this->identifiant) 
	 		{
	 			// Initialisation de la requete :
	 			$sql_requete_update="UPDATE $this->table SET ";
	  			foreach ($this->champs as $valeur)
	  			{
	  				// Concatenation champ = valeur :
	  				if (isset($this->$valeur) && !is_array($this->$valeur) && $valeur!="id".$this->classe)
	  				{
	  					$sql_requete_update=$sql_requete_update."$valeur='".$this->$valeur."', ";
	  				}
	  			}
	  			$sql_requete_update=substr($sql_requete_update,0,-2);
	  			
	  			// Clause WHERE :
	  			$sql_requete_update=$sql_requete_update." WHERE ".$this->champ_identifiant."='".$this->identifiant."';";
	  			
	  			// Lancement de la mise a jour de l objet correspondant :
				$sql_resultat=requete_sql($sql_requete_update);
	  			return $this->identifiant;
	    	}
	 		elseif (!isset($this->identifiant)) 
	 		{
	 			// Test des champs obligatoires :
	 			$test_champs_obligatoires=true;
	 			
	 			if (isset($this->champs_obligatoires) && is_array($this->champs_obligatoires))
	 			{
	 				foreach ($this->champs_obligatoires as $champoblig)
	 				{
	 					if (!isset($this->$champoblig) || $this->$champoblig=="") 
	 					{
	 						if ($test_champs_obligatoires==true)
	 						{
	 							$this->message.=_IL_MANQUE_UN_CHAMP_OBLIGATOIRE;
			 					$this->message.=_CLASSE_CHAMPS_MANQUANT.$this->classe._CLASSE_CHAMPS_MANQUANT_FIN;
			 					$this->message.=_LES_CHAMPS_OBLIGATOIRES_MANQUANT_SONT_LES_SUIVANTS;
			 					$this->message.="<UL>";
	 						}
	 						$test_champs_obligatoires=false;
			 				$this->message.="<LI>".$champoblig."</LI>";
	 					}
	 					if ($test_champs_obligatoires==false)
	 					{
	 						$this->message.="</UL>";
	 					}
	 				}
	 			}
	 			
	 			// Test des champs uniques :
	 			$test_champs_uniques=true;
	 			
	 			if (isset($this->champs_uniques) && is_array($this->champs_uniques))
	 			{
	 				foreach ($this->champs_uniques as $champuniq)
	 				{
	 					if ((isset($this->$champuniq) || $this->$champuniq!="") && in_array($champuniq,$this->champs)) 
	 					{
	 						$sql="SELECT * FROM $this->table WHERE ".$champuniq."='".$this->$champuniq."'";
							$requete=requete_sql($sql);
							$qte=compte_sql($requete);
							if ($qte!=0)
							{
								$test_champs_uniques=false;
	 							$this->message.="<p><SPAN>"._LA_VALEUR.$this->$champuniq._POUR_LE_CHAMP.$champuniq._EXISTE_DEJA."</SPAN></p><a href=\"javascript:history.go(-1)\">"._RETOUR."</a>";
	 						}
	 					}
	 				}
	 			}
	 			
	 			// Initialisation de la requete :
	 			if ($test_champs_obligatoires==true && $test_champs_uniques==true)
	 			{
	 				$sql_requete_insert1="INSERT INTO $this->table (";
		  			foreach ($this->champs as $valeur)
		  			{
		  				// Concatenation champ1,champ2 et 'valeur1','valeur2' :
		  				if (isset($this->$valeur) && !is_array($this->$valeur) && $valeur!="id".$this->classe)
		  				{
		  					$sql_requete_insert1=$sql_requete_insert1."$valeur,";
		  					$sql_requete_insert2=$sql_requete_insert2."'".$this->$valeur."',";
		  				}
		  			}
		  			$sql_requete_insert1=substr($sql_requete_insert1,0,-1).") VALUES (";
		  			$sql_requete_insert2=substr($sql_requete_insert2,0,-1).");";
		  			$sql_requete_insert=$sql_requete_insert1.$sql_requete_insert2;
		  			  			
		  			// Lancement de la creation de l objet correspondant :
		  			$sql_resultat=requete_sql($sql_requete_insert);
		  			$this->identifiant=id_insere_sql();
		  			return $this->identifiant;
	 			}
	 		}
			if ($this->message!="") 
			{
				echo $this->message;
			}
    	}
    }
	
	// Suppression logique de l'objet :
	function supprimer($verbeux = true)
	{
 		// Calcul de la requete :
 		$sql_requete_suppression="UPDATE $this->table SET visible='0' WHERE ".$this->champ_identifiant."='".$this->identifiant."';";
  		// Lancement de la mise a jour de l objet correspondant :
  		$sql_resultat=requete_sql($sql_requete_suppression);
		if ($verbeux==true)
		{
			echo "<H3><SPAN>"._OBJET_SUPPRIMER."</SPAN></H3><p><SPAN><a href=\"".$_SERVER['HTTP_REFERER']."\" >"._RETOUR."</a>&nbsp;</SPAN></p>";
		}
	}
	
	
	// Renvoi de l'identifiant de l'objet :
	function identifiant()
	{
		$id=$this->champ_identifiant;
 		$this->identifiant=$this->$id;
 		return $this->identifiant;
	}

	// Formulaire de creation d'objet :
	function formulaire()
	{
		//Initialisation des variables :
		global $langue;
		global $trad_SQL;
		
		// Enregistrement de l'objet s'il est poste :
		if ((isset($_POST["ok"]) && $_POST["suppression"]!="1" && $_POST["suivant"]!="1") || (isset($_GET["ok"]) && $_GET["suppression"]!="1" && $_GET["suivant"]!="1"))
		{
			$this->update($_POST);
			$this->enregistrer();
			foreach($this->champs_caches as $champ_cache)
			{
				$this->$champ_cache=$_POST[$champ_cache];
			}
		}
		
		// Enregistrement de l'objet et affichage d'un nouveau formulaire :
		elseif ((isset($_POST["ok"]) && (isset($_POST["suivant"]) && $_POST["suivant"]=="1") && (!isset($_POST["suppression"]) || isset($_POST["suppression"]) && $_POST["suppression"]!="1")) || (isset($_GET["ok"]) && (isset($_GET["suivant"]) && $_GET["suivant"]=="1") && (!isset($_GET["suppression"]) || isset($_GET["suppression"]) && $_GET["suppression"]!="1")))
		{
			$this->update($_POST);
			$this->enregistrer();
			$this= new $this->classe;
			foreach($this->champs_caches as $champ_cache)
			{
				$this->$champ_cache=$_POST[$champ_cache];
			}
		}
		
		// Supression logique de l'objet:
		elseif ((isset($_POST["suppression"]) && $_POST["suppression"]=="1") || (isset($_GET["suppression"]) && $_GET["suppression"]=="1"))
		{
			$this->update($_POST);
			$this->supprimer();
		}
		else
		{
			// Initialisation de(s) argument(s) : 		
	 		$arguments = func_get_args();
	 		$numargs = func_num_args();
			if ($numargs>0) 
			{
	 			for ($i=0; $i<=$numargs/2; $i=$i+2)
	 			{
	 				$this->$arguments[$i]=$arguments[$i+1];
	 			}
			}
		}
		
		//Non affichage du formulaire en cas de suppression :
		if ($_POST["suppression"]!="1" && $_GET["suppression"]!="1")
		{
			?><script type="text/javascript" language="javascript">
			<!--
			function controle_<? echo $this->classe; ?>(){
				var test=true;
				var message_erreur="<? echo _MESSAGE_D_ERREUR; ?>";
				<?
				//script de controle des champs obligatoires :
				if (isset($this->champs_obligatoires) && is_array($this->champs_obligatoires) && count($this->champs_obligatoires)>0)
				{
					foreach($this->champs_obligatoires as $champoblig)
					{
						if (in_array($champoblig,$this->champs_formulaire))
						{
							?>
						
							if(document.formulaire_<? echo $this->classe.".".$champoblig; ?>.value == "")
							{
								message_erreur+="<? echo _LE_CHAMP.$champoblig._NE_PEUT_ETRE_VIDE; ?>";
						   		document.formulaire_<? echo $this->classe.".".$champoblig; ?>.focus();
							   	test=false;
					  		}
				  			<?
						}
					}
				}
				?>
				
				if (test==true) document.formulaire_<? echo $this->classe; ?>.submit();
				else alert(message_erreur);
			}
			function suivant_<? echo $this->classe; ?>()
			{
					document.formulaire_<? echo $this->classe?>.suivant.value = "1";
					controle_<? echo $this->classe; ?>();
			}
			<?
			if (isset($this->identifiant))
			{ ?> 
			function suppression_<? echo $this->classe; ?>()
			{
			document.formulaire_<? echo $this->classe?>.suppression.value = "1";
			document.formulaire_<? echo $this->classe; ?>.submit();
			} <?
			}
			?>
			//-->
			</script>
			<h3><span><? 
			if(!isset($this->identifiant))
			{
				echo _CREATION_DE;
				if (array_key_exists($this->classe,$trad_SQL)) 
				{
					echo $trad_SQL[$this->classe];
				}
				else 
				{
					echo $this->classe;
				}
			}
			else
			{
				echo _MODIFICATION_DE;
				if (array_key_exists($this->classe,$trad_SQL)) 
				{
					echo $trad_SQL[$this->classe];
				}
				else 
				{
					echo $this->classe;
				}
			}
			?></span></h3>
				<DIV id="creation_<? echo $this->classe; ?>_cadre">
					<FORM action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="POST" name="formulaire_<? echo $this->classe; ?>">
					<INPUT type="HIDDEN" name="ok" value="1" />
					<?
					foreach($this->champs_formulaire as $champ)
					{
						if (in_array($champ,$this->champs_uniques))
						{		
							if (!isset($valeur[$champ]))
							{
								?>
								<DIV class="champ_cadre">
									<DIV class="intitule_champ"><SPAN><? if (array_key_exists($champ,$trad_SQL)) { echo $trad_SQL[$champ]; } else { echo $champ; } ?>&nbsp;:</SPAN></DIV>
									<DIV class="champ"><?
									if(!isset($this->$champ))
									{
										$temp = new champ($champ,$this->classe,"");
										echo $temp->champ_saisie;
									}
									else
									{
										$temp = new champ($champ,$this->classe,$this->$champ);
										echo $temp->champ_saisie;
									}						
									?>
									</DIV>
								</DIV>
					  			<?
							}
						}
						elseif (in_array($champ,$this->champs_obligatoires))
						{
							if (!isset($valeur[$champ]))
							{
								?>
								<DIV class="champ_cadre">
									<DIV class="intitule_champ"><SPAN><? if (array_key_exists($champ,$trad_SQL)) { echo $trad_SQL[$champ]; } else { echo $champ; } ?>&nbsp;:</SPAN></DIV>
									<DIV class="champ"><?
									if(!isset($this->$champ))
									{
										$temp = new champ($champ,$this->classe,"");
										echo $temp->champ_saisie;
									}
									else
									{
										$temp = new champ($champ,$this->classe,$this->$champ);
										echo $temp->champ_saisie;
									}						
									?>
									</DIV>
								</DIV>
					  			<?
							}
						}
					else
					{
						if (!isset($valeur[$champ]))
							{
								?>
								<DIV class="champ_cadre">
									<DIV class="intitule_champ"><SPAN><? if (array_key_exists($champ,$trad_SQL)) { echo $trad_SQL[$champ]; } else { echo $champ; } ?>&nbsp;:</SPAN></DIV>
									<DIV class="champ"><?
									if(!isset($this->$champ))
									{
										$temp = new champ($champ,$this->classe,"");
										echo $temp->champ_saisie;
									}
									else
									{
										$temp = new champ($champ,$this->classe,$this->$champ);
										echo $temp->champ_saisie;
									}						
									?>
									</DIV>
								</DIV>
					  			<?
							}
						}
					}
					if(is_array($this->champs_caches) && count($this->champs_caches)>0)
					{
						foreach ($this->champs_caches as $champ_defaut) 
						{
							echo ("<INPUT type=\"HIDDEN\" name=\"".$champ_defaut."\" READONLY value=\"".$this->$champ_defaut."\" />");
						}
					}
				if(isset($this->identifiant))
				{
					?>
					<INPUT type="HIDDEN" name="identifiant" value="<? echo $this->identifiant; ?>" />
					<?
				}
				?>
					<DIV class="bouton_cadre">
						<INPUT type="button" value="<? echo _BOUTON_OK; ?>" OnClick="controle_<? echo $this->classe; ?>()" />
						<INPUT type="button" value="<? echo _BOUTON_SUIVANT; ?>" OnClick="suivant_<? echo $this->classe; ?>()" />
						<INPUT type="HIDDEN" name="suivant" value="0" />
						<INPUT type="reset" value="<? echo _BOUTON_RESET; ?>" />
						<?
						//Bouton de suppression desactive car retour sur le formulaire et non sur la page de gestion
						if(false && isset($this->identifiant))
						{
							?>
							<INPUT type="button" value="<? echo _BOUTON_SUPPRIMER; ?>" OnClick="suppression_<? echo $this->classe; ?>()" />
							<INPUT type="HIDDEN" name="suppression" value="0" />
							<?
						}
						?>
						</DIV>
					<INPUT type="HIDDEN" name="langue" value="<? echo $langue; ?>" />
				</FORM>
			</DIV>
			<?
		}
	}
}
?>