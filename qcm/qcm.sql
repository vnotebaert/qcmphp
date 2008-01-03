Base de données qcm sur le serveur localhost
# phpMyAdmin MySQL-Dump
# version 2.2.6
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Serveur: localhost
# Généré le : Mardi 01 Janvier 2008 à 18:44
# Version du serveur: 3.23.49
# Version de PHP: 4.2.0
# Base de données: `qcm`
# --------------------------------------------------------

#
# Structure de la table `qcm_auteur`
#

DROP TABLE IF EXISTS `qcm_auteur`;
CREATE TABLE `qcm_auteur` (
  `idauteur` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `idutilisateur_rel` bigint(20) unsigned NOT NULL default '0',
  `idtheme_rel` bigint(20) unsigned NOT NULL default '0',
  `datecreation` int(11) NOT NULL default '0',
  `validation` enum('0','1') NOT NULL default '0',
  `idutilisateur_validateur_rel` bigint(20) unsigned NOT NULL default '0',
  `datevalidation` int(11) NOT NULL default '0',
  `correcteur` enum('0','1') NOT NULL default '0',
  `dateaccordcorrecteur` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idauteur`),
  KEY `idutilisateur_rel` (`idutilisateur_rel`),
  KEY `idtheme_rel` (`idtheme_rel`),
  KEY `idutilisateur_validateur_rel` (`idutilisateur_validateur_rel`)
) TYPE=MyISAM COMMENT='auteur/correcteur par theme et attribue par merite ou libre.';

#
# Contenu de la table `qcm_auteur`
#

INSERT INTO `qcm_auteur` (`idauteur`, `visible`, `idutilisateur_rel`, `idtheme_rel`, `datecreation`, `validation`, `idutilisateur_validateur_rel`, `datevalidation`, `correcteur`, `dateaccordcorrecteur`) VALUES (1, '1', 23, 16, 0, '1', 6, 0, '0', 0);
# --------------------------------------------------------

#
# Structure de la table `qcm_choix`
#

DROP TABLE IF EXISTS `qcm_choix`;
CREATE TABLE `qcm_choix` (
  `idchoix` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `idquestion_rel` bigint(20) unsigned NOT NULL default '0',
  `titre` varchar(100) NOT NULL default '',
  `intitule` text NOT NULL,
  `vraifaux` enum('0','1') NOT NULL default '0',
  `valeur` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`idchoix`),
  KEY `idquestion_rel` (`idquestion_rel`)
) TYPE=MyISAM;

#
# Contenu de la table `qcm_choix`
#

INSERT INTO `qcm_choix` (`idchoix`, `visible`, `idquestion_rel`, `titre`, `intitule`, `vraifaux`, `valeur`) VALUES (9, '1', 15, '', 'Monstrueux Sux', '0', 0),
(10, '1', 15, '', 'Massa Susetes', '0', -5),
(11, '1', 15, '', 'Mitraillette Super-puissante', '0', -4),
(12, '1', 15, '', 'Moule Shot', '1', 5),
(13, '1', 16, '', 'Un niveau de jeu', '0', -5),
(14, '1', 16, '', 'Une arme des terroristes', '0', 0),
(15, '1', 16, '', 'Une arme des contre-terroristes', '1', 5),
(16, '1', 16, '', 'Une grenade Flash-bang', '0', 0),
(17, '1', 17, '', 'World Agonie', '0', -20),
(18, '1', 17, '', 'Warrior Ancestral', '0', -2),
(19, '1', 17, '', 'War Arranger', '1', 10),
(20, '1', 17, '', 'War Amateur', '0', 0),
(21, '1', 19, '', 'Un restart', '1', 3),
(22, '1', 19, '', 'Un Redémarrage du Serveur', '0', -1),
(23, '1', 19, '', 'Un Restore Spin', '0', -5),
(24, '1', 19, '', 'Un Restore Skill', '0', -2),
(25, '1', 19, '', 'Un Restart Spawn', '0', 0),
(26, '1', 19, '', 'Un Refresh Skin', '0', -5),
(27, '1', 20, '', 'Un Gros Bill', '0', 0),
(28, '1', 20, '', 'Un personnage très puissant', '0', -1),
(29, '1', 20, '', 'Un sort augmentant les capacités des personnages', '1', 5),
(30, '1', 20, '', 'Background United Favorite Filters', '0', -20),
(31, '1', 20, '', 'Un animal à cornes qui aime brouter de l\'herbe', '0', -128),
(32, '1', 18, '', 'Un Petit Gars Moulu', '0', -5),
(33, '1', 18, '', 'Un Progamer', '1', 10),
(34, '1', 18, '', 'Une Partie GagnÃ©e Merdique', '0', -3),
(35, '1', 21, '', 'Kajima', '0', -1),
(36, '1', 21, '', 'Jabuki', '0', -1),
(37, '1', 21, '', 'Mugiwara', '1', 2),
(38, '1', 21, '', 'Kaizoku', '0', -1),
(39, '1', 23, '', 'East blue', '0', -1),
(40, '1', 23, '', 'West blue', '0', -1),
(41, '1', 23, '', 'North blue', '0', -1),
(42, '1', 23, '', 'All blue', '1', 2),
(43, '1', 23, '', 'None blue', '0', -1),
(44, '1', 24, '', 'De l\'essence', '0', -1),
(45, '1', 24, '', 'De l\'huile', '0', -1),
(46, '1', 24, '', 'Du cola', '1', 2),
(47, '1', 24, '', 'Du jus de fruit', '0', -1),
(48, '1', 25, '', 'Magnet', '0', -1),
(49, '1', 25, '', 'Log pose', '1', 2),
(50, '1', 25, '', 'Den Den mushi', '0', -1),
(51, '1', 25, '', 'Dials', '0', -1),
(52, '1', 22, '', 'East blue', '0', -1),
(53, '1', 22, '', 'North Blue', '0', -1),
(54, '1', 22, '', 'None Blue', '0', -1),
(55, '1', 22, '', 'All blue', '1', 2);
# --------------------------------------------------------

#
# Structure de la table `qcm_equipe`
#

DROP TABLE IF EXISTS `qcm_equipe`;
CREATE TABLE `qcm_equipe` (
  `idequipe` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `titre` varchar(100) NOT NULL default '',
  `intitule` text NOT NULL,
  `idutilisateur_resp_rel` bigint(20) unsigned NOT NULL default '0',
  `datecreation` int(11) NOT NULL default '0',
  PRIMARY KEY  (`idequipe`),
  KEY `idutilisateur_resp_rel` (`idutilisateur_resp_rel`)
) TYPE=MyISAM;

#
# Contenu de la table `qcm_equipe`
#

# --------------------------------------------------------

#
# Structure de la table `qcm_question`
#

DROP TABLE IF EXISTS `qcm_question`;
CREATE TABLE `qcm_question` (
  `idquestion` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `idquestionnaire_rel` bigint(20) NOT NULL default '0',
  `ordre` tinyint(4) NOT NULL default '0',
  `titre` varchar(100) NOT NULL default '',
  `intitule` text NOT NULL,
  `solution` text NOT NULL,
  `type` enum('choix_unique','choix_unique_liste','choix_multiple','choix_multiple_liste','choix_mot','choix_texte') NOT NULL default 'choix_unique',
  `niveau` tinyint(4) NOT NULL default '0',
  `idutilisateur_auteur_rel` bigint(20) unsigned NOT NULL default '0',
  `validation` enum('0','1') NOT NULL default '0',
  `idutilisateur_validateur_rel` bigint(20) unsigned NOT NULL default '0',
  `datecreation` int(11) NOT NULL default '0',
  `datevalidation` int(11) NOT NULL default '0',
  `textevalidation` text NOT NULL,
  PRIMARY KEY  (`idquestion`),
  KEY `idutilisateur_validateur_rel` (`idutilisateur_validateur_rel`),
  KEY `idutilisateur_auteur_rel` (`idutilisateur_auteur_rel`),
  KEY `idquestionnaire_rel` (`idquestionnaire_rel`),
  KEY `ordre` (`ordre`)
) TYPE=MyISAM;

#
# Contenu de la table `qcm_question`
#

INSERT INTO `qcm_question` (`idquestion`, `visible`, `idquestionnaire_rel`, `ordre`, `titre`, `intitule`, `solution`, `type`, `niveau`, `idutilisateur_auteur_rel`, `validation`, `idutilisateur_validateur_rel`, `datecreation`, `datevalidation`, `textevalidation`) VALUES (15, '1', 6, 1, 'FPS', 'Que veut dire <strong>MS</strong> dans les <strong>FPS</strong>?', 'Moule Shot.', 'choix_unique', 0, 21, '1', 6, 1140472579, 1195855540, 'Ok'),
(16, '1', 6, 2, 'FPS', 'Dans <strong>Counter-Strike</strong> qu\'est-ce qu\'une <strong>4.3</strong>? ', 'Le <strong>M4a1</strong>, une arme des contre-terroristes de la catégorie des fusils d\'assault. ', 'choix_unique', 0, 21, '1', 6, 1140473157, 1195855540, 'Ok'),
(17, '1', 6, 3, 'FPS', 'Qu\'est qu\'un <strong>WA</strong> dans une Ã©quipe de jeu en rÃ©seau?', 'Un War Arranger :<br />\r\nPersonne chargÃ©e d\'organiser les matchs avec les autres Ã©quipes.', 'choix_unique', 0, 21, '1', 6, 1140473495, 1195855540, 'Ok'),
(18, '1', 6, 5, 'GÃ©nÃ©ral', 'Qu\'est-ce qu\'un ou une <strong>PGM</strong>?', 'Un Pro-Gamer\r\n\r\n  <ol> \r\n    <li> Joueur professionnel</li> \r\n    <li> Joueur qui joue pour gagner et qui se vante de son niveau</li> \r\n  </ol>', 'choix_unique', 0, 21, '1', 6, 1140474194, 1195855540, 'Ok'),
(19, '1', 6, 4, 'FPS', 'Au cours d\'un match, qu\'est-ce qu\'un <strong>RS</strong>? ', 'Un restart.\r\n<p>Un redémarrage du la partie avec mise à zéro des scores et du temps de jeu.</p>\r\n<p>Il est effectué avant le début de tout match afin de l\'initialiser.</p>', 'choix_unique', 0, 21, '1', 6, 1140474415, 1195855540, 'Ok'),
(20, '1', 6, 6, 'MMORPG', 'Qu\'est qu\'un <strong>BUFF</strong>? ', 'Un sort augmentant les capacités du ou des personnages pendant un certain temps.', 'choix_unique', 0, 21, '1', 6, 1140475659, 1195855540, 'Ok'),
(21, '1', 7, 0, 'Personnages', 'Comment s\'appelle <strong>chapeau de paille</strong> en japonais ?', 'Traduction litterale du mot en japonais : <strong>Mugiwara</strong>.', 'choix_unique', 0, 21, '1', 21, 1195910734, 1195912672, ''),
(22, '1', 7, 1, 'Univers', 'Quelle est la mer recherchÃ©e par <strong>Sanji </strong>?', '', 'choix_unique', 0, 21, '1', 21, 1195911147, 1195912672, ''),
(23, '0', 7, 1, 'Univers', 'Quelle est la mer recherchée par Sanji ?', '', 'choix_unique', 0, 21, '1', 21, 1195911152, 1195912672, ''),
(24, '1', 7, 3, 'Personnages', 'Que met <strong>F<span style="color: #5200ff;">r</span><span style="color: #ff0000;">a</span><span style="color: #00ff54;">n</span><span style="color: #ffff00; background-color: #5200ff;">c</span><span style="color: #3dfffe; background-color: #ac10ff;">k</span><span style="color: #ffaa00; background-color: #009632;">y</span></strong> dans son abdomen pour lui donner des forces ?', 'Seul le <strong>cola</strong> lui convient car c\'est la seule boisson Ã  lui donner <font color="#3d3fff" style="background-color: #74ff2e;"><font color="#ffff3d">une at</font><font color="#ff0000">titude </font><font color="#3d3fff">Funky<font style="background-color: #74ff2e;"> </font></font></font><font color="#3d3fff" style="background-color: #74ff2e;">!</font>', 'choix_unique', 0, 21, '1', 6, 1195911538, 1197106279, 'faut bien que je sois d&#039;accord...'),
(25, '1', 7, 2, 'Univers', 'Comment s\'appelle <strong>la boussole</strong> qui permet de se repÃ©rer sur la route de tous les pÃ©rils?', 'Les <strong>log poses</strong> sont utilisÃ©s par les navigateurs pour se diriger d\'Ã®le en Ã®le. Les log poses pointent toujours sur une seule et mÃªme Ã®le Ã  la fois jusqu\'Ã  ce que la personne utilsant ce log pose y arrive. Alors le log pose se recharge pour pointer vers la prochaine Ã®le.', 'choix_unique', 0, 21, '1', 21, 1195912027, 1195912672, '');
# --------------------------------------------------------

#
# Structure de la table `qcm_questionnaire`
#

DROP TABLE IF EXISTS `qcm_questionnaire`;
CREATE TABLE `qcm_questionnaire` (
  `idquestionnaire` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `idtheme_rel` bigint(20) unsigned NOT NULL default '0',
  `titre` varchar(100) NOT NULL default '',
  `intitule` text NOT NULL,
  `tempsminimum` int(10) unsigned NOT NULL default '120',
  `tempsmaximum` int(10) unsigned NOT NULL default '600',
  `niveau` tinyint(4) NOT NULL default '0',
  `idutilisateur_auteur_rel` bigint(20) unsigned NOT NULL default '0',
  `validation` enum('0','1') NOT NULL default '0',
  `idutilisateur_validateur_rel` bigint(20) unsigned NOT NULL default '0',
  `datecreation` int(11) NOT NULL default '0',
  `datevalidation` int(11) NOT NULL default '0',
  `textevalidation` text NOT NULL,
  PRIMARY KEY  (`idquestionnaire`),
  KEY `idtheme_rel` (`idtheme_rel`),
  KEY `idutilisateur_validateur_rel` (`idutilisateur_validateur_rel`),
  KEY `idutilisateur_auteur_rel` (`idutilisateur_auteur_rel`)
) TYPE=MyISAM;

#
# Contenu de la table `qcm_questionnaire`
#

INSERT INTO `qcm_questionnaire` (`idquestionnaire`, `visible`, `idtheme_rel`, `titre`, `intitule`, `tempsminimum`, `tempsmaximum`, `niveau`, `idutilisateur_auteur_rel`, `validation`, `idutilisateur_validateur_rel`, `datecreation`, `datevalidation`, `textevalidation`) VALUES (6, '1', 3, 'Language de jeux video', '<p>Comprenez vous ou parlez vous courement le language des joueurs des salles en rÃ©seau?</p> \r\n  <p>Ils jouent aux <strong>FPS</strong> et aux <strong>MMORPG</strong>, mais qu\'est-ce donc?</p>', 120, 600, 0, 21, '1', 6, 1140472174, 1195855540, 'Ok'),
(7, '1', 25, 'One Piece', 'Le questionnaire sur le fameux Manga de EiichirÅ Oda, retraÃ§ant l\'aventure du pirate <strong>Luffy au Chapeau de paille </strong>et de ses compagnons.', 10, 30, 0, 21, '1', 21, 1195910326, 1195912672, '');
# --------------------------------------------------------

#
# Structure de la table `qcm_reponse`
#

DROP TABLE IF EXISTS `qcm_reponse`;
CREATE TABLE `qcm_reponse` (
  `idreponse` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `idutilisateur_rel` bigint(20) unsigned NOT NULL default '0',
  `idchoix_rel` bigint(20) unsigned NOT NULL default '0',
  `datereponse` int(11) NOT NULL default '0',
  `mot` varchar(255) NOT NULL default '',
  `texte` longtext NOT NULL,
  `idutilisateur_correcteur_rel` bigint(20) unsigned NOT NULL default '0',
  `datecorrection` int(11) NOT NULL default '0',
  `textecorrection` longtext NOT NULL,
  `idquestion_rel` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`idreponse`),
  KEY `idutilisateur_rel` (`idutilisateur_rel`),
  KEY `idchoix_rel` (`idchoix_rel`),
  KEY `idutilisateur_correcteur_rel` (`idutilisateur_correcteur_rel`),
  KEY `idquestion_rel` (`idquestion_rel`)
) TYPE=MyISAM;

#
# Contenu de la table `qcm_reponse`
#

INSERT INTO `qcm_reponse` (`idreponse`, `visible`, `idutilisateur_rel`, `idchoix_rel`, `datereponse`, `mot`, `texte`, `idutilisateur_correcteur_rel`, `datecorrection`, `textecorrection`, `idquestion_rel`) VALUES (1, '1', 6, 12, 1198839758, '', '', 0, 0, '', 15),
(2, '1', 6, 19, 1198839768, '', '', 0, 0, '', 17),
(3, '1', 6, 15, 1198839776, '', '', 0, 0, '', 16),
(4, '1', 6, 21, 1198839795, '', '', 0, 0, '', 19),
(5, '1', 6, 34, 1198839804, '', '', 0, 0, '', 18),
(6, '1', 6, 29, 1198839810, '', '', 0, 0, '', 20),
(7, '1', 6, 37, 1198936951, '', '', 0, 0, '', 21),
(8, '1', 23, 37, 1198950985, '', '', 0, 0, '', 21),
(9, '1', 23, 55, 1198951001, '', '', 0, 0, '', 22),
(10, '1', 23, 49, 1198951010, '', '', 0, 0, '', 25),
(11, '1', 23, 46, 1198951020, '', '', 0, 0, '', 24),
(12, '1', 6, 55, 1199012462, '', '', 0, 0, '', 22),
(13, '1', 6, 49, 1199030204, '', '', 0, 0, '', 25),
(14, '1', 6, 46, 1199030214, '', '', 0, 0, '', 24);
# --------------------------------------------------------

#
# Structure de la table `qcm_theme`
#

DROP TABLE IF EXISTS `qcm_theme`;
CREATE TABLE `qcm_theme` (
  `idtheme` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `titre` varchar(100) NOT NULL default '',
  `intitule` text NOT NULL,
  `idtheme_rel` bigint(20) unsigned NOT NULL default '0',
  `niveau` int(11) NOT NULL default '0',
  `taille` int(11) NOT NULL default '1',
  `bornegauche` int(11) NOT NULL default '1',
  `langue` varchar(4) NOT NULL default 'fr',
  PRIMARY KEY  (`idtheme`),
  KEY `idtheme_rel` (`idtheme_rel`),
  KEY `bornegauche` (`bornegauche`),
  KEY `niveau` (`niveau`),
  KEY `langue` (`langue`)
) TYPE=MyISAM COMMENT='arborescence des themes';

#
# Contenu de la table `qcm_theme`
#

INSERT INTO `qcm_theme` (`idtheme`, `visible`, `titre`, `intitule`, `idtheme_rel`, `niveau`, `taille`, `bornegauche`, `langue`) VALUES (1, '1', 'Classement des thÃ¨mes', '', 0, 1, 75, 1, 'fr'),
(2, '1', 'Sciences humaines et sociales', '<p><a href="http://fr.wikipedia.org/wiki/Image:Sciences_humaines.svg" class="image" title="Catï¿½gorie:Sciences humaines"><img width="55" height="55" border="0" align="left" alt="Catï¿½gorie:Sciences humaines" src="http://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Sciences_humaines.svg/55px-Sciences_humaines.svg.png" /></a>Les <a href="http://fr.wikipedia.org/wiki/Sciences_humaines" title="Sciences humaines">sciences humaines</a>\r\nregroupent toutes les disciplines qui touchent la culture de l\'Ãªtre\r\nhumain et toutes ses rÃ©alisations. De maniÃ¨re gÃ©nÃ©rale, 10 disciplines\r\nforment le point central des <a href="http://fr.wikipedia.org/wiki/Sciences_humaines" title="Sciences humaines">sciences humaines</a>:</p> \r\n  <ul> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Administration" title="Administration">Administration</a> ou <a href="http://fr.wikipedia.org/wiki/Science_administrative" title="Science administrative">Science administrative</a>,</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Anthropologie" title="Anthropologie">Anthropologie</a>,</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Arch%C3%A9ologie" title="ArchÃ©ologie">ArchÃ©ologie</a> ou <a href="http://fr.wikipedia.org/wiki/Civilisations_anciennes" title="Civilisations anciennes">Civilisations anciennes</a>,</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Sciences_%C3%A9conomiques" title="Sciences Ã©conomiques">Sciences Ã©conomiques</a> (= Ã‰conomie)</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/G%C3%A9ographie" title="GÃ©ographie">GÃ©ographie</a>,</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Histoire" title="Histoire">Histoire</a>,</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Psychologie" title="Psychologie">Psychologie</a> ou <a href="http://fr.wikipedia.org/wiki/Ergonomie" title="Ergonomie">Ergonomie</a></li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Sciences_de_la_religion" title="Sciences de la religion">Sciences de la religion</a>,</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Science_politique" title="Science politique">Science politique</a>,</li> \r\n    <li><a href="http://fr.wikipedia.org/wiki/Sociologie" title="Sociologie">Sociologie</a>.</li> \r\n  </ul> \r\n  <p>&nbsp;</p> \r\n  <p>Les <a href="http://fr.wikipedia.org/wiki/Sciences_sociales" title="Sciences sociales">sciences sociales</a>\r\nregroupent un ensemble de disciplines scientifiques relatives aux\r\ndivers aspects sociaux de la vie humaine, Ã  travers les conditions de\r\ntravail et les relations des personnes dans la vie quotidienne et dans\r\nla famille.</p>', 1, 2, 19, 48, 'fr'),
(3, '1', 'Jeux vidÃ©os', '<p><span class="citation"></span>Un <strong>jeu vidÃ©o</strong>, ou <strong>ludiciel</strong>, est un <a title="Jeu" href="http://fr.wikipedia.org/wiki/Jeu">jeu</a> utilisant un dispositif <a title="Informatique" href="http://fr.wikipedia.org/wiki/Informatique">informatique</a>. Le joueur utilise des <a title="PÃ©riphÃ©rique (informatique)" href="http://fr.wikipedia.org/wiki/P%C3%A9riph%C3%A9rique_%28informatique%29">pÃ©riphÃ©riques</a> pour agir sur le <a title="Jeu" href="http://fr.wikipedia.org/wiki/Jeu">jeu</a> et <a title="Perception" href="http://fr.wikipedia.org/wiki/Perception">percevoir</a> l\'environnement <a title="Virtuel" href="http://fr.wikipedia.org/wiki/Virtuel">virtuel</a>. </p> \r\n  <p align="center"><span class="citation">Â« Le <a title="Jeu vidÃ©o" href="http://fr.wikipedia.org/wiki/Jeu_vid%C3%A9o">jeu vidÃ©o</a> nous dit que la mort n\'est pas une fin. Il nous reste encore 3 continues. Â»</span> </p> \r\n  <p align="center">~ Lu sur le forum du site <a rel="nofollow" title="http://www.planetjeux.net/" class="external text" href="http://www.planetjeux.net/">Planetjeux</a>.</p>Â­', 23, 3, 1, 73, 'fr'),
(14, '1', 'Architecture', '<p>Lâ€™<strong><a title="Architecture" href="http://fr.wikipedia.org/wiki/Architecture">architecture</a></strong>\r\nest lâ€™art de faire, de combiner et de disposer, par les techniques\r\nappropriÃ©es, des Ã©lÃ©ments pleins ou vides, fixes ou mobiles, opaques ou\r\ntransparents, destinÃ©s Ã  constituer les volumes protecteurs qui mettent\r\nlâ€™homme, dans les divers aspects de sa vie, Ã  lâ€™abri de toutes les\r\nnuisances naturelles et artificielles. La combinatoire qui prÃ©side Ã \r\nlâ€™Ã©laboration de ces volumes sâ€™applique aussi bien Ã  leurs rapports de\r\nproportion quâ€™Ã  leurs matÃ©riaux, leurs couleurs et leur situation dans\r\nun espace naturel ou dans un contexte environnemental, ensemble qui\r\ncrÃ©e une unitÃ© homogÃ¨ne ou non, de dimensions variÃ©es, allant du simple\r\nabri Ã  la <a title="MÃ©tropole" href="http://fr.wikipedia.org/wiki/M%C3%A9tropole">mÃ©tropole</a>, et dont lâ€™apparition provoque un effet esthÃ©tique ou non selon sa rÃ©ussite.</p>', 15, 3, 1, 3, 'fr'),
(15, '1', 'Arts', '<a title="Catï¿½gorie:Art" class="image" href="http://fr.wikipedia.org/wiki/Image:Artalt.png"><img width="55" height="52" border="0" align="left" src="http://upload.wikimedia.org/wikipedia/commons/thumb/4/43/Artalt.png/55px-Artalt.png" alt="Catï¿½gorie:Art" /></a>L\'<strong><a title="Art" href="http://fr.wikipedia.org/wiki/Art">art</a></strong>, dans sa plus large signification, est l\'expression de la <a title="CrÃ©ativitÃ©" href="http://fr.wikipedia.org/wiki/Cr%C3%A9ativit%C3%A9">crÃ©ativitÃ©</a> ou de l\'imagination. Le mot Â« art Â» vient du terme <a title="Latin" href="http://fr.wikipedia.org/wiki/Latin">latin</a> <em>ars</em> qui signifie Â« arrangement Â», Â« habiletÃ© Â». L\'art se distingue des <a title="Loisir" href="http://fr.wikipedia.org/wiki/Loisir">loisirs</a>\r\npar le fait qu\'il s\'agit d\'une activitÃ© Ã  part entiÃ¨re. Il regroupe une\r\ngrande variÃ©tÃ© de disciplines dont le but principal est de concevoir\r\nune <a title="Å’uvre" href="http://fr.wikipedia.org/wiki/%C5%92uvre">Å“uvre</a> en faisant appel Ã  l\'<a title="EsthÃ©tique" href="http://fr.wikipedia.org/wiki/Esth%C3%A9tique">esthÃ©tique</a> et Ã  l\'<a title="Ã‰motion" href="http://fr.wikipedia.org/wiki/%C3%89motion">Ã©motion</a> pour les partager avec un public qui l\'interprÃ¨te. L\'art comprend des formes aussi diverses que la <a title="Prose" href="http://fr.wikipedia.org/wiki/Prose">prose</a>, l\'<a title="Ã‰criture" href="http://fr.wikipedia.org/wiki/%C3%89criture">Ã©criture</a>, la <a title="PoÃ©sie" href="http://fr.wikipedia.org/wiki/Po%C3%A9sie">poÃ©sie</a>, la <a title="Danse" href="http://fr.wikipedia.org/wiki/Danse">danse</a>, le <a title="ThÃ©Ã¢tre" href="http://fr.wikipedia.org/wiki/Th%C3%A9%C3%A2tre">thÃ©Ã¢tre</a>, le <a title="CinÃ©ma" href="http://fr.wikipedia.org/wiki/Cin%C3%A9ma">cinÃ©ma</a>, la <a title="Musique" href="http://fr.wikipedia.org/wiki/Musique">musique</a>, la <a title="Sculpture" href="http://fr.wikipedia.org/wiki/Sculpture">sculpture</a>, la <a title="Photographie" href="http://fr.wikipedia.org/wiki/Photographie">photographie</a>, l\'<a title="Architecture" href="http://fr.wikipedia.org/wiki/Architecture">architecture</a>, la <a title="Peinture" href="http://fr.wikipedia.org/wiki/Peinture">peinture</a> ou la <a title="Mode" href="http://fr.wikipedia.org/wiki/Mode">mode</a>.', 1, 2, 25, 2, 'fr'),
(16, '1', 'Bande dessinÃ©e', '<p align="center">Â« Actuellement, la <strong>bande dessinÃ©e</strong> constitue la principale application de l\'art sÃ©quentiel au support papier. La bande dessinÃ©e, ainsi que j\'en ai eu conscience dÃ¨s mes dÃ©buts, demeure une forme authentique d\'art et de littÃ©rature, capable de traiter aussi bien de sujets importants que d\'humour, nous permettant de nous exprimer Ã  travers le dessin. Â»<br /> <a title="Will Eisner" href="/wiki/Will_Eisner">Will Eisner</a>, 1997.</p>', 15, 3, 3, 5, 'fr'),
(21, '1', 'Sciences exactes et naturelles', '<div style="float: left; margin-right: 0.9em;">\r\n    <p><a class="image" title="Icon" href="http://fr.wikipedia.org/wiki/Image:Sciences_exactes.svg"><img width="90" height="90" border="0" alt="Icon" src="http://upload.wikimedia.org/wikipedia/commons/thumb/3/37/Sciences_exactes.svg/90px-Sciences_exactes.svg.png" /></a></p>\r\n  </div>\r\nLa <strong>science</strong> vient du <a title="Latin" href="http://fr.wikipedia.org/wiki/Latin">latin</a> <em>scientia</em>, la <a title="Connaissance" href="http://fr.wikipedia.org/wiki/Connaissance">connaissance</a>. Aujourd\'hui, la <strong>science</strong> dÃ©signe une dÃ©marche intellectuelle reposant idÃ©alement sur un refus des <a title="Dogme" href="http://fr.wikipedia.org/wiki/Dogme">dogmes</a> et un examen <a title="Raison" href="http://fr.wikipedia.org/wiki/Raison">raisonnÃ©</a> et mÃ©thodique du monde et de ses rÃ©gularitÃ©s, et visant Ã  produire des <a title="Connaissance" href="http://fr.wikipedia.org/wiki/Connaissance">connaissances</a> rÃ©sistant aux critiques <a title="RationalitÃ©" href="http://fr.wikipedia.org/wiki/Rationalit%C3%A9">rationnelles</a>&nbsp;;\r\nmais elle peut aussi dÃ©signer l\'ensemble organisÃ© de ces connaissances.\r\nAu cours de son dÃ©veloppement et suite Ã  l\'accumulation des savoirs\r\ndivers, elle s\'est structurÃ©e en <a title="Discipline scientifique" href="http://fr.wikipedia.org/wiki/Discipline_scientifique">domaines scientifiques</a>&nbsp;: <a title="MathÃ©matiques" href="http://fr.wikipedia.org/wiki/Math%C3%A9matiques">mathÃ©matiques</a>, <a title="Chimie" href="http://fr.wikipedia.org/wiki/Chimie">chimie</a>, <a title="Biologie" href="http://fr.wikipedia.org/wiki/Biologie">biologie</a>, <a title="Physique" href="http://fr.wikipedia.org/wiki/Physique">physique</a>, <a title="MÃ©canique" href="http://fr.wikipedia.org/wiki/M%C3%A9canique">mÃ©canique</a>, <a title="Optique" href="http://fr.wikipedia.org/wiki/Optique">optique</a>, <a title="Astronomie" href="http://fr.wikipedia.org/wiki/Astronomie">astronomie</a>, <a title="Sciences Ã©conomiques" href="http://fr.wikipedia.org/wiki/Sciences_%C3%A9conomiques">Ã©conomie</a>, <a title="Sociologie" href="http://fr.wikipedia.org/wiki/Sociologie">sociologie</a>...', 1, 2, 17, 30, 'fr'),
(22, '1', 'SociÃ©tÃ©', '<p><a class="image" title="CatÃ©gorie:SociÃ©tÃ©" href="http://fr.wikipedia.org/wiki/Image:Soci%C3%A9t%C3%A9.png"><img width="55" height="55" border="0" align="left" alt="CatÃ©gorie:SociÃ©tÃ©" src="http://upload.wikimedia.org/wikipedia/fr/thumb/c/c8/Soci%C3%A9t%C3%A9.png/55px-Soci%C3%A9t%C3%A9.png" /></a>La <strong>sociÃ©tÃ© civile</strong>, c\'est &quot;<em>le domaine de la vie sociale organisÃ©e\r\nqui est volontaire, largement autosuffisant et autonome de l\'Ã‰tat</em>&quot;\r\n(Larry Diamond). Une Ã©lection est un des Ã©vÃ©nements principaux oÃ¹ la\r\nsociÃ©tÃ© civile se trouve mobilisÃ©e, notamment Ã  travers l\'Ã©ducation de\r\nl\'Ã©lectoraÂ­t. C\'est le corps social, par opposition Ã  la classe\r\npolitique.</p>', 1, 2, 1, 68, 'fr'),
(23, '1', 'Vie quotidienne et loisirs', '<p><a href="http://fr.wikipedia.org/wiki/Cat%C3%A9gorie:Vie_quotidienne" title="CatÃ©gorie:Vie quotidienne"><span title="CatÃ©gorie:Vie quotidienne" style="text-decoration: none;">Â­ </span></a> <a href="http://fr.wikipedia.org/wiki/Image:Loisirs.svg" class="image" title="CatÃ©gorie:Vie quotidienne"><img width="55" height="55" border="0" align="left" alt="CatÃ©gorie:Vie quotidienne" src="http://upload.wikimedia.org/wikipedia/fr/thumb/e/eb/Loisirs.svg/55px-Loisirs.svg.png" /></a>\r\nOn appelle <strong>loisir</strong> l\'activitÃ© que l\'on effectue durant le\r\ntemps dont on peut disposer en dehors de ses occupations habituelles\r\n(emploi, gestion de la maison, Ã©ducation des enfants...) et des\r\ncontraintes quâ€™elles imposent (<a href="http://fr.wikipedia.org/wiki/Transport" title="Transport">transports</a> par exemple). On le qualifie Ã©galement de <em>temps libre</em>.</p> \r\n  <p>Ce <em>temps libre</em> est usuellement consacrÃ© Ã  des activitÃ©s essentiellement non productives dâ€™un point de vue <a href="http://fr.wikipedia.org/wiki/Macro-%C3%A9conomie" title="Macro-Ã©conomie">macro-Ã©conomique</a>, voire ludiques ou culturelles : <a href="http://fr.wikipedia.org/wiki/Bricolage" title="Bricolage">bricolage</a>, <a href="http://fr.wikipedia.org/wiki/Jardinage" title="Jardinage">jardinage</a>, <a href="http://fr.wikipedia.org/wiki/Sport" title="Sport">sports</a>, <a href="http://fr.wikipedia.org/wiki/Divertissement" title="Divertissement">divertissements</a>...\r\nce qui a entraÃ®nÃ© un glissement sÃ©mantique vers ce dernier terme, Ã  tel\r\npoint quâ€™il sâ€™est crÃ©Ã© une distinction entre le sport et les loisirs.</p> \r\n  <blockquote> \r\n    <p>Â« <em>ConsidÃ©rant qu\'en adoptant dÃ¨s sa premiÃ¨re session, Ã \r\nWashington, une Convention sur la durÃ©e du travail, [la ConfÃ©rence\r\ngÃ©nÃ©rale] a eu notamment pour objet de garantir aux travailleurs, outre\r\nles heures de sommeil nÃ©cessaires, un temps suffisant pour faire ce qui\r\nleur plaÃ®t, ainsi que l\'indique exactement l\'Ã©tymologie du mot â€œ\r\nloisirs â€ (...)</em> Â»<br />\r\n    â€” <a href="http://fr.wikipedia.org/w/index.php?title=Conf%C3%A9rence_internationale_du_travail&amp;action=edit" class="new" title="ConfÃ©rence internationale du travail">ConfÃ©rence internationale du travail</a>, <a href="http://fr.wikipedia.org/wiki/Gen%C3%A8ve" title="GenÃ¨ve">GenÃ¨ve</a>, 1924, p. 644.</p> \r\n  </blockquote>Â­', 1, 2, 3, 72, 'fr'),
(24, '1', 'Technologies', '<p><a class="image" title="CatÃ©gorie:Technologie" href="http://fr.wikipedia.org/wiki/Image:Crystal_Clear_action_run.png"><img width="55" height="55" border="0" align="left" alt="CatÃ©gorie:Technologie" src="http://upload.wikimedia.org/wikipedia/commons/thumb/5/5d/Crystal_Clear_action_run.png/55px-Crystal_Clear_action_run.png" /></a>Â­Â« <strong>La technologie</strong> est un terme vaste concernant l\'usage et la connaissance des outils et des techniques dÃ©veloppÃ©s par l\'humanitÃ©.&nbsp;Â»Â­</p>', 1, 2, 1, 70, 'fr'),
(25, '1', 'Mangas', '<p>Tout sur les <strong>mangas</strong> (papiers) et les <strong>animes</strong> du pays du soleil levant.</p>', 16, 4, 1, 6, 'fr'),
(26, '1', 'CinÃ©ma', '', 15, 3, 1, 9, 'fr'),
(27, '1', 'Culture', '', 15, 3, 1, 11, 'fr'),
(28, '1', 'Culture gÃ©nÃ©rale', 'Regroupement des questionnaires multi-sujets.', 1, 2, 1, 28, 'fr'),
(31, '1', 'Danse', '<p align="center">Â« <strong>La danse</strong> est le premier-nÃ© des arts. La musique et la poÃ©sie s\'Ã©coulent dans le temps ; les arts plastiques et l\'architecture modÃ¨lent l\'espace. Mais la danse vit Ã  la fois dans l\'espace et le temps. Avant de confier ses Ã©motions Ã  la pierre, au verbe, au son, l\'homme se sert de son propre corps pour organiser l\'espace et pour rythmer le temps. Â»</p>\r\n  <p align="center">(<a title="Curt Sachs" href="/wiki/Curt_Sachs">Curt Sachs</a>).</p>', 15, 3, 1, 13, 'fr'),
(32, '1', 'Histoire de l\'art', '<strong>L\'histoire de l\'art</strong>, discipline qui Ã©tudie l\'histoire des <strong><a title="Art visuel" href="http://fr.wikipedia.org/wiki/Art_visuel">arts visuels</a></strong>.', 15, 3, 1, 15, 'fr'),
(33, '1', 'LittÃ©rature', '', 15, 3, 1, 17, 'fr'),
(34, '1', 'Musique', '<p>La <strong>musique</strong> est la <a href="http://fr.wikipedia.org/wiki/Science" title="Science">science</a><sup id="_ref-0" class="reference"><a href="http://fr.wikipedia.org/wiki/Musique#_note-0"><span class="cite_crochet"></span><span class="cite_crochet"></span></a></sup><sup id="_ref-1" class="reference"><a href="http://fr.wikipedia.org/wiki/Musique#_note-1"><span class="cite_crochet"></span><span class="cite_crochet"></span></a></sup> et l\'<a href="http://fr.wikipedia.org/wiki/Art" title="Art">art</a>, consistant Ã  arranger et ordonner les <a href="http://fr.wikipedia.org/wiki/Son_%28physique%29" title="Son (physique)">sons</a> et les <a href="http://fr.wikipedia.org/wiki/Silence_%28musique%29" title="Silence (musique)">silences</a> au cours du temps (le plus souvent de faÃ§on <a href="http://fr.wikipedia.org/wiki/Rythme" title="Rythme">rythmÃ©e</a>), de sorte que les sons obtenus soient agrÃ©ables Ã  l\'<a href="http://fr.wikipedia.org/wiki/Oreille" title="Oreille">oreille</a>.</p> \r\n  <p>La musique est l\'une des pratiques <a href="http://fr.wikipedia.org/wiki/Culture" title="Culture">culturelles</a> les plus anciennes. Elle comporte frÃ©quemment une dimension <a href="http://fr.wikipedia.org/wiki/Art" title="Art">artistique</a>. La musique s\'inspire toujours d\'un &quot;matÃ©riau sonore&quot; pouvant regrouper l\'ensemble des <a href="http://fr.wikipedia.org/wiki/Perception" title="Perception">sons perceptibles</a>, pour construire ce &quot;matÃ©riau musical&quot;. L\'<a href="http://fr.wikipedia.org/wiki/Ou%C3%AFe" title="Ouï¿½e">ouÃ¯e</a>,\r\nqui est le plus adaptÃ© de nos sens pour la connaissance des sentiments\r\nest, a contrario, le moins apte Ã  la connaissance objective. La musique\r\nest un concept dont la signification est multiple, il en rÃ©sulte\r\nqu\'elle ne peut avoir une dÃ©finition unique en regroupant tous les <a href="http://fr.wikipedia.org/wiki/Type_de_musique" title="Type de musique">types de musique</a>, tous les <a href="http://fr.wikipedia.org/wiki/Genre_musical" title="Genre musical">genres musicaux</a>.</p>', 15, 3, 1, 19, 'fr'),
(35, '1', 'Peinture', 'LittÃ©ralement, la <strong><a href="http://fr.wikipedia.org/wiki/Peinture" title="Peinture">peinture</a></strong> dÃ©signe la <a href="http://fr.wikipedia.org/wiki/Peinture_%28mati%C3%A8re%29" title="Peinture (matiï¿½re)">matiÃ¨re</a> et la pratique consistant Ã  appliquer une <a href="http://fr.wikipedia.org/wiki/Couleur" title="Couleur">couleur</a> Ã  l\'aide de diffÃ©rents matÃ©riaux (<a href="http://fr.wikipedia.org/wiki/Pigment" title="Pigment">pigments</a> en poudre, <a href="http://fr.wikipedia.org/wiki/Gouache" title="Gouache">gouache</a>, <a href="http://fr.wikipedia.org/wiki/Peinture_%C3%A0_l%27huile" title="Peinture ï¿½ l\'huile">huile</a>, <a href="http://fr.wikipedia.org/wiki/Peinture_acrylique" title="Peinture acrylique">acrylique</a>, <a href="http://fr.wikipedia.org/wiki/Encre" title="Encre">encre</a>, etc.) sur une surface tel que du <a href="http://fr.wikipedia.org/wiki/Papier" title="Papier">papier</a>, une <a href="http://fr.wikipedia.org/wiki/Toile_%28peinture%29" title="Toile (peinture)">toile</a>, du <a href="http://fr.wikipedia.org/wiki/Bois" title="Bois">bois</a>, du <a href="http://fr.wikipedia.org/wiki/Peinture_sur_verre" title="Peinture sur verre">verre</a> et bien d\'autres supports. \r\n  \r\n  <p>Dans un sens artistique, le terme &quot;<strong>peinture</strong>&quot; signifie la combinaison de cette activitÃ© avec le <a href="http://fr.wikipedia.org/wiki/Dessin" title="Dessin">dessin</a>, la <a href="http://fr.wikipedia.org/wiki/Composition" title="Composition">composition</a>, c\'est-Ã -dire qu\'il intÃ©gre des considÃ©rations esthÃ©tiques. En ce sens, la peinture est le moyen pour l\'<a href="http://fr.wikipedia.org/wiki/Artiste-peintre" title="Artiste-peintre">artiste-peintre</a> de reprÃ©senter une expression personnelle sur des sujets aussi variÃ©s qu\'il existe d\'artistes. C\'est donc un <a href="http://fr.wikipedia.org/wiki/Art" title="Art">Art</a>.</p>', 15, 3, 1, 21, 'fr'),
(36, '1', 'Photographie', 'Â­Â­<p>La <strong><a href="http://fr.wikipedia.org/wiki/Photographie" title="Photographie">photographie</a></strong> est une technique permettant de fixer une image sur une surface sensible Ã  l\'aide de la lumiÃ¨re et des objets qui la reflÃ©tent.</p><p>Elle dÃ©signe aussi plus gÃ©nÃ©ralement la branche des <a href="http://fr.wikipedia.org/wiki/Arts_visuels" title="Arts visuels">arts graphiques</a> qui utilise cette technique comme moyen.</p>', 15, 3, 1, 23, 'fr'),
(37, '1', 'Spectacle', '<div class="floatleft"><span><a title="Neuburg Donau Stadttheater Vorhang.jpg" class="image" href="http://fr.wikipedia.org/wiki/Image:Neuburg_Donau_Stadttheater_Vorhang.jpg"><img width="120" height="96" border="0" align="left" src="http://upload.wikimedia.org/wikipedia/commons/thumb/6/6a/Neuburg_Donau_Stadttheater_Vorhang.jpg/120px-Neuburg_Donau_Stadttheater_Vorhang.jpg" /></a></span></div> \r\n  <p align="center"><span><a title="Augsburg Parktheater Goeggingen Vorhang.jpg" class="image" href="http://fr.wikipedia.org/wiki/Image:Augsburg_Parktheater_Goeggingen_Vorhang.jpg"><img width="120" height="94" border="0" align="right" src="http://upload.wikimedia.org/wikipedia/commons/thumb/5/5d/Augsburg_Parktheater_Goeggingen_Vorhang.jpg/120px-Augsburg_Parktheater_Goeggingen_Vorhang.jpg" /></a></span><strong>&quot;Ne pas se rendre au thÃ©atre, c\'est comme faire sa toilette sans miroir&quot;.</strong> <a title="Arthur Schopenhauer" href="http://fr.wikipedia.org/wiki/Arthur_Schopenhauer">Arthur Schopenhauer</a>,<span></span><span></span> <em>ObservatÂ­ions psychologiques</em></p> \r\n  <div class="floatleft"><span></span></div> \r\n  <div class="floatright"><span></span>Les <a title="Arts du spectacle" href="http://fr.wikipedia.org/wiki/Arts_du_spectacle">arts du spectacle</a> vivant, dits aussi <a title="Spectacle vivant" href="http://fr.wikipedia.org/wiki/Spectacle_vivant"><em>arts vivants</em></a>, regroupent un grand nombre de disciplines dont l\'objectif est la\r\nreprÃ©sentation devant un public. Il s\'agit de pratiques issues du <a title="Thï¿½ï¿½tre" href="http://fr.wikipedia.org/wiki/Th%C3%A9%C3%A2tre">thÃ©atre</a>, de la <a title="Danse" href="http://fr.wikipedia.org/wiki/Danse">danse</a>, du <a title="Cabaret" href="http://fr.wikipedia.org/wiki/Cabaret">cabaret</a>, du <a title="Conte" href="http://fr.wikipedia.org/wiki/Conte">conte</a>, du <a title="Cirque" href="http://fr.wikipedia.org/wiki/Cirque">cirque</a>, du <a title="Thï¿½ï¿½tre d\'improvisation" href="http://fr.wikipedia.org/wiki/Th%C3%A9%C3%A2tre_d%27improvisation">thÃ©atre d\'improvisation</a>, ou encore du <a title="Spectacle de rue" href="http://fr.wikipedia.org/wiki/Spectacle_de_rue">spectacle de rue</a>.</div> <center> </center> <br />', 15, 3, 1, 25, 'fr'),
(38, '1', 'Droit', '<div class="floatright"><span><a title="Cour suprême des États-Unis d\'Amérique" class="image" href="http://fr.wikipedia.org/wiki/Image:Supreme_Court2.jpg"><img width="200" height="132" border="0" align="right" src="http://upload.wikimedia.org/wikipedia/commons/thumb/6/63/Supreme_Court2.jpg/200px-Supreme_Court2.jpg" alt="Cour suprême des États-Unis d\'Amérique" /></a></span></div>  \r\n  <p>Le <strong><a title="Droit" href="http://fr.wikipedia.org/wiki/Droit">droit</a></strong> (du <a title="Latin" href="http://fr.wikipedia.org/wiki/Latin">latin</a> <em>directum</em>) est un ensemble de règles régissant la vie en société et sanctionnées par la puissance publique par les moyens de la <a title="Justice" href="http://fr.wikipedia.org/wiki/Justice">justice</a>.</p>\r\n  <div class="floatright"><span></span></div>  \r\n  <p>Le mot droit est un <a title="Polysémie" href="http://fr.wikipedia.org/wiki/Polys%C3%A9mie">polysème</a>. Il faut en effet distinguer&nbsp;:</p>\r\n  <div class="floatright"><span></span></div>  \r\n  <ul>\r\n    <li>la science juridique, qui est l\'objet de ce portail&nbsp;: elle étudie les <a title="Règle de droit" href="http://fr.wikipedia.org/wiki/R%C3%A8gle_de_droit">règles de droit</a> prises dans leur ensemble, ou dans une de ses <a title="Branches du droit" href="http://fr.wikipedia.org/wiki/Branches_du_droit">branches</a> seulement&nbsp;;</li>\r\n    <li>le <a title="Droit objectif" href="http://fr.wikipedia.org/wiki/Droit_objectif">droit objectif</a>\r\nqui est un ensemble des règles de droit destinées à organiser, dans une\r\nsociété donnée, les rapports entre les hommes, et sanctionnables par\r\nl\'autorité publique;</li>\r\n    <li>le <a title="Droit subjectif" href="http://fr.wikipedia.org/wiki/Droit_subjectif">droit subjectif</a>,\r\nqui rassemble les prérogatives reconnues à un individu, ou à un groupe\r\nd’individus, leur permettant de jouir d\'une chose ou d\'exiger d\'autrui\r\nune prestation.</li>\r\n  </ul>', 2, 3, 1, 49, 'fr'),
(39, '1', 'Economie', '<p>Lï¿½<strong>ï¿½conomie</strong>, ou lï¿½<strong>activitï¿½ ï¿½conomique</strong>, (<a href="http://fr.wikipedia.org/wiki/Grec_ancien" title="Grec ancien">grec ancien</a> : <em>Î¿á¼°ÎºÎ¿Î½Î¿Î¼Î¯Î±</em>, <font color="#333333">ï¿½ administration d\'un foyer ï¿½</font><font color="gray">ï¿½ <em>de Î¿á¼¶ÎºÎ¿Ï‚ (maison, dans le sens de patrimoine) et Î½Î­Î¼Ï‰ (administrer)</em> ï¿½</font>)\r\nest l\'activitï¿½ humaine qui consiste ï¿½ la production, la distribution,\r\nl\'ï¿½change et la consommation de produits et services. Lï¿½ï¿½conomie est\r\nï¿½tudiï¿½e par les <strong><a href="http://fr.wikipedia.org/wiki/Sciences_%C3%A9conomiques" title="Sciences ï¿½conomiques">sciences ï¿½conomiques</a></strong> et prend appui sur des <a href="http://fr.wikipedia.org/wiki/Th%C3%A9orie_%C3%A9conomique" title="Thï¿½orie ï¿½conomique">thï¿½ories ï¿½conomiques</a>.</p> \r\n  <p>On parle ï¿½galement de l\'ï¿½conomie comme de la situation ï¿½conomique <a href="http://fr.wikipedia.org/wiki/Conjoncture" title="Conjoncture">conjoncturelle</a> d\'un pays ou dï¿½une zone, c\'est-ï¿½-dire de sa position instantanï¿½e dans les <a href="http://fr.wikipedia.org/wiki/Cycle_%C3%A9conomique" title="Cycle ï¿½conomique">cycles ï¿½conomiques</a>. Lï¿½activitï¿½ ï¿½conomique est rï¿½gulï¿½e par la <a href="http://fr.wikipedia.org/wiki/Politique_conjoncturelle" title="Politique conjoncturelle">politique conjoncturelle</a> des <a href="http://fr.wikipedia.org/wiki/Autorit%C3%A9s_mon%C3%A9taires" title="Autoritï¿½s monï¿½taires">autoritï¿½s monï¿½taires</a> et du <a href="http://fr.wikipedia.org/wiki/Gouvernement" title="Gouvernement">gouvernement</a>. Les <a href="http://fr.wikipedia.org/wiki/Administrations_publiques" title="Administrations publiques">administrations publiques</a> mï¿½nent par ailleurs des <a href="http://fr.wikipedia.org/wiki/Politiques_%C3%A9conomiques" title="Politiques ï¿½conomiques">politiques ï¿½conomiques</a> dans le but de modifier le fonctionnement ï¿½conomique d\'un pays.</p> \r\n  <p>Un des <a href="http://fr.wikipedia.org/wiki/Indicateur_%C3%A9conomique" title="Indicateur ï¿½conomique">indicateurs ï¿½conomiques</a> principaux est le <a href="http://fr.wikipedia.org/wiki/Produit_int%C3%A9rieur_brut" title="Produit intï¿½rieur brut">produit intï¿½rieur brut</a> (PIB), qui permet des comparaisons de puissance ï¿½conomique entre pays.</p>', 2, 3, 1, 51, 'fr'),
(40, '1', 'GÃ©ographie', 'La <a href="http://fr.wikipedia.org/wiki/G%C3%A9ographie" title="Gï¿½ographie">gï¿½ographie</a> est la <a href="http://fr.wikipedia.org/wiki/Science" title="Science">science</a> qui ï¿½tudie les interactions entre l\'<a href="http://fr.wikipedia.org/wiki/Homme" title="Homme">Homme</a> et son <a href="http://fr.wikipedia.org/wiki/Environnement" title="Environnement">environnement</a>.<br />\r\nSon champ d\'ï¿½tude s\'ï¿½tend des <a href="http://fr.wikipedia.org/wiki/Sciences_humaines" title="Sciences humaines">sciences humaines</a> et <a href="http://fr.wikipedia.org/wiki/Sciences_sociales" title="Sciences sociales">sociales</a> aux <a href="http://fr.wikipedia.org/wiki/Sciences_naturelles" title="Sciences naturelles">sciences naturelles</a>, la gï¿½ographie entretient donc de nombreuses relations avec les autres <a href="http://fr.wikipedia.org/wiki/Science" title="Science">sciences</a>.', 2, 3, 1, 53, 'fr'),
(41, '1', 'Histoire', '<div style="float: left; margin-right: 0.5em;"> \r\n    <div class="floatleft"><span><a title="History" class="image" href="http://fr.wikipedia.org/wiki/Image:Clio1.gif"><img width="75" height="74" border="0" src="http://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Clio1.gif/75px-Clio1.gif" alt="History" /></a></span></div> \r\n  </div> \r\n  <p>L’«&nbsp;<strong>Histoire</strong>&nbsp;» est à la fois l\'étude des <a title="Fait" class="new" href="http://fr.wikipedia.org/w/index.php?title=Fait&amp;action=edit">faits</a> et des <a title="Événement" href="http://fr.wikipedia.org/wiki/%C3%89v%C3%A9nement">événements</a> du passé et aussi l’ensemble de ces faits, de ces événements. Le nom a pour origine les «&nbsp;enquêtes&nbsp;» (&#7993;&#963;&#964;&#959;&#961;&#943;&#945;&#953; [Historiai] en <a title="Grec ancien" href="http://fr.wikipedia.org/wiki/Grec_ancien">grec ancien</a>) d\'<a title="Hérodote" href="http://fr.wikipedia.org/wiki/H%C3%A9rodote">Hérodote</a>, mais c’est <a title="Thucydide" href="http://fr.wikipedia.org/wiki/Thucydide">Thucydide</a> qui lui applique le premier des <a title="Méthodologie" href="http://fr.wikipedia.org/wiki/M%C3%A9thodologie">méthodes</a> <a title="Critique" href="http://fr.wikipedia.org/wiki/Critique">critiques</a>, notamment le croisement de <a title="Source (information)" href="http://fr.wikipedia.org/wiki/Source_%28information%29">sources</a> différentes…</p>  \r\n  <p></p>', 2, 3, 1, 55, 'fr'),
(42, '1', 'Information', 'On appelle <strong>sciences de l\'information et des bibliothèques (SIB)</strong> l\'ensemble des <a title="Savoir" href="http://fr.wikipedia.org/wiki/Savoir">savoirs</a> et <a title="Savoir-faire" href="http://fr.wikipedia.org/wiki/Savoir-faire">savoir-faire</a> utiles aux personnes chargées de gérer une <a title="Bibliothèque" href="http://fr.wikipedia.org/wiki/Biblioth%C3%A8que">bibliothèque</a> ou un service d\'<a title="Information" href="http://fr.wikipedia.org/wiki/Information">information</a>-<a title="Documentation" href="http://fr.wikipedia.org/wiki/Documentation">documentation</a>.', 2, 3, 1, 57, 'fr'),
(43, '1', 'Langues', '<a title="Pieter Bruegel de Oude (1525-1569), De Toren van Babel (1563)" class="image" href="http://fr.wikipedia.org/wiki/Image:Brueghel-tower-of-babel.jpg"><img width="200" height="151" border="0" align="right" src="http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Brueghel-tower-of-babel.jpg/200px-Brueghel-tower-of-babel.jpg" alt="Pieter Bruegel de Oude (1525-1569), De Toren van Babel (1563)" /></a> \r\n  <div align="center">\r\n    <div align="left">L\'humanité se distinguant par la grande variété de ses langues, c\'est tout naturellement la <a title="Tour de Babel" href="http://fr.wikipedia.org/wiki/Tour_de_Babel">Tour de Babel</a> qui sert d\'emblème à ce portail. Ci-contre, une de ses représentations, peinte en <a title="1563" href="http://fr.wikipedia.org/wiki/1563">1563</a> par <a title="Pieter Bruegel l\'Ancien" href="http://fr.wikipedia.org/wiki/Pieter_Bruegel_l%27Ancien">Pieter Bruegel l\'Ancien</a> et, juste au-dessous, des échantillons de divers <a title="Écriture" href="http://fr.wikipedia.org/wiki/%C3%89criture">systèmes d\'écriture</a>.<br /></div>\r\n    <div align="center"><a title="Échantillons de divers alphabets" class="image" href="http://fr.wikipedia.org/wiki/Image:AlphabetsScriptsWorld.png"><img width="200" height="46" border="0" src="http://upload.wikimedia.org/wikipedia/commons/thumb/d/de/AlphabetsScriptsWorld.png/200px-AlphabetsScriptsWorld.png" alt="Échantillons de divers alphabets" /></a></div>   \r\n  </div>', 2, 3, 1, 59, 'fr'),
(44, '1', 'Philosophie', '<p>«&nbsp;Penser, c\'est dire non. Remarquez que le signe du oui est d\'un\r\nhomme qui s\'endort&nbsp;; au contraire le réveil secoue la tête et dit non.\r\nNon à quoi&nbsp;? Au monde, au tyran, au prêcheur&nbsp;? Ce n\'est que\r\nl\'apparence. En tous ces cas-là, c\'est à elle-même que la pensée dit\r\nnon. Elle rompt l\'heureux acquiescement. Elle se sépare d\'elle-même.\r\nElle combat contre elle-même. Il n\'y a pas au monde d\'autre combat. Ce\r\nqui fait que le monde me trompe par ses perspectives, ses brouillards,\r\nses chocs détournés, c\'est que je consens, c\'est que je ne cherche pas\r\nautre chose. Et ce qui fait que le tyran est maître de moi, c\'est que\r\nje respecte au lieu d\'examiner. Même une doctrine vraie, elle tombe au\r\nfaux par cette somnolence. C\'est par croire que les hommes sont\r\nesclaves. Réfléchir, c\'est nier ce que l\'on croit. Qui croit ne sait\r\nmême plus ce qu\'il croit. Qui se contente de sa pensée ne pense plus\r\nrien.&nbsp;»</p> \r\n  <p><a title="Émile Chartier" href="http://fr.wikipedia.org/wiki/%C3%89mile_Chartier">Alain</a>, <em><a title="Propos sur les pouvoirs" class="new" href="http://fr.wikipedia.org/w/index.php?title=Propos_sur_les_pouvoirs&amp;action=edit">Propos sur les pouvoirs</a></em></p>', 2, 3, 1, 61, 'fr'),
(45, '1', 'Psychologie', '<p><span class="mw-headline">La <strong>psychologie</strong>, du grec <a title="Psukhê" href="http://fr.wikipedia.org/wiki/Psukh%C3%AA">psukhê</a> (<a title="Âme" href="http://fr.wikipedia.org/wiki/%C3%82me">âme</a>) et <a title="Logos" href="http://fr.wikipedia.org/wiki/Logos">logos</a> (<a title="Science" href="http://fr.wikipedia.org/wiki/Science">science</a>),\r\nest l\'étude scientifique des faits psychiques, la connaissance\r\nempirique ou intuitive des sentiments, des idées, des comportements,\r\nl\'ensemble des manières de penser, de sentir, d\'agir qui caractérisent\r\nune personne, un animal, un groupe, un personnage.</span></p> \r\n  <p><span class="mw-headline">Divisée en de nombreuses branches d’étude, ses disciplines abordent le domaine tant au plan <a title="Théorie" href="http://fr.wikipedia.org/wiki/Th%C3%A9orie">théorique</a> que <a title="Pratique" href="http://fr.wikipedia.org/wiki/Pratique">pratique</a>, avec des applications <a title="Thérapie" href="http://fr.wikipedia.org/wiki/Th%C3%A9rapie">thérapeutiques</a>, sociales, <a title="Politique" href="http://fr.wikipedia.org/wiki/Politique">politiques</a>, <a title="Commerciales" class="new" href="http://fr.wikipedia.org/w/index.php?title=Commerciales&amp;action=edit">commerciales</a> (<a title="Marketing" href="http://fr.wikipedia.org/wiki/Marketing">marketing</a>) ou <a title="Théologie" href="http://fr.wikipedia.org/wiki/Th%C3%A9ologie">théologiques</a>.</span></p> \r\n  <p><span class="mw-headline">La psychologie a pour objectif l\'investigation du <a title="Psychisme" href="http://fr.wikipedia.org/wiki/Psychisme">psychisme</a>\r\ncomme fondement d\'une structure subjective et d\'un fonctionnement\r\nspécifique (processus et mécanisme) articulé à la perception et\r\nreprésentation du monde extérieur.</span></p>', 2, 3, 1, 63, 'fr'),
(46, '1', 'Sociologie', '<a href="http://upload.wikimedia.org/wikipedia/commons/9/9c/Sociologielogo.png"><img width="51" height="58" border="0" align="left" src="http://upload.wikimedia.org/wikipedia/commons/9/9c/Sociologielogo.png" alt="Image:Sociologielogo.png" /></a>\r\nLa <strong><a title="Sociologie" href="http://fr.wikipedia.org/wiki/Sociologie">sociologie</a></strong> est l\'étude des phénomènes sociaux. C\'est <a title="Sieyès" href="http://fr.wikipedia.org/wiki/Siey%C3%A8s">Sieyès</a> qui le premier propose ce terme. C\'est toutefois <a title="Auguste Comte" href="http://fr.wikipedia.org/wiki/Auguste_Comte">Auguste Comte</a> qui lui donne son sens actuel. Même si, de <a title="Platon" href="http://fr.wikipedia.org/wiki/Platon">Platon</a> à <a title="Montesquieu" href="http://fr.wikipedia.org/wiki/Montesquieu">Montesquieu</a>, les études de nature sociologique sont anciennes, ce n\'est qu\'au milieu du <span style="text-transform: uppercase;" title="Nombre 19 écrit en chiffres romains" class="romain">XIX</span><sup class="exposant">e</sup> que naît un ensemble systématique de travaux qui considèrent le social comme un domaine d\'étude <em><a title="Sui generis" href="http://fr.wikipedia.org/wiki/Sui_generis">sui generis</a></em>, notamment ceux de <a title="Alexis de Tocqueville" href="http://fr.wikipedia.org/wiki/Alexis_de_Tocqueville">Alexis de Tocqueville</a>, <a title="Karl Marx" href="http://fr.wikipedia.org/wiki/Karl_Marx">Karl Marx</a> et <a title="Frédéric Le Play" href="http://fr.wikipedia.org/wiki/Fr%C3%A9d%C3%A9ric_Le_Play">Frédéric Le Play</a>.&nbsp;\r\n  <p style="text-indent: 1.5em;">Il faut attendre le tournant du <span style="text-transform: uppercase;" title="Nombre 20 écrit en chiffres romains" class="romain">XX</span><sup class="exposant">e</sup>\r\nsiècle pour que la sociologie trouve une assise institutionnelle. De\r\ncette époque datent également les travaux qui forment encore le socle\r\nde la discipline, en particulier ceux de <a title="Max Weber" href="http://fr.wikipedia.org/wiki/Max_Weber">Max Weber</a>, <a title="Georg Simmel" href="http://fr.wikipedia.org/wiki/Georg_Simmel">Georg Simmel</a> et <a title="Émile Durkheim" href="http://fr.wikipedia.org/wiki/%C3%89mile_Durkheim">Émile Durkheim</a>.\r\nCes auteurs proposent, les premiers, des modèles d\'intelligibilité et\r\ndes protocoles d\'enquête systématiques et cohérents entre eux pour\r\nétudier les phénomènes sociaux.</p> \r\n  <p style="text-indent: 1.5em;">La sociologie est aujourd\'hui une discipline diversifiée, à la fois dans ses objets, ses méthodes et ses <a title="Paradigme" href="http://fr.wikipedia.org/wiki/Paradigme">paradigmes</a>.\r\nOn lui doit la mise au jour d\'un ensemble de faits, comme les\r\ninégalités sociales devant l\'école ou les facteurs sociaux du suicide.\r\nDiscipline récente, elle est une source d\'intelligibilité indispensable\r\nà la compréhension du monde contemporain.</p>', 2, 3, 1, 65, 'fr'),
(47, '1', 'Astronomie', '<p>L<span style="font-weight: bold;">\'</span><strong>astronomie</strong> est la <a title="Science" href="http://fr.wikipedia.org/wiki/Science">science</a> de l\'<a title="Observation du ciel" href="http://fr.wikipedia.org/wiki/Observation_du_ciel">observation des astres</a>, cherchant Ã  expliquer leur origine, leur <a title="Ã©volution" href="http://fr.wikipedia.org/wiki/%C3%89volution">Ã©volution</a>, leurs propriÃ©tÃ©s <a title="Physique" href="http://fr.wikipedia.org/wiki/Physique">physiques</a> et <a title="Chimique" href="http://fr.wikipedia.org/wiki/Chimique">chimiques</a>. Elle ne doit pas Ãªtre confondue avec la <a title="MÃ©canique cÃ©leste" href="http://fr.wikipedia.org/wiki/M%C3%A9canique_c%C3%A9leste">mÃ©canique cÃ©leste</a> qui n\'en est qu\'un domaine particulier. Avec plus de 6 000 ans d\'Histoire, les origines de l\'astronomie remontant au-delÃ  de l\'<a title="AntiquitÃ©" href="http://fr.wikipedia.org/wiki/Antiquit%C3%A9">antiquitÃ©</a>, dans les pratiques religieuses <a title="PrÃ©histoire" href="http://fr.wikipedia.org/wiki/Pr%C3%A9histoire">prÃ©historiquesÂ­</a></p> \r\n  <p><em>Astronomie</em> vient du <a title="Grec ancien" href="http://fr.wikipedia.org/wiki/Grec_ancien">grec</a> <em><span lang="grc" xml:lang="grc" class="lang-grc">Î±ÏƒÏ„ÏÎ¿Î½Î¿Î¼Î¯Î±</span></em> (<em><span lang="grc" xml:lang="grc" class="lang-grc">Î¬ÏƒÏ„ÏÎ¿Î½</span></em> et <em><span lang="grc" xml:lang="grc" class="lang-grc">Î½ÏŒÎ¼Î¿Ï‚</span></em>) ce qui signifie <em>loi des astres</em>.</p> \r\n  <p>L\'astronomie est l\'une des rares sciences oÃ¹ les <a title="Astronomie amateur" href="http://fr.wikipedia.org/wiki/Astronomie_amateur">amateurs</a>\r\npeuvent encore jouer un rÃ´le actif. Elle est en effet pratiquÃ©e Ã  titre\r\nde loisir auprÃ¨s d\'un large public d\'astronomes amateurs : les plus\r\npassionnÃ©s et expÃ©rimentÃ©s d\'entre eux participent Ã  la dÃ©couverte d\'<a title="AstÃ©roÃ¯de" href="http://fr.wikipedia.org/wiki/Ast%C3%A9ro%C3%AFde">astÃ©roÃ¯des</a> et de <a title="ComÃ¨te" href="http://fr.wikipedia.org/wiki/Com%C3%A8te">comÃ¨tes</a>. C\'est Ã  ce sujet un loisir particuliÃ¨rement populaire en <a title="France" href="http://fr.wikipedia.org/wiki/France">France</a>, comme en tÃ©moigne la <em><a title="Nuit des Ã©toiles" href="http://fr.wikipedia.org/wiki/Nuit_des_%C3%A9toiles">Nuit des Ã©toiles</a></em>.</p>', 21, 3, 1, 31, 'fr'),
(48, '1', 'Biologie', 'La <strong>biologie</strong> (du <a title="Grec ancien" href="http://fr.wikipedia.org/wiki/Grec_ancien">grec</a> <span lang="grc" xml:lang="grc" class="lang-grc">&#946;&#943;&#959;&#962;</span> / <em>bios</em>, «&nbsp;vie&nbsp;» et <span lang="grc" xml:lang="grc" class="lang-grc">&#955;&#972;&#947;&#959;&#962;</span> / <em>logos</em>, «&nbsp;parole, discours&nbsp;») est la <a title="Science" href="http://fr.wikipedia.org/wiki/Science">science</a>\r\ndu vivant. Son objet est l\'étude des organismes vivants, des cellules\r\nqui les composent à la physiologie des organismes dans leur ensemble,\r\nde l\'évolution des espèces aux recherches comportementales, de\r\nl\'écologie scientifique à la médecine. Les champs couverts par la\r\nbiologie sont immenses et nombre de domaines qui lui sont liés\r\napparaissent souvent comme des sciences à part entière, étudiant le\r\nvivant à toutes ses échelles, des bactéries aux plus grands mammifères.', 21, 3, 1, 33, 'fr'),
(49, '1', 'Chimie', '<p>La <strong>chimie</strong> est la <a title="Science" href="http://fr.wikipedia.org/wiki/Science">science</a> qui étudie la composition, les <a title="Réaction chimique" href="http://fr.wikipedia.org/wiki/R%C3%A9action_chimique">réactions</a> et les propriétés chimiques et physiques de la <a title="Matière" href="http://fr.wikipedia.org/wiki/Mati%C3%A8re">matière</a>. La chimie est par nature interdisciplinaire et relie les <a title="Sciences naturelles" href="http://fr.wikipedia.org/wiki/Sciences_naturelles">sciences naturelles</a>, elle a un rôle important dans le fonctionnement de notre monde et dans l\'existence de la vie.</p> \r\n  <p>Sans les propriétés chimiques de l\'eau, de l\'air et des\r\nbiomolécules, la vie n\'aurait pas pu se développer de façon si\r\ncomplexe. L\'étude du monde à l\'échelle moléculaire permet de mieux\r\ncomprendre le monde à l\'échelle de l\'homme. Dans ce but, la chimie\r\ns\'appuie beaucoup sur des <a title="Expérience" href="http://fr.wikipedia.org/wiki/Exp%C3%A9rience">expériences</a>, qui répondent à la rigueur scientifique. La chimie s\'applique à de simples <a title="Atome" href="http://fr.wikipedia.org/wiki/Atome">atomes</a>\r\njusqu\'à des édifices moléculaires imposants (ADN, cristaux, …). En\r\ntermes de dimensions, le domaine d\'application de la chimie se situe\r\nentre le <a title="Femtomètre" href="http://fr.wikipedia.org/wiki/Femtom%C3%A8tre">femtomètre</a> (10<sup>-15</sup> m) et le <a title="Micromètre" href="http://fr.wikipedia.org/wiki/Microm%C3%A8tre">micromètre</a> (10<sup>-6</sup>\r\nm). La chimie contemporaine possède une diversité remarquable&nbsp;: en plus\r\nde toutes les substances naturelles qui existent, une grande quantité\r\nde nouveaux composés chimiques artificiels est régulièrement découverte.</p>', 21, 3, 1, 35, 'fr'),
(50, '1', 'Logique', '<p>La <strong>logique</strong> (du <a title="Grec ancien" href="http://fr.wikipedia.org/wiki/Grec_ancien">grec</a> &#955;&#972;&#947;&#959;&#962; (<a title="Logos" href="http://fr.wikipedia.org/wiki/Logos">logos</a>),\r\nce qui veut dire, entre autres, raison ou discours) est dans une\r\npremière approche l\'étude des règles formelles que doit respecter toute\r\ndéduction correcte.</p> \r\n  <p>Elle est depuis l\'<a title="Logique" href="http://fr.wikipedia.org/wiki/Logique#Antiquit.C3.A9">antiquité</a> l\'une des grandes <a title="Discipline (spécialité)" href="http://fr.wikipedia.org/wiki/Discipline_%28sp%C3%A9cialit%C3%A9%29">disciplines</a> de la <a title="Philosophie" href="http://fr.wikipedia.org/wiki/Philosophie">philosophie</a>, avec l\'<a title="Éthique" href="http://fr.wikipedia.org/wiki/%C3%89thique">éthique</a> et la <a title="Métaphysique" href="http://fr.wikipedia.org/wiki/M%C3%A9taphysique">métaphysique</a>. En outre, on a assisté durant le <a title="XXe siècle" href="http://fr.wikipedia.org/wiki/XXe_si%C3%A8cle"><span title="Nombre&nbsp;écrit en chiffres romains" class="romain">XX</span><sup class="exposant">e</sup>&nbsp;siècle</a> au développement fulgurant d\'une approche <a title="Mathématiques" href="http://fr.wikipedia.org/wiki/Math%C3%A9matiques">mathématique</a> et <a title="Informatique" href="http://fr.wikipedia.org/wiki/Informatique">informatique</a> de la logique. Elle trouve de nos jours de nombreuses applications en <a title="Ingénierie" href="http://fr.wikipedia.org/wiki/Ing%C3%A9nierie">ingénierie</a>, en <a title="Linguistique" href="http://fr.wikipedia.org/wiki/Linguistique">linguistique</a>, en <a title="Psychologie" href="http://fr.wikipedia.org/wiki/Psychologie">psychologie</a> cognitive, en <a title="Philosophie analytique" href="http://fr.wikipedia.org/wiki/Philosophie_analytique">philosophie analytique</a> ou en <a title="Communication" href="http://fr.wikipedia.org/wiki/Communication">communication</a>.</p>', 21, 3, 1, 37, 'fr'),
(51, '1', 'MathÃ©matiques', '<p>Les <strong>mathï¿½matiques</strong> constituent un domaine de <a href="http://fr.wikipedia.org/wiki/Connaissance" title="Connaissance">connaissance</a> construit par des raisonnements hypothï¿½ticodï¿½ductifs, relativement ï¿½ des concepts tels que les <a href="http://fr.wikipedia.org/wiki/Nombre" title="Nombre">nombres</a>, les <a href="http://fr.wikipedia.org/wiki/G%C3%A9om%C3%A9trie" title="Gï¿½omï¿½trie">figures</a>, les <a href="http://fr.wikipedia.org/wiki/Structure_alg%C3%A9brique" title="Structure algï¿½brique">structures</a> et les <a href="http://fr.wikipedia.org/wiki/Changement" title="Changement">changements</a>. Les mathï¿½matiques dï¿½signent aussi le domaine de <a href="http://fr.wikipedia.org/wiki/Recherche_scientifique" title="Recherche scientifique">recherche</a> visant ï¿½ dï¿½velopper ces connaissances, ainsi que la <a href="http://fr.wikipedia.org/wiki/Discipline_%28sp%C3%A9cialit%C3%A9%29" title="Discipline (spï¿½cialitï¿½)">discipline</a> qui les enseigne.</p> \r\n  <p>Les mathï¿½matiques se distinguent des autres <a href="http://fr.wikipedia.org/wiki/Sciences" title="Sciences">sciences</a> par un rapport particulier au <a href="http://fr.wikipedia.org/wiki/R%C3%A9alit%C3%A9" title="Rï¿½alitï¿½">rï¿½el</a>. Elles sont de nature purement intellectuelle, basï¿½es sur des <a href="http://fr.wikipedia.org/wiki/Axiome" title="Axiome">axiomes</a> supposï¿½s <a href="http://fr.wikipedia.org/wiki/Vrai" title="Vrai">vrais</a>, non soumis ï¿½ l\'expï¿½rience (mais qui en sont souvent inspirï¿½s) ou sur des <a href="http://fr.wikipedia.org/wiki/Postulat" title="Postulat">postulats</a> provisoirement admis. Un <a href="http://fr.wikipedia.org/wiki/%C3%89nonciation" title="ï¿½nonciation">ï¿½noncï¿½ mathï¿½matique</a>, pouvant porter les noms de <a href="http://fr.wikipedia.org/wiki/Th%C3%A9or%C3%A8me" title="Thï¿½orï¿½me">thï¿½orï¿½me</a>, <a href="http://fr.wikipedia.org/wiki/Proposition_%28math%C3%A9matiques%29" title="Proposition (mathï¿½matiques)">proposition</a>, <a href="http://fr.wikipedia.org/wiki/Lemme_%28math%C3%A9matiques%29" title="Lemme (mathï¿½matiques)">lemme</a>, <a href="http://fr.wikipedia.org/w/index.php?title=Fait&amp;action=edit" class="new" title="Fait">fait</a>, <a href="http://fr.wikipedia.org/wiki/Scholie" title="Scholie">scholie</a> ou <a href="http://fr.wikipedia.org/wiki/Corollaire" title="Corollaire">corollaire</a>, est considï¿½rï¿½ comme valide lorsque le discours formel qui ï¿½tablit sa <a href="http://fr.wikipedia.org/wiki/V%C3%A9rit%C3%A9" title="Vï¿½ritï¿½">vï¿½ritï¿½</a> suit une certaine structure rationnelle appelï¿½e <a href="http://fr.wikipedia.org/wiki/D%C3%A9monstration" title="Dï¿½monstration">dï¿½monstration</a>, ou raisonnement dï¿½ductif.</p> \r\n  <p>Bien que les rï¿½sultats mathï¿½matiques soient des vï¿½ritï¿½s purement\r\nformelles ils trouvent cependant des applications remarquables dans les\r\nautres <a href="http://fr.wikipedia.org/wiki/Science" title="Science">sciences</a> et dans les domaines de la <a href="http://fr.wikipedia.org/wiki/Technique" title="Technique">technique</a>. C\'est ainsi que <a href="http://fr.wikipedia.org/wiki/Eug%C3%A8ne_Wigner" title="Eugï¿½ne Wigner">Eugï¿½ne Wigner</a> parle de <em>&quot;la dï¿½raisonnable efficacitï¿½ des mathï¿½matiques dans les sciences de la nature&quot;</em>.</p>', 21, 3, 1, 39, 'fr'),
(52, '1', 'MÃ©decine', 'La <strong>mï¿½decine</strong> (du latin mï¿½dicus : qui guï¿½rit) est la <a href="http://fr.wikipedia.org/wiki/Science" title="Science">science</a>, dont l\'objet est ï¿½ la fois l\'ï¿½tude du <a href="http://fr.wikipedia.org/wiki/Corps_humain" title="Corps humain">corps humain</a>, de son fonctionnement normal (<a href="http://fr.wikipedia.org/wiki/Physiologie" title="Physiologie">physiologie</a>), ainsi que de la conservation de la santï¿½ ( <a href="http://fr.wikipedia.org/wiki/Prophylaxie" title="Prophylaxie">prophylaxie</a> ) , des dysfonctionnements ( <a href="http://fr.wikipedia.org/wiki/Pathologie" title="Pathologie">pathologie</a>) et enfin des divers moyens pour obtenir le rï¿½tablissement de la <a href="http://fr.wikipedia.org/wiki/Sant%C3%A9" title="Santï¿½">santï¿½</a> ( <a href="http://fr.wikipedia.org/wiki/Th%C3%A9rapie" title="Thï¿½rapie">thï¿½rapie</a>).', 21, 3, 1, 41, 'fr'),
(53, '1', 'Physique', 'La <strong>physique</strong> (du <a title="Grec ancien" href="http://fr.wikipedia.org/wiki/Grec_ancien">grec</a> <span lang="gr" xml:lang="gr" class="lang-gr">&#966;&#965;&#963;&#953;&#954;&#951;</span>, la nature)<span lang="gr" xml:lang="gr" class="lang-gr"> </span>est étymologiquement la «&nbsp;<a title="Science" href="http://fr.wikipedia.org/wiki/Science">science</a> de la <a title="Nature" href="http://fr.wikipedia.org/wiki/Nature">nature</a>&nbsp;». Dans un sens général et ancien, la physique désigne la connaissance de toute la nature matérielle&nbsp;; c\'est le sens de <a title="René Descartes" href="http://fr.wikipedia.org/wiki/Ren%C3%A9_Descartes">René Descartes</a> et de ses élèves <a title="Jacques Rohault" href="http://fr.wikipedia.org/wiki/Jacques_Rohault">Jacques Rohault</a> et <a title="Sylvain Leroy" href="http://fr.wikipedia.org/wiki/Sylvain_Leroy">Régis</a><sup class="reference" id="_ref-0"><a href="http://fr.wikipedia.org/wiki/Physique#_note-0"><span class="cite_crochet"></span><span class="cite_crochet"></span></a></sup>. Elle correspond alors aux <a title="Sciences naturelles" href="http://fr.wikipedia.org/wiki/Sciences_naturelles">sciences naturelles</a> ou encore à la <a title="Philosophie naturelle" href="http://fr.wikipedia.org/wiki/Philosophie_naturelle">philosophie naturelle</a>. Au XXI<sup class="exposant">e</sup>\r\nsiècle, sa signification est néanmoins plus restreinte&nbsp;: elle décrit de\r\nfaçon à la fois quantitative et conceptuelle les composants\r\nfondamentaux de l\'univers, les <a title="Force (physique)" href="http://fr.wikipedia.org/wiki/Force_%28physique%29">forces</a> qui s\'y exercent et leurs effets. Elle développe des <a title="Théorie" href="http://fr.wikipedia.org/wiki/Th%C3%A9orie">théories</a> en utilisant l\'outil des <a title="Mathématiques" href="http://fr.wikipedia.org/wiki/Math%C3%A9matiques">mathématiques</a>\r\npour décrire et prévoir l\'évolution de systèmes. La signification\r\nancienne de la physique rassemble l\'actuelle physique, la chimie et les\r\nsciences naturelles actuelles<sup class="reference" id="_ref-1"><a href="http://fr.wikipedia.org/wiki/Physique#_note-1"><span class="cite_crochet"></span><span class="cite_crochet"></span></a></sup>. \r\n  <p>La physique n\'accepte comme résultat que ce qui est <a title="Métrologie" href="http://fr.wikipedia.org/wiki/M%C3%A9trologie">mesurable</a> et <a title="Reproductible" href="http://fr.wikipedia.org/wiki/Reproductible">reproductible</a> par <a title="Méthode expérimentale" href="http://fr.wikipedia.org/wiki/M%C3%A9thode_exp%C3%A9rimentale">expérience</a>. Cette méthode permet de confirmer ou d\'infirmer les <a title="Hypothèse" href="http://fr.wikipedia.org/wiki/Hypoth%C3%A8se">hypothèses</a> fondées sur une <a title="Théorie" href="http://fr.wikipedia.org/wiki/Th%C3%A9orie">théorie</a> donnée.</p>', 21, 3, 1, 43, 'fr'),
(54, '1', 'Sciences de la Terre et de l\'Univers', 'Les <strong>sciences de la Terre</strong> regroupent les <a href="http://fr.wikipedia.org/wiki/Science" title="Science">sciences</a> dont l\'objet est l\'ï¿½tude de la <a href="http://fr.wikipedia.org/wiki/Terre" title="Terre">Terre</a> (<a href="http://fr.wikipedia.org/wiki/Lithosph%C3%A8re" title="Lithosphï¿½re">lithosphï¿½re</a>, <a href="http://fr.wikipedia.org/wiki/Hydrosph%C3%A8re" title="Hydrosphï¿½re">hydrosphï¿½re</a> et <a href="http://fr.wikipedia.org/wiki/Atmosph%C3%A8re_de_la_Terre" title="Atmosphï¿½re de la Terre">atmosphï¿½re</a>) et de son environnement spatial ; en tant que <a href="http://fr.wikipedia.org/wiki/Plan%C3%A8te" title="Planï¿½te">planï¿½te</a>,\r\nla Terre peut servir de paradigme ï¿½ l\'ï¿½tude d\'autres planï¿½tes et,\r\ndepuis que des sondes spatiales permettent d\'explorer d\'autres objets\r\ndu <a href="http://fr.wikipedia.org/wiki/Syst%C3%A8me_solaire" title="Systï¿½me solaire">systï¿½me solaire</a>, la <a href="http://fr.wikipedia.org/wiki/Plan%C3%A9tologie" title="Planï¿½tologie">planï¿½tologie</a> est aussi classï¿½e parmi les sciences de la Terre. Celle-ci ï¿½tudie notamment la <a href="http://fr.wikipedia.org/wiki/Lune" title="Lune">Lune</a>, les <a href="http://fr.wikipedia.org/wiki/Plan%C3%A8te" title="Planï¿½te">planï¿½tes</a> et leurs <a href="http://fr.wikipedia.org/wiki/Satellite_naturel" title="Satellite naturel">satellites naturels</a>, les <a href="http://fr.wikipedia.org/wiki/Ast%C3%A9ro%C3%AFde" title="Astï¿½roï¿½de">astï¿½roï¿½des</a>, les <a href="http://fr.wikipedia.org/wiki/M%C3%A9t%C3%A9orite" title="Mï¿½tï¿½orite">mï¿½tï¿½orites</a> et les <a href="http://fr.wikipedia.org/wiki/Com%C3%A8te" title="Comï¿½te">comï¿½tes</a>.', 21, 3, 1, 45, 'fr');
# --------------------------------------------------------

#
# Structure de la table `qcm_theme_favori`
#

DROP TABLE IF EXISTS `qcm_theme_favori`;
CREATE TABLE `qcm_theme_favori` (
  `id_theme_favori` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `idutilisateur_rel` bigint(20) unsigned NOT NULL default '0',
  `idtheme_rel` bigint(20) unsigned NOT NULL default '0',
  `datecreation` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_theme_favori`),
  KEY `idutilisateur_rel` (`idutilisateur_rel`,`idtheme_rel`)
) TYPE=MyISAM;

