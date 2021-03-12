<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html style="margin: 0px; padding: 0px;">
<head>
  <script language="javascript">
    function autoRedirect() {
      window.setTimeout("document.getElementById('indexForm').submit()",10);
    }
  </script>
  <style>
    body {font-family:verdana;font-size:12pt}
    td {padding:2px 10px;}
    .header {background:#545381;color:white;}
    .min50 {min-width:50px;}
    .center{text-align:center;}
    .download{font-size:80%; border:1px solid #AAAAEE;background:#EEEEFF;color:#555555;text-decoration:none;}
  </style>
</head>

<body>
<?php

$version="V9.1";
$nbDays=1; // days
if (isset($_REQUEST['nbDays'])) $nbDays=intval($_REQUEST['nbDays']);
if ($nbDays<1) $nbDays=1;
$dateCheck=date("Y-m-d 00:00:00",time()-(($nbDays-1) * 24 * 60 * 60));
$scanDir=array('api','db','model','report','sso','tool','view');
$root="D:\\www\\projeqtor$version\\";
$out="D:\\www\\temp";

$action=(isset($_REQUEST['action']))?$_REQUEST['action']:null;
if ($action and $action=='zip') {
  $zipName=$out.DIRECTORY_SEPARATOR."projeqtor_patch$version.zip";
  $nbFiles=zipFiles();
  if ($nbFiles>0) {
    echo "$nbFiles fichiers dans $zipName";
    echo '&nbsp;<a class="download" href="'.str_replace('D:\\www\\','http://localhost/',$zipName).'" target="#">&nbsp;'.date('d-m-Y')." &agrave;  ".date('H:i:s').'&nbsp;</a>';
  } else {
    echo '&nbsp<br/>';
  }
} else {
  echo '&nbsp<br/>';
}

display();


function display() {
  global $scanDir,$dateCheck,$root,$out,$version,$nbDays;
  $files=array();
  foreach($scanDir as $dir) {
    $files=array_merge_preserve_keys($files,listFiles($dir));
  }
  krsort($files);
  echo "<form id='mainForm' action='/projeqtor$version/deploy/patch.php'>";
  $button="<button type='submit'>ZIP</button>";
  $dayInput="<input style='width:30px;margin-left:100px;text-align:center' type='text' name='nbDays' value='$nbDays' onChange='document.getElementById(\"action\").value=\"nbDays\";document.getElementById(\"mainForm\").submit();'/>";
  echo "<input type='hidden' name='action' id='action' value='zip' />";
  echo "<table><tr class='header'><td>date$dayInput</td><td>r&eacute;pertoire</td><td>fichier</td><td class='min50 center'>$button</td></tr>";
  foreach ($files as $file) {
    $date=$file['date'];
    $dir=$file['dir'];
    $fileName=$file['file'];
    $key=str_replace(array(' ','.'),array('_','_'),$date.'_'.$dir.DIRECTORY_SEPARATOR.$fileName);
    $checked=(isset($_REQUEST["file_$key"]))?' checked ':'';
    $check="<input type='checkbox' name='file_$key' $checked />";
    echo "<tr><td>$date</td><td>$dir</td><td>$fileName</td><td class='center'>$check</td></tr>";
  }
  echo "</table>";
  echo "</form>";
}

function listFiles($dir) {
  global $scanDir,$dateCheck,$root,$out,$version,$nbDays;
  $result = array();
  foreach (scandir($root.$dir) as $key => $value) {
    if (in_array($value,array(".",".."))) continue;
    if (substr($value,0,1)=='.') continue;
    if (is_dir($root.$dir.DIRECTORY_SEPARATOR.$value)) {
        $result=array_merge_preserve_keys($result,listFiles($dir.DIRECTORY_SEPARATOR.$value));
    } else {
      $date=date("Y-m-d H:i:s",filemtime($root.$dir.DIRECTORY_SEPARATOR.$value));
      //echo $value.' '.$date.'<br/>';
      if ($date<$dateCheck) continue; // Too old change
      $key=$date.'_'.$dir.DIRECTORY_SEPARATOR.$value;
      $result[$key] = array('dir'=>$dir, 'file'=>$value, 'date'=>$date);
    }
  }
  return $result;
}
function array_merge_preserve_keys() {
  $params=func_get_args();
  $result=array();
  foreach ($params as &$array) {
    foreach ($array as $key=>&$value) {
      $result[$key]=$value;
    }
  }
  return $result;
}
function zipFiles() {
  global $scanDir,$dateCheck,$root,$out,$version;
  $outDir=$out.DIRECTORY_SEPARATOR.'projeqtor';
  if (! file_exists($out)) mkdir($out,null,true);
  if (file_exists($outDir)) purgeDir($outDir,true);
  mkdir($outDir);
  $outDir.=DIRECTORY_SEPARATOR;
  $rootDir=$root.DIRECTORY_SEPARATOR;
  $files=array();
  foreach($scanDir as $dir) {
    $files=array_merge_preserve_keys($files,listFiles($dir));
  }
  $nbFiles=0;
  foreach ($files as $file) {
    $date=$file['date'];
    $dir=$file['dir'];
    $fileName=$file['file'];
    $key=str_replace(array(' ','.'),array('_','_'),$date.'_'.$dir.DIRECTORY_SEPARATOR.$fileName);
    $checked=(isset($_REQUEST["file_$key"]))?' checked ':'';
    if ($checked) {
      $nbFiles++;
      if (! file_exists($outDir.$dir)) mkdir($outDir.$dir,null,true);
      copy($root.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$fileName,$outDir.$dir.DIRECTORY_SEPARATOR.$fileName);
    }
  }
  $zipFile = str_replace('\projeqtor','',$outDir)."projeqtor_patch$version.zip";
  if (file_exists($zipFile)) unlink($zipFile);
  $zip=new ZipArchive();
  $ret=$zip->open($zipFile, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);
  $Directory = new RecursiveDirectoryIterator($outDir);
  $Iterator = new RecursiveIteratorIterator($Directory);
  $files = new RecursiveIteratorIterator($Directory, RecursiveIteratorIterator::SELF_FIRST);
  foreach ($files as $file) {
    $fileFullName=realpath($file);
    $file = str_replace('\\', '/', $file);
    $file=substr($file,strlen($out)+1);
    $fileName=basename($file);    
    if (substr($fileName,0,1)=='.') continue;
    if (is_dir($fileFullName) === true) {
      $zip->addEmptyDir($file);
    } else if (is_file($fileFullName) === true) {
      $content=file_get_contents($fileFullName);
      $zip->addFromString($file, $content);
    }
  }
  $zip->close();
  return $nbFiles;
}
function purgeDir($dir, $removeDirs=true) {
  if (! is_dir($dir)) {
    return;
  }
  $handle = opendir($dir);
  if (! is_resource($handle)) {
    return;
  }
  while (($file = readdir($handle)) !== false) {
    if ($file == '.' || $file == '..' || $file=='.svn') {
      continue;
    }
    $filepath = $dir == '.' ? $file : $dir . '/' . $file;
    if (is_link($filepath)) {
      continue;
    }
    if (is_file($filepath)) {
      unlink($filepath);
    } else if (is_dir($filepath)) {
      purgeDir($filepath, $removeDirs);
    }
  }
  if ($removeDirs) {
    rmdir($dir);
  }
  closedir($handle);
}
?>
</body>