<?php
/*
 * Cree le 19 nov. 2005
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@caramail.com
 * Description : fichier de test incluant la generation de la sauvegarde zip de
 * l'environnement.
 * 
 */
//mode debug on=1 / off=0
$debug=0;

//Tailles de l'image
$largeur=1000;
$hauteur=680;
$pas=2;

//fonction stockant la regle de calcul
//regles de coloration:
function regles($i,$j) 
{
	switch ($i) {
	case 0:
		//N°0
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 1;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 1:
		//N°1
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 1;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 2:
		//N°2
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 1;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 3:
		//N°3
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 1;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 1;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 4:
		//N°4
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 5:
		//N°5
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 6:
		//N°6
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 0;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 1;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 7:
		//N°7
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 1;
	    break;
		}
	break;
	case 8:
		//N°8
		switch ($j) {
		case 0:
			return 1;
		break;
		case 1:
			return 0;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 9:
		//N°9
		switch ($j) {
		case 0:
			return 1;
		break;
		case 1:
			return 0;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 10:
		//N°10
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 11:
		//N°11
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 1;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 12:
		//N°12
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 13:
		//N°13
		switch ($j) {
		case 0:
			return 1;
		break;
		case 1:
			return 0;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	case 14:
		//N°14
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 1;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 1;
	    break;
		case 7:
			return 1;
	    break;
		}
	break;
	case 15:
		//N°15
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 0;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 1;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 0;
	    break;
		case 7:
			return 1;
	    break;
		}
	break;
	case 16:
		//N°16
		switch ($j) {
		case 0:
			return 0;
		break;
		case 1:
			return 1;
	    break;
		case 2:
			return 1;
	    break;
		case 3:
			return 0;
	    break;
		case 4:
			return 0;
	    break;
		case 5:
			return 0;
	    break;
		case 6:
			return 1;
	    break;
		case 7:
			return 0;
	    break;
		}
	break;
	}
	
} 

//creation de l'image
if ($debug==0) {
	header("Content-type: image/png");

	$im = @imagecreate ($largeur, $hauteur)
	    or die ("Impossible d'initialiser la bibliothèque GD");
	$background_color = imagecolorallocate ($im, 255, 255, 255);
	$couleur[0] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[1] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[2] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[3] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[4] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[5] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[6] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[7] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$couleur[8] = imagecolorallocate ($im, rand(0,255), rand(0,255), rand(0,255));
	$noir=imagecolorallocate ($im, 0, 0, 0);
}

if (!isset($_GET["dada"])) {
	$hasard=rand(0,16);
}
else {
	$hasard=intval($_GET["dada"]);
}
if ($debug==0) {
	$textcolor = imagecolorallocate($im, 0, 0, 0);
}
$valeur=array();
$nbcolor=rand(0,8);

for ($i = 0; $i <= $largeur; $i=$i+$pas) {
	for ($j = 0; $j <= $hauteur; $j=$j+$pas) {
		$a=rand(0,$nbcolor);
		$cool=$couleur[$a];
		if ($i==0) {
			if ($j==intval($hauteur/2)) {
				if ($debug==0) {
					imagefilledrectangle($im,$i,$j,$i+$pas,$j+$pas,$cool);
				}
				$valeur[$i][$j]=1;
			}
			else {
				$valeur[$i][$j]=0;
			}
		}
		else {
			$a=$valeur[$i-$pas][$j-$pas];
			$b=$valeur[$i-$pas][$j];
			$c=$valeur[$i-$pas][$j+$pas];
			$sum=intval($a+2*$b+4*$c);
			if ($debug==1) {
				echo "sum=$sum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$valeur[$i][$j]=regles($hasard,$sum);	
			if ($valeur[$i][$j]==1) {
				if ($debug==0) {
					imagefilledrectangle($im,$i,$j,$i+$pas,$j+$pas,$cool);
				}
			}
		}
		if ($debug==1) {
			//test du code
			$k=$i-$pas;
			$l=$j-$pas;
			$m=$j+$pas;
			if ($i==0) {
				echo ("i:".$i." j:".$j." valeur : ".$valeur[$i][$j]."<BR>");
			}
			else {
				echo ("i:".$i." j:".$j." valeur : ".$valeur[$i][$j]."&nbsp;&nbsp;=&nbsp;&nbsp;".$valeur[$i-$pas][$j-$pas]."(".$k.",".$l.")+".$valeur[$i-$pas][$j]."(".$k.",".$j.")*2+".$valeur[$i-$pas][$j+$pas]."(".$k.",".$m.")*4<BR>");
			}
		}
	}
}
// ajout de la phrase en haut à gauche
if ($debug==0) {
	imagestring($im, 5, 0, 0, "Les lois du hasard :", $textcolor);
	imagestring($im, 5, 15, 15, "-loi n°$hasard", $textcolor);
}
else {
	echo "Les lois du hasard :<BR>";
	echo "-loi n°$hasard<BR>";
}
if ($debug==0) {
	imagepng ($im);
	imagedestroy($im);
}
?>