<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
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
    var $liste_fils_arbo= array();

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
	     	$theme_choisie=requete_sql("select * FROM $this->table WHERE idtheme=$idtheme_selectionne");
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
   			$liste_fils_sql=requete_sql("select * FROM $this->table WHERE idtheme_rel=$idtheme_selectionne AND visible='1' ORDER BY bornegauche ASC");
	   		while($theme=tableau_sql($liste_fils_sql)) 
	   		{
	   			array_push($this->liste_fils,$theme);
	   		}
			$liste_fils_arbo_sql=requete_sql("select * FROM $this->table WHERE bornegauche>$this->bornegauche AND bornegauche+taille<$this->bornegauche+$this->taille AND visible='1' ORDER BY bornegauche ASC");
	   		while($theme=tableau_sql($liste_fils_arbo_sql)) 
	   		{
	   			array_push($this->liste_fils_arbo,$theme);
	   		}
			
    	}
 		// Initialisation du theme si l'on ne donne pas d'indentifiant :
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
	
	//nombre de questionnaire d'une theme
    function nb_questionnaire()
    {
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.questionnaire.php');
		$vtempquestionnaire = new questionnaire();
		$vnb_questionnaire="";
		$count_questionnaire_sql=requete_sql("SELECT SUM(T3.titre IS NOT NULL) AS nombrefils_arbo, SUM(T1.idtheme=T3.idtheme_rel) AS nombrefils_direct
		FROM $this->table AS T1 
		LEFT JOIN $this->table AS T2 ON (T2.bornegauche>=T1.bornegauche AND T2.bornegauche + T2.taille<=T1.bornegauche + T1.taille AND T1.visible='1' AND T2.visible='1') 
		LEFT JOIN $vtempquestionnaire->table AS T3 ON (T3.idtheme_rel=T2.idtheme AND T3.visible=1 AND T3.validation='1')
		WHERE T1.idtheme=$this->identifiant GROUP BY T1.idtheme");
		$nbquest=tableau_sql($count_questionnaire_sql);
		$vnb_questionnaire[0]=$nbquest["nombrefils_arbo"];
		$vnb_questionnaire[1]=$nbquest["nombrefils_direct"];
		return $vnb_questionnaire;
	}
	
	
	//nombre de questionnaire d'une theme
    function liste_questionnaires($vfiltre = "1",$vordre="titre")
    {
		//declaration des variables :
		global $page_affichage_questionnaire;
		
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.questionnaire.php');
		$vtempquestionnaire = new questionnaire();
		
		$requete_sql="SELECT *
		FROM $vtempquestionnaire->table AS T1 
		WHERE T1.idtheme_rel=$this->identifiant AND T1.validation='1' AND T1.visible='1' AND ".$vfiltre." 
		ORDER BY ".$vordre;
		$liste_questionnaires=requete_sql($requete_sql);
		$qte=compte_sql($liste_questionnaires);
		if ($qte!=0)
		{
			echo "\n<div class=\"tableau\"><table>";
			echo "<tr><th>"._TITRE."</th><th>"._INTITULE."</th></tr>\n";
			while($questionnaire=tableau_sql($liste_questionnaires)) 
			{
				if(is_array($questionnaire) && count($questionnaire)>0)
				{
					echo "<tr>";
					//Affichage titre et intitule :
					echo "<td><a href=\"".$page_affichage_questionnaire."?v=".$questionnaire['idquestionnaire']."\">";
					if (strlen($questionnaire['titre'])>0)
					{
						echo $questionnaire['titre'];
					}
					else 
					{
						echo "&nbsp;";
					}
					echo "</a></td>";
					echo"<td>";
					if (strlen($questionnaire['intitule'])>0)
					{
						echo $questionnaire['intitule'];
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
	}
}
?>