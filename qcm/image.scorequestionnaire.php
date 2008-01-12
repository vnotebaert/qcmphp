<?php
/*
 * Cree le 23 aout 2006
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description : image png de l'arborescence des themes
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
global $langue;

$hauteur=100;
$largeur=200;
$facteur_taille_graph=3;

$largueur_img=$largeur*$facteur_taille_graph;
$hauteur_img=$hauteur*$facteur_taille_graph+50;
if ($largueur_img<=0) { $largueur_img=10;}
if ($hauteur_img<=0) { $hauteur_img=10;}

//creation de l'image :
header ("Content-type: image/png");
$im = @imagecreatetruecolor ($largueur_img, $hauteur_img)
    or die ("Impossible d'initialiser la bibliotheque GD");

//aucune mise en cache	
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             // Date du passe
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // toujours modifie
header("Cache-Control: no-cache, must-revalidate");           // HTTP/1.1
header("Pragma: no-cache");                                   // HTTP/1.0

//gestion des couleurs
$couleur_fond = imagecolorallocate ($im, 255, 255, 255);
$couleur_texte = imagecolorallocate ($im, 0, 0, 0);
$couleur_contour = imagecolorallocate ($im, 0, 0, 0);
$couleur_reponses_vrai=imagecolorallocate ($im, 0, 255, 0);
$couleur_reponses_fausse=imagecolorallocate ($im, 255, 0, 0);
$couleur_reponses_score_max=imagecolorallocate ($im, 0, 255, 255);
$couleur_reponses_score=imagecolorallocate ($im, 0, 0, 150);
//gestion de la police de caratere :
$vpolice_titre=3;
$vpolice=2;

//application de la couleur de fond:
imagefill($im,0,0,$couleur_fond);

//calcul du score sur le questionnaire
require_once($adresserepertoiresite.'/scripts/php/class.questionnaire.php');
$questionnaire = new questionnaire($_GET["i"]);
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
$vanglefaux=360*$rapport_total_sur_faux;
$vpctvrai=(1-$rapport_total_sur_faux);
$vpctvrai=$vpctvrai*100;

// French notation
$nombre_format_francais = number_format($vpctvrai, 2, ',', ' ');
$vtextepctvrai=$nombre_format_francais."%";
$vtextevrai=_REPONSES_VRAI.$score[2]."/".$score[0];

//calcul de l'angle de l'arc du score
if (($score[7]-$score[6])!=0)
{
	$rapport_score_ecart=($score[4]-$score[6])/($score[7]-$score[6]);
}
else
{
	$rapport_score_ecart=0;
}
$vanglescore=360*(1-$rapport_score_ecart);
$vpctscore=$rapport_score_ecart;
$vpctscore=$vpctscore*100;

// French notation
$nombre_format_francais_score = number_format($vpctscore, 2, ',', ' ');
$vtextepctscore=$nombre_format_francais_score."%";
$vtextescore=_SCORE.$score[4]."/".$score[7];
$vtextescoremin=_MIN.$score[6];

//creation de l'image du score :
imagestring ($im,$vpolice_titre,20*$facteur_taille_graph,10*$facteur_taille_graph,_SCORE_GRAPH_VRAI,$couleur_texte);
imagefilledellipse($im,50*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,$couleur_reponses_vrai);
imagefilledarc($im,50*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,0,$vanglefaux,$couleur_reponses_fausse,IMG_ARC_PIE);
imagestring ($im,$vpolice,25*$facteur_taille_graph,80*$facteur_taille_graph,$vtextepctvrai,$couleur_texte);
imagestring ($im,$vpolice,25*$facteur_taille_graph,80*$facteur_taille_graph+20,$vtextevrai,$couleur_texte);
imagestring ($im,$vpolice_titre,120*$facteur_taille_graph,10*$facteur_taille_graph,_SCORE_GRAPH_SCORE,$couleur_texte);
imagefilledellipse($im,135*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,$couleur_reponses_score_max);
imagefilledarc($im,135*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,50*$facteur_taille_graph,0,$vanglescore,$couleur_reponses_score,IMG_ARC_PIE);
imagestring ($im,$vpolice,120*$facteur_taille_graph,80*$facteur_taille_graph,$vtextepctscore,$couleur_texte);
imagestring ($im,$vpolice,120*$facteur_taille_graph,80*$facteur_taille_graph+20,$vtextescore,$couleur_texte);
imagestring ($im,$vpolice,120*$facteur_taille_graph,80*$facteur_taille_graph+40,$vtextescoremin,$couleur_texte);

imagepng($im);
imagedestroy($im);
?>