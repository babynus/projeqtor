<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

include_once "../tool/projeqtor.php";
if ($_SERVER['REQUEST_METHOD'] != "POST" or securityGetAccessRightYesNo('menuPlugin','read')!='YES') {
  traceHack ( "plugin management tried without access right" );
  exit ();
}
header ('Content-Type: text/html; charset=UTF-8');
/** ===========================================================================
 * Save a document version (file) : call corresponding method in SqlElement Class
 * The new values are fetched in $_REQUEST
 */

// ATTENTION, this PHP script returns its result into an iframe (the only way to submit a file)
// then the iframe returns the result to resultDiv to reproduce expected behaviour
$isIE=false;
if (array_key_exists('isIE',$_REQUEST)) {
  $isIE=$_REQUEST['isIE'];
} 
if ($isIE and $isIE<=9) {?>
<html>
<head>   
</head>
<body onload="parent.savePluginAck();">
<?php } else { ob_start();}?>
<?php 
$error=false;
$uploadedFile=false;
projeqtor_set_time_limit(3600); // 60mn
$attachmentMaxSize=Parameter::getGlobalParameter('paramAttachmentMaxSize');
$uploadedFileArray=array();

if (array_key_exists('pluginFile',$_FILES)) {
  $uploadedFileArray[]=$_FILES['pluginFile'];
} else if (array_key_exists('uploadedfile0',$_FILES)) {
  $cnt = 0;
  while(isset($_FILES['uploadedfile'.$cnt])){
  		$uploadedFileArray[]=$_FILES['uploadedfile'.$cnt];
  }
} else if (array_key_exists('pluginFile',$_FILES) and array_key_exists('name',$_FILES['pluginFile'])) {
  for ($i=0;$i<count($_FILES['pluginFile']['name']);$i++) {
    $uf=array();
    $uf['name']=$_FILES['pluginFile']['name'][$i];
    $uf['type']=$_FILES['pluginFile']['type'][$i];
    $uf['tmp_name']=$_FILES['pluginFile']['tmp_name'][$i];
    $uf['error']=$_FILES['pluginFile']['error'][$i];
    $uf['size']=$_FILES['pluginFile']['size'][$i];
    $uploadedFileArray[$i]=$uf;
  }
} else {
  $error=htmlGetErrorMessage(i18n('errorTooBigFile',array($attachmentMaxSize,'paramAttachmentMaxSize')));
  errorLog(i18n('errorTooBigFile',array($attachmentMaxSize,'paramAttachmentMaxSize')));
  //$error=true;
}

foreach ($uploadedFileArray as $uploadedFile) {
  if (! $error) {
    if ( $uploadedFile['error']!=0) {
      //$error="[".$uploadedFile['error']."] ";
      errorLog("[".$uploadedFile['error']."] uploadPlugin.php");
      //$error=true;
      switch ($uploadedFile['error']) {
      	case 1:
      	  $error.=htmlGetErrorMessage("[".$uploadedFile['error']."] ".i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
      	  errorLog(i18n('errorTooBigFile',array(ini_get('upload_max_filesize'),'upload_max_filesize')));
      	  break;
      	case 2:
      	  $error.=htmlGetErrorMessage("[".$uploadedFile['error']."] ".i18n('errorTooBigFile',array($attachmentMaxSize,'paramAttachmentMaxSize')));
      	  errorLog(i18n('errorTooBigFile',array($attachmentMaxSize,'paramAttachmentMaxSize')));
      	  break;
      	case 4:
      	  $error.=htmlGetWarningMessage("[".$uploadedFile['error']."] ".i18n('errorNoFile'));
      	  errorLog(i18n('errorNoFile'));
      	  break;
      	case 3:
      	  $error.=htmlGetErrorMessage("[".$uploadedFile['error']."] ".i18n('errorUploadNotComplete'));
      	  errorLog(i18n('errorUploadNotComplete'));
      	  break;
      	default:
      	  $error.=htmlGetErrorMessage($error="[".$uploadedFile['error']."] ".i18n('errorUploadFile',array($uploadedFile['error'])));
      	  errorLog(i18n('errorUploadFile',array($uploadedFile['error'])));
      	  break;
      }
    }
  }
  if (! $error) {
    if (! $uploadedFile['name']) {
      $error=htmlGetWarningMessage(i18n('errorNoFile'));
      errorLog(i18n('errorNoFile'));
      //$error=true;
    }
  }
}
$pathSeparator=Parameter::getGlobalParameter('paramPathSeparator');
if (!$error) {
  foreach ($uploadedFileArray as $uploadedFile) {
    $fileName=$uploadedFile['name'];
	  $fileName=SqlElement::checkValidFileName($fileName); // only allow [a-z, A-Z, 0-9, _, -] in file name
    $mimeType=$uploadedFile['type'];
    $mimeType=SqlElement::checkValidMimeType($mimeType);
	  $fileSize=$uploadedFile['size'];   
    $uploaddir = Plugin::getDir();
    /*if (! file_exists($uploaddir)) {
      mkdir($uploaddir,0777,true);
    }*/
    $paramFilenameCharset=Parameter::getGlobalParameter('filenameCharset');
    if ($paramFilenameCharset) {
      $uploadfile = $uploaddir . $pathSeparator . iconv("UTF-8", $paramFilenameCharset.'//TRANSLIT//IGNORE',$fileName);
    } else {
      $uploadfile = $uploaddir . $pathSeparator . $fileName;
    }
    if ( ! move_uploaded_file($uploadedFile['tmp_name'], $uploadfile)) {
      $error = htmlGetErrorMessage(i18n('errorUploadFile','hacking ?'));
      errorLog(i18n('errorUploadFile','hacking ?'));
    } 
    $message="<div class='messageOK' >" . i18n('pluginFileUploaded') . "</div>"
      	      ."<input type='hidden' value='resultOK' />";
  }
}
// TODO: need to make sure script tags can't be injected via maliciously crafted mimeType
$jsonReturn = json_encode(array('file' => $fileName, 'name' => $fileName, 'type' => $mimeType, 'size' => $fileSize, 'message' => $message));
/*
$jsonReturn='{"file":"'.$fileName.'",'
    .'"name":"'.$fileName.'",'
        .'"type":"'.$mimeType.'",'
            .'"size":"'.$fileSize.'"  ,'
                .'"message":"'.$message.'"}';
*/
if ($isIE and $isIE<=9) {
  echo $message;
  echo '</body>';
  echo '</html>';
} else {
  ob_end_clean();
  echo $jsonReturn;
}?>