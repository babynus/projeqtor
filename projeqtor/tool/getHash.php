<?php
/** ============================================================================
 * 
 */
require_once "../tool/projeqtor.php";
$username="";
if (isset($_REQUEST['username'])) {
	$username=$_REQUEST['username'];
}
$crit=array('name'=>$username);
$user=SqlElement::getSingleSqlElementFromCriteria('User', $crit);
$sessionSalt=md5("projeqtor".date('YmdHis'));
$_SESSION['sessionSalt']=$sessionSalt;
echo $user->crypto.";".$user->salt.";".$sessionSalt;