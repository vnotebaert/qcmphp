<?php
/*
 * Cree le 21 decembre 2007
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  include du choix de la langue de QCM_PHP
 *
 */
if ($utilisateur_connecte->_testauthentification==2) 
{
	if(!headers_sent())
	{
		//chargement de la librairie commune :
		require_once('conf.site.inc.php');
		global $adresserepertoiresite;
		global $adressehttpsite;
		require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
	}

	?>
	<div class="dragableBox" id="ltheme_favori_selection">
		<div id="theme_favori_selection">
			<div id="theme_favori_cadre">
				<h3 class="theme_favori_selection"><span><? echo _THEME_FAVORI_TITRE; ?></span></h3>
				<ul>
					<?
					$vtemptheme=$prefixe."_theme";
					$vtemp=$prefixe."_theme_favori";
					$vtheme_favori_sql="SELECT T2.* FROM $vtemp AS T1, $vtemptheme AS T2 WHERE T1.visible='1' AND T2.visible='1' AND T1.idtheme_rel= T2.idtheme AND T1.idutilisateur_rel='$idutilisateur';";
					$vtheme_favori_sql=requete_sql($vtheme_favori_sql);
					if (compte_sql($vtheme_favori_sql)>0)
					{
						while($vtheme_favori_temp=tableau_sql($vtheme_favori_sql)) 
						{
							?>
							<li>
								<? echo "<a href=\"#\" onclick=\"maj_module(".$vtheme_favori_temp["idtheme"].")\">".htmlentities($vtheme_favori_temp["titre"], ENT_QUOTES, "UTF-8")."</a>&nbsp;"; ?>
								<? echo "<span class=\"retirer\"  title=\""._RETIRER_THEME_DES_FAVORIS."\" onclick=\"retirer_theme_favori(".$vtheme_favori_temp["idtheme"].")\">[-]</span>\n"; ?>
							</li>
							<?
						}
					}
					else
					{
						echo "<li>"._AUCUN_THEME_FAVORI."</li>";
					}
					?>
				</ul>
			</div>
		</div>
	</div>
	<?
}
?>