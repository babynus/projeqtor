<?php
include "../files/config/parameters.php";

$dbType=$paramDbType;
$dbHost=$paramDbHost;
$dbPort=$paramDbPort;
$dbUser=$paramDbUser;
$dbPassword=$paramDbPassword;
$dbName=$paramDbName;

ini_set('mysql.connect_timeout', 10);
$dsn = $dbType.':host='.$dbHost.';port='.$dbPort.';dbname='.$dbName;
$connexion = new PDO($dsn, $dbUser, $dbPassword);
$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$connexion->query("SET NAMES utf8");
ini_set('mysql.connect_timeout', 60);

$sql = 'SHOW TABLE STATUS';
$result_tables = $connexion->query($sql);
foreach($result_tables as $table) {
  $tableName=$table['Name'];
  $sql="DESC $tableName;";
  $result_rows = $connexion->query($sql);
  foreach($result_rows as $row) {
    //echo " - ".$row['Field']. " => ".$row['Type']. "<br/>"; 
    //if ($row['Comment']) echo " ".$row['Field']. " => ".$row['Comment']. "<br/>";
    $type=$row['Type'];
    $name=$row['Field'];
    if ($name=='id') continue;
    if (strtolower(substr($type,0,3))=='int') {
      $size=explode(')',explode('(',$type)[1])[0];
      echo "ALTER TABLE \${prefix}$tableName MODIFY $name $type COMMENT '$size';<br/>";
    }
  }
}