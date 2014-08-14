<?php
function runScript($vers,$pluginSqlFile=null) {
  global $versionParameters, $parametersLocation;
  $paramDbName=Parameter::getGlobalParameter('paramDbName');
  $paramDbPrefix=Parameter::getGlobalParameter('paramDbPrefix');
  $dbType=Parameter::getGlobalParameter('paramDbType');
  projeqtor_set_time_limit(1500);
  traceLog("=====================================");
  traceLog("");
  if ($vers) {
	  traceLog("VERSION " . $vers);
	  traceLog("");
	  $handle = @fopen("../db/projeqtor_" . $vers . ".sql", "r");
  } else {
  	traceLog("PLUGIN SQL FILE : ".$pluginSqlFile);
  	traceLog("");
  	$handle = @fopen($pluginSqlFile, "r");
  	$versionParameters=array();
  }
  $query="";
  $nbError=0;
  if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle);
        $buffer=trim($buffer);
        $buffer=str_replace('${database}', $paramDbName, $buffer);
        $buffer=str_replace('${prefix}', $paramDbPrefix, $buffer);
        if ( substr($buffer,0,2)=='--' ) {
          $buffer=''; // remove comments
        }
        if ($buffer!='') {
          $query.=$buffer . "\n";
        }
        if ( substr($buffer,strlen($buffer)-1,1)==';' ) {
        	$query=trim(formatForDbType($query));
        	if ($query) {
        		Sql::beginTransaction();
	          $result=Sql::query($query);
	          if ( ! $result or !$result->queryString ) {
	          	Sql::rollbackTransaction();
	          	$nbError++;
	          	traceLog("");
	          	if ($vers) {
	              traceLog( "Error # $nbError => SQL error while executing maintenance query for version $vers (see above message)");
	          	} else {
	          		traceLog( "Error # $nbError => SQL error while executing Plugin query in file $pluginSqlFile (see above message)");
	          	}
	            traceLog("");
	            //traceLog(Sql::$lastQueryErrorMessage);
	            //traceLog("");
	            traceLog("*************************************************");
	            traceLog("");
	            $query="";
	          } else {
	          	Sql::commitTransaction();
	            $action="";
	            if (substr($query,0,12)=='CREATE TABLE') {
	              $action="CREATE TABLE";
	            }
	            if (substr($query,0,12)=='RENAME TABLE') {
	              $action="RENAME TABLE";
	            }
	            if (substr($query,0,11)=='INSERT INTO') {
	              $action="INSERT INTO";
	            }
	            if (substr($query,0,6)=='UPDATE') {
	              $action="UPDATE";
	            }
	            if (substr($query,0,11)=='ALTER TABLE') {
	              $action="ALTER TABLE";
	            }
	            if (substr($query,0,10)=='DROP TABLE') {
	              $action="DROP TABLE";
	            }
	            if (substr($query,0,11)=='DELETE FROM') {
	              $action="DELETE FROM";
	            }
	            if (substr($query,0,14)=='TRUNCATE TABLE') {
	              $action="TRUNCATE TABLE";
	            }
	            if (substr($query,0,12)=='CREATE INDEX') {
                $action="CREATE INDEX";
              }
	            $deb=strlen($action);
	            $end=strpos($query,' ', $deb+1);
	            $len=$end-$deb;
	            $tableName=substr($query, $deb, $len );
	            if ($action=="DROP TABLE") {            
                $q=trim($query,"\n");
                $q=trim($q,"\r");
	            	$q=trim($q,' ;');
                $q=trim($q,' ');
	            	$tableName=substr($q,strrpos($q,' ',-2)+1);
	            }
	            $tableName=trim($tableName);
	            $tableName=trim($tableName,'`');
	            $tableName=trim($tableName,'"');
	            $tableName=trim($tableName,';');
	            switch ($action) {
	              case "CREATE TABLE" :
	                traceLog(" Table \"" . $tableName . "\" created."); 
	                break;
	              case "DROP TABLE" :
	                traceLog(" Table \"" . $tableName . "\" dropped."); 
	                break;
	              case "ALTER TABLE" :
	                traceLog(" Table \"" . $tableName . "\" altered."); 
	                break;
	              case "RENAME TABLE" :
	                traceLog(" Table \"" . $tableName . "\" renamed."); 
	                break;
	              case "TRUNCATE TABLE" :
	                traceLog(" Table \"" . $tableName . "\" truncated.");
	                if ($dbType=='pgsql') {Sql::updatePgSeq($tableName);} 
	                break;                
	              case "INSERT INTO":         	
	              	traceLog(" " . Sql::$lastQueryNbRows . " lines inserted into table \"" . $tableName . "\".");
	                if ($dbType=='pgsql') {Sql::updatePgSeq($tableName);} 
	                break;
	              case "UPDATE":
	                traceLog(" " . Sql::$lastQueryNbRows . " lines updated into table \"" . $tableName . "\"."); 
	                break;
	              case "DELETE FROM":
	                traceLog(" " . Sql::$lastQueryNbRows . " lines deleted from table \"" . $tableName . "\".");
	                if ($dbType=='pgsql') {Sql::updatePgSeq($tableName);} 
	                break;              
	              case "CREATE INDEX" :
                  traceLog(" Index \"" . $tableName . "\" created."); 
                  break;
                default:
	                traceLog("ACTION '$action' NOT EXPECTED FOR QUERY : " . $query);
	            }
	          }
        	}
          $query="";
        }
    }
    if ($vers and array_key_exists($vers,$versionParameters)) {
      $nbParam=0;
      writeFile('// New parameters ' . $vers . "\n", $parametersLocation);
      foreach($versionParameters[$vers] as $id=>$val) {
      	$param=Parameter::getGlobalParameter($id);
      	if (! $param) {
          $nbParam++;
          writeFile('$' . $id . ' = \'' . addslashes($val) . '\';',$parametersLocation);
          writeFile("\n",$parametersLocation);
          traceLog('Parameter $' . $id . ' added');
      	}
      }
      //echo i18n('newParameters', array($nbParam, $vers));
      echo '<br/>' . "\n";
    }
    fclose($handle);
    traceLog("");
    traceLog("DATABASE UPDATED");
    if ($nbError==0) {
      traceLog(" WITH NO ERROR");
    } else {
      traceLog(" WITH " . $nbError . " ERROR" . (($nbError>1)?"S":""));
    }
  }
  traceLog("");
  return $nbError;
}

