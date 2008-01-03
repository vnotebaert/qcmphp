<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : Definition de la classe champ qui gere l'affichage des champs des formulaires
 * 
 */
 
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.objet.php');

 class champ extends objet
{
    // Definition des proprietees
    var $nom_champ;
    var $type;
    var $est_nul;
    var $est_relation;
    var $table_relation;
    var $relation_champ;
    var $valeur_par_defaut;
    var $extra;
    var $champ_saisie;
     
    // Constructeur 
    function champ($nom_champ,$classe,$valeur_champ)
    {
    	// Definition des variables globales :
    	global $prefixe;
    	global $utilisateur_connecte;
		global $langue;
		global $trad_SQL;
    	
		// Definition de(s) table(s) :
 		$this->table=$prefixe."_".$classe;
 		
 		// Heritage :
 		parent::objet();
		
 		// Initialisation :
 		$this->nom_champ=$nom_champ;
 		
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
		$valeur_champ=stripslashes($valeur_champ);
		
		//Recherche des champ :
		if ($test_table)
		{
			$requete=requete_sql("SHOW COLUMNS FROM $this->table LIKE '$this->nom_champ'");
			while($temp=tableau_sql($requete))
	    	{
	    		$this->type=$temp["Type"];
	    		if ($temp["Key"]=="MUL") 
	    		{
	    			$this->est_relation="1";
	    			$chaine=explode("_", $this->nom_champ);
	    			$chaine=substr($chaine[0],2);
	    			$this->table_relation=$prefixe."_".$chaine;
					require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
					
					$champ_liste_choix= new regle("0","liste_".substr($this->table_relation,4));
	    			$this->relation_champ=explode("|",$champ_liste_choix->valeur);
	    		}
	    		else
	    		{
	    			$this->est_relation="0";
	    			$this->table_relation="";
	    			$this->relation_champ="";
	    		}
	    		$this->valeur_par_defaut=$temp["Default"];
	    		$this->extra=$temp["Extra"];
	    		$this->est_nul="0";
	    		if ($temp["Null"]!="") $this->est_nul="1";
	    	}
		    if (!in_array($this->table_relation,$liste_des_tables))
	    	{
	    		$this->table_relation="";
	    	}
	    	//Calcul du champ de saisie :
			$type=explode("(",$this->type);
			//liste de choix du language
	    	if ($nom_champ=="langue") {
				$this->champ_saisie="<select name=\"$this->nom_champ\">";
				$langues_dispo=langue_possible();
				foreach ($langues_dispo as $valeur)
				{
					
					$this->champ_saisie.="<option value=".$valeur;
					if (isset($valeur_champ) && $valeur_champ==$valeur) $this->champ_saisie.=" selected=\"selected\"";
					$this->champ_saisie.=">".$valeur."</option>\n";
				}
				$this->champ_saisie.="\n</select>";
			}
			//Chaine de caractere
	    	elseif ($type[0]=="varchar")
	    	{
	    		$this->champ_saisie="<input type=\"text\" name=\"$this->nom_champ\" maxlength=\"".substr($type[1],0,-1)."\" value=\"".$valeur_champ."\" />";
	    	}
	    	//Chaine de caractere
	    	elseif ($type[0]=="char")
	    	{
	    		$this->champ_saisie="<input type=\"text\" name=\"$this->nom_champ\" size=\"".substr($type[1],0,-1)."\" maxlength=\"".substr($type[1],0,-1)."\" value=\"".$valeur_champ."\" />";
	    	}
	    	//Nombre entre -128 et 128
	    	elseif ($type[0]=="tinyint")
	    	{
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
	    		$valeur_max_tinyint= new regle("0","Note_max");
				$this->champ_saisie="<select name=\"$this->nom_champ\">";
	    		for ($compteur = -$valeur_max_tinyint->valeur; $compteur <= $valeur_max_tinyint->valeur; $compteur++) 
	    		{
	    			$this->champ_saisie.="\n<option ";
	    			if(isset($valeur_champ) && $valeur_champ==$compteur) $this->champ_saisie.="selected=\"selected\" ";
					$this->champ_saisie.="value=\"".$compteur."\">".$compteur."&nbsp;";
					$this->champ_saisie.="</option>";
	    		}
	    		$this->champ_saisie.="\n</select>";
	    	}
	    	//Nombre > 128
	    	elseif ($type[0]=="int" || $type[0]=="smallint" || $type[0]=="mediumint" || $type[0]=="bigint")
	    	{
	    		$this->champ_saisie="<input type=\"text\" name=\"$this->nom_champ\" size=\"6\"  value=\"".$valeur_champ."\" />";
	    	}
	    	//Zone de texte
	    	elseif ($type[0]=="text" || $type[0]=="tinytext" || $type[0]=="mediumtext" || $type[0]=="longtext")
	    	{
	    		$taille=5;
	    		switch ($type[0])
	    		{ 
	    			case "tinytext" :
	    			$taille=4;
	    			case "text" :
	    			$taille=6;
	    			case "mediumtext" :
	    			$taille=8;
	    			case "longtext" :
	    			$taille=12;
	    		}
	    		$this->champ_saisie="" .
				"\n<textarea rows =\"".$taille."\" cols=\"100\" id=\"".$this->nom_champ."_texte\" name=\"".$this->nom_champ."\">".$valeur_champ."</textarea>";
			}
			//Bouton radio
	    	elseif ($type[0]=="enum")
	    	{
	    		$i=0;
	    		$temp=explode("','",substr($type[1],0,-1));
	    		$this->champ_saisie.="<ul>";
	    		foreach($temp as $valeur)
	    		{
	    			//Calcul de la valeur a afficher
	    			
	    			//calcul du champ de saisie
	    			$i++;
	    			$this->champ_saisie.="\n<li><input type=\"radio\" name=\"$this->nom_champ\" value=\"".str_replace("'","",$valeur)."\" id=\"".$this->nom_champ.$i."\" ";
	    			if ((!isset($valeur_champ) && $i==1) || (isset($valeur_champ) && $valeur_champ==str_replace("'","",$valeur)))
					{
						$this->champ_saisie.="checked=\"checked\"";
					}
					if (array_key_exists(str_replace("'","",$valeur),$trad_SQL))
					{
						$valeur_label=$trad_SQL[str_replace("'","",$valeur)];
					}
					else
					{
						
						$valeur_label=str_replace("'","",$valeur);
					}
					$this->champ_saisie.=" /> <label for=\"".$this->nom_champ.$i."\">".$valeur_label."</label></li>";
				}
				$this->champ_saisie.="</ul>";
	    	}
	    	
	    	//Si le champ est une relation :
	    	if ($this->table_relation!="")
	    	{
	    		//Calcul du champ identifiant dans la table en relation :
	    		$id_champ="id".substr($this->table_relation,4);
	    		
	    		//Debut du champ de saisie :
	    		$this->champ_saisie="<select name=\"$this->nom_champ\">";
	    		
	    		//Calcul de la requete a effectuer sur la table en relation :
	    		$requete="select * FROM $this->table_relation WHERE visible='1'";
	    		//Gestion des droits pour certains champs connus :
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
				
				$ordre_tri= new regle("0","tri_theme");
				$caractere_separateur= new regle("0","premier_caractere_arbo_theme");
				$caractere_indentation= new regle("0","indentation_arbo_theme");
	    		if ($this->table_relation==$prefixe."_theme" && $utilisateur_connecte->admin!=1)
	    		{
					$requete="select idtheme, CONCAT('$caractere_separateur->valeur', REPEAT('$caractere_indentation->valeur', niveau-1), titre) AS titre_arbo, CONCAT(LEFT('$caractere_separateur->valeur',niveau-1), REPEAT('$caractere_indentation->valeur', niveau-1), intitule) AS intitule_arbo, titre, intitule FROM qcm_theme WHERE visible='1' AND langue='$langue'";
	    			$requete.=" AND ";
	    			$requete.=$id_champ." IN (";
	    			foreach($utilisateur_connecte->idtheme_auteur as $vtheme)
	    			{
	    				$requete.="'".$vtheme."',";
	    			}
	    			$requete=substr($requete,0,-1).") ORDER BY bornegauche ASC";
	    		}
	    		elseif ($this->table_relation==$prefixe."_questionnaire" && $utilisateur_connecte->admin!=1)
	    		{
	    			$requete.=" AND ";
	    			$requete.=$id_champ." IN ('0',";
	    			foreach($utilisateur_connecte->idquestionnaire_auteur as $vquestionnaire)
	    			{
	    				$requete.="'".$vquestionnaire."',";
	    			}
	    			$requete=substr($requete,0,-1).")";
	    		}
	    		else
	    		{
	    			if($this->table_relation==$prefixe."_theme")
	    			{
	    			$requete="select idtheme, CONCAT(LEFT('$caractere_separateur->valeur',niveau-1), REPEAT('$caractere_indentation->valeur', niveau-1), titre) AS titre_arbo, CONCAT(LEFT('$caractere_separateur->valeur',niveau-1), REPEAT('$caractere_indentation->valeur', niveau-1), intitule) AS intitule_arbo, titre, intitule FROM qcm_theme WHERE visible='1' AND langue='$langue'";
	    			// Ordre de la liste :
		    		$requete.=" ORDER BY bornegauche ASC, $ordre_tri->valeur ASC;";
	    			}
	    			else
	    			{
		    			// Ordre de la liste 
		    			$requete.=" ORDER BY ";
						foreach ($this->relation_champ as $liste)
		    				{
		    					$requete.=$liste." ASC, ";
							}
						$requete=substr($requete,0,-2);
	    			}
	    		}
				$liste_sql=requete_sql($requete);
	    		//Complement du champ de saisie :
				$this->champ_saisie.="\n<option value=\"0\">"._NO_RELATION."</option>";
	    		while($valeur=tableau_sql($liste_sql)) 
	    		{
	    			$this->champ_saisie.="\n<option ";
	    			if(isset($valeur_champ) && $valeur_champ==$valeur[$id_champ]) $this->champ_saisie.="selected=\"selected\" ";
					$this->champ_saisie.="value=\"".$valeur[$id_champ]."\" >";
	    			foreach ($this->relation_champ as $liste)
	    			{
	    				$this->champ_saisie.=$valeur[$liste]."&nbsp;";
					}
					$this->champ_saisie.="</option>";
	    		}
	    		$this->champ_saisie.="\n</select>";
	    	}
	    	
	    	//Mise a vide des proprietes inappropriees :
	    	$this->champs=array();
	    	$this->champ_identifiant="";
		}
    } 
     
    // Definition des methodes
}
?>