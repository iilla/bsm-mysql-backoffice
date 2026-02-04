<?php
if (!isset($_POST["searchSelect"])) {

    $query="SELECT * FROM ".$selectedTable;
    $genericData = $DB_CONN->query($query);

} else {

    if ($_POST['searchSelect']=="all") {

        $query="SELECT * FROM ".$selectedTable;

    } else {
        $query="DESCRIBE ".$selectedTable;
        $fieldList = $DB_CONN->query($query);

        $query="SELECT ".$_POST['searchSelect'];
        for ($i=0;$i<count($fieldList->rows);$i++) {
            if($fieldList->rows[$i]['Field']!=$_POST['searchSelect']) {
                $query .= ",";
                $query .= $fieldList->rows[$i]['Field'];
            }
        }
        if ($_POST['referenceType'] == 'exactReference') {
           $query .=" FROM ".$selectedTable." WHERE ".$_POST['searchSelect']." = '".$_POST['searchReference']."' ORDER BY ".$_POST['searchSelect'].";";
        } else {
           $query .=" FROM ".$selectedTable." WHERE ".$_POST['searchSelect']." LIKE '%".$_POST['searchReference']."%' ORDER BY ".$_POST['searchSelect'].";";
        }
    }
    $genericData = $DB_CONN->query($query);

}

$totalFields = count($genericData->fields);	$totalRecords = count($genericData->rows);	//if($totalFields>13) $totalFields=12;

?>

    <div id="search-parameters">
        <form id="searchForm" name="searchForm" action="?menuSel=<?=$tableIndex?>" method='POST'>
            <table width="100%" border="0">
                <tr>
                    <td><b>Campo de la tabla:</b></td>
                    <td><b>Filtro: <span id="dataType-ref"></span></b></i></td>
                </tr>
                <tr>
                    <td>
                        <div id="selectContainer">
                            <select id="searchSelect" name="searchSelect" class="search-appearance">
                                <option onclick='show_dataType("all")' value="all"><b>Todos</b></option>
                                <?
                                $selected = "";
                                for($i=0;$i<$totalFields;$i++) {
                                    $selected = (isset($_POST['searchSelect']) && $_POST['searchSelect']==$genericData->fields[$i]->name)?"selected":"";
                                    echo "<option onclick='show_dataType(\"".$genericData->fields[$i]->type."\")' value='".$genericData->fields[$i]->name."' ".$selected.">".$genericData->fields[$i]->name."</option>";
                                }?>
                            </select>
                        </div>
                    </td>
                    <?
                    if (isset($_POST['searchSelect'])) {
                        $disableReference=($_POST['searchSelect']=="all")?"disabled":"";
                    } else {
                        $disableReference="disabled";
                    }
                    ?>
                    <td>
                        <input id="searchReference" name="searchReference" type="text" class="search-appearance search" value="<?=(isset($_POST['searchReference']) && ($_POST['searchSelect']!="all"))?$_POST['searchReference']:"";?>" <?=$disableReference?>/>
                    </td>
                    <td>
                        <input id="searchButton" name="searchButton" type="image" src="<?=IMG."button-filter.jpg"?>" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right" style="padding-right:20px;font-size:12px">
                        Búsqueda exacta: <input class="search" name="referenceType" value="exactReference" type="radio" checked <?=$disableReference?>/>
                        <br />
                        Búsqueda aproximada: <input class="search"name="referenceType" value="approxReference" type="radio" <?echo (isset($_POST['referenceType']) && ($_POST['referenceType']=="approxReference"))?'checked':'';?> <?=$disableReference?> />
                    </td>
                </tr>
            </table>
        </form>
        <div id="data-export">
            <? 
                $query=urlencode($query);
                $selectedTable=urlencode($selectedTable); 
                $scriptTrigger=PHP."bsm_export.php?query=".$query."&table=".$selectedTable;
            ?>
            <input onClick="window.location='<?=$scriptTrigger?>'" name="export-button" type="image" src="<?=IMG."button-export.jpg"?>" />
        </div>
    </div>
<? if ($totalRecords!=0) { ?>

    <? if (isset($windowHeight)) echo "hi there!"; ?>

    <!-- MUESTRA DE DATOS -->
    <div id="search-result">
    <?

        //Establecemos el número de paginas según los campos que tengamos
        if (($totalRecords%$MAX_REG)==0) {
            $display_pages = $totalRecords/$MAX_REG;
            $lastPage_numRecords = $MAX_REG;
        } else {
            $display_pages = $totalRecords/$MAX_REG;
            $display_pages = (int)$display_pages;
            $display_pages++;
            $lastPage_numRecords = $totalRecords%$MAX_REG;
        }

        $actualRecord = 0;
        $displayTextIndex = 0;

        //PAGINATION FOR
        for($pages=1;$pages<=$display_pages;$pages++) { 
            if ($pages==$display_pages) {
                $recordDisplay=$lastPage_numRecords+$actualRecord;
            } else {
                $recordDisplay = $MAX_REG+$actualRecord;
            }        
        

    ?>
        <div name="display_page_<?=$pages?>" id="display_page_<?=$pages?>" style="display:<?echo ($pages==1)?"block":"none";?>">							<table width="100%" class="display-table">
                <tr class="tittle-row" align="center">
                    <? for($i=0;$i<$totalFields;$i++) {
                        echo "<td>".$genericData->fields[$i]->name."</td>";
                    }?>
                </tr>
                <?
                for($i=$actualRecord;$i<$recordDisplay;$i++) {
                    $parity = (($i-1)%2==0)?"pairRow":"";
                    echo "<tr align='left' valign='middle' class='".$parity."'>";
                    for($j=0;$j<$totalFields;$j++) {
                        if ($genericData->fields[$j]->type != "blob") {
                            echo "<td>".$genericData->rows[$i][$genericData->fields[$j]->name]."</td>";
                        } else {
                            echo "<input id='displayText_".$displayTextIndex."' type='hidden' value='".$genericData->rows[$i][$genericData->fields[$j]->name]."' />";
                            echo "<td><img class='textViewer' onMouseOver='showText(".$displayTextIndex.")' onclick='copyToClipboard(".$displayTextIndex.")' src='".IMG."show-text.png' /></td>";
                            $displayTextIndex++;
                        }
                    }
                    echo "</tr>";
                    $actualRecord++;
                }?>
            </table>
        </div>
    <? } //END PAGINATION FOR ?>
    </div>
    <div id="data-operations">
        <!-- PAGINACIÓN -->
        <? if ($display_pages!=1) {?>
            <div id="data-pagination">
                <!-- guardamos los valores de la pagina actual y el total de paginas en inputs para javascript -->
                <input id="actual-page" type="hidden" value="1" />
                <input id="total-pages" type="hidden" value="<?=$display_pages?>" />
                <input onclick="dataDisplayer_pagination('prev');" style="display:none;float:left;" id="prev-button" name="prev-button" type="image" src="<?=IMG."prev-pag.png"?>" />
                &nbsp;&nbsp;<span id="count-pages">1</span>/<?=$display_pages?>&nbsp;&nbsp;
                <input onclick="dataDisplayer_pagination('next');" style="float:right;" id="next-button" name="next-button" type="image" src="<?=IMG."next-pag.png"?>" />
            </div>
        <?}?>
    </div>
<? } else {
    $displayMsg = "No hay resultados con esos par&aacute;metros de b&uacute;squeda, o no existen campos en la tabla.<br>";
    include INC."inc.msgbox.php";
} ?>