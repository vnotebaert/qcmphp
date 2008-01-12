<?php
/*
 * Cree le 21 decembre 2007
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  include d'un theme avec listing des themes fils, le nombre de questionnaires par theme et listing des questionnaires pour le theme selectionne
 *
 */
require_once('conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
if(!headers_sent())
{
	//chargement de la librairie commune :
	require_once($adresserepertoiresite.'/environnement/_librairie_environnement.php');
}

//chargement des definitions des classes utilisees
require_once($adresserepertoiresite.'/scripts/php/class.theme.php');
require_once($adresserepertoiresite.'/scripts/php/class.regle.php');

//intialisation des variables :
$vlien_theme_pere="";
$vpage_a_afficher="index.php";

// fonction de recurcivite sur la recherche du theme pere :
function lien_theme_pere($vtheme)
{
	$vlien_theme_pere="";
	if ($vtheme->idtheme_rel>0)
	{
		$vtheme_pere= new theme($vtheme->idtheme_rel);
		$nb=$vtheme_pere->nb_questionnaire();
		$vlien_theme_pere_temp="<a class=\"lien_ajax\" onclick=\"maj_module(".$vtheme_pere->identifiant.")\">".htmlentities($vtheme_pere->titre, ENT_QUOTES, "UTF-8")."</a>&nbsp;(<span class=\"nb_direct\" title=\""._NB_QUESTIONNAIRES_DIRECT."\">".$nb[1]."</span>"._THEME_SEPARATEUR_NB_QUESTIONNAIRE_DIRECT_ARBO."<span class=\"nb_arbo\"  title=\""._NB_QUESTIONNAIRES_ARBO."\">".$nb[0]."</span>)&nbsp;> ";
		$vlien_theme_pere=lien_theme_pere($vtheme_pere).$vlien_theme_pere_temp;
	}
	return $vlien_theme_pere;
}


//chargement du theme selectionne :
if (isset($_GET["t"]))
{
	$vtheme= new theme($_GET["t"]);
	$vliste="";
	$vlien_theme_pere=lien_theme_pere($vtheme);
	foreach($vtheme->liste_fils as $vthemefils)
	{
		$vthemefils_objet= new theme($vthemefils["idtheme"]);
		$nb=$vthemefils_objet->nb_questionnaire();
		$vliste.="<li><a class=\"lien_ajax\" onclick=\"maj_module(".$vthemefils["idtheme"].")\">".htmlentities($vthemefils["titre"], ENT_QUOTES, "UTF-8")."</a>&nbsp;(<span class=\"nb_direct\" title=\""._NB_QUESTIONNAIRES_DIRECT."\">".$nb[1]."</span>"._THEME_SEPARATEUR_NB_QUESTIONNAIRE_DIRECT_ARBO."<span class=\"nb_arbo\"  title=\""._NB_QUESTIONNAIRES_ARBO."\">".$nb[0]."</span>)&nbsp;</li>\n";
	}
}
else
{
	$vtheme= new theme();
	$i=0;
	$vliste="";
	$vtheme_temp="";
	$vlongueur_separateur=strlen(_THEME_FILS_SEPARATEUR_LISTE);
	$vlongueur_separateur=-1*$vlongueur_separateur;

	$vtheme_niv_1_sql="SELECT idtheme FROM $vtheme->table WHERE niveau=1 AND visible='1' AND langue='$langue';";
	$vtheme_niv_1_sql=requete_sql($vtheme_niv_1_sql);
	while($vthemeid_temp=tableau_sql($vtheme_niv_1_sql)) 
	{
		$vtheme_temp[$i]=new theme($vthemeid_temp[0]);
		$vliste[$i]="";
		foreach($vtheme_temp[$i]->liste_fils as $vthemefils_temp)
		{
			$vthemefils_objet= new theme($vthemefils_temp["idtheme"]);
			$nb=$vthemefils_objet->nb_questionnaire();
			$vliste[$i].="<li><a class=\"lien_ajax\" onclick=\"maj_module(".$vthemefils_temp["idtheme"].")\">".htmlentities($vthemefils_temp["titre"], ENT_QUOTES, "UTF-8")."</a>&nbsp;(<span class=\"nb_direct\" title=\""._NB_QUESTIONNAIRES_DIRECT."\">".$nb[1]."</span>"._THEME_SEPARATEUR_NB_QUESTIONNAIRE_DIRECT_ARBO."<span class=\"nb_arbo\"  title=\""._NB_QUESTIONNAIRES_ARBO."\">".$nb[0]."</span>)&nbsp;</li>\n";
		}
		$i++;
	}
}

$activation_AJAX= new regle("0","Activation_AJAX");
if ($activation_AJAX->valeur=="1")
{
?>
	<script type="text/javascript" src="./scripts/javascript/prototype.js" charset="utf-8"></script>
	<div id="ajax_wait" style="visibility:hidden"></div>
<?
}
?>
<script type="text/javascript">
<!--  chargement AJAX ou POST de la liste des themes
	function maj_module(vt)
	{
		<?
		if ($activation_AJAX->valeur=="1")
		{
			?>
			new Ajax.Updater('module', 'include.theme_liste.php?t='+vt+'&tt='+vt, 
			{ 
				method: 'get',
				contentType : 'text/html',
				encoding: 'UTF-8', 
				onLoading: function() {
					//things to do at the start
					document.getElementById('ajax_wait').style.visibility = "visible";
				},
				onSuccess: function(transport) {
					//things to do when everything goes well
					document.getElementById('ajax_wait').style.visibility = "hidden";
				}
			});
			<?
		}
		else
		{
			?>
			document.getElementById('theme_list_form').t.value=vt;
			document.getElementById('theme_list_form').tt.value=vt;
			document.getElementById('theme_list_form').submit();
			<?
		}
		?>
	}
-->	
<!--  ajout d'un theme favori
	function ajout_theme_favori(vt)
	{
		document.getElementById('theme_list_form').ajout.value='1';
		document.getElementById('theme_list_form').tt.value=vt;
		document.getElementById('theme_list_form').submit();
	}
-->
<!--  suppression d'un theme favori
	function retirer_theme_favori(vt)
	{
		document.getElementById('theme_list_form').ajout.value='2';
		document.getElementById('theme_list_form').tt.value=vt;
		document.getElementById('theme_list_form').submit();
	}
-->
</script>
<div id="theme_liste_selection">
	<div id="theme_liste_cadre">
		<h3><span><? echo _THEME_LISTE_TITRE; ?></span></h3>
		<div id="theme_liste_element">
			<form action="<? echo $vpage_a_afficher;?>" method="get" id="theme_list_form">
				<?
				if (isset($_GET["t"]))
				{
					$nb=$vtheme->nb_questionnaire();
					echo "<h4><span>".$vlien_theme_pere.htmlentities($vtheme->titre, ENT_QUOTES, "UTF-8")."&nbsp;(<span class=\"nb_direct\" title=\""._NB_QUESTIONNAIRES_DIRECT."\">".$nb[1]."</span>"._THEME_SEPARATEUR_NB_QUESTIONNAIRE_DIRECT_ARBO."<span class=\"nb_arbo\"  title=\""._NB_QUESTIONNAIRES_ARBO."\">".$nb[0]."</span>)</span></h4>\n";
					?>
					<?
					echo "<div id=\"theme_desc\"><span>".$vtheme->intitule."</span></div>\n";
					
					include("include.ajouter.theme_favori.php");
					
					if (strlen($vliste)>0)
					{
						echo "<ul>".$vliste."</ul>\n";
					}
					$vtheme->liste_questionnaires();
				}
				else
				{
					echo "<div id=\"theme_list_element_introduction\">"._THEME_LISTE_INTRODUCTION."</div>\n";
					$j=0;
					if (is_array($vtheme_temp) && count($vtheme_temp)>0)
					{
						foreach ($vtheme_temp as $vtemp)
						{
						$nb=$vtemp->nb_questionnaire();
						echo "<h4><span>".htmlentities($vtemp->titre, ENT_QUOTES, "UTF-8")."&nbsp;(<span class=\"nb_direct\" title=\""._NB_QUESTIONNAIRES_DIRECT."\">".$nb[1]."</span>"._THEME_SEPARATEUR_NB_QUESTIONNAIRE_DIRECT_ARBO."<span class=\"nb_arbo\"  title=\""._NB_QUESTIONNAIRES_ARBO."\">".$nb[0]."</span>)</span></h4>\n";
						?>
						<?
						echo "<div id=\"theme_desc\"><p><span>".$vtemp->intitule."</span></p></div>\n";
						?>
						<?
						if (strlen($vliste[$j])>0)
						{
							echo "<ul>".$vliste[$j]."</ul>\n";
						}
						$j++;
						}
						$vtemp->liste_questionnaires();
					}
				}
				?>
				<!--  on groupe les input hidden dans un cadre div pour passer la certification x-HTML -->
				<div style="display:none">><input type="hidden" value="<? echo $_GET["t"]; ?>" name="t" />
				<input type="hidden" value="0" name="tt" />
				<input type="hidden" value="0" name="ajout" /></div>
			</form>
		</div>
	</div>
</div>
<?
?>