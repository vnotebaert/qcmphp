# phpMyAdmin MySQL-Dump
# version 2.2.6
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Serveur: localhost
# Généré le : Dimanche 03 Septembre 2006 à 21:51
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

INSERT INTO `qcm_auteur` (`idauteur`, `visible`, `idutilisateur_rel`, `idtheme_rel`, `validation`, `idutilisateur_validateur_rel`, `datevalidation`, `correcteur`, `dateaccordcorrecteur`) VALUES (1, '1', 1, 1, '1', 0, 0, '0', 0),
(2, '1', 20, 1, '1', 0, 0, '0', 0),
(3, '1', 20, 2, '1', 0, 0, '0', 0);
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

INSERT INTO `qcm_choix` (`idchoix`, `visible`, `idquestion_rel`, `titre`, `intitule`, `vraifaux`, `valeur`) VALUES (1, '1', 1, '', 'Le géant vert.', '1', 10),
(2, '1', 1, '', 'Moi bien sûr!', '0', 0),
(3, '1', 1, '', 'Bigfoot', '0', 0),
(4, '1', 2, '', 'Mais qui c\\\'est ce Balthazar????', '0', 0),
(5, '1', 2, '', 'Gandalf', '1', 2),
(6, '1', 2, '', 'Mappal', '0', -10),
(7, '1', 3, '', 'Couillon', '0', 0),
(8, '1', 5, '', 'Coucou', '0', 0),
(9, '1', 15, '', 'Monstrueux Sux', '0', 0),
(10, '1', 15, '', 'Massa Susetes', '0', -15),
(11, '1', 15, '', 'Mitraillette Super-puissante', '0', -4),
(12, '1', 15, '', 'Moule Shot', '1', 5),
(13, '1', 16, '', 'Un niveau de jeu', '0', -5),
(14, '1', 16, '', 'Une arme des terroristes', '0', 0),
(15, '1', 16, '', 'Une arme des contre-terroristes', '1', 5),
(16, '1', 16, '', 'Une grenade Flash-bang', '0', 0),
(17, '1', 17, '', 'World Agonie', '0', -30),
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
(32, '1', 18, '', 'Un(e) Petit(e) Gars Moulu', '0', -5),
(33, '1', 18, '', 'Un Progamer', '1', 10),
(34, '1', 18, '', 'Une Partie Gagnée Merdique', '0', -3);
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
  `type` enum('unique','unique_liste','multiple','multiple_liste','mot','texte') NOT NULL default 'unique',
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

INSERT INTO `qcm_question` (`idquestion`, `visible`, `idquestionnaire_rel`, `ordre`, `titre`, `intitule`, `solution`, `type`, `niveau`, `idutilisateur_auteur_rel`, `validation`, `idutilisateur_validateur_rel`, `datecreation`, `datevalidation`, `textevalidation`) VALUES (15, '1', 6, 1, 'FPS', 'Que veut dire <STRONG>MS</STRONG> dans les <STRONG>FPS</STRONG>? ', 'Moule Shot', 'unique', 0, 21, '1', 6, 1140472579, 1155657632, 'Ok'),
(16, '1', 6, 2, 'FPS', 'Dans <STRONG>Counter-Strike</STRONG> qu\'est-ce qu\'une <STRONG>4.3</STRONG>? ', 'Le <STRONG>M4a1</STRONG>, une arme des contre-terroristes de la catégorie des fusils d\'assault. ', 'unique', 0, 21, '1', 6, 1140473157, 1155657632, 'Ok'),
(17, '1', 6, 3, 'FPS', 'Qu\'est qu\'un <STRONG>WA</STRONG> dans une équipe de jeu en réseau? ', 'Un War Arranger :<BR>\r\nPersonne chargée d\'organiser les matchs avec les autres équipes.', 'unique', 0, 21, '1', 6, 1140473495, 1155657632, 'Ok'),
(18, '1', 6, 5, 'Général', 'Qu\'est-ce qu\'un ou une <STRONG>PGM</STRONG>? ', 'Un Pro-Gamer\r\n<OL>\r\n<LI> Joueur professionnel</LI>\r\n<LI> Joueur qui joue pour gagner et qui se vante de son niveau</LI>\r\n</OL>', 'unique', 0, 21, '1', 6, 1140474194, 1155657632, 'Ok'),
(19, '1', 6, 4, 'FPS', 'Au cours d\'un match, qu\'est-ce qu\'un <STRONG>RS</STRONG>? ', 'Un restart.\r\n<P>Un redémarrage du la partie avec mise à zéro des scores et du temps de jeu.</P>\r\n<P>Il est effectué avant le début de tout match afin de l\'initialiser.</P>', 'unique', 0, 21, '1', 6, 1140474415, 1155657632, 'Ok'),
(20, '1', 6, 6, 'MMORPG', 'Qu\'est qu\'un <STRONG>BUFF</STRONG>? ', 'Un sort augmentant les capacités du ou des personnages pendant un certain temps.', 'unique', 0, 21, '1', 6, 1140475659, 1155657632, 'Ok');
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

