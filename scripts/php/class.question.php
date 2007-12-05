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
    	global $editor;
    	
    	
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
	    	$type_avec_choix= array("unique","unique_liste","multiple","multiple_liste");
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
		global $editor;
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
			if ($this->type=="multiple" || $this->type=="unique") 
			{
					$i=0;
					?>
					<ul>
					<?
					foreach ($this->liste_choix as $valeur) 
					{
						if ($this->type=="multiple") 
						{
							$i++;
							?>
							<li><input name="reponse[]" type="checkbox" value="<? echo($valeur["idchoix"]); ?>" tabindex="<? echo $i ?>" /><span class="titrechoix" lang="<? echo($langue); ?>"><? echo($valeur["titre"]) ?></span><span class="intitulechoix" lang="<? echo($langue); ?>"><? echo($valeur["intitule"]) ?></span>&nbsp;</li>
							<?
						}
						if ($this->type=="unique")
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
			if ($this->type=="multiple_liste" || $this->type=="unique_liste") 
			{
				$i=0;
				?>
				
				<SELECT name="reponse<? 
				if ($this->type=="multiple_liste") 
				{
					echo"[]\" MULTIPLE";
				}
				else 
				{
					echo"\""; 
				}
				?>><?
				foreach ($this->liste_choix as $clef=>$valeur) 
				{
					?>
					
					<OPTION value="<? echo($valeur["idchoix"]); ?>" ><span class="titrechoix" lang="<? echo $langue; ?>"><? echo(stripslashes($valeur["titre"])) ?></span><span class="intitulechoix" lang="<? echo $langue; ?>"><? echo(stripslashes($valeur["intitule"])) ?></span>&nbsp;</OPTION><?
				}
				?>
				
				</SELECT>
				<?
			}
			if ($this->type=="mot")
			{
				?>
				<input name="reponse" type="text" value="" tabindex="1" />
				<?
			}		
			if ($this->type=="texte")
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
				<textarea rows ="5" cols="100" id="reponse_texte" name="reponse" value=""></textarea>
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
				
				editor_generate('reponse_texte',config);
				</script>
				<?
				}		
			?>
			</div>
			<DIV class="bouton_cadre"><input type="submit" value="<? echo _BOUTON_OK ?>" /> <input type="reset" value="<? echo _BOUTON_RESET ?>" /></div>
			</form><?
    	}
		if(isset($_POST["reponse"]))
		{
			if (!is_array($_POST["reponse"]) && ($this->type=="unique" || $this->type=="unique_liste")) 
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
			elseif ($this->type=="multiple" || $this->type=="multiple_liste")
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
			elseif ($this->type=="mot")
			{
				for ($i=0;$i<count($_POST["reponse"]);$i++) 
				{
					echo("<DIV class=\"reponse\"><H1>"._VOUS_AVEZ_REPONDU ."</H1>". nl2br(htmlentities($_POST["reponse"],ENT_QUOTES)) ."</DIV>");
					$ch_reponse=new reponse(0,nl2br(htmlentities($_POST["reponse"],ENT_QUOTES)),"",$this->identifiant);
					$ch_reponse->enregistrer();
				}
				echo("<DIV class=\"solution\"><H1>"._SOLUTION_TEXTE."</H1><p>".$this->solution."</p></DIV>");
			}
			elseif ($this->type=="texte")
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
    	global $editor;
    	
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