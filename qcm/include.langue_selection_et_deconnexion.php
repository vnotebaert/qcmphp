<?php
/*
 * Cree le 21 decembre 2007
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  include du choix de la langue de QCM_PHP
 *
 */
?>
<script type="text/javascript">
	<!--
	function setlangueconfig(){
		// create an instance of the Date object
		var now = new Date();
		// fix the bug in Navigator 2.0, Macintosh
		fixDate(now);
		// cookie expires in one year
		now.setTime(now.getTime() + 365*24*60*60*1000);
		var langue=document.getElementById('langue_utilisateur_form').langue.value;
		setCookie('langue', langue, now, "", "", false);
	}
	//-->
</script>
<div class="dragableBox" id="llangue_selection">
	<h3 class="langue_selection"><span><? echo _LANGUE_SELECTION_TITRE; ?></span></h3>
	<ul>
		<li>
			<div id="langue_selection">
				<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" id="langue_utilisateur_form">
					<div id="langue_cadre">
						<span><? echo _LANGUE_SELECTION; ?></span>
						<select name="langue">
						<?
						$langues_dispo=langue_possible();
						foreach ($langues_dispo as $valeur) {
							echo "<option value=\"".$valeur."\"";
							if ($langue==$valeur) echo " selected=\"selected\"";
							echo ">".$valeur."</option>\n";
							}
						?>
						</select>
					</div>
					<div class="bouton_cadre">
						<input type="submit" value="<? echo _BOUTON_OK; ?>" onclick="setlangueconfig()" />
					</div>
				</form>
			</div>
		</li>
		<?
		if ($utilisateur_connecte!="") 
		{
			?>
			<li><? echo $utilisateur_connecte->authentification(); ?>&nbsp;</li>
			<?
		}
		?>
	</ul>
</div>
<?
?>