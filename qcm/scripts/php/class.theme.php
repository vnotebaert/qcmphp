<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : Definition de la classe theme
 * 
 */
 
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.objet.php');


 class theme extends objet
{
    // Definition des proprietees 
    var $idtheme;
    var $idtheme_rel;
    var $titre;
    var $intitule;
	var $niveau;
	var $taille;
	var $bornegauche;
	var $langue;
    var $liste_fils= array();

    // Constructeur 
    function theme() {
    	// Definition des variables globales :
    	global $prefixe;
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_theme";
    	
    	// Initialisation de(s) argument(s) : 		
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0 ) $idtheme_selectionne=$arguments[0];
     	if ($numargs > 1 ) $this->tableau_arguments=$arguments[1];
 		
 		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("titre");
 		// Champs du formulaire de creation :
 		$this->champs_formulaire=array("titre","intitule","idtheme_rel");
 		
 		// Recherche du choix si l'on donne son identifiant :
		if (isset($idtheme_selectionne)) 
		{	
	     	$theme_choisie=requete_sql("SELECT * FROM $this->table WHERE idtheme=$idtheme_selectionne");
			$theme_choisie=tableau_sql($theme_choisie);
	    	$this->idtheme = $idtheme_selectionne;
	    	$this->identifiant = $idtheme_selectionne;
	    	$this->visible = $theme_choisie["visible"];
	    	$this->idtheme_rel = $theme_choisie["idtheme_rel"];
	    	$this->titre = $theme_choisie["titre"];
	    	$this->intitule = $theme_choisie["intitule"];
			$this->niveau = $theme_choisie["niveau"];
			$this->taille = $theme_choisie["taille"];
			$this->bornegauche = $theme_choisie["bornegauche"];
			$this->langue = $theme_choisie["langue"];
   			$liste_fils_sql=requete_sql("SELECT * FROM $this->table WHERE idtheme_rel=$idtheme_selectionne AND visible='1' ORDER BY titre ASC");
	   		while($theme=tableau_sql($liste_fils_sql)) 
	   		{
	   			array_push($this->liste_fils,$theme);
	   		}
    	}
 		// Initialisation du choix si l'on ne donne pas d'indentifiant :
		// l'heritage suffit
    } 
     
    // Definition des methodes

    // Enregistrement d'un theme
    function enregistrer()
    {
		//Recalcul du niveau :
		if ($this->idtheme_rel<=0) $this->niveau=1;
		else
		{
			$vtemp=new theme($this->idtheme_rel);
			$niveaupere=$vtemp->niveau;
			$this->niveau=$niveaupere+1;
		}
    	// Heritage:
    	parent::enregistrer();
    	
	}
	
    // Suppression d'un theme
    function supprimer($verbeux = true)
    {
    	// Heritage:
    	parent::supprimer($verbeux);
    	//Supression en cascade des descendants:
		foreach ($this->liste_fils as $vfils)
		{
			$vtemp=new theme($vfils['idtheme']);
			$vtemp->supprimer(false);
		}
    }
}
?>