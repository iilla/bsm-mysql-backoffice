<?php

	//Datos de conexión para la base de datos

	/*
	$DB_SET["db-type"]= "mysql";
	$DB_SET["db-hostname"]= "www.krowtennetwork.com";
	$DB_SET["db-username"]= "strd_user";
	$DB_SET["db-password"]= "pilota.21.]";
	$DB_SET["db-name"]= "stradivarius";
	*/
	
	/*
	$DB_SET["db-type"]= "mysql";
	$DB_SET["db-hostname"]= "www.krowtennetwork.com";
	$DB_SET["db-username"]= "blog_25";
	$DB_SET["db-password"]= "tng.10.24";
	$DB_SET["db-name"]= "krowtennetwork_blog";
	*/
	
	/*
	$DB_SET["db-type"]= "mysql";
	$DB_SET["db-hostname"]= "joangwilkinson.ipagemysql.com";
	$DB_SET["db-username"]= "asaidb";
	$DB_SET["db-password"]= "1234";
	$DB_SET["db-name"]= "asaidb";
	*/
	
	//$DB_SET["db-type"]= "mysql";
	/*
	$DB_SET["db-hostname"]= "rdbms.strato.de";
	$DB_SET["db-username"]= "U2832870";
	$DB_SET["db-password"]= "RvPU1cVqkTIxyTq7E";
	$DB_SET["db-name"]= "DB2832870";
	*/

	$DB_SET["db-hostname"]= "sql202.epizy.com";
	$DB_SET["db-username"]= "epiz_25365282";
	$DB_SET["db-password"]= "XygFwLvKnc2CL79";
	$DB_SET["db-name"]= "epiz_25365282_portfolio_asai";

	//Nombre de la aplicación
	$APP_NAME = "BACKOFFICE - STRADIVARIUS MAGAZINE";
	
	//Configuración de seguridad
	$ADM_SEC = 1; //Poner distinto de 1 para anular login screen
	$ADM_USR = "sample"; 	//Usuario	
	$ADM_PWD = "sample";  //contraseña
	
	//codificamos las variables para que puedan contener carácteres UTF8
	$APP_NAME = utf8_encode($APP_NAME);
	$ADM_USR = utf8_encode($ADM_USR);
	$ADM_PWD = utf8_encode($ADM_PWD);
	
	//filtro, por si queremos mostrar solo información de una o varias tablas en concreto
	//Igualar ENABLE_TAB_FILTER a cero si no queremos filtro. 
	$ENABLE_TAB_FILTER = 0;
	
	// especificar el nombre de las tablas que queremos filtrar.
	if($ENABLE_TAB_FILTER!=0) {
		$TAB_FILTER[] = "concurso_basico";
		$TAB_FILTER[] = "puntuaciones_magazine";
		$TAB_FILTER[] = "affiliate";
	}
	
	//registros por pagina máximos por defecto
	$MAX_REG = 31;
?>
	