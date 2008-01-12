<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : Definition de la classe choix
 * 
 */
 
//chargement de la librairie commune :
require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
require_once($adresserepertoiresite.'/scripts/php/class.objet.php');

 class choix extends objet
{
    // Definition des proprietees 
    var $idchoix;
    var $idquestion_rel;  
    var $titre;
    var $intitule;
    var $vraifaux;
    var $valeur;
     
    // Constructeur 
    function choix() {
    	// Definition des variables globales :
    	global $prefixe;
    	global $page_question;
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_choix";
 		
    	// Initialisation de(s) argument(s) : 		
 		$arguments = func_get_args();
 		$numargs = func_num_args();
 		if ($numargs > 0 ) $idchoix_selectionne=$arguments[0];
     	if ($numargs > 1 ) $this->tableau_arguments=$arguments[1];
 		
 		// Heritage :
 		parent::objet();
 		
 		// Initialisation :
 		// Champs obligatoires :
 		$this->champs_obligatoires=array("idquestion_rel");
 		// Champs du formulaire de creation :
 		$this->champs_formulaire=array("titre","intitule","vraifaux","valeur");
 		// Champs caches du formulaire:
 		$this->champs_caches=array("idquestion_rel");
 		
 		// Recherche du choix si l'on donne son identifiant :
		if (isset($idchoix_selectionne)) {	
     	$reponse_choisie=requete_sql("select * FROM $this->table WHERE idchoix=$idchoix_selectionne");
		$reponse_choisie=tableau_sql($reponse_choisie);
    	$this->idchoix = $idchoix_selectionne;
    	$this->identifiant = $idchoix_selectionne;
    	$this->visible = $reponse_choisie["visible"];
    	$this->idquestion_rel = $reponse_choisie["idquestion_rel"];  
    	$this->titre = $reponse_choisie["titre"];  
    	$this->intitule = $reponse_choisie["intitule"];  
    	$this->vraifaux = $reponse_choisie["vraifaux"];  
    	$this->valeur = $reponse_choisie["valeur"];
 		}
 		// Initialisation du choix si l'on ne donne pas d'indentifiant :
		// l'heritage suffit
    } 
     
    // Definition des methodes
}
?>
