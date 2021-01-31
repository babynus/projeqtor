<?php
require_once "../tool/projeqtor.php";
traceLog("update assignment were cost is null");
//setSessionUser(new User());
$ass=new Assignment();
$assList=$ass->getSqlElementsFromCriteria(null,false, "realCost is null and realWork is not null and dailyCost is not null");
$cpt=0;
$cptCommit=100;
Sql::beginTransaction();
traceLog("   => ".count($assList)." to update");
if (count($assList)<100) {
  projeqtor_set_time_limit(1500);
} else {
  traceLog("   => setting unlimited execution time for script (more than 100 assignments to update)");
  projeqtor_set_time_limit(0);
}
foreach($assList as $ass) {
  $res=$ass->saveWithRefresh();
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