/* AUTEUR: MASSE */
/* DATE DE CREATION: 02/08/2001 */
/* MODIFICATION PAR MASSE 14/05/2004 : slogan devient une fonction avec pour parametre la langue*/
<!--
function aleatoire(min,max,arrondi){
var nombre=Math.random();
nombre = nombre*(max-min)+min;
if (arrondi==1) {nombre=Math.round(nombre);}
return nombre;
}

function slogan(lang)
{
var text;
slogan_text = new Array();
if (lang=="francais"){
slogan_text[0]="Seules les l&eacute;gendes ne meurent jamais.";
slogan_text[1]="Il faut savoir mourir pour entrer dans la l&eacute;gende.";
slogan_text[2]="Les plus long voyages sont ceux dont on ne revient jamais.";
slogan_text[3]="Ecrivez votre l&eacute;gende avant que le temps ne l'efface.";
slogan_text[4]="La gloire ou l'oubli sont au d&eacute;tour de ces chemins.";
slogan_text[5]="Tous les r&acirc;les de vos ennemis contre un souffle de victoire...";
slogan_text[6]="Pour sauver le monde, il faudra d'abord sauver votre peau.";
slogan_text[7]="L'Histoire se joue quand les h&eacute;ros entrent en sc&egrave;ne.";
slogan_text[8]="Vainnnn Diouuuu, si j'tatrappe t'va voir c'que t'vas prendre!!!!";
slogan_text[9]="Votre vie ne tient qu'&agrave; un fil, celui de votre &eacute;p&eacute;e.";
slogan_text[10]="Dans ce royaume, m&eacute;fiez vous de celui qui vous souhaite la bienvenue.";
slogan_text[11]="Le courage que l'on lit dans vos yeux portera-t-il plus loin que les fl&egrave;ches du destin?";
slogan_text[12]="Soyez le h&eacute;ros d'un monde sans lois...";
slogan_text[13]="Serez-vous plus r&eacute;sistant que la lame de votre adversaire?";
slogan_text[14]="L'avenir est un long pass&eacute;...";
slogan_text[15]="Je ne serais pas le h&eacute;ros d'un monde sans toi!";
slogan_text[16]="Devenez le fils du diable ou mourrez.";
slogan_text[17]="Ne croyez en rien surtout vous-même.";
}
else if (lang=="english"){
slogan_text[0]="Only legends never died.";
slogan_text[1]="You can trust noone even yourself.";
slogan_text[2]="Become devil's son or you will died.";
slogan_text[3]="All rails of your enemies against a breath of victory...";
}
else{
slogan_text[0]="Only legends never died.";
}

nombre = aleatoire(0,slogan_text.length-1,1);

text=slogan_text[nombre];

document.write(text);
}

// -->