INSERT INTO `qcm_questionnaire` (`idquestionnaire`, `visible`, `idtheme_rel`, `titre`, `intitule`, `tempsminimum`, `tempsmaximum`, `niveau`, `idutilisateur_auteur_rel`, `validation`, `idutilisateur_validateur_rel`, `datecreation`, `datevalidation`, `textevalidation`) VALUES (1, '1', 1, 'Essai', 'coucou', 120, 600, 0, 20, '0', 0, 0, 0, ''),
(2, '1', 1, 'Essai', 'coucou', 120, 600, 0, 20, '0', 0, 0, 0, ''),
(3, '1', 1, 'Essai', 'coucou', 120, 600, 0, 20, '0', 0, 0, 0, ''),
(4, '1', 11, 'Essai', 'coucou', 120, 600, 0, 20, '0', 0, 0, 0, ''),
(5, '1', 2, 'Coucou', 'Taratata', 120, 600, 0, 6, '0', 0, 1140269696, 0, ''),
(6, '1', 1, 'Language de jeux video', '<P>Comprenez vous ou parlez vous courement le language des joueurs des salles en réseau?</P>\r\n<P>Ils jouent aux <STRONG>FPS</STRONG> et aux <STRONG>MMORPG</STRONG>, mais qu\'est-ce donc?</P>', 120, 600, 0, 21, '1', 6, 1140472174, 1155657632, 'Ok');
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

INSERT INTO `qcm_reponse` (`idreponse`, `visible`, `idutilisateur_rel`, `idchoix_rel`, `datereponse`, `mot`, `texte`, `idutilisateur_correcteur_rel`, `datecorrection`, `textecorrection`, `idquestion_rel`) VALUES (1, '1', 6, 29, 1157311555, '', '', 0, 0, '', 20),
(2, '1', 6, 12, 1157311602, '', '', 0, 0, '', 15);
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

INSERT INTO `qcm_theme` (`idtheme`, `visible`, `titre`, `intitule`, `idtheme_rel`, `niveau`, `taille`, `bornegauche`, `langue`) VALUES (1, '1', 'Classement des thèmes', '<P> </P>', 0, 1, 27, 1, 'fr'),
(2, '1', 'Loisir', 'Jeux, jardinerie,...', 1, 2, 17, 10, 'fr'),
(3, '1', 'Jeux vidéos', '<P><FONT face="arial, helvetica, sans-serif">Les jeux vidéos sont un loisir ludique interactif. L\'essor d\'Internet à ouvert les jeux vidéos à une dimmension multijoueur inégalable.</FONT></P>', 2, 3, 5, 21, 'fr'),
(4, '1', 'Coucou1', '', 2, 3, 3, 11, 'fr'),
(5, '1', 'Coucou2', '', 2, 3, 5, 15, 'fr'),
(6, '1', 'essai', '', 4, 4, 1, 12, 'fr'),
(7, '1', 'hard', '', 3, 4, 3, 22, 'fr'),
(8, '1', 'autre', '<P align=center>daaddada<U>dadada<EM>da<STRONG>da<STRIKE>dada<SUB>dada</SUB><SUP>dada</SUP></STRIKE></STRONG></EM></U></P>', 1, 2, 7, 2, 'fr'),
(9, '1', 'testniveau', 'dad<U>dadaadda<EM>dada<STRONG>daqsq</STRONG></EM></U>', 5, 4, 3, 16, 'fr'),
(10, '1', 'sccs', '<P><STRONG>sc</STRONG></P>\r\n<P><SUB>sccs</SUB></P>\r\n<P>*cs</P>', 9, 5, 1, 17, 'fr'),
(11, '1', 'dada', '', 8, 3, 1, 5, 'fr'),
(12, '1', 'dada', '', 8, 3, 1, 3, 'fr'),
(13, '1', 'dada', '', 8, 3, 1, 7, 'fr');
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

INSERT INTO `qcm_utilisateur` (`idutilisateur`, `visible`, `compte`, `motpasse`, `nom`, `prenom`, `pseudonyme`, `description`, `idequipe_rel`, `admin`, `responsabledelegue`, `email`, `autrescontacts`, `datecreation`, `datederniereconnection`, `dateentreeequipe`, `activation`) VALUES (1, '1', 'mS From dz', 'b01abf84324066bdb4ee', 'MASSE', 'David', 'eternel', 'dadadadasasaxaxa', 0, '0', '0', 'da@dada.com', 'dadadadasasaw\r\nasaxxa', 1135107243, 1140555894, 0, '1'),
(6, '1', 'dada', 'b01abf84324066bdb4ee', 'Eternel', 'Legende', 'Grimoire', 'xaxa\r\nxaxa\r\nxaxa', 0, '1', '0', 'eternel7@caramail.com', 'dada', 1135358811, 1157284628, 0, '1'),
(19, '1', 'da', '5ca2aa845c8cd5ace6b0', 'da', '', '', '', 0, '0', '0', 'da@da.com', '', 1135963505, 1140428569, 0, '1'),
(20, '1', 'dadada', 'b01abf84324066bdb4ee', 'David', 'Legende', 'Grimoire', 'xaxa\r\nxaxa\r\nxaxa', 0, '0', '0', 'eternel7@caramail.com', 'dada', 1135358811, 1139436935, 0, '1'),
(21, '1', 'EmiMaGiK', '74c829721ad98863034f', '', '', '', '', 0, '1', '0', 'emimagik@hotmail.fr', '', 1140474822, 1140548262, 0, '1');
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
(11, 'indentation_arbo_theme', 'Caractere d\'indentation dans la représentation arborescente des themes.', '&nbsp;&nbsp;&nbsp;&nbsp;', 'choix libre');

