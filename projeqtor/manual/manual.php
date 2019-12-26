<?php 
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2017 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
 * 
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU Affero General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Manual 
 */
   //include_once '../tool/projeqtor.php'; 
   header ('Content-Type: text/html; charset=UTF-8');
   session_start();
   $includeManual=true;
   include_once 'reference.php'; 
   $page=0;
   if (array_key_exists('page', $_REQUEST)) {
     $page=$_REQUEST['page'];
   } else if (array_key_exists('section', $_REQUEST)) {
     $sec=$_REQUEST['section'];
     foreach($section as $id=>$name) {
       if ($name==$sec) {
         $page=$id;
         break;
       }
     }
   }
   if ($page and ! is_numeric($page)) { echo "xxx";exit; }
   $tag='';
   if (array_key_exists('tag', $_REQUEST)) {
     $tag=$_REQUEST['tag'];
   }
   $secName=$slide[$page];
   $prev='';
   $prevSec='';
   $next='';
   $nextSec='';
   foreach ($slide as $id=>$name) {
     if ($id<$page) {
       $prev=$id;
       if ($slide[$id]==$secName) {
         $prevSec=$id;
       }
     } else if ($id>$page) {
       if ($slide[$id]==$secName) {
         $nextSec=$id;
       }
       $next=$id;
       break;
     }
   }
   $defaultTheme="ProjeQtOrLight";
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html class="<?php echo getTheme();?>">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>ProjeQtOr - Manual</title>
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <?php if (file_exists("../view/css/projeqtor.css")) {?>
    <link rel="stylesheet" type="text/css" href="../view/css/projeqtor.css" />
  <?php } else {?>
    <link rel="stylesheet" type="text/css" href="projeqtor.css" />
  <?php } ?>
  <?php if (file_exists("../external/dojo/dojo.js")) {?>
  <script type="text/javascript" 
          src="../external/dojo/dojo.js" 
          djConfig="modulePaths: {i18n: '../../tool/i18n'}, parseOnLoad: true, isDebug: false" >
  </script>
  <script type="text/javascript">  
      dojo.require("dijit.form.FilteringSelect");
  </script>
  <?php }?>
  <script type="text/javascript">
    function loadPage(page) {
      dojo.byId("page").value=page;
      dojo.byId("tag").value="<?php echo $tag;?>";
      dojo.byId("manualForm").submit();
      //window.location='manual.php?page='+page+'&tag=<?php echo $tag;?>';
    }
    function searchTag(tag) {
    	dojo.byId("page").value="<?php echo $page;?>";
      dojo.byId("tag").value=tag;
      dojo.byId("manualForm").submit();
    	//window.location='manual.php?tag='+tag+'&page=<?php echo $page;?>';
    }
    self.focus();
  </script>
</head>

