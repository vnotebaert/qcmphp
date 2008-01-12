<?
// connection_sql
function connection_sql($host,$login,$password) {

//configuration de la connection
require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require($adresserepertoiresite.'/environnement/conf.inc.php');

$connect=mysql_connect($host,$login,$password);
return $connect;
} 
// connection_sql

// db_selection_sql
function db_selection_sql($base) {

//configuration de la connection
require_once('/conf.site.inc.php');
global $adresserepertoiresite;
global $adressehttpsite;
require($adresserepertoiresite.'/environnement/conf.inc.php');

return mysql_select_db($base);;
} 
// db_selection_sql
 
// requete_sql
function requete_sql($sql) {

	//configuration de la connection
	require_once('/conf.site.inc.php');
	global $adresserepertoiresite;
	global $adressehttpsite;
	require($adresserepertoiresite.'/environnement/conf.inc.php');
	require($adresserepertoiresite.'/environnement/conf.connection.php');
	global $connect;
	
	if (! $res=mysql_query($sql,$connect)) {
   		echo mysql_error();
   		echo "<br><a href=\"javascript:history.go(-1)\">BACK</a>";
   	}
   	return $res;
} 
 // requete_sql
 
// tableau_sql
function tableau_sql($reponse_sql) {

//renvoie du tableau equivalant
return mysql_fetch_array($reponse_sql);
} 
// tableau_sql

// compte_sql
function compte_sql($reponse_sql) {

//renvoie du nombre de ligne(s) dans la reponse sql
return mysql_num_rows($reponse_sql);
}
// compte_sql

// id_insere_sql()
function id_insere_sql() {

//renvoie de l'identifiant de la derniere ligne inseree :	
return mysql_insert_id();
}
?>