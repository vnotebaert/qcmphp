<?php
/* 
 * Cree le 16 oct. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  Fichier contenant les definitions des constantes de langue
 * francaise pour QCM
 * 
 */


 
//	Toute page		//
define (_BOUTON_OK,"OK");
define (_BOUTON_RESET,"Cancel");
define (__META_KEYWORDS,"QCM,questionnaire");
define (_META_DESCRIPTION,"Questionnaire &agrave; choix multiple ou examen en ligne, tout est possible avec QCM_PHP");
define (_LANGUE_SELECTION,"Choose your language");
define (_ABREVIATION_LANGUE,"en");

// page index //
define (_TITRE_ENTETE,"<acronym title=\"Question &agrave; Choix Multiples\">QCM en anglais</acronym>");
define (_SOUS_TITRE_ENTETE,"<acronym title=\"Question &agrave; Choix Multiples\">QCM</acronym> testez vos connaissances");
define (_RESUME_PRINCIPAL,"<acronym title=\"Question &agrave; Choix Multiples\">QCM</acronym> est un outil pour cr&eacute;er des questionnaires disponibles sur le net, pour tester ses connaissances ou r&eacute;aliser des examens en ligne.");
define (_TITRE_PREAMBULE,"Pr&eacute;ambule");
define (_TEXTE_PREAMBULE,"Questionnaire &agrave; choix multiples ou examen en ligne, tout est possible avec <acronym title=\"Question &agrave; Choix Multiples et Hypertext Preprocessor.\">QCM_PHP</acronym>.");
define (_TITRE_PRINCIPAL,"<acronym title=\"Question &agrave; Choix Multiples\">QCM</acronym>");
define (_TITRE_PARTICIPATION,"Participation");
define (_TEXTE_PARTICIPATION,"<acronym title=\"Question &agrave; Choix Multiples et Hypertext Preprocessor.\">QCM_PHP</acronym> est librement adaptable. Il est d&eacute;velopp&eacute; sous licence logiciel libre. Il est accessible sour Sourceforge.com dans le r&eacute;pertoire <acronym title=\"Question &agrave; Choix Multiples\">QCM</acronym> du projet WorldRPG.");
define (_FONCTION_SELECTION,"Fonctionnalit&eacute;s");
define (_STATISTIQUE_SELECTION,"Statistiques");
define (_CONNEXION_AUTOMATIQUE,"Remember Me?");

// cadre question //
define (_BONNE_REPONSE,"Right answer.</br>");
define (_MAUVAISE_REPONSE,"Wrong answer.</br>");
define (_VOUS_AVEZ_REPONDU,"Your answer is: ");
define (_SOLUTION,"Solution : ");
define (_SOLUTION_MOT,"Solution : ");
define (_SOLUTION_TEXTE,"Short answer : ");

// zip //
define (_COMPRESSION_EN_COURS,"Compression en cours.");
define (_CLIQUEZ_ICI_POUR_TELECHARGER_LE_FICHIER,"Cliquez ici pour t&eacute;l&eacute;charger le fichier ");

//traduction des champs et classes:
global $trad_SQL;
$trad_SQL= array();
$trad_SQL["langue"]="Language";
$trad_SQL["titre"]=_TITRE;
$trad_SQL["intitule"]=_INTITULE;
$trad_SQL["ordre"]=_ORDRE;
$trad_SQL["theme"]="Subject";
$trad_SQL["question"]="Question";
$trad_SQL["type"]="Type";
$trad_SQL["idtheme_rel"]="Subject father";
$trad_SQL["solution"]="Solution text";
$trad_SQL["valeur"]="Point number corresponding to this answer";
$trad_SQL["vraifaux"]="R&eacute;ponse vrai (1) ou fausse (0)";
$trad_SQL["tempsminimum"]="Temps minimum pour r&eacute;pondre avant de diminuer la note maximum";
$trad_SQL["tempsmaximum"]="Temps maximum pour r&eacute;pondre avant d'obtenir la note minimum";
?>