<body class="<?php echo getTheme();?>" style="background-image: url();">
<table  valign="top" align="center" width="100%" height="100%" ><tr><td text-align="center" align="center">  
  <table valign="top" align="center" height="100%">
    <tr>
      <td width="210px" valign="top" align="center">
        <div class="title" style="text-align:center; height:20px;">
          INDEX
        </div>
        <div class="title" style="font-size:11px;text-align:left;cursor: pointer; height:20px;" >
          &nbsp;&nbsp;search tag : 
          <select dojoType="dijit.form.FilteringSelect" class="input" 
           style="width:110px;font-size:10px"
           <?php echo autoOpenFilteringSelect();?>
           name='manualTag' id='manualTag' value="<?php echo $tag;?>" onchange="searchTag(this.value);">
            <?php foreach ($tags as $id=>$list) {
              if ($list) {
                echo '<option value="' . $id . '" ';
                echo ($id==$tag)?' SELECTED ':'';
                echo '>' . $id .'</option>';
              }
            }?>
            <script type="dojo/connect" event="onChange" >
              searchTag(this.value);
            </script>
          </select>
        </div> 
        <div style="width:200px; height:600px;overflow: auto; text-shadow: 0px 0px;">
        <?php displayIndex($page, $tag);?>
        </div>
      </td>
      <td valign="top" align="left" width="800px">
        <table width="100%">
          <tr height="40px">
            <td width="120px" align="left" valign="middle"><span class="nobr">
             <img/ src="img/home.png" onclick="loadPage(0)" /> 
             <?php if ($prev!=='') {?>
                <img src="img/left.png" onClick="loadPage(<?php echo $prev;?>)" />
              <?php } else {?>
                <img src="img/left-inactive.png" />
              <?php }?> 
              <?php if ($next!='') {?>
                <img src="img/right.png" onClick="loadPage(<?php echo $next;?>)" />
              <?php } else {?>
                <img src="img/right-inactive.png" />
              <?php }?></span>           
            </td>
            <td valign="top">
              <div style="overflow: auto; width: 100%; height: 40px; text-shadow: 0px 0px;">
                <?php displayTopics($page);?>
              </div>
            </td>
            <td width="80px" align="right" valign="middle"><span class="nobr">
              <?php if ($prevSec!='') {?>
                <img src="img/first.png" onClick="loadPage(<?php echo $prevSec;?>)" />
              <?php } else {?>
                <img src="img/first-inactive.png" />
              <?php }?> 
              <?php if ($nextSec!='') {?>
                <img src="img/last.png" onClick="loadPage(<?php echo $nextSec;?>)" />
              <?php } else {?>
                <img src="img/last-inactive.png" />
              <?php }?> </span>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <img src="slides/img<?php echo $page;?>.png" />
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</td></tr></table>
<form  method="POST" style="display:none" id="manualForm" action="manual.php">
  <input pe="hidden" name="page" id="page" value="" />
  <input pe="hidden" name="tag" id="tag" value="" />
</form>
</body>
</html>

<?php 
function displayIndex($page, $tag) {
  global $slide, $section, $slideName, $tags;
  echo '<table class="background" width="100%" align="center">';
  if ($tag) {
    $lst=$tags[$tag];
    sort($lst);
    foreach ($lst as $id) {
      echo '<tr class="menuTree" height="20px">';
      echo '<td width="15px" align="center" >';
      echo ($id==$page)?'<img src="img/level.png" />':'';
      echo '</td>';
      echo '<td class="menuTree tabLabel" style="text-align:left;cursor: pointer" onClick="loadPage(' . $id . ');">';
      echo $slideName[$id];
      echo '</td></tr>';
    }    
  } else {
    foreach ($section as $id=>$name) {
      echo '<tr class="menuTree" height="20px">';
      echo '<td width="15px" align="center" >';
      echo ($name==$slide[$page])?'<img src="img/level.png" />':'';
      echo '</td>';
      echo '<td class="menuTree tabLabel" style="text-align:left;cursor: pointer" onClick="loadPage(' . $id . ');">';
      echo $slideName[$id];
      echo '</td></tr>';
    }
  }
  echo '</table>';
}

function getTheme() {
  global $defaultTheme;
  $theme='ProjeQtOr'; // default if never  set
  if (isset($defaultTheme)) {
    $theme=$defaultTheme;   
  }
  if ( sessionValueExists('theme')) {
  	$theme=getSessionValue('theme');
  }
  if ($theme=="random") {
    $themes=array_keys(Parameter::getList('theme'));
    $rnd=rand(0, count($themes)-2);
    $theme=$themes[$rnd];
    setSessionValue('theme',$theme); // keep value in session to have same theme during all session...
  }
  return $theme;
}

function displayTopics($numPage) {
  global $slideTopics, $slidePage, $slideName;
  $lstTopics=$slideTopics[$numPage];
  $split=explode(' ', $lstTopics);
  //$empty=true;
  foreach($split as $id=>$top) {
    if (array_key_exists($top, $slidePage)) {
      $topPage=$slidePage[$top];
      if (array_key_exists($topPage, $slideName)) {
        $topName=$slideName[$topPage];
        //if (! $empty) {echo ' ';}
        echo '<a class="menuTree tabLabel" style="line-height:150%; border: 1px solid grey;"' 
         . ' onclick="loadPage(' . $topPage . ');" title="go to related topic"><span class="nobr">' . $topName . '</span></a> ';
        //$empty=false;
      }
    }
  } 
}