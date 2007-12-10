<?php
/*
 * Created on 16 oct. 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
/*fichier_langue()*/
/*Fonction qui inclue dans le code php le fichier definissant les correspondances multi-langue*/
function fichier_langue() {
	global $langue;
	if (is_file($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF'])."/language/langue_".$langue.".php")) require_once($_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF'])."/language/langue_".$langue.".php");
}
/*fichier_langue()*/


/*langue_possible()*/
/*Fonction qui renvois les langues disponibles*/
function langue_possible() {
$langue_possible=array();
$Directory = "./language";
$MyDirectory = opendir($Directory);
while ($File = readdir($MyDirectory)) {
		if (is_file($Directory."/".$File) && substr($File,0,6)!="langue_"){
			$temp_langue=substr($File,7);
			$langue_possible[]=substr($temp_langue,0,-4);
		}
}
closedir($MyDirectory);
clearstatcache();
return $langue_possible;
}
/*langue_possible()*/
?>
