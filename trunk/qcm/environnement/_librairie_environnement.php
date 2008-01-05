<?php
/*
 * Cree le 15 mai 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description :  fichier definissant les variables d environnement
 * 
 */

/*Fichier de configuration*/
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/conf.inc.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/conf.connection.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/_fonctions_sql.php');
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']).'/environnement/traduction.php');
//Chargement de la classe utilisateur:
require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF'])."/scripts/php/class.utilisateur.php");

/*Declaration des variables globales */
global $langue;
global $utilisateur_connecte;

/*Declaration des pages globales */
global $page_a_propos;
$page_a_propos="a_propos.php";
global $page_questionnaire;
$page_questionnaire="gestion_questionnaires.php";
global $page_question;
$page_question="gestion_questions.php";
global $page_choix;
$page_choix="gestion_choix.php";
global $page_theme;
$page_theme="gestion_themes.php";
global $page_administration;
$page_administration="administration.php";
global $page_affichage_questionnaire;
$page_affichage_questionnaire="affichage_questionnaire.php";

/*Gestion de la deconnection de session*/
if ((isset($_GET['deco']) && $_GET['deco']==1) || (isset($_POST['deco']) && $_POST['deco']==1))
{
	// Initialisation de la session.
	session_start();
	// Detruit toutes les variables de session
	session_unset();
	$_SESSION=array();
	// Finalement, d&eacute;truit la session
	session_destroy();
	// Redirection
	if (dirname($_SERVER['PHP_SELF'])!="")
	{
		header("Location: http://".$_SERVER['HTTP_HOST']
		.dirname($_SERVER['PHP_SELF'])
		."/index.php");
	}
	else
	{
		header("Location: http://".$_SERVER['HTTP_HOST']
		.dirname($_SERVER['PHP_SELF'])
		."index.php");	
	}
}

/*Gestion de la langue*/
session_start();

//Redirection si aucune langue :
if(!isset($langue)) 
{
	$langue=$_COOKIE['langue'];
	if($langue=="null" || $langue=="") 
	{
		$langue=$langue_par_defaut;
	}
	if (dirname($_SERVER['PHP_SELF'])!="")
	{
		header("Location: http://".$_SERVER['HTTP_HOST']
		.dirname($_SERVER['PHP_SELF'])
		."/index.php?langue="
		.$langue);
	}
	else
	{
		header("Location: http://".$_SERVER['HTTP_HOST']
		.dirname($_SERVER['PHP_SELF'])
		."index.php?langue="
		.$langue);
	}
	$_SESSION['langue']=$langue;
}
//Modification de la langue si post
if(isset($_POST['langue']) || isset($_GET['langue']))
{
	if(isset($_POST['langue'])) $langue=$_POST['langue'];
	if(isset($_GET['langue'])) $langue=$_GET['langue'];
	$_SESSION['langue']=$langue;
}
//Chargement du fichier de langue
fichier_langue();

/*Gestion de l'utilisateur*/
$utilisateur_connecte="";

if ((isset($_POST["compte"]) && isset($_POST["motdepasse"])) || isset($_SESSION['utilisateur'])) {
	if (isset($_POST["compte"]) && isset($_POST["motdepasse"]))
	{
		$utilisateur_connecte= new utilisateur($_POST["compte"],$_POST["motdepasse"]);
		//Si l'utilisateur est authentifie on le stocke dans la session :
		if ($utilisateur_connecte->_testauthentification==2) $_SESSION['utilisateur']=serialize($utilisateur_connecte);
	}
	else 
	{
		$utilisateur_connecte=unserialize($_SESSION['utilisateur']);
	}
}
global $idutilisateur;
$idutilisateur=$utilisateur_connecte->idutilisateur;
?>