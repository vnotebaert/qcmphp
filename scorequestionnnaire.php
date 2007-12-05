<?php
/*
 * Cree le 23 aout 2006
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : image png de l'arborescence des themes
 * 
 */
//chargement de la librairie commune :
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_librairie_environnement.php');
global $langue;

//creation d'une variable temporaire de classe theme :
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.theme.php');

$vtemp=new theme();

//calcul de la dimension de l'image:
$select_niveaumax="SELECT MAX(niveau) FROM ".$vtemp->table." WHERE visible=1 AND langue='$langue';";
$select_niveaumax=requete_sql($select_niveaumax);
$niveaumax=tableau_sql($select_niveaumax);
$niveaumax=$niveaumax[0];

$select_largueur="SELECT COUNT(*), SUM(IF(niveau=1,taille,0)) FROM ".$vtemp->table." WHERE visible=1 AND langue='$langue'";
$select_largueur=requete_sql($select_largueur);
$select_largueur=tableau_sql($select_largueur);
$nombretheme=$select_largueur[0];
$taille_niveau1=$select_largueur[1];

//initialisation des variables d adaptation du schema:
$hauteur=150;
$facteur_taille=30;

$largueur_img=$taille_niveau1*$facteur_taille+1;
$hauteur_img=$niveaumax*$hauteur+1;
if ($largueur_img<=0) { $largueur_img=10;}
if ($hauteur_img<=0) { $hauteur_img=10;}

//creation de l'image :
header ("Content-type: image/png");
$im = @imagecreatetruecolor ($largueur_img, $hauteur_img)
    or die ("Impossible d'initialiser la bibliothèque GD");
	
$couleur_fond = imagecolorallocate ($im, 255, 255, 255);
$couleur_texte = imagecolorallocate ($im, 0, 0, 0);
$couleur_contour = imagecolorallocate ($im, 0, 0, 0);
$couleur_rectangle=imagecolorallocate ($im, 240, 240, 240);

//application de la couleur de fond:
imagefill($im,0,0,$couleur_fond);

//tracage du schema de l'arborecence :
$select_themes="SELECT T1.*, IF(T1.taille<>1,COUNT(*),0) AS nbfils_arbo, SUM(T1.idtheme=T2.idtheme_rel) AS nbfils_direct
FROM ".$vtemp->table." AS T1 
LEFT JOIN ".$vtemp->table." AS T2 ON (T2.bornegauche>T1.bornegauche AND T2.bornegauche + T2.taille<T1.bornegauche + T1.taille AND T2.langue='$langue') 
WHERE T1.visible=1 AND (T2.visible=1 OR T2.visible IS NULL) AND T1.langue='$langue' 
GROUP BY T1.idtheme 
ORDER BY `T1`.`bornegauche` ASC";

$select_themes=requete_sql($select_themes);
while($vtheme=tableau_sql($select_themes))
{
	$x1=($vtheme['bornegauche']-1)*$facteur_taille;
	$y1=($vtheme['niveau']-1)*$hauteur;
	$x2=($vtheme['bornegauche']+$vtheme['taille']-1)*$facteur_taille;
	$y2=($vtheme['niveau'])*$hauteur;
	imagefilledrectangle($im, $x1, $y1, $x2, $y2, $couleur_rectangle);
	imagerectangle($im, $x1, $y1, $x2, $y2, $couleur_contour);
	if ($vtheme['nbfils_direct']>0)
	{
		$texte_fils=" " . $vtheme['nbfils_direct'] . "|" . $vtheme['nbfils_arbo'];
	}
	else 
	{
		$texte_fils="";
	}
	if(($x2-$x1)<($y2-$y1))
	{
		imagestringup($im, 4, ($x2+2*$x1)/3, $y1+$hauteur/2+strlen($vtheme['titre'])*4, $vtheme['titre']. $texte_fils , $couleur_texte);
	}
	else
	{
		imagestring($im, 4, ($x2+$x1)/2-strlen($vtheme['titre'])*4, $y1+$hauteur/2, $vtheme['titre']. $texte_fils, $couleur_texte);
	}
}
//nombre de themes :
$xposition=3;
$yposition=3;
imagestring($im, 5, $xposition, $yposition, _NB_THEMES.$nombretheme.$texte, $couleur_texte);

imagepng($im);
imagedestroy($im);
?>