/*
 * Delete duplicate if new version has been installed twice :
 *  - habilitation
 * 
 */
function deleteDuplicate() {
  // HABILITATION
  $hab=new Habilitation();
  $habList=$hab->getSqlElementsFromCriteria(null, false, null, 'idMenu, idProfile, id ');
  $idMenu='';
  $idProfile='';
  foreach ($habList as $hab) {
    if ($hab->idMenu==$idMenu and $hab->idProfile==$idProfile) {
      $hab->delete();
    } else {
      $idMenu=$hab->idMenu;
      $idProfile=$hab->idProfile;
    }
  }
  // HABILITATIONREPORT
  $hab=new HabilitationReport();
  $habList=$hab->getSqlElementsFromCriteria(array(), false, null, 'idReport, idProfile, id ');
  $idReport='';
  $idProfile='';
  foreach ($habList as $hab) {
    if ($hab->idReport==$idReport and $hab->idProfile==$idProfile) {
      $hab->delete();
    } else {
      $idReport=$hab->idReport;
      $idProfile=$hab->idProfile;
    }
  }
// HABILITATIONOTHER
  $hab=new HabilitationOther();
  $habList=$hab->getSqlElementsFromCriteria(array(), false, null, 'scope, idProfile, id ');
  $scope='';
  $idProfile='';
  foreach ($habList as $hab) {
    if ($hab->scope==$scope and $hab->idProfile==$idProfile) {
      $hab->delete();
    } else {
      $scope=$hab->scope;
      $idProfile=$hab->idProfile;
    }
  }
  // ACCESSRIGHT
  $acc=new AccessRight();
  $accList=$acc->getSqlElementsFromCriteria(array(), false, null, 'idProfile, idMenu, id ');
  $idMenu='';
  $idProfile='';
  foreach ($accList as $acc) {
    if ($acc->idMenu==$idMenu and $acc->idProfile==$idProfile) {
      $acc->delete();
    } else {
      $idMenu=$acc->idMenu;
      $idProfile=$acc->idProfile;
    }
  }
  
// PARAMETER
  $par=new Parameter();
  $parList=$par->getSqlElementsFromCriteria(array(), false, null, 'idUser, idProject, parameterCode, id');
  $idUser='';
  $idProject='';
  $parameterCode='';
  foreach ($parList as $par) {
    if ($par->idUser==$idUser and $par->idProject==$idProject and $par->parameterCode==$parameterCode) {
      $par->delete();
    } else {
      $idUser=$par->idUser;
      $idProject=$par->idProject;
      $parameterCode=$par->parameterCode;
    }
  }
// REPORT PARAMETER
  $par=new ReportParameter();
  $parList=$par->getSqlElementsFromCriteria(array(), false, null, 'idReport, name');
  $idReport='';
  $name='';
  foreach ($parList as $par) {
    if ($par->idReport==$idReport and $par->name==$name) {
      $par->delete();
    } else {
      $idReport=$par->idReport;
      $name=$par->name;
    }
  }
}

