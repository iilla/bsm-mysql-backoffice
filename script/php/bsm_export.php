<?php
	//header("Content-type: application/vnd.ms-excel; charset=utf-8'");
	header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8'");
	header("Content-Disposition: attachment; filename=bsm_".date("Y-m-d")."_".date("H:i:s").".xls");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Consulta exportada a microsoft excel</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<style type="text/css">
			#display-table {
				border:1px solid #8d8d8d;
				background-color:#bcbcbc;
				font-size:13px;
			}

			#display-table td{
				border:1px solid #8d8d8d;
				padding-right:10px;
				vertical-align:middle;
				border-bottom:1px solid #919191;
			}

			.tittle-row {
				background-color:#919191;
				font-weight:bold;
			}

			.tittle-row td {
				border:0px;
				padding-right:10px;
			}
	</style>
	</head> 
	<body>
		<?php
			require_once ("../../config/bsm_settings.php");
			//Extraemos datos de la BD segun la query
			$db = mysqli_connect($DB_SET["db-hostname"],$DB_SET["db-username"],$DB_SET["db-password"]);
			mysqli_select_db($db,$DB_SET["db-name"]);
			mysqli_query($db,"SET NAMES 'utf8'");
			mysqli_query($db,"SET CHARACTER SET utf8");
			mysqli_query($db,"SET CHARACTER_SET_CONNECTION=utf8");	
			$result_content = mysqli_query($db,$_REQUEST['query']);
			$result_fields = mysqli_query($db,"SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$_REQUEST['table']."'");
			$i = 0;
			while ($array = mysqli_fetch_array($result_fields)) {
				$fields[$i] = $array['COLUMN_NAME'];
				$i++;
			}
			while ($array = mysqli_fetch_array($result_content)) {
				$content[] = $array;
			}		
		?>
		<center> <h1><?echo $APP_NAME;?></h1></center>
		
		<b><u>Consulta generada con los siguiente parametros:</u></b><br />
		
		<b>Base de datos: </b><?echo $DB_SET["db-name"];?><br />
		<b>Tabla: </b><?echo $_REQUEST['table'];?><br />
		<b>Consulta SQL: </b><?echo $_REQUEST['query'];?><br />
		<br /><br />
		<table id="display-table" border="1">
			<tr class="tittle-row" align="center">
				<? for($i=0;$i<count($fields);$i++) { 
					echo "<td>".$fields[$i]."</td>";
				}?>					
			</tr>
			<? for($i=0;$i<count($content);$i++) { 
				echo "<tr>";
				for($j=0;$j<count($fields);$j++) { 
					echo "<td>".$content[$i][$fields[$j]]."</td>";
				}
				echo "</tr>";
			}?>			
		</table>	
	</body>
</html>