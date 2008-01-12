<?php
/*
 * Cree le 21 decembre 2007
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  include d'authentification de QCM_PHP
 *
 */
?>
<div class="dragableBox" id="lconnexion">
	<h3 class="connexion"><span><? echo _CONNEXION; ?></span></h3>
	<ul>
		<li>
			<div id="compte_utilisateur">
				<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" id="compte_utilisateur_form">
					<?
					if ($utilisateur_connecte->_testauthentification!=2) 
					{
						?>
						<div id="compte_cadre">
							<span><? echo _COMPTE; ?></span><input type="text" name="compte" id="compte" size="10" />
						</div>
						<div id="motdepasse_cadre">
							<span><? echo _MOT_DE_PASSE; ?></span><input type="password" name="motdepasse" id="motdepasse" size="10" />
						</div>
						<div id="connexionautomatique_cadre">
							<span><? echo _CONNEXION_AUTOMATIQUE; ?></span><input type="checkbox" name="connexionautomatique" id="connexionautomatique" size="10" />
						</div>
						<div class="bouton_cadre">
							<input type="submit" value="<? echo _BOUTON_OK; ?>" />
						</div>
						<div id="creation_compte">
							<span><a href="compte.php" title="<? echo _CREATION_COMPTE_TITRE; ?>" accesskey="c"><? echo _CREATION_COMPTE_LIEN ; ?></a>&nbsp;</span>
						</div>
						<?
					}
					if ($utilisateur_connecte!="") 
					{
						if (in_array($utilisateur_connecte->_testauthentification,array(2,1)) && $utilisateur_connecte->avatarurl!="") 
						{
							//chargement de l'environnement pour la fonction de balise image :
							require_once('conf.site.inc.php');
							global $adresserepertoiresite;
							global $adressehttpsite;
							require_once($adresserepertoiresite.'/scripts/php/class.environnement.php');
							$toto = new environnement();
							$toto->image($utilisateur_connecte->avatarurl,"","avatar");
						}?>
						<ul>
							<li><? echo $utilisateur_connecte->authentification(); ?>&nbsp;</li>
							<?
							if (in_array($utilisateur_connecte->_testauthentification,array(2,1)))
							{
								?>
								<li><a href="compte.php?modif=1" title="<? echo _MODIFICATION_COMPTE_TITRE; ?>" accesskey="m"><? echo _MODIFICATION_COMPTE_LIEN;?></a>&nbsp;</li>
								<?
							}
							?>
						</ul>
						<?
					}
					?>
				</form>
			</div>
		</li>
	</ul>
</div>
<?
?>