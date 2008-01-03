<?
$adresse=$_SERVER["DOCUMENT_ROOT"].dirname($_SERVER['PHP_SELF']);
if (strpos(dirname($_SERVER['PHP_SELF']),"/",1)!=false)
{
	$dir=substr(dirname($_SERVER['PHP_SELF']),0,strpos(dirname($_SERVER['PHP_SELF']),"/",1));
}
else
{
	$dir=dirname($_SERVER['PHP_SELF']);
}
echo "adresse : ".$adresse."<br />";
echo "dir : ".$dir."<br />";
?>