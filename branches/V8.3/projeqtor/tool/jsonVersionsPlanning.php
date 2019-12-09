<?php
/*
 * @author: qCazelles 
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/jsonVersionsPlanning.php');

$showOnlyActivesVersions=Parameter::getUserParameter('showOnlyActivesVersions');
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

if($showOnlyActivesVersions== 1){
  $pvComponentActList= array();
  $productVersionActiv= array();
  $listIdPv='';
  $productVersion = new ProductVersion();
  $componentVersion = new ComponentVersion();
  $where=" isStarted=1 and idle=0  and isDelivered=0 and isEis=0 ";
  debugLog($where);
  $listActiveComponentVersion=$componentVersion->getSqlElementsFromCriteria(null,null,$where);
  debugLog($listActiveComponentVersion);
  $listIdPv=implode(',',$pvsArray);
  $where.="and id in ($listIdPv)";
  foreach ($productVersion->getSqlElementsFromCriteria(null,null,$where) as $id=>$objPvValide){
    $productVersionActiv[$objPvValide->id]=$objPvValide->id;
  }
  foreach ($pvsArray as  $idProductV){
    $listComponentV=ProductVersionStructure::getComposition($idProductV);
//     debugLog($listComponentV);
//     debugLog($listActiveComponentVersion);
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
    $list=$productVersion->searchAtivityForVersion();
    //debugLog($list);
    $res=$productVersion->displayVersion();
    if($res=='true'){
      foreach (ProductVersionStructure::getComposition($productVersion->id) as $idComponentVersion) {
        $componentVersion = new ComponentVersion($idComponentVersion);
        $hide=SqlList::getFieldFromId('ComponentVersionType', $componentVersion->idComponentVersionType, 'lockUseOnlyForCC');
        if ($hide!=1) $componentVersion->treatmentVersionPlanning($productVersion);
      }
    }
  }
///
}else{
  echo '{"identifier":"id", "items":[';
  foreach ($pvsArray as $idProductVersion) {
    $productVersion = new ProductVersion($idProductVersion);
    $res=$productVersion->displayVersion();
    if($res=='true'){
      foreach (ProductVersionStructure::getComposition($productVersion->id) as $idComponentVersion) {
        $componentVersion = new ComponentVersion($idComponentVersion);
        //$cond=true;
        //foreach($componentTypeNoDisplay as $ctnd){
        //  if($componentVersion->idVersionType == $ctnd->id)
        //    $cond=false;
        //}
        
        $hide=SqlList::getFieldFromId('ComponentVersionType', $componentVersion->idComponentVersionType, 'lockUseOnlyForCC');
        if ($hide!=1) $componentVersion->treatmentVersionPlanning($productVersion);
      }
    }
  }
}
echo ']}';

