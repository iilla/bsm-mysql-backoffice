<?php //Remember you used short_tags in this project. @Blackwood
	include "../config/bsm_ubicador.php";
	include CONF."bsm_settings.php";
	


	session_start();
	if ($ADM_SEC == 1) {
		if (isset($_POST['logon'])) {
			if ($_POST['username']==$ADM_USR && $_POST['password']==$ADM_PWD) {
				$_SESSION['user_logged'] = $ADM_USR;
				$_SESSION['user_password'] =$ADM_PWD;
				header("Location: ./bsm_home.php");
			} else {
				header("Location: ./bsm_login.php?errlog=1");
			}
		} elseif ($_SESSION['user_logged'] == "" || $_SESSION['user_password'] == "") {
			header("Location: ./bsm_login.php");
		} else {
			header ("Location: ./bsm_home.php");
		}
	} else {
		header ("Location: ./bsm_home.php");
	}
?>