#
# Contenu de la table `qcm_theme_favori`
#

INSERT INTO `qcm_theme_favori` (`id_theme_favori`, `visible`, `idutilisateur_rel`, `idtheme_rel`, `datecreation`) VALUES (3, '0', 29, 15, 0),
(4, '0', 29, 15, 0),
(5, '0', 29, 15, 0),
(6, '0', 29, 16, 0),
(7, '0', 29, 25, 0);
# --------------------------------------------------------

#
# Structure de la table `qcm_utilisateur`
#

DROP TABLE IF EXISTS `qcm_utilisateur`;
CREATE TABLE `qcm_utilisateur` (
  `idutilisateur` bigint(20) unsigned NOT NULL auto_increment,
  `visible` enum('1','0') NOT NULL default '1',
  `compte` varchar(100) NOT NULL default '',
  `motpasse` varchar(20) NOT NULL default '',
  `nom` varchar(100) NOT NULL default '',
  `prenom` varchar(100) NOT NULL default '',
  `pseudonyme` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `idequipe_rel` bigint(20) unsigned NOT NULL default '0',
  `admin` enum('0','1') NOT NULL default '0',
  `responsabledelegue` enum('0','1') NOT NULL default '0',
  `email` varchar(100) NOT NULL default '',
  `autrescontacts` text NOT NULL,
  `datecreation` int(11) NOT NULL default '0',
  `datederniereconnection` int(11) NOT NULL default '0',
  `dateentreeequipe` int(11) NOT NULL default '0',
  `activation` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`idutilisateur`),
  UNIQUE KEY `compte` (`compte`),
  KEY `idequipe_rel` (`idequipe_rel`)
) TYPE=MyISAM;

