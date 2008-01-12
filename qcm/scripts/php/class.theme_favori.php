<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : Definition de la classe theme_favori
 * 
 */
 
//chargement de la librairie commune :
require_once('conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
require_once($adresserepertoiresite.'/scripts/php/class.objet.php');

  class theme_favori extends objet
{
    // Definition des proprietees 
    var $idauteur;
    var $idutilisateur_rel;
    var $idtheme_rel;
    var $datecreation;
     
    // Constructeur 
    function theme_favori() {
    	// Definition des variables globales :
    	global $prefixe;
    	global $utilisateur_connecte;
    	
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_theme_favori";
 		
 		// Initialisation de(s) argument(s) : 		
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0) $idtheme_favori=$arguments[0];
 		if ($numargs > 1) $this->tableau_arguments=$arguments[1];
 		 		
  		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("idutilisateur_rel","idtheme_rel");
 		// Champs du formulaire de creation :
 		$this->champs_formulaire=array("idtheme_rel");
 		// Champs caches du formulaire:
 		$this->champs_caches=array();
     		
 		// Recherche du theme favori si l'on donne son identifiant :
		if (isset($idtheme_favori)) 
		{	
	     	$theme_favori_choisi=requete_sql("select * FROM $this->table WHERE idtheme_favori=$idtheme_favori");
			$theme_favori_choisi=tableau_sql($theme_favori_choisi);
	    	$this->idtheme_favori = $idtheme_favori;
	    	$this->identifiant = $idtheme_favori;
	    	$this->visible = $theme_favori_choisi["visible"];
	    	$this->idutilisateur_rel = $theme_favori_choisi["idutilisateur_rel"];  
	    	$this->idtheme_rel = $theme_favori_choisi["idtheme_rel"];  
	    	$this->datecreation = $theme_favori_choisi["datecreation"];  
	    }
	    
	    // Initialisation du theme favori si l'on ne donne pas d'identifiant :
 		else {
	 		if (!isset($this->datecreation) || $this->datecreation=="") 
	 		{
	 			$this->datecreation=time();
	 		}
	 		if (!isset($this->idutilisateur_rel) || $this->idutilisateur_rel=="" || !is_numeric($this->idutilisateur_rel) || intval($this->idutilisateur_rel)!= $this->idutilisateur_rel) 
	 		{
	 			$this->idutilisateur_rel=$utilisateur_connecte->identifiant;
	 		}
 		}
    } 
     
    // Definition des methodes
}
?>