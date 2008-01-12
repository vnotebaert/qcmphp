<?php
/*
 * Created on 15 mai 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

//chargement de la configuration
require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require_once($adresserepertoiresite."/environnement/conf.inc.php");
require_once($adresserepertoiresite."/environnement/_fonctions_sql.php");

// connection a la base
global $connect;
$connect=connection_sql($host,$login,$basepassword);
db_selection_sql($base);
?>
