<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
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
		global $editor;
    	
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
	    	if ($nom_champ=="langue") {
				$this->champ_saisie="<SELECT name=\"$this->nom_champ\">";
				$langues_dispo=langue_possible();
				foreach ($langues_dispo as $valeur)
				{
					
					$this->champ_saisie.="<OPTION value=".$valeur;
					if (isset($valeur_champ) && $valeur_champ==$valeur) $this->champ_saisie.=" SELECTED";
					$this->champ_saisie.=">".$valeur."</OPTION>\n";
				}
				$this->champ_saisie.="\n</SELECT>";
			}
	    	elseif ($type[0]=="varchar")
	    	{
	    		$this->champ_saisie="<INPUT type=\"TEXT\" name=\"$this->nom_champ\" maxlength=\"".substr($type[1],0,-1)."\" value=\"".$valeur_champ."\" />";
	    	}
	    	elseif ($type[0]=="char")
	    	{
	    		$this->champ_saisie="<INPUT type=\"TEXT\" name=\"$this->nom_champ\" size=\"".substr($type[1],0,-1)."\" maxlength=\"".substr($type[1],0,-1)."\" value=\"".$valeur_champ."\" />";
	    	}
	    	elseif ($type[0]=="tinyint")
	    	{
	    		$this->champ_saisie="<SELECT name=\"$this->nom_champ\">";
	    		for ($compteur = -128; $compteur <= 127; $compteur++) 
	    		{
	    			$this->champ_saisie.="\n<OPTION ";
	    			if(isset($valeur_champ) && $valeur_champ==$compteur) $this->champ_saisie.="SELECTED ";
					$this->champ_saisie.="value=\"".$compteur."\">".$compteur."&nbsp;";
					$this->champ_saisie.="</OPTION>";
	    		}
	    		$this->champ_saisie.="\n</SELECT>";
	    	}
	    	elseif ($type[0]=="int" || $type[0]=="smallint" || $type[0]=="mediumint" || $type[0]=="bigint")
	    	{
	    		$this->champ_saisie="<INPUT type=\"TEXT\" name=\"$this->nom_champ\" size=\"6\"  value=\"".$valeur_champ."\" />";
	    	}
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
	    		
	    		if ($editor=="htmlarea")
	    		{
		    		$this->champ_saisie="<script type=\"text/javascript\" language=\"Javascript1.2\"><!-- // load htmlarea
					_editor_url = \"scripts/javascript/\";                     // URL to htmlarea files
					var win_ie_ver = parseFloat(navigator.appVersion.split(\"MSIE\")[1]);
					if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
					if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
					if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
					if (navigator.userAgent.indexOf('Mozilla')      >= 0) { win_ie_ver = 6; }
					if (win_ie_ver >= 5.5) {
					  document.write('<script src=\"' +_editor_url+ 'editor.js\"');
					  document.write(' language=\"Javascript1.2\"><\/script>');  
					} else { document.write('<script>function editor_generate() { return false; }<\/script>'); }
					// --></script>\n<TEXTAREA rows =\"".$taille."\" cols=\"100\" id=\"".$this->nom_champ."_texte\" name=\"".$this->nom_champ."\">".$valeur_champ."</TEXTAREA>
					<script type=\"text/javascript\" language=\"javascript1.2\">
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
					    \"Arial\":           \"arial, helvetica, sans-serif\",
					    \"Courier New\":     \"courier new, courier, mono\",
					    \"Georgia\":         \"Georgia, Times New Roman, Times, Serif\",
					    \"Tahoma\":          \"Tahoma, Arial, Helvetica, sans-serif\",
					    \"Times New Roman\": \"times new roman, times, serif\",
					    \"Verdana\":         \"Verdana, Arial, Helvetica, sans-serif\",
					    \"impact\":          \"impact\",
					    \"WingDings\":       \"WingDings\"
					};
					config.fontsizes = {
					    \"1 (8 pt)\":  \"1\",
					    \"2 (10 pt)\": \"2\",
					    \"3 (12 pt)\": \"3\",
					    \"4 (14 pt)\": \"4\",
					    \"5 (18 pt)\": \"5\",
					    \"6 (24 pt)\": \"6\",
					    \"7 (36 pt)\": \"7\"
					};
								
					config.fontstyles = [   // make sure classNames are defined in the page the content is being display as well in or they won't work!
					  { name: \"headline\",     className: \"headline\",  classStyle: \"font-family: arial black, arial; font-size: 28px; letter-spacing: -2px;\" },
					  { name: \"arial red\",    className: \"headline2\", classStyle: \"font-family: arial black, arial; font-size: 12px; letter-spacing: -2px; color:red\" },
					  { name: \"verdana blue\", className: \"headline4\", classStyle: \"font-family: verdana; font-size: 18px; letter-spacing: -2px; color:blue\" }
					];
					
					editor_generate('".$this->nom_champ."_texte',config);
					</script>";
				}
				elseif ($editor="xinha")
				{
					$this->champ_saisie="" .
					"\n<TEXTAREA rows =\"".$taille."\" cols=\"100\" id=\"".$this->nom_champ."_texte\" name=\"".$this->nom_champ."\">".$valeur_champ."</TEXTAREA>";
				}
			}
	    	elseif ($type[0]=="enum")
	    	{
	    		$i=0;
	    		$temp=explode("','",substr($type[1],0,-1));
	    		$this->champ_saisie.="<UL>";
	    		foreach($temp as $valeur)
	    		{
	    			$i++;
	    			$this->champ_saisie.="\n<LI><INPUT TYPE=\"RADIO\" name=\"$this->nom_champ\" value=\"".str_replace("'","",$valeur)."\" id=\"".$this->nom_champ.$i."\" ";
	    			if ((!isset($valeur_champ) && $i==1) || (isset($valeur_champ) && $valeur_champ==str_replace("'","",$valeur))) $this->champ_saisie.="CHECKED";
					$this->champ_saisie.=" \> <label for=\"".$this->nom_champ.$i."\">".str_replace("'","",$valeur)."</label></LI>";
				}
				$this->champ_saisie.="</UL>";
	    	}
	    	
	    	//Si le champ est une relation :
	    	if ($this->table_relation!="")
	    	{
	    		//Calcul du champ identifiant dans la table en relation :
	    		$id_champ="id".substr($this->table_relation,4);
	    		
	    		//Debut du champ de saisie :
	    		$this->champ_saisie="<SELECT name=\"$this->nom_champ\">";
	    		
	    		//Calcul de la requete a effectuer sur la table en relation :
	    		$requete="SELECT * FROM $this->table_relation WHERE visible='1'";
	    		//Gestion des droits pour certains champs connus :
				require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
				
				$ordre_tri= new regle("0","tri_theme");
				$caractere_separateur= new regle("0","premier_caractere_arbo_theme");
				$caractere_indentation= new regle("0","indentation_arbo_theme");
	    		if ($this->table_relation==$prefixe."_theme" && $utilisateur_connecte->admin!=1)
	    		{
					$requete="SELECT idtheme, CONCAT($caractere_separateur->valeur, REPEAT('$caractere_indentation->valeur', niveau-1), titre) AS titre_arbo, CONCAT(LEFT('$caractere_separateur->valeur',niveau-1), REPEAT('$caractere_indentation->valeur', niveau-1), intitule) AS intitule_arbo, titre, intitule FROM qcm_theme WHERE visible='1' AND langue='$langue'";
	    			$requete.=" AND ";
	    			$requete.=$id_champ." IN (";
	    			foreach($utilisateur_connecte->idtheme_auteur as $vtheme)
	    			{
	    				$requete.="'".$vtheme."',";
	    			}
	    			$requete=substr($requete,0,-1).")";
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
	    			$requete="SELECT idtheme, CONCAT(LEFT('$caractere_separateur->valeur',niveau-1), REPEAT('$caractere_indentation->valeur', niveau-1), titre) AS titre_arbo, CONCAT(LEFT('$caractere_separateur->valeur',niveau-1), REPEAT('$caractere_indentation->valeur', niveau-1), intitule) AS intitule_arbo, titre, intitule FROM qcm_theme WHERE visible='1' AND langue='$langue'";
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
				$this->champ_saisie.="\n<OPTION value=\"0\">"._NO_RELATION."</OPTION>";
	    		while($valeur=tableau_sql($liste_sql)) 
	    		{
	    			$this->champ_saisie.="\n<OPTION ";
	    			if(isset($valeur_champ) && $valeur_champ==$valeur[$id_champ]) $this->champ_saisie.="SELECTED ";
					$this->champ_saisie.="value=\"".$valeur[$id_champ]."\" >";
	    			foreach ($this->relation_champ as $liste)
	    			{
	    				$this->champ_saisie.=$valeur[$liste]."&nbsp;";
					}
					$this->champ_saisie.="</OPTION>";
	    		}
	    		$this->champ_saisie.="\n</SELECT>";
	    	}
	    	
	    	//Mise a vide des proprietes inappropriees :
	    	$this->champs=array();
	    	$this->champ_identifiant="";
		}
    } 
     
    // Definition des methodes
}
?>