function formatForDbType($query) {
  $dbType=Parameter::getGlobalParameter('paramDbType');
  if ($dbType=='mysql') {
    return $query;
  }
  $from=array();
  $to=array();
  if ($dbType=='pgsql') {
  	if (stripos($query,'ADD INDEX')) {
  		return '';
  	}
  	$from[]='  ';                                         $to[]=' ';
    $from[]='`';                                          $to[]='';
    $from[]=' int(12) unsigned NOT NULL AUTO_INCREMENT';  $to[]=' serial';
    $from[]='int(';                                       $to[]=' numeric(';
    $from[]=' datetime';                                  $to[]=' timestamp';
    $from[]=' double';                                    $to[]=' double precision';
    $from[]=' unsigned';                                  $to[]='';
    $from[]='\\\'';                                       $to[]='\'\'';
    $from[]='ENGINE=InnoDB';                              $to[]='';
    $from[]='DEFAULT CHARSET=utf8';                       $to[]='';
    $res=str_ireplace($from, $to, $query);
    // ALTER TABLE : very different from MySql !!!
    if (substr($res,0,11)=='ALTER TABLE') {
    	$posChange=strpos($res,'CHANGE');
    	while ($posChange) {
    		$colPos1=strpos($res,' ',$posChange+1);
    		$colPos2=strpos($res,' ',$colPos1+1);
    		$colPos3=strpos($res,' ',$colPos2+1);
    		if (!$colPos3) {$colPos3=strlen($res)-1;}
    		$col1=substr($res,$colPos1+1,$colPos2-$colPos1-1);
    		$col2=substr($res,$colPos2+1,$colPos3-$colPos2-1);
        if ($col1==$col2) {
          $res=substr($res,0,$posChange-1). ' ALTER '.$col2.' TYPE '.substr($res,$colPos3+1);
        } else {
        	$res=substr($res,0,$posChange-1). ' RENAME '.$col1.' TO '.$col2.';';
        }
    		$posChange=strpos($res,'CHANGE', $posChange+5);
    	}
    } else if (substr($res,0,12)=='RENAME TABLE') {
    	 $res=str_replace('RENAME TABLE','ALTER TABLE',$res);
    	 $res=str_replace(' TO ',' RENAME TO ',$res);
    }
  } else {
  	// not mysql, not pgsql, so WHAT ?
    echo "unknown database type '$dbType'";
    return '';
  }
  
  return $res;
}

function migrateParameters($arrayParamsToMigrate) {
	global $parametersLocation;
	include $parametersLocation;
	foreach ($arrayParamsToMigrate as $param) {
    //$crit=array('idUser'=>null, 'idProject'=>null, 'parameterCode'=>$param);
    //$parameter=SqlElement::getSingleSqlElementFromCriteria('Parameter', $crit);
    //if (!$parameter or !$parameter->id) { 
    $parameter=new Parameter();
    //}
    $parameter->idUser=null;
    $parameter->idProject=null;
    $parameter->parameterCode=$param;  
    $parameter->parameterValue=Parameter::getGlobalParameter($param);
    if ($param=='paramMailEol') {
    	if ($parameter->parameterValue=='\n') {
    		$parameter->parameterValue='LF';
    	} else  {
    		$parameter->parameterValue='CRLF';
    	}
    }
    $parameter->save();
  }
  Parameter::regenerateParamFile();
}

function beforeVersion($V1,$V2) {
	$V1=ltrim($V1,'V');
	$V2=ltrim($V2,'V');
	return(version_compare($V1, $V2,"<"));
}

function afterVersion($V1,$V2) {
	$V1=ltrim($V1,'V');
	$V2=ltrim($V2,'V');
	return(version_compare($V1, $V2,">="));
}