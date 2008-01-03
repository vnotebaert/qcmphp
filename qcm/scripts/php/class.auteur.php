<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : Definition de la classe auteur
 * 
 */
 
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.objet.php');

  class auteur extends objet
{
    // Definition des proprietees 
    var $idauteur;
    var $idutilisateur_rel;
    var $idtheme_rel;
    var $datecreation;
    var $validation;
    var $idutilisateur_validateur_rel;  
    var $datevalidation;
	var $correcteur;
	var $dateaccordcorrecteur;
     
    // Constructeur 
    function auteur() {
    	// Definition des variables globales :
    	global $prefixe;
    	global $langue;
    	global $utilisateur_connecte;
    	
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_auteur";
 		$table_utilisateur=$prefixe."_utilisateur";
 		$table_theme=$prefixe."_theme";
 		
 		// Initialisation de(s) argument(s) : 		
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0) $idauteur=$arguments[0];
 		if ($numargs > 1) $this->tableau_arguments=$arguments[1];
 		 		
  		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("idutilisateur_rel","idtheme_rel");
 		// Champs du formulaire de creation :
 		$this->champs_formulaire=array("idutilisateur_rel","idtheme_rel");
 		// Champs caches du formulaire:
 		$this->champs_caches=array();
     		
 		// Recherche de la question si l'on donne son identifiant :
		if (isset($idauteur)) 
		{	
	     	$auteur_choisi=requete_sql("select * FROM $this->table WHERE idauteur=$idauteur");
			$auteur_choisi=tableau_sql($auteur_choisi);
	    	$this->idauteur = $idauteur;
	    	$this->identifiant = $idauteur;
	    	$this->visible = $auteur_choisi["visible"];
	    	$this->idutilisateur_rel = $auteur_choisi["idutilisateur_rel"];  
	    	$this->idtheme_rel = $auteur_choisi["idtheme_rel"];  
	    	$this->datecreation = $auteur_choisi["datecreation"];  
	    	$this->validation = $auteur_choisi["validation"];  
	    	$this->idutilisateur_validateur_rel = $auteur_choisi["idutilisateur_validateur_rel"];  
	   		$this->datevalidation = $auteur_choisi["datevalidation"];  
	    	$this->correcteur = $auteur_choisi["correcteur"];  
	   		$this->dateaccordcorrecteur = $auteur_choisi["dateaccordcorrecteur"];  
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
	
    // Validation d'un auteur
    function validation($val)
    {
    	// Declaration des variables:
    	global $utilisateur_connecte;
    	
    	if (in_array($val,array("1","0")))
    	{
    		// Calcule de la requete :
 			$sql_requete_validation="UPDATE $this->table SET validation='".$val."', datevalidation='".time()."',  idutilisateur_validateur_rel='".$utilisateur_connecte->identifiant."' WHERE ".$this->champ_identifiant."='".$this->identifiant."';";
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
			<form action="<? echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>" method="post" id="formulaire_validation">
				<input type="hidden" name="identifiant" value="<? echo $this->identifiant; ?>" />
				<div class="intitule_champ"><span><? echo _VALIDATION; ?> :</span></div>
				<div class="champ"><input type="text" readonly="READONLY" disabled="DISABLED" size="1" value="<? echo $this->validation; ?>" />
				</div>
				<div class="bouton_cadre">
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
}
?>