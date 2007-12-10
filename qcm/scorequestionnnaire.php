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

$hauteur=150;
$largeur=150;

$largueur_img=$largeur;
$hauteur_img=$hauteur;
if ($largueur_img<=0) { $largueur_img=10;}
if ($hauteur_img<=0) { $hauteur_img=10;}

//creation de l'image :
header ("Content-type: image/png");
$im = @imagecreatetruecolor ($largueur_img, $hauteur_img)
    or die ("Impossible d'initialiser la bibliothèque GD");
	
$couleur_fond = imagecolorallocate ($im, 255, 255, 255);
$couleur_texte = imagecolorallocate ($im, 0, 0, 0);
$couleur_contour = imagecolorallocate ($im, 0, 0, 0);
$couleur_reponses_vrai=imagecolorallocate ($im, 0, 255, 0);
$couleur_reponses_fausse=imagecolorallocate ($im, 255, 0, 0);

//application de la couleur de fond:
imagefill($im,0,0,$couleur_fond);

//calcul du score sur le questionnaire
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/scripts/php/class.questionnaire.php');
$questionnaire = new questionnaire(6);
$score=$questionnaire->score_qcm();

//calcul de l'angle de l'arc de reponse(s) fausse(s)
if($score[0]>0)
{
	$rapport_total_sur_faux=$score[3]/$score[0];
}
else
{
	$rapport_total_sur_faux=0;
}
$vangle=360*$rapport_total_sur_faux;

//creation de l'image du score :
imagefilledellipse($im,50,50,50,50,$couleur_reponses_vrai);
imagefilledarc($im,50,50,50,50,0,$vangle,$couleur_reponses_fausse,"curve");

imagepng($im);
imagedestroy($im);
?>