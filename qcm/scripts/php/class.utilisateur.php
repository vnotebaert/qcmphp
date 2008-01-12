<?php
/*
 * Cree le 22 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  Definition de la classe utilisateur
 * 
 */
  
//chargement de la librairie commune :
require_once('conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
require_once($adresserepertoiresite.'/scripts/php/class.objet.php');
 
  class utilisateur extends objet
{
    // Definition des proprietes :
    var $idutilisateur;
    var $compte;
    var $motpasse;
	var $connexionautomatique;
    var $nom;
    var $prenom;
    var $pseudonyme;
	var $avatarurl;
    var $description;
    var $idequipe_rel;
    var $admin;
    var $responsabledelegue;
    var $email;
    var $autrescontacts;
    var $datecreation;
    var $datederniereconnection;
    var $dateentreeequipe;
    var $activation;
    var $_testauthentification;
    var $message_connexion;
	var $idtheme_auteur = array();
	var $idtheme_correcteur = array();
	var $idtheme_favori_utilisateur = array();
	var $idquestion_auteur = array();
	var $idquestionnaire_auteur = array();
	
    // Definition du constructeur :
    // on doit donner un compte et un mode de passe
    function utilisateur() 
    {
    	// Definition des variables globales :
    	global $prefixe;
		global $adresserepertoiresite;
		
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_utilisateur";
 		$this->table_question=$prefixe."_question";
 		$this->table_questionnaire=$prefixe."_questionnaire";
 		$this->table_auteur=$prefixe."_auteur";
		
 		// Initialisation de(s) argument(s) :
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0 ) $compte_arg=$arguments[0];
 		if ($numargs > 1 ) $motdepasse_arg=$arguments[1];
 		if ($numargs > 2 ) $this->tableau_arguments=$arguments[2];
 		if ($numargs > 3 ) 
 		{
 			$id=$arguments[3];
 			$this->identifiant=$arguments[3];
 		}
		if ($numargs > 4 ) $motdepasse_crypte_arg=$arguments[4];
 		if ($compte_arg=="0") unset($compte_arg);
 		if ($motdepasse_arg=="0") unset($motdepasse_arg);
 		if (!is_array($this->tableau_arguments)) unset($this->tableau_arguments);
 		if ($id=="0" || $id=="") 
		{
			unset($id);
			unset($this->identifiant);
		}
 		
 		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("compte","motpasse","datecreation","email");

		//Champs uniques :
		$this->champs_uniques=array("compte");
 		
		// Test d'authentification si un compte et un mot de passe sont donnes :
		if (isset($compte_arg) && isset($motdepasse_arg))
		{
			// Mot de passe crypte :
	 		$motdepasse_crypte=substr(MD5($motdepasse_arg),0,20);
	 
			// Recherche du compte :
			$sql="SELECT * FROM $this->table WHERE compte='$compte_arg' AND visible='1'";
			$utilisateur_res=requete_sql($sql);
			$qte=compte_sql($utilisateur_res);
			if ($qte==0) {
				// Compte inexistant
				$this->compte = $compte_arg; 
		        $this->motpasse = $motdepasse_crypte;
		        $this->validation = "0";
		        $this->admin = "0";
		        $this->_testauthentification = -1; 
			}
			else 
			{
				//Le compte existe
				//Initialisation de l'utilisateur
				$utilisateur_trouve=tableau_sql($utilisateur_res);
				foreach($utilisateur_trouve as $key => $value) {
					if (!is_numeric($key)) $this->$key=$value;
				}
				//Test du mot de passe
		        if ($this->motpasse==$motdepasse_crypte && $this->activation==1) {		        	
					//L'utilisateur est reconnu et correcte
					//Mise a jour de sa derniere date de connexion
					$this->datederniereconnection=time();
		        	$sql1="UPDATE $this->table SET datederniereconnection=$this->datederniereconnection WHERE $this->champ_identifiant=".$this->identifiant().";";
					$res1=requete_sql($sql1);
					$this->_testauthentification = 2;
					
					//Recherche des themes dont l'utilisateur est auteur :
					$sqlauteur="SELECT idtheme_rel FROM $this->table_auteur WHERE idutilisateur_rel=".$this->identifiant()." AND visible=1 AND validation='1';";
					$resauteur=requete_sql($sqlauteur);
					while ($auteur=tableau_sql($resauteur))
					{
						//Creation d'une variable temporaire de classe theme :
						require_once($adresserepertoiresite.'/scripts/php/class.theme.php');
						$vtemptheme=new theme($auteur['idtheme_rel']);
						$this->idtheme_auteur[]=$auteur['idtheme_rel'];
						foreach($vtemptheme->liste_fils_arbo as $idthemefils)
						{
							$this->idtheme_auteur[]=$idthemefils['idtheme'];
						}
					}
					
					//Recherche des themes dont l'utilisateur est correcteur :
					$sqlcorrecteur="SELECT idtheme_rel FROM $this->table_auteur WHERE idutilisateur_rel=".$this->identifiant()." AND visible=1 AND validation='1' AND correcteur='1';";
					$rescorrecteur=requete_sql($sqlcorrecteur);
					while ($correcteur=tableau_sql($rescorrecteur))
					{
						$this->idtheme_correcteur[]=$correcteur['idtheme_rel'];
					}
					
					//Recherche des questions dont l'utilisateur est auteur :
					$sqlquestauteur="SELECT idquestion FROM $this->table_question WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1 ORDER BY idquestionnaire_rel ASC, ordre ASC;";
					$resquestauteur=requete_sql($sqlquestauteur);
					while($questauteur=tableau_sql($resquestauteur))
					{
						$this->idquestion_auteur[]=$questauteur['idquestion'];
					}
					
					//Recherche des questionnaires dont l'utilisateur est auteur :
					$sqlquestionnaireauteur="SELECT idquestionnaire FROM $this->table_questionnaire WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1;";
					$resquestionnaireauteur=requete_sql($sqlquestionnaireauteur);
					while($questionnaireauteur=tableau_sql($resquestionnaireauteur))
					{
						$this->idquestionnaire_auteur[]=$questionnaireauteur['idquestionnaire'];
					}
					
					//Recherche des themes favoris de l'utilisateur :
					require_once($adresserepertoiresite.'/scripts/php/class.theme_favori.php');
					$vtemptheme_fav=new theme_favori();
					$sqlidtheme_favori_utilisateur="SELECT idtheme_rel FROM $vtemptheme_fav->table WHERE idutilisateur_rel=".$this->identifiant()." AND visible='1';";
					$residtheme_favori_utilisateur=requete_sql($sqlidtheme_favori_utilisateur);
					while($idtheme_favori_utilisateur=tableau_sql($residtheme_favori_utilisateur))
					{
						$this->idtheme_favori_utilisateur[]=$idtheme_favori_utilisateur['idtheme_rel'];
					}
				}
				
		        elseif ($this->motpasse!=$motdepasse_crypte) {
			        //Mot de passe errone
					$this->admin = "0";
					$this->_testauthentification = 0;
		        }
		        elseif ($this->activation!=1) {
			        //Mot de passe juste mais compte non active
					$this->admin = "0";
					$this->_testauthentification = 1;
		        }
			}
		}

	    // Initialisation de l'utilisateur si l'on souhaite le creer (troisieme argument uniquement) :
		if (!isset($compte_arg) && !isset($motdepasse_arg) && isset($this->tableau_arguments))
		{
			// Mot de passe crypte :
	 		$this->setmotpasse($this->motpasse);
			
			if ((!isset($this->_testauthentification) || $this->_testauthentification=="")) 
	 		{
	 			$this->_testauthentification = 1;
	 		}
	 		if (!isset($this->datecreation) || $this->datecreation=="") 
	 		{
	 			$this->datecreation=time();
	 		}
		}
		
	    // Recherche de l'utilisateur par son identifiant (quatrieme argument uniquement) :
		if (!isset($compte_arg) && !isset($motdepasse_arg) && !isset($this->tableau_arguments) && isset($id))
		{
			// Recherche du compte :
			$sql="SELECT * FROM $this->table WHERE $this->champ_identifiant='$id'";
			$utilisateur_res=requete_sql($sql);
			$utilisateur_trouve=tableau_sql($utilisateur_res);
			if (is_array($utilisateur_trouve))
			{
				foreach($utilisateur_trouve as $key => $value) 
				{
					$this->$key=$value;
				}
				//Recherche des themes dont l'utilisateur est auteur :
				$sqlauteur="SELECT idtheme_rel FROM $this->table_auteur WHERE idutilisateur_rel=".$this->identifiant()." AND visible=1 AND validation='1';";
				$resauteur=requete_sql($sqlauteur);
				while ($auteur=tableau_sql($resauteur))
				{
					$this->idtheme_auteur[]=$auteur['idtheme_rel'];
				}
				
				//Recherche des themes dont l'utilisateur est correcteur :
				$sqlcorrecteur="SELECT idtheme_rel FROM $this->table_auteur WHERE idutilisateur_rel=".$this->identifiant()." AND visible=1 AND validation='1' AND correcteur='1';";
				$rescorrecteur=requete_sql($sqlcorrecteur);
				while ($correcteur=tableau_sql($rescorrecteur))
				{
					$this->idtheme_correcteur[]=$correcteur['idtheme_rel'];
				}
				
				//Recherche des questions dont l'utilisateur est auteur :
				$sqlquestauteur="SELECT idquestion FROM $this->table_question WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1 ORDER BY idquestionnaire_rel ASC, ordre ASC;";
				$resquestauteur=requete_sql($sqlquestauteur);
				while($questauteur=tableau_sql($resquestauteur))
				{
					$this->idquestion_auteur[]=$questauteur['idquestion'];
				}
				
				//Recherche des questionnaires dont l'utilisateur est auteur :
				$sqlquestionnaireauteur="SELECT idquestionnaire FROM $this->table_questionnaire WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1;";
				$resquestionnaireauteur=requete_sql($sqlquestionnaireauteur);
				while($questionnaireauteur=tableau_sql($resquestionnaireauteur))
				{
					$this->idquestionnaire_auteur[]=$questionnaireauteur['idquestionnaire'];
				}
				
				//Recherche des themes favoris de l'utilisateur :
				require_once($adresserepertoiresite.'/scripts/php/class.theme_favori.php');
				$vtemptheme_fav=new theme_favori();
				$sqlidtheme_favori_utilisateur="SELECT idtheme_rel FROM $vtemptheme_fav->table WHERE idutilisateur_rel=".$this->identifiant()." AND visible='1';";
				$residtheme_favori_utilisateur=requete_sql($sqlidtheme_favori_utilisateur);
				while($idtheme_favori_utilisateur=tableau_sql($residtheme_favori_utilisateur))
				{
					$this->idtheme_favori_utilisateur[]=$idtheme_favori_utilisateur['idtheme_rel'];
				}
			}
		}
		
		// Recherche de l'utilisateur par son identifiant (quatrieme argument uniquement) :
		if (isset($compte_arg) && !isset($motdepasse_arg) && !isset($this->tableau_arguments) && !isset($id) && isset($motdepasse_crypte_arg))
		{
	 		// Mot de passe crypte :
	 		$motdepasse_crypte=$motdepasse_crypte_arg;
			
			// Recherche du compte :
			$sql="SELECT * FROM $this->table WHERE compte='$compte_arg' AND visible='1'";
			$utilisateur_res=requete_sql($sql);
			$qte=compte_sql($utilisateur_res);
			if ($qte==0) {
				// Compte inexistant
				$this->compte = $compte_arg; 
		        $this->motpasse = $motdepasse_crypte;
		        $this->validation = "0";
		        $this->admin = "0";
		        $this->_testauthentification = -1; 
			}
			else 
			{
				//Le compte existe
				//Initialisation de l'utilisateur
				$utilisateur_trouve=tableau_sql($utilisateur_res);
				foreach($utilisateur_trouve as $key => $value) {
					if (!is_numeric($key)) $this->$key=$value;
				}
				//Test du mot de passe
		        if ($this->motpasse==$motdepasse_crypte && $this->activation==1) {		        	
					//L'utilisateur est reconnu et correcte
					//Mise a jour de sa derniere date de connexion
					$this->datederniereconnection=time();
		        	$sql1="UPDATE $this->table SET datederniereconnection=$this->datederniereconnection WHERE $this->champ_identifiant=".$this->identifiant().";";
					$res1=requete_sql($sql1);
					$this->_testauthentification = 2;
					
					//Recherche des themes dont l'utilisateur est auteur :
					$sqlauteur="SELECT idtheme_rel FROM $this->table_auteur WHERE idutilisateur_rel=".$this->identifiant()." AND visible=1 AND validation='1';";
					$resauteur=requete_sql($sqlauteur);
					while ($auteur=tableau_sql($resauteur))
					{
						//Creation d'une variable temporaire de classe theme :
						require_once($adresserepertoiresite.'/scripts/php/class.theme.php');
						$vtemptheme=new theme($auteur['idtheme_rel']);
						$this->idtheme_auteur[]=$auteur['idtheme_rel'];
						foreach($vtemptheme->liste_fils_arbo as $idthemefils)
						{
							$this->idtheme_auteur[]=$idthemefils['idtheme'];
						}
					}
					
					//Recherche des themes dont l'utilisateur est correcteur :
					$sqlcorrecteur="SELECT idtheme_rel FROM $this->table_auteur WHERE idutilisateur_rel=".$this->identifiant()." AND visible=1 AND validation='1' AND correcteur='1';";
					$rescorrecteur=requete_sql($sqlcorrecteur);
					while ($correcteur=tableau_sql($rescorrecteur))
					{
						$this->idtheme_correcteur[]=$correcteur['idtheme_rel'];
					}
					
					//Recherche des questions dont l'utilisateur est auteur :
					$sqlquestauteur="SELECT idquestion FROM $this->table_question WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1 ORDER BY idquestionnaire_rel ASC, ordre ASC;";
					$resquestauteur=requete_sql($sqlquestauteur);
					while($questauteur=tableau_sql($resquestauteur))
					{
						$this->idquestion_auteur[]=$questauteur['idquestion'];
					}
					
					//Recherche des questionnaires dont l'utilisateur est auteur :
					$sqlquestionnaireauteur="SELECT idquestionnaire FROM $this->table_questionnaire WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1;";
					$resquestionnaireauteur=requete_sql($sqlquestionnaireauteur);
					while($questionnaireauteur=tableau_sql($resquestionnaireauteur))
					{
						$this->idquestionnaire_auteur[]=$questionnaireauteur['idquestionnaire'];
					}
					
					//Recherche des themes favoris de l'utilisateur :
					require_once($adresserepertoiresite.'/scripts/php/class.theme_favori.php');
					$vtemptheme_fav=new theme_favori();
					$sqlidtheme_favori_utilisateur="SELECT idtheme_rel FROM $vtemptheme_fav->table WHERE idutilisateur_rel=".$this->identifiant()." AND visible='1';";
					$residtheme_favori_utilisateur=requete_sql($sqlidtheme_favori_utilisateur);
					while($idtheme_favori_utilisateur=tableau_sql($residtheme_favori_utilisateur))
					{
						$this->idtheme_favori_utilisateur[]=$idtheme_favori_utilisateur['idtheme_rel'];
					}
				}
		        elseif ($this->motpasse!=$motdepasse_crypte) {
			        //Mot de passe errone
					$this->admin = "0";
					$this->_testauthentification = 0;
		        }
		        elseif ($this->activation!=1) {
			        //Mot de passe juste mais compte non active
					$this->admin = "0";
					$this->_testauthentification = 1;
		        }
			}
		}
    }
    
    // Definition des methodes
     
    // Fonction de calcul du mot de passe crypte a partir de mot de passe en clair 
    function setmotpasse($motdepasse) { 
        $this->motpasse = substr(MD5($motdepasse),0,20);
    } 

	// Fonction qui renvoie le message d'authentification
    // 	returns:
	//	-1	le compte n existe pas 
    //       0	le compte existe mais le mot de passe est incorrect
    //	1	le compte existe mais n est pas active
    //	2	compte et mot de passe sont correctes 
    function authentification() { 
        //Declaration des variables :
		global $page_index;
		
		if ($this->_testauthentification==-1)
        {
        	$this->message_connexion=_COMPTE_INEXISTANT;
        }
        if ($this->_testauthentification==0)
        {
        	$this->message_connexion=_MOT_DE_PASSE_INCORRECT;
        } 
		if ($this->_testauthentification==1)
        {
        	$this->message_connexion=_COMPTE_EXISTANT_MAIS_NON_ACTIF;
        }
        if ($this->_testauthentification==2)
        {
	        $this->message_connexion=_AUTHENTIFICATION_OK_SOUS_1
	        .$this->pseudonyme. " (".$this->prenom." ".$this->nom.")"
	        ._AUTHENTIFICATION_OK_SOUS_2
	        ."<a href=\"".$page_index."?deco=1\" title=\""._AUTHENTIFICATION_OK_TITLE_DECO."\" accesskey=\"i\" onclick=\"deleteCookie('compte','','');\">"
			._AUTHENTIFICATION_OK_SOUS_3."</a>"
			._AUTHENTIFICATION_OK_SOUS_4
			.$this->pseudonyme
			._AUTHENTIFICATION_OK_SOUS_5;
        }
        return $this->message_connexion;
    }
    
    //complement sur la methode objet::enregistrer
    function enregistrer() 
    {
		//Declaration des variables :
		global $adresserepertoiresite;
		global $adressehttpsite;
		
    	//chargement des regles pour la creation de compte :
 		require_once($adresserepertoiresite.'/scripts/php/class.regle.php');
 		
		$activation_par_mail=new regle(0,"Activation_par_mail");
    	
		$testcreation=false;
		if (!isset($this->identifiant))
		{
			$testcreation=true;
		}
    	$id=objet::enregistrer();
    	if ($this->message=="" && $testcreation) 
    	{
    		$this->message=_LA_CREATION_DU_COMPTE_C_EST_BIEN_DEROULEE;
    		if ($activation_par_mail->valeur==1) 
    		{
    			$destinataire=$this->email;
    			$sujet = _SUJET_MAIL_CREATION_COMPTE;
				$from = "From: QCM@$SERVER_NAME\n";
				$from .= "X-Mailer: PHP/" . phpversion();
				$from .= "MIME-version: 1.0\n";
				$from .= "Content-type: text/html; charset= utf-8\n";
    			$message = _MESSAGE_MAIL_CREATION_COMPTE;
    			$message .= " <a href=\"".$adressehttpsite."compte.php?I=".$id."&act=".MD5($this->datecreation)."\">"._LIEN_ACTIVATION_COMPTE_UTILISATEUR."</a>";
    			 mail($destinataire,$sujet, $message,$from);
       			$this->message.=_UN_MAIL_DE_CONFIRMATION_VOUS_A_ETE_ENVOYE;
       			$this->message.=_L_ACTIVATION_S_EFFECTUE_GRACE_AU_MAIL_DE_CONFIRMATION;
    		}
    		else 
    		{
    			$sql_activation="UPDATE $this->table SET activation='1',  datederniereconnection='".time()."' WHERE ".$this->champ_identifiant."='".$id."';";
				$sql_resultat=requete_sql($sql_activation);
    		}
    	}
    	if ($this->message=="" && !$testcreation)
    	{
    		$this->message=_LA_MODIFICATION_DU_COMPTE_C_EST_BIEN_DEROULEE;
    	}
    }
	
	//activiation d'un compte utilisateur :
	function activation($code)
	{
		if ($code==MD5($this->datecreation)) {
			$sql_activation="UPDATE $this->table SET activation='1',  datederniereconnection='".time()."' WHERE ".$this->champ_identifiant."='".$this->identifiant()."';";
			$sql_resultat=requete_sql($sql_activation);
			$this->message=_LE_COMPTE_UTILISATEUR.$this->compte._EST_ACTIVE;
			$this->_testauthentification=2;
	  		return $this->identifiant();			
		}
	}
	
	//Recherche des questions dont l'utilisateur est auteur :
	function auteur_question()
	{
    	// Definition des variables globales :
    	global $prefixe;
    	global $page_question;
    	global $adresserepertoiresite;
    	
		// Definition des tables :
		$table_question=$prefixe."_question";
		$table_questionnaire=$prefixe."_questionnaire";
		
		//requete standard :
		$sqlauteur="SELECT * FROM $table_question WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1 ORDER BY idquestionnaire_rel ASC, ordre ASC;";
		//requete admin :
		if ($this->admin=="1")
		{
			$sqlauteur="SELECT * FROM $table_question WHERE visible=1 ORDER BY idquestionnaire_rel ASC, ordre ASC;";
		}
		$resauteur=requete_sql($sqlauteur);
		
		echo "<h3 class=\"listing_question_utilisateur\"><span>"._LISTING_QUESTION_UTILISATEUR."</span></h3>";
		
		if (compte_sql($resauteur)>0)
		{
				echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/prototype.js\"  charset=\"utf-8\"></script>";
				echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/tablekit.js\" charset=\"utf-8\"></script>";
				echo "\n<div class=\"tableau\"><table id=\"liste_question\" class=\"resizable sortable\">";
			echo "<tr><th>"._MODIFICATION."</th><th>"._SUPPRESSION."</th><th>"._VALIDATION."</th><th>"._TITRE."</th><th>"._INTITULE."</th></tr>\n";
			while($auteur=tableau_sql($resauteur)) 
			{
				if(is_array($auteur) && count($auteur)>0)
				{
					echo "<tr><td><a href=\"".$page_question."?i=".$auteur['idquestion']."\">"._MODIFIER."</a></td><td><a href=\"".$page_question."?i=".$auteur['idquestion']."&amp;suppression=1 \">"._SUPPRIMER."</a></td>";
					//Gestion de l'affichage de la validation :
					//chargement des regles pour le format des dates :
					require_once($adresserepertoiresite.'/scripts/php/class.regle.php');
					
					$format_date=new regle("0","format_date");
					
					if ($auteur['datevalidation']=="0") echo "<td>"._NON_TRAITEE.$auteur['validation']."</td>";
					else echo "<td>"._TRAITEE_LE.date($format_date->valeur,$auteur['datevalidation']).". <a href=\"#\" title=\"".stripslashes($auteur['textevalidation'])."\">"._RESULTAT.$auteur['validation']."</a></td>";
					
					//Affichage titre et intitule :
					echo "<td>";
					if (strlen($auteur['titre'])>0)
					{
						echo $auteur['titre'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</td>";
					echo"<td>";
					if (strlen($auteur['intitule'])>0)
					{
						echo $auteur['intitule'];
					}
					else {
					echo "&nbsp;";
					}
					echo "</td></tr>\n";
				}
			}
			echo "</table></div>\n";
		}
		else
		{
			echo "<p>"._AUCUNE_QUESTION_POUR_L_UTILISATEUR."</p>";
		}
	}
	
	//Recherche des questionnaires dont l'utilisateur est auteur :
	function auteur_questionnaire()
	{
    	// Definition des variables globales :
    	global $prefixe;
    	global $page_questionnaire;
		global $trad_SQL;
		global $adresserepertoiresite;
    	
		// Definition des tables :
		$table_questionnaire=$prefixe."_questionnaire";
		
		//requete standard :
		$sqlauteur="SELECT * FROM $table_questionnaire WHERE idutilisateur_auteur_rel=".$this->identifiant()." AND visible=1 ORDER BY idtheme_rel ASC, titre ASC;";
		//requete admin :
		if ($this->admin=="1")
		{
			$sqlauteur="SELECT * FROM $table_questionnaire WHERE visible=1 ORDER BY idtheme_rel ASC, titre ASC;";
		}
		$resauteur=requete_sql($sqlauteur);
		
		echo "<h3 class=\"listing_questionnaire_utilisateur\"><span>"._LISTING_QUESTIONNAIRE_UTILISATEUR."</span></h3>";
		
		if (compte_sql($resauteur)>0)
		{
			echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/prototype.js\"  charset=\"utf-8\"></script>";
			echo "\n<script type=\"text/javascript\" src=\"./scripts/javascript/tablekit.js\" charset=\"utf-8\"></script>";
			echo "\n<div class=\"tableau\"><table id=\"liste_questionnaire\" class=\"sortable resizable\">";
			echo "<tr><th>"._MODIFICATION."</th><th>"._SUPPRESSION."</th><th>"._VALIDATION."</th><th>"._VALIDATION_DATE."</th><th>"._TITRE."</th><th>"._INTITULE."</th><th>"._NIVEAU."</th></tr>\n";
			while($auteur=tableau_sql($resauteur)) 
			{
				if(is_array($auteur))
				{
					echo "<tr><td><a href=\"".$page_questionnaire."?i=".$auteur['idquestionnaire']."\">"._MODIFIER."</a></td><td><a href=\"".$page_questionnaire."?i=".$auteur['idquestionnaire']."&amp;suppression=1 \">"._SUPPRIMER."</a></td>";
					//Gestion de l'affichage de la validation :
					//chargement des regles pour le format des dates :
					require_once($adresserepertoiresite.'/scripts/php/class.regle.php');
					$format_date=new regle("0","format_date");
					
					if ($auteur['datevalidation']=="0") echo "<td>"._NON_TRAITEE.$auteur['validation']."</td><td>&nbsp;</td>";
					else echo "<td><a href=\"#\" title=\"".stripslashes($auteur['textevalidation'])."\">"._RESULTAT.$auteur['validation']."</a></td><td>"._TRAITEE_LE.date($format_date->valeur,$auteur['datevalidation'])."</td>";
					
					//Affichage titre et intitule :
					echo "<td>";
					if (strlen($auteur['titre'])>0)
					{
						echo $auteur['titre'];
					}
					else 
					{
						echo "&nbsp;";
					}
					echo "</td>";
					echo"<td>";
					if (strlen($auteur['intitule'])>0)
					{
						echo $auteur['intitule'];
					}
					else 
					{
						echo "&nbsp;";
					}
					//Affichage niveau :
					echo "<td>";
					if (strlen($auteur['niveau'])>0)
					{
						if (array_key_exists($auteur['niveau'],$trad_SQL))
						{
							$valeur_label=$trad_SQL[$auteur['niveau']];
						}
						else
						{
							
							$valeur_label=$auteur['niveau'];
						}
						echo $valeur_label;
					}
					else 
					{
						echo "&nbsp;";
					}
					echo "</td></tr>\n";
				}
			}
			echo "</table></div>\n";
		}
		else
		{
			echo "<p>"._AUCUN_QUESTIONNAIRE_POUR_L_UTILISATEUR."</p>";
		}
	}

// end class definition 
}
?>