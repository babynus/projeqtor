<?php 
$invalidQuery="query should be ../api/class of object/id of object";
$cronnedScript=true;
$batchMode=true;
require_once "../tool/projeqtor.php";
$user=new User(); 
$_SESSION['user']=$user;

IF ($_SERVER['REQUEST_METHOD']=='GET') {
  if (isset($_REQUEST['uri'])) {
    $uri=$_REQUEST['uri'];
    $split=explode('/',$uri);
    if (count($split>1)) {
    	$class=ucfirst($split[0]);
    	$where="1=0";
    	if (class_exists($class)) {
    		$obj=new $class();
    		$table=$obj->getDatabaseTableName();
    		if (count($split)==2 and is_numeric($split[1]) ) {      // =============== uri = {OblectClass}/{ObjectId}
	    		$id=$split[1];
	    		$where="id=$id";   			
    		} else if (count($split)==2 and $split[1]=='all') {     // =============== uri = {OblectClass}/all
    			$where="1=1";
    		} else if (count($split)==4 and $split[1]=='updated') {  // =============== uri = {OblectClass}/update/{YYYYMMDDHHMNSS}/{YYYYMMDDHHMNSS}
    			$beg=$split[2];
    			$end=$split[3];
    			$begDate=substr($beg,0,4).'-'.substr($beg,4,2).'-'.substr($beg,6,2).' '.substr($beg,8,2).':'.substr($beg,10,2).':'.substr($beg,12,2);
    			$endDate=substr($end,0,4).'-'.substr($end,4,2).'-'.substr($end,6,2).' '.substr($end,8,2).':'.substr($end,10,2).':'.substr($end,12,2);
    			$hist=new History();
    			$crit="refType='$class' and operationDate>='$begDate' and operationDate<'$endDate'";
    			$histList=$hist->getSqlElementsFromCriteria(null, null, $crit);
    			$hAr=array();
    			foreach ($histList as $hist) {
    				$hAr[$hist->refId]=$hist->refId;
    			}
    			if (count($hAr)==0) {
    				$where="id=0";
    			} else {
    				$where="id in (".implode(',',$hAr).")";
    			}
    		} else if (count($split)==3 and $split[1]=='filter') {  // =============== uri = {OblectClass}/filter/{filterId}
 					$filterId=$split[2];
 					$crit=new FilterCriteria();
 					$critList=$crit->getSqlElementsFromCriteria(array('idFilter'=>$filterId));
 					$where=(count($critList)>0)?"1=1":"1=0";
 					$idTab=0;
 					foreach ($critList as $crit) {
 			      if ($crit->sqlOperator!='SORT') {			
			      	$split=explode('_', $crit->sqlAttribute);        
			        $critSqlValue=$crit->sqlValue;
			        if ($crit->sqlOperator=='IN' and $crit->sqlAttribute=='idProduct') {
			          $critSqlValue=str_replace(array(' ','(',')'), '', $critSqlValue);
			          $splitVal=explode(',',$critSqlValue);
			          $critSqlValue='(0';
			          foreach ($splitVal as $idP) {
			            $prod=new Product($idP);
			            $critSqlValue.=', '.$idP;
			            $list=$prod->getRecursiveSubProductsFlatList(false, false);
			            foreach ($list as $idPrd=>$namePrd) {
			              $critSqlValue.=', '.$idPrd;
			            }
			          }         
			          $critSqlValue.=')';
			        }
			        if (count($split)>1 ) {
			          $externalClass=$split[0];
			          $externalObj=new $externalClass();
			          $externalTable = $externalObj->getDatabaseTableName();          
			          $idTab+=1;
			          //$externalTableAlias = 'T' . $idTab;
			          //$queryFrom .= ' left join ' . $externalTable . ' as ' . $externalTableAlias .
			          // ' on ( ' . $externalTableAlias . ".refType='" . get_class($obj) . "' and " .  $externalTableAlias . '.refId = ' . $table . '.id )';
			          //$queryWhere.=($queryWhere=='')?'':' and ';
			          //$queryWhere.=$externalTableAlias . "." . $split[1] . ' ' 
			          //       . $crit['sql']['operator'] . ' '
			          //       . $critSqlValue;
			        } else {
			          $where.=($where=='')?'':' and ';
			          $where.="(".$table . "." . $crit->sqlAttribute . ' ' 
			                     . $crit->sqlOperator
			                     . $critSqlValue;
			          if (strlen($crit->sqlAttribute)>=9 
			          and substr($crit->sqlAttribute,0,2)=='id'
			          and substr($crit->sqlAttribute,-7)=='Version'
			          and $crit->sqlOperator=='IN') {
			            $scope=substr($crit->sqlAttribute,2);
			            $vers=new OtherVersion();
			            $where.=" or exists (select 'x' from ".$vers->getDatabaseTableName()." VERS "
			              ." where VERS.refType='".$objectClass."' and VERS.refId=".$table.".id and scope='".$scope."'"
			              ." and VERS.idVersion IN ".$critSqlValue
			              .")";
			          }
			          $where.=")";
			        }
			      }
			    }
        }
    		echo '{"identifier":"id",' ;
        echo ' "items":[';        
        $list=$obj->getSqlElementsFromCriteria(null,null,$where);
        $cpt=0;
        foreach ($list as $obj) {
        	if ($cpt) echo ",";
        	$cpt++;
          echo '{'.jsonDumpObj($obj).'}';
        }
        echo ']';
        echo ' }';
    		
    	} else {
    		returnError($invalidQuery);
    		returnError("<br/>$class is not a known class");
    	}
    } else {
    	returnError($invalidQuery);
    }
  } else {
    returnError($invalidQuery);
  }
} else {
  returnError ('method '.$_SERVER['REQUEST_METHOD'].' not taken into acocunt in this API');
}


function returnError($msg) {
	echo "ERROR : ".$msg;
}

function jsonDumpObj($obj, $included=false) {
	$res="";
	foreach($obj as $fld=>$val) {
		if (is_object($val)) {
		  if ($res!="") { $res.=", ";}
			$res.=jsonDumpObj($val, true);
		} else if (substr($fld,0,1)=='_'
		  or $obj->isAttributeSetToField($fld, 'hidden')
		  or $included and ($fld=='id' or $fld=='refType' or $fld=='refId' or $fld=='refName' 
		                 or $fld=='handled' or $fld=='done' or $fld=='idle' or $fld=='cancelled') ) {
			// Nothing
		} else {
		  if ($res!="") { $res.=", ";}
		  $res.='"' . htmlEncode($fld) . '":"' . htmlEncodeJson($val) . '"';
		  if (substr($fld,0,2)=='id' and strlen($fld)>2) {
		  	$idclass=substr($fld,2);
		  	if (strtoupper(substr($idclass,0,1))==substr($idclass,0,1)) {
		  		$res.=", ";
		  		$res.='"name' . $idclass . '":"' . htmlEncodeJson(SqlList::getNameFromId($idclass, $val)) . '"';
		  	}
		  }
		}  
	}
	return $res;
}
?>