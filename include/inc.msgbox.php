<div id="msgbox">
	<?
		if (!isset($displayMsg)) {
			echo "Bienvenido a <b>".$APP_NAME."</b><br />";
			echo "<center>Pulsa una de las tablas para comenzar.</center>";
		} else {
			echo "<center><b>".$APP_NAME."</b></center><br />";
			echo "<center>".utf8_encode($displayMsg)."</center>";
		}
	?>
</div>