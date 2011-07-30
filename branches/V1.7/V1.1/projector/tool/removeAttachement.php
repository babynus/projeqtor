<?php
/** ===========================================================================
 * Delete the current attachement : call corresponding method in SqlElement Class
 */

require_once "../tool/projector.php";

$attachementId=null;
if (array_key_exists('attachementId',$_REQUEST)) {
  $attachementId=$_REQUEST['attachementId'];
}
$attachementId=trim($attachementId);
if ($attachementId=='') {
  $attachementId=null;
} 
if ($attachementId==null) {
  throwError('attachementId parameter not found in REQUEST');
}
$obj=new Attachement($attachementId);
// TODO : file may have been deleted / chek before
if (file_exists($obj->subDirectory . $obj->fileName)) {
  unlink($obj->subDirectory . $obj->fileName);
  rmdir($obj->subDirectory);
}
$result=$obj->delete();

// Message of correct saving
if (stripos($result,'id="lastOperationStatus" value="ERROR"')>0 ) {
  echo '<span class="messageERROR" >' . $result . '</span>';
} else if (stripos($result,'id="lastOperationStatus" value="OK"')>0 ) {
  echo '<span class="messageOK" >' . $result . '</span>';
} else { 
  echo '<span class="messageWARNING" >' . $result . '</span>';
}
?>