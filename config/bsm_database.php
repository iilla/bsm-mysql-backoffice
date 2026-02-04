<?php

 class BaseDades{
	private $conexio;
	private $dbn;
	private $lstquery; //La última query hecha
	private $totreg;
	private $errlog;
	private $dbtables;
	
	public function __construct($dbdata){
		 if (!$this->conexio = mysqli_connect($dbdata["db-hostname"],$dbdata["db-username"],$dbdata["db-password"],$dbdata["db-name"])){exit('ERROR - Configuración erronea de Base de datos');}
		// if (!mysqli_select_db($dbdata["db-name"], $this->conexio)){exit('ERROR No existe estructura en la Base de datos');}
		 $this->dbn=$dbdata["db-name"];
		 $this->dbtables = mysqli_query($this->conexio,"SHOW TABLE STATUS FROM ".$dbdata["db-name"]);
		 mysqli_query($this->conexio,"SET NAMES 'utf8'");
		 mysqli_query($this->conexio,"SET CHARACTER SET utf8");
		 mysqli_query($this->conexio,"SET CHARACTER_SET_CONNECTION=utf8");	
	}

    //nos devolverá una clase stdClass
	public function query($sql,$noexit=false) {
		$this->lstquery =  strtoupper($sql);
		$this->totreg=0;

		$resource = mysqli_query($this->conexio,$sql);

		if ($resource) {
		if (($resource instanceof mysqli_result)) {
                                    $camps=array();
                                    for ($i=0; $i < mysqli_num_fields($resource); $i++){
                                       $j= new stdClass();
                                       $fetchFieldData = mysqli_fetch_field_direct($resource, $i);
                                       $j->name = $fetchFieldData->name;
                                       $j->type = $fetchFieldData->type;
                                       $j->len = $fetchFieldData->max_length;
                                       $j->flags = $fetchFieldData->flags;
                                       $camps[]=$j;
                                    }
									/*
									List of Flags:
									MYSQLI_NOT_NULL_FLAG Indicates that a field is defined as NOT NULL ()
									MYSQLI_PRI_KEY_FLAG Field is part of a primary index ()
									MYSQLI_UNIQUE_KEY_FLAG Field is part of a unique index. ()
									MYSQLI_MULTIPLE_KEY_FLAG Field is part of an index. ()
									MYSQLI_BLOB_FLAG Field is defined as BLOB ()
									MYSQLI_UNSIGNED_FLAG Field is defined as UNSIGNED ()
									MYSQLI_ZEROFILL_FLAG Field is defined as ZEROFILL ()
									MYSQLI_AUTO_INCREMENT_FLAG Field is defined as AUTO_INCREMENT ()
									MYSQLI_TIMESTAMP_FLAG Field is defined as TIMESTAMP ()
									MYSQLI_SET_FLAG Field is defined as SET ()
									MYSQLI_NUM_FLAG Field is defined as NUMERIC ()
									MYSQLI_PART_KEY_FLAG Field is part of an multi-index ()
									MYSQLI_GROUP_FLAG Field is part of GROUP BY ()
									*/
                                    $i = 0;
                                    $data = array();
                                    while ($result = mysqli_fetch_assoc($resource)) {
                                            $data[$i] = $result;
                                            $i++;
                                    }

                                    mysqli_free_result($resource);
                                    //echo var_dump($camps);
                                    $query = new stdClass();
                                    $query->row = isset($data[0]) ? $data[0] : array(); //Nos extrae la primera fila U.u
                                    //$query->row = $data[0];
                                    $query->rows = $data; //Un array de rows
                                    $query->num_rows = $i;
                                    $query->fields = $camps;
									$query->voidValue = ($query->num_rows>0) ? true:false;
									//var_dump($query->rows);
                                    //echo var_dump($query);
                                    unset($data);
                                    $this->errlog ="";
                                    return $query;
                         } else {
                                    $this->errlog ="";
                                    return TRUE;
                         }
		} else {
                      if($noexit===true){
                            $this->errlog = 'Error1: ' . mysqli_error($this->conexio) . '<br />Error No: ' . mysqli_errno($this->conexio) . '<br />' . $sql;
                      } else {
                            exit('Error2: ' . mysqli_error($this->conexio) . '<br />Error No: ' . mysqli_errno($this->conexio) . '<br />' . $sql);
                      }
                }
  	}
	
	public function LstError(){
		return $this->errlog;
	}
	
	public function Total(){
		if (!empty($this->totreg)){return $this->totreg;}
		$p = strpos($this->lstquery,"SELECT");
		//echo $this->lstquery;
		if ($p !== false){
			$p2 = strpos($this->lstquery,"FROM");
			$q = substr_replace($this->lstquery,"COUNT(*)",7,$p2-7);
			$q = substr($q,0,strpos($q,"LIMIT"));
			$Result = mysqli_query($q);
			$Result = mysqli_fetch_array($Result);
			$this->totreg = $Result[0];
			unset($Result);
			return $this->totreg; 
		}else{
			return 0;
		}
	}
	
	public function escape($value) {
                //Restringimos el uso de "+". Lo uso para concatenar
                //valores retornados a jQuery vía Get
                $value = str_replace("+", "", $value);
		return mysqli_real_escape_string($value, $this->conexio);
	}
	
  	public function countAffected() {
    	return mysqli_affected_rows($this->conexio);
  	}

  	public function getLastId() {
    	return mysqli_insert_id($this->conexio);
  	}		
	
	public function __destruct() {
                //echo 'eeentra <br>';
		mysqli_close($this->conexio);
	}

	public function dbname(){
	  return $this->dbn;
	}
	
	public function ToJSON($dades){
	//retorna en recordset en format JSON
	  return json_encode($dades->rows);
	}
	
	Public function Conexio(){
	 return $this->conexio;
	}

//        Public function ToSelect($args=array()){
//	    if (isset($args["rows"])){
//		$rows = $args["rows"];
//		if (count($rows)>0){$keys = array_keys($rows[0]);}
//		$size = $this->Param($args,"size","size=\"","\"");
//		$nom = $this->Param($args,"name","name=\"","\"");
//		$id = $this->Param($args,"id","id=\"","\"");
//		$onchange = $this->Param($args,"onchange","onchange=\"","\"");
//		$class= $this->Param($args,"class","class=\"","\"");
//		$idsel = intval($this->Param($args,"idsel"));
//		$v[]= "<select $nom $id $onchange $class $size>";
//		foreach ($rows as $r){
//			$v[]="<option value=\"" . $r[$keys[0]] . "\" ". (($r[$keys[0]]==$idsel)?"selected=\"selected\"":"") . ">".$r[$keys[1]]."</option>";
//		}
//		$v[]="</select>";
//		return join("\n",$v);
//	    }else{return null;}
//	}
//
//        Private function Param($args,$nom,$pre="",$post=""){
//	 return ((isset($args[$nom]))?$pre .  $args[$nom]. $post:"");
//	}

	/*MAGIC FORMS*/


	public function SaveForm(){
		//mirar si hi ha quelcom per guardar
		//MFform = 1 activa el guadador 
		//MFTABLE = nom de la taula on guardar
		//MFID= nom del identificador de la taula
		//MFFIELD_nomcamp valor a guardar
		if (isset($_REQUEST["MFform"])){
			//grabar
			if (isset($_REQUEST["MFFIELD_" . $_REQUEST["MFID"]])){
			 //UPDATE
			 return $_REQUEST["MFFIELD_" . $_REQUEST["MFID"]];
			}Else{
			//insert

			  $sq = "INSERT INTO " . $_REQUEST["MFTABLE"] . " (" . join(",",$this->MF_camps()) . ") VALUES (" . join(",",$this->MF_camps(true)) .")";
			  
			  $this->query($sq,true);
			  if (!empty($this->errlog)){
				return $this->errlog;
			  }
			  $lstid= $this->getLastId();	
			}
			if (isset($_REQUEST["MFSQPOST"])){
				$sq =$_REQUEST["MFSQPOST"];
				$this->query($sq,true);
				if (!empty($this->errlog)){
					return $this->errlog;
				}
			}
			if (isset($_REQUEST["MFSQRETURN"])){
				$sq=$_REQUEST["MFSQRETURN"];
				$sq=str_replace("#lstid",$lstid,$sq);
				$dad=$this->query($sq,true);
				if (!empty($this->errlog)){
					return $this->errlog;
				}else{
					return join(",",$dad->rows[0]);
				}
			}else{
				return $lstid;
			}
		}
	}
	private function MF_camps($valors=false){
		$ar=array();
		if ($valors===true){
				 $sq = "SELECT " . join(",",$this->MF_camps(false)) . " FROM " . $_REQUEST["MFTABLE"] . " where 0=1";
				 $dad=$this->query($sq);
				 foreach ($dad->fields as $camp){
				 	if (strtolower($camp->name) != $_REQUEST["MFID"]){
			/*STRING, VAR_STRING: string TINY, SHORT, LONG, LONGLONG, INT24: int FLOAT, DOUBLE, DECIMAL: real TIMESTAMP: timestamp YEAR: yearDATE: dateTIME: timeDATETIME: datetimeTINY_BLOB, MEDIUM_BLOB, LONG_BLOB, BLOB: blobNULL: null*/
						switch (strtolower($camp->type)){
							case "string":
							case "var_string":
								$ar[]="\"" . $this->escape($_REQUEST["MFFIELD_".$camp->name]) . "\"";
								//echo __LINE__; 
								break;
							case "float":
							case "double":
							case "decimal":
							case "tiny":
							case "short":
							case "long":
							case "longlong":
							case"int":
								$ar[]= str_replace(",",".", $this->escape($_REQUEST["MFFIELD_".$camp->name]));
								break;
							case "date":
							case "datetime":
							case "timestamp":
								$ar[]="'" . FormatDate('Y-m-d',$_REQUEST["MFFIELD_".$camp->name]) . "'";
								break;
							default:
								$ar[]= $this->escape($_REQUEST["MFFIELD_".$camp->name]);
								break;
							}
						}
					}	
		}else{
			foreach ($_REQUEST as $k=>$v){
				if (strpos($k,"MFFIELD_")!==false){
					$ar[]=str_replace("MFFIELD_","",$k);}
				}
		}	
		return $ar;
	}
	
	public function infoTables () {
		$i = 0;
		while ($array = mysqli_fetch_array($this->dbtables)) {
			$infoTables[$i]["name"] = $array["Name"];
			$infoTables[$i]["rows"] = $array["Rows"];
			$i++;
		}
		return $infoTables;
	}
 }
	$DB_CONN = new BaseDades($DB_SET);
?>