#
# Contenu de la table `qcm_utilisateur`
#

INSERT INTO `qcm_utilisateur` (`idutilisateur`, `visible`, `compte`, `motpasse`, `nom`, `prenom`, `pseudonyme`, `description`, `idequipe_rel`, `admin`, `responsabledelegue`, `email`, `autrescontacts`, `datecreation`, `datederniereconnection`, `dateentreeequipe`, `activation`) VALUES (6, '1', 'dada', 'b01abf84324066bdb4ee', 'Eternel', 'Legende', 'Grimoire', 'xaxa\r\nxaxa\r\nxaxa', 0, '1', '0', 'eternel7@gmail.com', 'dada', 1135358811, 1199206807, 0, '1'),
(21, '1', 'EmiMaGiK', '74c829721ad98863034f', '', '', '', '', 0, '1', '0', 'emimagik@hotmail.fr', '', 1140474822, 1195913300, 0, '1'),
(22, '1', 'eMi', 'b6dd9f9058a30970f02d', 'RaF', 'Pavoni', 'eMi', '', 0, '0', '0', 'emimagik@hotmail.fr', '', 1195909902, 0, 0, '0'),
(23, '1', 'arts', '96930e61e073920d9327', 'arts', 'arts', 'arts', '', 0, '0', '0', 'arts@arts.arts', '', 1198939718, 1199193415, 0, '1'),
(24, '1', 'test1', '098f6bcd4621d373cade', 'test', 'test', '', '', 0, '0', '0', 'test@test.test', '', 1199193982, 0, 0, '0'),
(25, '1', 'test2', '098f6bcd4621d373cade', 'test', '', '', '', 0, '0', '0', 'test@test.test', '', 1199194387, 0, 0, '0'),
(26, '1', 'test3', '098f6bcd4621d373cade', '', '', '', '', 0, '0', '0', 'test@test.test', '', 1199194445, 0, 0, '0'),
(27, '1', 'test4', '098f6bcd4621d373cade', '', '', '', '', 0, '0', '0', 'test@test.test', '', 1199194491, 0, 0, '0'),
(28, '1', 'test5', '098f6bcd4621d373cade', '', '', '', '', 0, '0', '0', 'test@test.test', '', 1199194757, 0, 0, '0'),
(29, '1', 'test6', '098f6bcd4621d373cade', 'Test6', '', '', '', 0, '0', '0', 'test@test.test', '', 1199194879, 1199195269, 0, '1'),
(30, '1', 'test7', '098f6bcd4621d373cade', '', '', '', '', 0, '0', '0', 'test@test.test', '', 1199195202, 0, 0, '0');
# --------------------------------------------------------

