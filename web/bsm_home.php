<?php
/* Author: Blackwood */
header('Content-Type: text/html; charset=utf-8');
require_once "../config/bsm_ubicador.php";
require_once CONF."bsm_settings.php";

if ($ADM_SEC==1) {
	session_start();
	if ($_SESSION['user_logged'] == "" || $_SESSION['user_password'] == "") {
		header ("Location: ./index.php");
	}
}

if (isset($_REQUEST['logout']) && $_REQUEST['logout']==1 && $ADM_SEC==1) {
		session_unset($_SESSION['user_logged']);
		session_unset($_SESSION['user_password']);
		header ("Location: ./index.php");
}

?>

<!DOCTYPE html> 
<html>
	<head> 
		<title><?=$APP_NAME?></title>
		<meta charset="utf-8">
		<meta name="title" content="<?=$APP_NAME?>" />
		<meta property="og:title" content="<?=$APP_NAME?>" />
		
		<link rel="stylesheet" href="<?=CSS."bsm_basestyle.css"?>" type="text/css" media="screen, projection, print" />	
		<link rel="stylesheet" href="<?=CSS."bsm_style.css"?>" type="text/css" media="screen, projection, print" />
		
		

		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
		<!-- <script type="text/javascript" src="<?=JS."jquery-1.9.1.min.js"?>"></script> -->
		<script type="text/javascript" src="<?=JS."bsm_scripts.js"?>"></script>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-1LD68LTBRZ"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-1LD68LTBRZ');
		</script>
	</head>
	<body>
		<? require_once CONF."bsm_database.php"; ?>
		<div id="container">
			<div id="header"> <img src="<?=IMG."bsm_cabecera.jpg"?>"/></div>
			<div id="content">
				<div id="leftside-menu">
					<div id="menu-left-title" class="menu-left-item">Listado de tablas</div>
					<?
						$dbinfo = $DB_CONN->infoTables();
						$found = false;
						if ($ENABLE_TAB_FILTER!=0) {
							for ($i=0;$i<count($dbinfo);$i++) {
								if (in_array($dbinfo[$i]['name'],$TAB_FILTER)) {
									$dbinfo_selected[] = $dbinfo[$i];
									$found = true;
								}
							}
						} else {
							$found = true;
							$dbinfo_selected = $dbinfo;
						} 
						
						if ($found) {
							$selectedTable = (isset($_REQUEST['menuSel']))?$dbinfo_selected[$_REQUEST['menuSel']]['name']:$dbinfo_selected[0]['name'];
							$tableIndex = (isset($_REQUEST['menuSel']))?$_REQUEST['menuSel']:0;
							for ($i=0;$i<count($dbinfo_selected);$i++) {
								if (!isset($_REQUEST['menuSel']) && $i==0) {
									$selected = "selected";
								} elseif (isset($_REQUEST['menuSel']) && $_REQUEST['menuSel']==$i) {
									$selected = "selected";
								} else {
									$selected = "";
								}
								echo "<div id='menu-".$i."' class='menu-left-item ".$selected."'> <a href='?menuSel=".$i."'>".$dbinfo_selected[$i]['name']."</a></div>";
							}
						}
					?>
				</div>
				<div id="info-displayer">
					<? 
						if ($found) {
							include INC."inc.genericdatadisplayer.php";
						} else {
							$displayMsg = "No hay tablas en la base de datos.<br>";
							include INC."inc.msgbox.php";					
						}
					?>
				</div>		
			</div>
		</div>
		<div class="clear"> </div>
 
		<div id="footer">
			<div id="center_foot">
				<? if ($ADM_SEC==1) { ?>
					<a id="logout" href="?logout=1">logout&nbsp;&nbsp;<img src="<?=IMG."bsm_logout.gif"?>"/></a>
				<? } ?>
			</div>
		</div>

	</body>
</html>
