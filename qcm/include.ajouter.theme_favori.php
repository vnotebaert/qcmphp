<?php
/*
 * Cree le 21 decembre 2007
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  include d'un theme avec listing des themes fils, le nombre de questionnaires par theme et listing des questionnaires pour le theme selectionne
 *
 */

require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
if(!headers_sent())
{
	//chargement de la librairie commune :

	require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
}

if (isset($utilisateur_connecte->identifiant))
{
	//chargement des definitions des classes utilisees
	require_once($adresserepertoiresite.'/scripts/php/class.theme_favori.php');
	require_once($adresserepertoiresite.'/scripts/php/class.regle.php');
	$vthemefavori= new theme_favori();

	//ajout du theme selectionne dans la liste des favoris :
	if (isset($_GET["tt"]) && isset($_GET["ajout"]) && $_GET["ajout"]=="1")
	{
		$vthemefavori->set("idtheme_rel",$_GET["tt"]);
		$vthemefavori->enregistrer();
	}
	//suppression du theme selectionne de la liste des favoris :
	if (isset($_GET["tt"]) && isset($_GET["ajout"]) && $_GET["ajout"]=="2" && isset($idutilisateur))
	{
		$sqlrequeteretirerthemfav="UPDATE $vthemefavori->table SET visible='0' WHERE idtheme_rel='".$_GET["tt"]."' and idutilisateur_rel='".$idutilisateur."';";
		$sqlrequeteretirerthemfav_result=requete_sql($sqlrequeteretirerthemfav);
	}
	
	if (isset($_GET["t"]))
	{
		//recherche du theme dans la liste des favoris :
		$sqlrecherchethemfav="SELECT * FROM $vthemefavori->table WHERE visible='1' AND idtheme_rel='".$_GET["t"]."' and idutilisateur_rel='".$idutilisateur."';";
		$sqlrecherchethemfav_result=requete_sql($sqlrecherchethemfav);
		$presencetheme=0;
		if (compte_sql($sqlrecherchethemfav_result)>0)
		{
			$presencetheme=1;
		}
		?>
		<div id="ajouter_theme_favori">
			<?
			if ($presencetheme==0)
			{
				echo "<span class=\"ajouter\"  title=\""._AJOUTER_THEME_AUX_FAVORIS."\" onclick=\"ajout_theme_favori(".$_GET["t"].")\">[+]</span>\n";
			}
			else
			{
				echo "<span class=\"retirer\"  title=\""._RETIRER_THEME_DES_FAVORIS."\" onclick=\"retirer_theme_favori(".$_GET["t"].")\">[-]</span>\n";
			}
			?>
		</div>
		<?
	}
}
?>