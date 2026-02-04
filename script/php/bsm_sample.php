<?php
	header("Content-type: application/vnd.ms-excel; charset=utf-8'");
	header("Content-Disposition: attachment; filename=bsm_".date("Y-m-d")."_".date("H:i:s").".xls");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml2/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<title>Backoffice Stradivas Magazine</title>
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
		<?
			require_once ("../../config/bsm_settings.php");
			//Extraemos datos de la BD segun la query
			$db = mysql_connect($DB_SET["db-hostname"],$DB_SET["db-username"],$DB_SET["db-password"]);
			mysql_select_db($DB_SET["db-name"],$db);
			mysql_query("SET NAMES 'utf8'", $db);
			mysql_query("SET CHARACTER SET utf8", $db);
			mysql_query("SET CHARACTER_SET_CONNECTION=utf8", $db);	
			$result_content = mysql_query($_REQUEST['query'],$db);
			$result_fields = mysql_query("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_NAME = '".$_REQUEST['table']."'",$db);
			$i = 0;
			while ($array = mysql_fetch_array($result_fields)) {
				$fields[$i] = $array['COLUMN_NAME'];
				$i++;
			}
			while ($array = mysql_fetch_array($result_content)) {
				$content[] = $array;
			}		
		?>
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