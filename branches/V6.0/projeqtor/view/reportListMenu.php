<?php 
require_once "../tool/projeqtor.php";
$categ=null;
if (isset($_REQUEST['idCategory'])) {
  $categ=$_REQUEST['idCategory'];
}

if (!$categ) {
  $listCateg=SqlList::getList('ReportCategory');
  echo "<ul>";
  foreach ($listCateg as $id=>$name) {
    echo "<li onClick='loadDiv(\"../view/reportListMenu.php?idCategory=$id\",\"reportMenuList\");'>$name</li>";
  }
  echo "</ul>";
} else {
  $catObj=new ReportCategory($categ);
  echo "<span class='backButton' onClick='loadDiv(\"../view/reportListMenu.php\",\"reportMenuList\");'>X</span>";
  echo i18n($catObj->name);
  $report=new Report();
  $crit=array('idReportCategory'=>$categ);
  $listReport=$report->getSqlElementsFromCriteria($crit);
  echo "<ul>";
  foreach ($listReport as $rpt) {
    echo "<li onClick='reportSelectReport($rpt->id);'>".i18n($rpt->name)."</li>";
  }
  echo "</ul>";
}  
  
?>