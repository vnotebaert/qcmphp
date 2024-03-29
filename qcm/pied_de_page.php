<?php
/*
 * Cree le 7 janv. 2006
 *
 * Auteur : David MASSE alias eternel ou Baal Hazgard
 * Email : eternel7@gmail.com
 * Description :  Pied de page des pages de QCM avec test du XHTML, CSS, 508 et AAA
 * 
 */
?>
<div id="pieddepage">
	<ul>
		<li><a href="http://validator.w3.org/check/referer" title="Check the validity of this site&#8217;s XHTML">xhtml</a> &nbsp; </li>
		<li><a href="http://jigsaw.w3.org/css-validator/check/referer" title="Check the validity of this site&#8217;s CSS">css</a> &nbsp; </li>
		<li><a href="http://bobby.watchfire.com/bobby/bobbyServlet?URL=http%3A%2F%2F<? echo str_replace("/", "%2F", $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>&amp;output=Submit&amp;gl=sec508&amp;test=" title="Check the accessibility of this site according to U.S. Section 508">508</a> &nbsp;</li>
		<li><a href="http://bobby.watchfire.com/bobby/bobbyServlet?URL=http%3A%2F%2F<? echo str_replace("/", "%2F", $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']); ?>&amp;output=Submit&amp;gl=wcag1-aaa&amp;test=" title="Check the accessibility of this site according to WAI Content Accessibility Guidelines 1">aaa</a> &nbsp;</li>
	</ul>
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
	<script type="text/javascript">
		var pageTracker = _gat._getTracker("UA-3391184-1");
		pageTracker._initData();
		pageTracker._trackPageview();
	</script>
</div>