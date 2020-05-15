<?php
include_once("../tool/projeqtor.php");



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="keywork" content="projeqtor, project management" />
    <meta name="author" content="projeqtor" />
    <meta name="Copyright" content="Pascal BERNARD" />
  <link rel="stylesheet" type="text/css" href="../view/css/projeqtor.css" />
  <link rel="stylesheet" type="text/css" href="../view/css/projeqtorFlat.css" />
  <link rel="shortcut icon" href="../view/img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <script type="text/javascript" src="../view/js/projeqtor.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../view/js/jsgantt.js?version=<?php echo $version.'.'.$build;?>"></script>
  <script type="text/javascript" src="../view/js/projeqtorWork.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../view/js/projeqtorDialog.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../view/js/projeqtorFormatter.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/dojo/dojo.js?version=<?php echo $version.'.'.$build;?>"></script>
  <script type="text/javascript" src="../external/dojo/projeqtorDojo.js?version=<?php echo $version;?>"></script>
  <script type="text/javascript">
  dojo.addOnLoad(function(){
    console.log("Hello World");
  });
  </script>
</head>
<body id="body" class="tundra <?php echo getTheme();?>">
<div class="centerDiv" style="width:100%;height:100%;overflow-y:auto;overflow-x:hidden;padding:30px 50px;" id="centerDiv">
<h1>MODALITES</h1>
<?php InterventionMode::drawList();?>
<h1>TEST SAISIE INTERVENTION</h1>
<div id="plannedWorkManualInterventionDiv">
<?php 
$listResource=array('1','3');
$listMonth=array('202006');
$size=30;
PlannedWorkManual::setSize($size);
PlannedWorkManual::drawTable('intervention',$listResource, $listMonth, false);
?>
</div>
<input type='text' id="plannedWorkManualInterventionSize" value="<?php echo $size;?>" />
<input type='text' id="plannedWorkManualInterventionResourceList" value="<?php echo implode(',',$listResource);?>" />
<input type='text' style="width:500px" id="plannedWorkManualInterventionMonthList" value="<?php echo implode(',',$listMonth);?>" />
<h1>TEST ASSIGNATION ADMIN</h1>
<div id="plannedWorkManualAssignmentDiv">
<?php 
$listResource=array('1');
$listMonth=array('202005','202006','202007','202008','202009','202010');
$size=20;
PlannedWorkManual::setSize($size);
PlannedWorkManual::drawTable('assignment',$listResource, $listMonth, false);
?>
</div>
<input type='text' id="plannedWorkManualAssignmentSize" value="<?php echo $size;?>" />
<input type='text' id="plannedWorkManualAssignmentResourceList" value="<?php echo implode(',',$listResource);?>" />
<input type='text' style="width:500px" id="plannedWorkManualAssignmentMonthList" value="<?php echo implode(',',$listMonth);?>" />
<br/><br/><input type="text" id="selectInterventionDataResult" value="" style="width:800px;background:#ffe0e0" />
</div>

</body>

