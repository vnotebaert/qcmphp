<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : Definition de la classe environnement definissant les methodes non reliees a un objet
 * mais plus directement aux donnees
 * 
 */

require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');

 class environnement
{
    // Definition des proprietees
         
    // Constructeur 
    function environnement() {	
    }
     
    // Definition des methodes
    function liste_themes($idpere) 
    {
    	//initialisation des variables globales:
		global $langue;
		global $page_theme;
		
		//Creation d'une variable temporaire de classe theme :
    	require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.theme.php');
		
		if ($idpere==0 || !isset($idpere)) 
		{
			$vtemp= new theme();
			$id=0;
		}
		else 
		{
			$vtemp= new theme($idpere);
			$id=$vtemp->identifiant();
		}
    	$requete="select T1.idtheme AS idtheme, T1.titre AS titre, T1.intitule AS intitule, SUM(1)-1 as NB
		FROM $vtemp->table AS T1, $vtemp->table AS T2 
		WHERE T1.visible='1' AND T1.idtheme_rel='$id' AND T2.visible='1' AND T1.langue='$langue' AND T2.langue='$langue' AND (T1.idtheme=T2.idtheme_rel OR T1.idtheme=T2.idtheme) 
		GROUP BY T1.idtheme ORDER BY T1.titre;";
    	$liste_themes=requete_sql($requete);
		$qte=compte_sql($liste_themes);
		if ($qte!=0)
		{
			echo "\n<div class=\"tableau\"><table id=\"liste_theme\" >";
			echo "<tr><th colspan=\"2\">"._DETAIL."</th><th>"._MODIFICATION."</th><th>"._SUPPRESSION."</th><th>"._TITRE."</th><th>"._INTITULE."</th></tr>\n";
			//Affichage du pere s'il existe :
			if ($id!=0)
			{
				echo "<tr class=\"groupe\"><td colspan=\"2\" >";
				if ($vtemp->idtheme_rel!=0) 
				{
					echo "<a href=\"".$page_theme."?p=".$vtemp->idtheme_rel."\">"._REMONTER."</a>";
				}
				else
				{
					echo "&nbsp;";
				}
				echo "</td><td><a href=\"".$page_theme."?i=".$vtemp->idtheme."\">"._MODIFIER."</a></td><td>&nbsp;</td>";
				//Affichage titre et intitule :
				echo "<td>";
				if (strlen($vtemp->titre)>0)
				{
					echo $vtemp->titre;
				}
				else {
					echo "&nbsp;";
				}
				echo "</td>";
				echo"<td>";
				if (strlen($vtemp->intitule)>0)
				{
					echo $vtemp->intitule;
				}
				else 
				{
					echo "&nbsp;";
				}
				echo "</td></tr>\n";
			}
			while($theme=tableau_sql($liste_themes)) 
			{
				if(is_array($theme) && count($theme)>0)
				{
					echo "<tr><td class=\"groupe\">&nbsp;</td><td>";
					if ($theme['NB']>0) 
					{
						echo "<a href=\"".$page_theme."?p=".$theme['idtheme']."\">"._DETAILLER."</a>";
					}
					else 
					{
						echo "&nbsp;";
					}
					echo "</td><td><a href=\"".$page_theme."?i=".$theme['idtheme']."\">"._MODIFIER."</a></td><td><a href=\"".$page_theme."?i=".$theme['idtheme']."&amp;suppression=1 \">"._SUPPRIMER."</a></td>";
					//Affichage titre et intitule :
					echo "<td>";
					if (strlen($theme['titre'])>0)
					{
						echo $theme['titre'];
					}
					else 
					{
						echo "&nbsp;";
					}
					echo "</td>";
					echo"<td>";
					if (strlen($theme['intitule'])>0)
					{
						echo $theme['intitule'];
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
    
    //Question au hasard pour la page d'acceuil :
    function question_au_hasard()
    {
	    //initialisation des variables globales:
		global $langue;
		global $idutilisateur;
    	
		//Creation de variables temporaires:
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.question.php');
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.questionnaire.php');
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.reponse.php');
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.theme.php');
		
    	$vtemp= new question();
		$vquestionnaire= new questionnaire();
		$vtheme = new theme();
		$vreponse= new reponse();
    	
    	$select_sql="select T1.$vtemp->champ_identifiant 
		FROM $vtemp->table AS T1, $vtheme->table AS T2, $vquestionnaire->table AS T3 
		LEFT JOIN $vreponse->table AS T4 ON (T1.idquestion=T4.idquestion_rel AND T4.idutilisateur_rel='$idutilisateur')
		WHERE T4.idreponse IS NULL AND T1.visible='1' AND T2.visible='1' AND T3.visible='1' AND T1.idquestionnaire_rel=T3.idquestionnaire 
		AND T2.idtheme=T3.idtheme_rel AND T2.langue='$langue' AND T1.validation='1' 
		ORDER BY RAND() LIMIT 1;";
    	$select_sql=requete_sql($select_sql);
    	$une_question=tableau_sql($select_sql);
    	return $une_question[$vtemp->champ_identifiant];
    }
	
	//Mise a jour des themes (non optimise) :
	function mise_a_jour_theme()
	{
	    //initialisation des variables globales :
		global $langue;
		
		//initialisation des variables :
		$pere_prec=0;
		$taille_prec=0;
    	
		//Creation d'une variable temporaire de classe theme :
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.theme.php');
		
		$vtemp=new theme();
		
		//RAZ des taille et borne gauche des themes:
		$update_raz="UPDATE ".$vtemp->table." SET taille=1, bornegauche=1 WHERE langue='$langue'";
		$update_raz=requete_sql($update_raz);
		
		//mise a jour du niveau des themes :
		$update_niveaumin="UPDATE ".$vtemp->table." SET niveau=1 WHERE idtheme_rel=0 AND langue='$langue'";
		$update_niveaumin=requete_sql($update_niveaumin);
		$dernierniveau=1;
		$select_niveau="select T1.* FROM ".$vtemp->table." AS T1, ".$vtemp->table." AS T2 WHERE T2.niveau=$dernierniveau AND T1.idtheme_rel=T2.idtheme AND T1.langue='$langue' AND T2.langue='$langue';";
		$select_niveau=requete_sql($select_niveau);
		while(compte_sql($select_niveau)>0)
		{
			$vniveau=$dernierniveau+1;
			$update_niveau="UPDATE ".$vtemp->table." SET niveau=$vniveau WHERE idtheme";
			$update_niveau.=" IN (";
	    	while($vtheme=tableau_sql($select_niveau))
	    	{
	    		$update_niveau.="'".$vtheme['idtheme']."',";
	    	}
	    	$update_niveau=substr($update_niveau,0,-1).")";
			$update_niveau=requete_sql($update_niveau);
			$dernierniveau=$dernierniveau+1;
			$select_niveau="select T1.* FROM ".$vtemp->table." AS T1, ".$vtemp->table." AS T2 WHERE T2.niveau=$dernierniveau AND T1.idtheme_rel=T2.idtheme AND T1.langue='$langue' AND T2.langue='$langue';";
			$select_niveau=requete_sql($select_niveau);	
		}
		
		//2 boucles sur les niveaux pour mettre a jour la taille et la borne gauche:
		$select_niveaumax="select MAX(niveau) FROM ".$vtemp->table." WHERE visible='1' AND langue='$langue';";
		$select_niveaumax=requete_sql($select_niveaumax);
		$niveaumax=tableau_sql($select_niveaumax);
		$niveaumax=$niveaumax[0];
		//mise a jour de la taille des themes
		for($i=$niveaumax;$i>0;$i--) 
		{
			$select_suivante="select T2.".$vtemp->champ_identifiant.", SUM(T1.taille+1)+1 AS vtaille 
			FROM ".$vtemp->table." AS T1 
			RIGHT JOIN ".$vtemp->table." AS T2 ON (T1.".$vtemp->champ_identifiant."_rel=T2.".$vtemp->champ_identifiant." AND T1.visible=1 AND T1.langue='$langue') 
			WHERE T2.niveau=$i AND T2.visible=1 AND T2.langue='$langue' 
			GROUP BY T1.".$vtemp->champ_identifiant."_rel";
			$select_suivante=requete_sql($select_suivante);
			while($noeud=tableau_sql($select_suivante)) 
			{
				$update_taille="UPDATE $vtemp->table SET taille=".$noeud['vtaille']." WHERE $vtemp->champ_identifiant=".$noeud['idtheme'].";";
				requete_sql($update_taille);
			}
		}
		//mise a jour de la bornegauche des themes 
		require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.regle.php');
		
		$ordre_tri= new regle("0","tri_theme");
		for($i=0;$i<$niveaumax+1;$i++) 
		{
			//mise a jour des racines de l'arborescence
			if ($i==0)
			{
				$select_borne="select T1.".$vtemp->champ_identifiant.", T1.taille, T2.bornegauche AS vborne, T2.idtheme AS vidtheme_pere FROM ".$vtemp->table." AS T1 
				LEFT JOIN ".$vtemp->table." AS T2 ON (T1.".$vtemp->champ_identifiant."_rel=T2.".$vtemp->champ_identifiant." AND T1.visible=1 AND T1.langue='$langue')
				WHERE T2.niveau IS NULL AND T1.idtheme IS NOT NULL AND T2.langue='$langue'
				ORDER BY T1.idtheme_rel ASC, T1.$ordre_tri->valeur ASC";
			}
			//mise a jour des autres elements de l'arborescence
			else
			{
				$select_borne="select T1.".$vtemp->champ_identifiant.", T1.taille, T2.bornegauche AS vborne, T2.idtheme AS vidtheme_pere
				FROM ".$vtemp->table." AS T1 
				RIGHT JOIN ".$vtemp->table." AS T2 ON (T1.".$vtemp->champ_identifiant."_rel=T2.".$vtemp->champ_identifiant." AND T1.visible=1 AND T1.langue='$langue')
				WHERE T2.niveau=$i AND T1.idtheme IS NOT NULL AND T2.visible=1 AND T2.langue='$langue'
				ORDER BY T1.idtheme_rel ASC, T1.$ordre_tri->valeur ASC";
			}
			$select_borne=requete_sql($select_borne);
			$nombre_ligne=compte_sql($select_borne);
			for($j=1;$j<=$nombre_ligne;$j++)
			{
				$element=tableau_sql($select_borne);
				//si l'on change de pere la borne se calcul par rapport a la borne du pere :
				if ($element['vidtheme_pere']!=$pere_prec)
				{
					$borne_prec=$element['vborne']+1;
					$update_borne="UPDATE $vtemp->table SET bornegauche=".$borne_prec." WHERE $vtemp->champ_identifiant=".$element['idtheme'].";";
					$taille_prec=$element['taille'];
					requete_sql($update_borne);
					$pere_prec=$element['vidtheme_pere'];
				}
				//si l'on ne change pas de pere la borne se calcul par rapport a la derniere borne :
				else
				{
					$borne_prec=$taille_prec+1+$borne_prec;
					$update_borne="UPDATE $vtemp->table SET bornegauche=".$borne_prec." WHERE $vtemp->champ_identifiant=".$element['idtheme'].";";
					$taille_prec=$element['taille'];
					requete_sql($update_borne);
					$pere_prec=$element['vidtheme_pere'];
				}
			}
		}
	}
	 
	 
	function liste_utilisateurs($vfiltre="1", $vordre="compte") 
    {
    	//initialisation des variables globales:
		global $langue;
		
		//Creation d'une variable temporaire de classe theme :
    	require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.utilisateur.php');
	}
}
?>