#
# Structure de la table `qcm_z_regle`
#

DROP TABLE IF EXISTS `qcm_z_regle`;
CREATE TABLE `qcm_z_regle` (
  `idregle` bigint(20) unsigned NOT NULL auto_increment,
  `nom` varchar(100) NOT NULL default '',
  `description` text NOT NULL,
  `valeur` varchar(25) NOT NULL default '',
  `listechoix` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`idregle`),
  UNIQUE KEY `nom` (`nom`)
) TYPE=MyISAM COMMENT='interdiction d insertion de ligne si pas développeur';

#
# Contenu de la table `qcm_z_regle`
#

INSERT INTO `qcm_z_regle` (`idregle`, `nom`, `description`, `valeur`, `listechoix`) VALUES (1, 'Confirmation_mot_de_passe', 'Parametre demandant la confirmation du mot de passe lors de la creation d\'un compte utilisateur.', '0', '1|0'),
(2, 'Confirmation_email', 'Parametre demandant la confirmation de l\'email lors de la creation d\'un compte utilisateur.', '0', '1|0'),
(3, 'Activation_par_mail', 'Activation du compte d\'un utilisateur par clic sur un lien envoye a l\'email correspondant au compte.', '1', '1|0'),
(4, 'liste_equipe', 'Champ affiche dans les listes de choix sur la table equipe.', 'titre', 'titre|intitule'),
(5, 'liste_question', 'Champ affiche dans les listes de choix sur la table question.', 'titre', 'titre|intitule'),
(6, 'liste_theme', 'Champ affiche dans les listes de choix sur la table theme.', 'titre_arbo', 'titre|intitule|titre_arbo|intitule_arbo'),
(7, 'Format_date', 'Gestion de l\'affichage des dates par l\'intermédiaire de la fonction date() en php', 'd/m/Y', 'voir la fonction date() en php'),
(8, 'liste_questionnaire', 'Champ affiche dans les listes de choix sur la table questionnaire.', 'titre', 'titre|intitule'),
(9, 'tri_theme', 'Ordre de tri dans l\'arborescence des themes', 'titre', 'titre|intitule'),
(10, 'premier_caractere_arbo_theme', 'Premier caractere dans la presentation arborescente des themes.', '', 'choix libre'),
(11, 'indentation_arbo_theme', 'Caractere d\'indentation dans la représentation arborescente des themes.', '&nbsp;&nbsp;&nbsp;&nbsp;', 'choix libre'),
(12, 'Activation_AJAX', 'Autorisation de l\'utilisation d\'AJAX pour certaine fonctionnalité.', '1', '0|1'),
(13, 'Note_max', 'Note maximum que l\'on peut donner a une reponse et nombre maximum appliqué au tinyint.', '20', '');