<?php
/*
 * @author: qCazelles 
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/jsonVersionsPlanning.php');

$showOnlyActivesVersions=Parameter::getUserParameter('showOnlyActivesVersions');
$hideversionsWithoutActivity=Parameter::getUserParameter('versionsWithoutActivity');
$displayProductversionActivity = Parameter::getUserParameter('planningVersionDisplayProductVersionActivity');
$pvsArray = array();
//CHANGE qCazelles - Correction GANTT - Ticket #100
//Old
// if (isset($_REQUEST['productVersionsListId'])) {
//   $pvsArray = $_REQUEST['productVersionsListId'];
// }
// else {
//   for ($i = 0; $i < $_REQUEST['nbPvs']; $i++) {
//     $pvsArray[$i] = $_REQUEST['pvNo'.$i];
//   }
// }
//New
if (isset($_REQUEST['productVersionsListId'])) {
  if ( strpos($_REQUEST['productVersionsListId'], '_')!==false) {
    $pvsArray=explode('_', $_REQUEST['productVersionsListId']);
  }
  else {
    $pvsArray[]=$_REQUEST['productVersionsListId'];
  }
}
//END CHANGE qCazelles - Correction GANTT - Ticket #100
else {
	for ($i = 0; $i < $_REQUEST['nbPvs']; $i++) {
		$pvsArray[$i] = $_REQUEST['pvNo'.$i];
	}
}
//$type = new Type();
//$componentTypeNoDisplay = $type->getSqlElementsFromCriteria(array('lockUseOnlyForCC'=>'1','scope'=>'ComponentVersion'));

//florent ticket 4302

if(RequestHandler::getValue('objectVersion')=='ComponentVersion'){
  $ps= new ProductVersionStructure();
  $pv= new ProductVersion();
  $productVArray= array();
  $idVersionArray=array();
  foreach ($pvsArray as $idCv) {
    $crit=array('idComponentVersion'=>$idCv);
    $productVersSt=$ps->getSqlElementsFromCriteria($crit);
    foreach ($productVersSt as $ProductVersionStructure){
      $productVArray[]=$ProductVersionStructure->idProductVersion;
    }
  }
  $productVArray=array_unique($productVArray);
  $productVArray=implode(',',$productVArray);
  $where="id in ($productVArray)";
  $idVersion=$pv->getSqlElementsFromCriteria(null,null,$where);
  foreach ($idVersion as $key=>$val){
    $idVersionArray[]=$val->id;
  }
  $pvsArray=$idVersionArray;
}

if($displayProductversionActivity == 1  and $hideversionsWithoutActivity== 1){
  $displayComponent=array();
  foreach ($pvsArray as $id=>$idProd){
    $cp=0;
    $comptDisplay=0;
    $prod= new ProductVersion($idProd);
    $activityOfProdV=$prod->searchAtivityForVersion();
    $activityOfCompV=(isset($activityOfProdV[0]))?$activityOfProdV[0]:array();
    $activityOfProdV=(isset($activityOfProdV[1]))?$activityOfProdV[1]:array();
    $listOfCompo=ProductVersionStructure::getComposition($idProd);
    foreach ($listOfCompo as $idComponentVersion){
      $cp++;
      $componentVersion = new ComponentVersion($idComponentVersion);
      $result=$componentVersion->searchAtivityForVersion();
      $listActivityComponent=(isset($result[0]))?$result[0]:array();
      $listActivityComponentVersion=(isset($result[1]))?$result[1]:array();
      if(empty($listActivityComponent) and empty($listActivityComponentVersion)){
        $comptDisplay++;
        $displayComponent[]=$idComponentVersion;
      }
    }
    if(empty($activityOfProdV) and empty($activityOfCompV) and $comptDisplay == $cp){
      unset($pvsArray[$id]);
    }
  }
}



if($showOnlyActivesVersions== 1){
  $pvComponentActList= array();
  $productVersionActiv= array();
  $listIdPv='';
  $productVersion = new ProductVersion();
  $componentVersion = new ComponentVersion();
  $where=" isStarted=1 and idle=0  and isDelivered=0 and isEis=0 ";
  $listActiveComponentVersion=$componentVersion->getSqlElementsFromCriteria(null,null,$where);
  $listIdPv=implode(',',$pvsArray);
  $where.="and id in ($listIdPv)";
  foreach ($productVersion->getSqlElementsFromCriteria(null,null,$where) as $id=>$objPvValide){
    $productVersionActiv[$objPvValide->id]=$objPvValide->id;
  }
  foreach ($pvsArray as  $idProductV){
    $listComponentV=ProductVersionStructure::getComposition($idProductV);
    if(isset($listComponentV) and isset($listActiveComponentVersion)){
      foreach ($listComponentV as $idComponentV){
        foreach ($listActiveComponentVersion as $id=>$ActivComponentVersion) {
          if($idComponentV==$ActivComponentVersion->id){
            $pvComponentActList[$idProductV]=$idProductV;
            continue;
          }
        }
      }
    }
  }
  $allProductVersionActive=$productVersionActiv+$pvComponentActList;
  if(empty($allProductVersionActive)){ 
    echo '<div class="messageWARNING">'.i18n('noCurrentVersion').'</div>';
    return; 
  }
  echo '{"identifier":"id", "items":[';
  foreach ($allProductVersionActive as $id) {
    $productVersion= new ProductVersion($id);
    $productVersion->displayVersion();
    foreach (ProductVersionStructure::getComposition($productVersion->id) as $idComponentVersion) {
      $componentVersion = new ComponentVersion($idComponentVersion);
      $hide=SqlList::getFieldFromId('ComponentVersionType', $componentVersion->idComponentVersionType, 'lockUseOnlyForCC');
      if($displayProductversionActivity == 1  and $hideversionsWithoutActivity== 1){
        foreach ($displayComponent as $idDisplayComp){
          if($idDisplayComp==$idComponentVersion){
            $hide=1;
          }
        }
      }
      if ($hide!=1) $componentVersion->treatmentVersionPlanning($productVersion);
    }
  }
///
}else{
  echo '{"identifier":"id", "items":[';
  foreach ($pvsArray as $idProductVersion) {
    $productVersion = new ProductVersion($idProductVersion);
    $productVersion->displayVersion();
    foreach (ProductVersionStructure::getComposition($productVersion->id) as $idComponentVersion) {
      $componentVersion = new ComponentVersion($idComponentVersion);
      //$cond=true;
      //foreach($componentTypeNoDisplay as $ctnd){
      //  if($componentVersion->idVersionType == $ctnd->id)
      //    $cond=false;
      //}
      
      $hide=SqlList::getFieldFromId('ComponentVersionType', $componentVersion->idComponentVersionType, 'lockUseOnlyForCC');
      if($displayProductversionActivity == 1  and $hideversionsWithoutActivity== 1){
        foreach ($displayComponent as $id){
          if($id==$idComponentVersion){
            $hide=1;
          }
        }
      }
      if ($hide!=1) $componentVersion->treatmentVersionPlanning($productVersion);
    }
  }
}
echo ']}';

