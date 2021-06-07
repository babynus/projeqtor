<?php 
require_once "../tool/projeqtor.php";
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
  <script type="text/javascript" src="js/projeqtorDialogAdminTool.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialogConfiguration.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialogDocument.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialogFinancial.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialogPlanning.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialogPoker.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialogRequirement.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../view/js/projeqtorFormatter.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/dojo/dojo.js?version=<?php echo $version.'.'.$build;?>"></script>
  <script type="text/javascript" src="../external/dojo/projeqtorDojo.js?version=<?php echo $version;?>"></script>
  <script type="text/javascript">
  dojo.addOnLoad(function(){
    page="../tool/adminFunctionalities.php?adminFunctionality=checkConsistency&correct=<?php echo RequestHandler::getValue('correct');?>";
    loadDiv(page, "displayDiv", null, null);
  });
  </script>
</head>
<body id="body" class="tundra <?php echo getTheme();?>">
<textarea style="width:500px;height:200px" rows="" id="textToCrypt" cols=""></textarea><br/>
<button onClick="dojo.byId('textCrypted').value=simpleCrypt(dojo.byId('textToCrypt').value)">CRYPT</button><br/>
<textarea style="width:500px;height:200px" rows="" id="textCrypted" cols=""></textarea>
</body>