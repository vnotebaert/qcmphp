<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : Definition de la classe regle qui permet le parametrage du comportement de QCM_PHP
 * 
 */
 
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.objet.php');

 class regle extends objet
{
    // Definition des proprietees 
    var $idregle;
    var $nom;
    var $description;
    var $valeur;
    var $listechoix; 
     
    // Constructeur 
    function regle() {
    	// Definition des variables globales :
    	global $prefixe;
   	
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_z_regle";
  		
 		// Initialisation de(s) argument(s) : 		
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0) $idregle=$arguments[0];
 		if ($numargs > 1) $nomregle=$arguments[1];
 		 		
  		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("titre","idutilisateurauteur_rel");
 		
 		// Recherche de la regle en fonction de son identifiant :
		if (isset($idregle) && $idregle!=0) 
		{	
	     	$regle_choisie=requete_sql("SELECT * FROM $this->table WHERE $this->champ_identifiant='$idregle'");
			$regle_choisie=tableau_sql($regle_choisie);
			$this->idregle=$regle_choisie["idregle"];
			$this->identifiant=$regle_choisie["idregle"];
			$this->nom=$regle_choisie["nom"];
			$this->description=$regle_choisie["description"];
			$this->valeur=$regle_choisie["valeur"];
			$this->listechoix=$regle_choisie["listechoix"];
	    }
	    
	    // Initialisation de la question si l'on ne donne pas d'indentifiant :
 		elseif (isset($nomregle)) 
 		{
	     	$regle_choisie=requete_sql("SELECT * FROM $this->table WHERE nom='$nomregle'");
			$regle_choisie=tableau_sql($regle_choisie);
			$this->idregle=$regle_choisie["idregle"];
			$this->nom=$regle_choisie["nom"];
			$this->description=$regle_choisie["description"];
			$this->valeur=$regle_choisie["valeur"];
			$this->listechoix=$regle_choisie["listechoix"];
 		}
    } 
     
    // Definition des methodes
    
// end class definition 
}
?>
