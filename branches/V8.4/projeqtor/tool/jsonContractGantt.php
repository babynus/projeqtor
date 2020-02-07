<?php
/*
 * @author: qCazelles 
 */
require_once "../tool/projeqtor.php";
require_once "../tool/jsonFunctions.php";
scriptLog('   ->/tool/jsonContractGantt.php');
SqlElement::$_cachedQuery['SupllierContract']=array();

$objectClass='SupplierContract';
$lstContract= array();
$nbRows=0;
$obj=new $objectClass();
$test= new SupplierContract();

$where="idle=0";
$lstContract=$obj->getSqlElementsFromCriteria(null,null,$where);


echo '{"identifier":"id",' ;
echo ' "items":[';
    drawElementContractGantt($objectClass,$lstContract,$nbRows);
echo ' ] }';






function drawElementContractGantt($objectClass,$lstContract,$nbRows){
    $nbContract=count($lstContract);
    $cp=$nbContract;
    foreach ($lstContract as $contract) {
      $redLine=false;
      $cp++;
      echo (++$nbRows>1)?',':'';
      $idContract=$contract->id.'.'.$nbRows;
      $class=get_class($contract);
      $nameType='id'.$objectClass.'Type';
      $type=new Type($contract->$nameType);
      if($class=='SupplierContract'){
        if($contract->idProvider){
          $provider=new Provider($contract->idProvider);
          $namePC=$provider->name;
        }
      }else{
        if($contract->idClient){
          $client=new Client($contract->idClient);
          $namePC=$client->name;
        }
      }
      if(strtotime($contract->deadlineDate) > strtotime($contract->endDate) or strtotime($contract->endDate) < time() ){
        $redLine=true;       
      }
      echo  '{';
        echo '"id":"'.$idContract.'"';
        echo ',"refid":"'.$contract->id.'"';
        echo ',"refname":"'.htmlEncode(htmlEncodeJson($contract->name)).'"';
        echo ',"reftype":"'.$class.'"';
        //echo ',"color: #50BB50"';
        echo ',"topreftype":"'.htmlEncode(htmlEncodeJson(SqlList::getNameFromId('Type',$type->id))).'"';
        echo ',"resource":"'.htmlEncode(htmlEncodeJson($namePC)).'"';
        echo ',"realstartdate":"'.($contract->startDate).'"';
        echo ',"realenddate":"'.($contract->endDate).'"';
        echo ',"duration":"'.($contract->initialContractTerm).'"';
        echo ',"status":"'.htmlEncodeJson(SqlList::getNameFromId('Status', $contract->idStatus)).'"';
        if ($contract->handled and $redLine == false ) {
          echo ',"redElement":"0"';
        }else if ($redLine==true and !$contract->idle and !$contract->done) {
          echo ',"redElement":"1"';
        }
        else {
          echo ',"redElement":"0"';
        }
      echo '  }';
      
      if($contract->deadlineDate or $contract->noticeDate){
        echo ',';
        echo '{';
        echo '"id":"'.$idContract.'.'.$cp.'"';
        echo ',"reftype":"Milestone"';
          if($contract->noticeDate){
            echo ',"realstartdate":"'.($contract->noticeDate).'"';
          }else{
            echo ',"realstartdate":"'.($contract->deadlineDate).'"';
          }
         echo '  }';
      }
      
    }
}
