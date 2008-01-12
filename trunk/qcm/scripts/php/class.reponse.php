<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : Definition de la classe reponse
 * 
 */

//chargement de la librairie commune :
require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite.'/scripts/php/class.objet.php');


 class reponse extends objet 
{
    // Definition des proprietees 
    var $idreponse; 
    var $idutilisateur_rel;
    var $idchoix_rel;
    var $datereponse;
    var $mot;
    var $texte;
	var $idquestion_rel;
     
    // Constructeur 
    function reponse($num_choix = 0,$mot = "",$texte = "",$num_question = 0) {
    	// Definition des variables globales :
    	global $prefixe;
    	global $idutilisateur;
    	
    	// Definition de(s) table(s) :
 		$this->table=$prefixe."_reponse";
 		
 		// Heritage :
 		parent::objet(); 	
        
        // Initialisation :
        // Champs obligatoires :
 		$this->champs_obligatoires=array("datereponse","idutilisateur_rel");
 		
 		$this->visible = 1;  
    	if (is_numeric($idutilisateur) && intval($idutilisateur)==$idutilisateur) 
    	{
    		$this->idutilisateur_rel = $idutilisateur;
    	}
    	else
    	{
    		$this->idutilisateur_rel = "0";
    	}
    	$this->idchoix_rel = $num_choix;
    	$this->datereponse = time();  
    	$this->mot = $mot;
    	$this->texte = $texte;
		$this->idquestion_rel=$num_question;
    	
    } 
     
    // Definition des methodes
}
?>
