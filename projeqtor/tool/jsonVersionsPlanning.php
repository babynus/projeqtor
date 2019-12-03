<?php
/*
 * @author: qCazelles 
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/jsonVersionsPlanning.php');

echo '{"identifier":"id", "items":[';
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
if($showOnlyActivesVersions== 1){
  $pvComponentActList= array();
  $productVersionActiv= array();
  $listIdPv='';
  $productVersion = new ProductVersion();
  $componentVersion = new ComponentVersion();
  $where=" isStarted=1 and idle=0 ";
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
            unset($listActiveComponentVersion[$id]);
            continue;
          }
        }
      }
    }
  }
  $allProductVersionActive=$productVersionActiv+$pvComponentActList;
  foreach ($allProductVersionActive as $id) {
    $productVersion= new ProductVersion($id);
    $productVersion->displayVersion();
    foreach (ProductVersionStructure::getComposition($productVersion->id) as $idComponentVersion) {
      $componentVersion = new ComponentVersion($idComponentVersion);
      $hide=SqlList::getFieldFromId('ComponentVersionType', $componentVersion->idComponentVersionType, 'lockUseOnlyForCC');
      if ($hide!=1) $componentVersion->treatmentVersionPlanning($productVersion);
    }
  }
///
}else{
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
      if ($hide!=1) $componentVersion->treatmentVersionPlanning($productVersion);
    }
  }
}
echo ']}';

