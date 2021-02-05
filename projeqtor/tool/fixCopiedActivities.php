<?php
require_once "../tool/projeqtor.php";
  traceLog("update assignment with unique ressource without assignmentSelection [9.0.5]");
  //setSessionUser(new User());
  $ass=new Assignment(); $assTable=$ass->getDatabaseTableName();
  $assSel=new AssignmentSelection(); $assSelTable=$assSel->getDatabaseTableName();
  $assList=$ass->getSqlElementsFromCriteria(null,false, "uniqueResource=1 and not exists (select 'x' from $assSelTable where $assSelTable.idAssignment=$assTable.id)");
  $cpt=0;
  $cptCommit=100;
  Sql::beginTransaction();
  //KpiValue::$_noKpiHistory=true;
  traceLog("   => ".count($assList)." to update");
  if (count($assList)<100) {
    projeqtor_set_time_limit(1500);
  } else {
    traceLog("   => setting unlimited execution time for script (more than 100 assignments to update)");
    projeqtor_set_time_limit(0);
  }
  foreach($assList as $ass) {
    $res=AssignmentSelection::addResourcesFromPool($ass->id,$ass->idResource,null);
    $cpt++;
    if ( ($cpt % $cptCommit) == 0) {
      Sql::commitTransaction();
      traceLog("   => $cpt assignments done...");
      Sql::beginTransaction();
    }
  }
  Sql::commitTransaction();
  traceLog("   => $cpt assignments updated"); 
echo "Done.<br/>$cpt assignments fixed.";