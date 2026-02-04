<?php

	//Datos de conexión para la base de datos
	$DB_SET["db-hostname"]= "localhost";
	$DB_SET["db-username"]= "root";
	$DB_SET["db-password"]= "";
	$DB_SET["db-name"]= "db_name";

	//Nombre de la aplicación
	$APP_NAME = "BACKOFFICE - STRANGE MANAGER";
	
	//Configuración de seguridad
	$ADM_SEC = 1; //Poner distinto de 1 para anular login screen
	$ADM_USR = "sample"; 	//Usuario	
	$ADM_PWD = "sample";  //contraseña
	
	//codificamos las variables para que puedan contener carácteres UTF8
	$APP_NAME = utf8_encode($APP_NAME);
	$ADM_USR = utf8_encode($ADM_USR);
	$ADM_PWD = utf8_encode($ADM_PWD);
	
	//filtro, por si queremos mostrar solo información de una o varias tablas en concreto
	//Igualar ENABLE_TAB_FILTER a false si no queremos filtro. 
	$ENABLE_TAB_FILTER = false;
	
	// especificar el nombre de las tablas que queremos filtrar.
	if($ENABLE_TAB_FILTER) {
		$TAB_FILTER[] = "table_to_show_1";
		$TAB_FILTER[] = "table_to_show_2";
		$TAB_FILTER[] = "table_to_show_3";
	}
	
	//registros por pagina máximos por defecto
	$MAX_REG = 31;
?>
	
