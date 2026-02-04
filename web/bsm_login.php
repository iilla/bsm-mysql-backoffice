<?php	
	header('Content-Type: text/html; charset=utf-8');
	include "../config/bsm_ubicador.php";
	include CONF."bsm_settings.php";
	
?>
<html>
	<head> 
		<title><?=$APP_NAME?></title>
		<meta charset="utf-8">
		<meta name="title" content="<?=$APP_NAME?>" />
		<meta property="og:title" content="<?=$APP_NAME?>" />
		
		<link rel="stylesheet" href="<?=CSS."bsm_basestyle.css"?>" type="text/css" media="screen, projection, print" />	
		<link rel="stylesheet" href="<?=CSS."bsm_style.css"?>" type="text/css" media="screen, projection, print" />
		<script type="text/javascript" src="<?=JS."bsm_scripts.js"?>"></script>
	</head>
	<body>
	<div id="login_screen">
			<center><p style="color:black"><b><?=$APP_NAME?></b></p></center>
				<br />
				<form name="bsm_login" action="index.php" autocomplete="OFF" method="post">
				<input type="hidden" name="logon" value="1">
					<table border="0" width="100%">
						<tr>
							<td align="right"> <span style="color:#E9E9E9"> Usuario &nbsp;&nbsp;&nbsp;</span> </td>
							<td> <input name="username" type="text" value="sample"/> </td>
							<td rowspan="2"> <img src="<?=IMG."bsm_login.jpg"?>" /> </td>
						</tr>
						<tr>
							<td align="right"> <span style="color:#E9E9E9"> Contraseña &nbsp;&nbsp;&nbsp;</span> </td>						
							<td> <input name="password" type="password" value="sample"/> </td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<input type="submit" name="submit" value="Login" />
								<input type="reset" value="Reset" />
							</td>
						</tr>
					</table>
					<?if (isset($_REQUEST['errlog'])) { ?>
						<span style="color:red;position:absolute;bottom:14px;left:110px;">Usuario o contraseña incorrectos</span>  
					<? }?>
				</form>
		</div>
	</body>
</html>