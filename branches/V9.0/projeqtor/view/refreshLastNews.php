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
 * Presents the list of objects of a given class.
 *
 */
require_once "../tool/projeqtor.php";
require_once "../tool/formatter.php";
scriptLog('   ->/view/refreshLastNews.php');
$userLang = getSessionValue('currentLocale');
$lang = "en";
if(substr($userLang,0,2)=="fr")$lang="fr";
?>
<div class="swapView" data-dojo-type="dojox/mobile/SwapView"  id="divNewsPage1" name="divNewsPage1">
        <table>
          <tr><?php 
            $urlGetNews = "http://projeqtor.org/admin/getNews.php";
            $currentVersion=null;
            if (ini_get('allow_url_fopen')) {
              enableCatchErrors();
              $currentVersion=file_get_contents($urlGetNews);
              disableCatchErrors();
             }
           $json = file_get_contents($urlGetNews);
           $obj = json_decode($json);
           $i=1;
           foreach ($obj as $objV=>$val){
              if($val!="id"){
                foreach ($val as $value){
                 if($value->lang!=$lang )continue;
                 if($i==5)break;
                 if($i==3){?><tr><?php } ?>
                <td>
                  <table>
                    <tr>
                      <td>
                        <div style="position:relative;border-top-left-radius:5px;border-top-right-radius:5px;color:var(--color-dark);font-weight:bold;cursor:pointer;text-align:center;display:flex;flex-direction:column;justify-content:center;overflow:hidden;<?php if($i==1 or $i==3){?>margin-right:10px; <?php } ?>margin-bottom:10px;height:165px;width:165px;background:#DCDCDC;border-radius:5px;" id="divMsgTitle<?php echo $i;?>" name="divMsgTitle<?php echo $i;?>" onmouseout="hideIntrotext(<?php echo $i;?>)" onmouseover="showIntrotext(<?php echo $i;?>)" onClick="showMsg(<?php echo $i;?>,<?php echo $i/4;?>);">
                          <?php echo $value->title;?>  <div style="position:absolute;left:72px;bottom:6px;" class="arrow-down"></div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><div onmouseout="hideIntrotext(<?php echo $i;?>)" onmouseover="showIntrotext(<?php echo $i;?>)" style="cursor:pointer;display:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:10px;width:165px;height:65px;overflow-y:auto;background:#f2f5f5;" id="divSubTitle<?php echo $i;?>" name="divSubTitle<?php echo $i;?>" onClick="showMsg(<?php echo $i;?>,<?php echo $i/4;?>);"><br><div style="margin-left:10px;"><?php echo $value->introtext;?></div></div></td>
                    </tr>
                     <tr>
                      <td><div style="cursor:pointer;display:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:10px;width:165px;height:50px;overflow-y:auto;background:#f2f5f5;" id="divMsgFull<?php echo $i;?>" name="divMsgFull<?php echo $i;?>" onClick="hideMsg(<?php echo $i;?>,<?php echo $i/4;?>);"><br><div style="margin-left:10px;"><?php echo $value->introtext.$value->fulltext;?></div></div></td>
                    </tr>
                  </table>
                </td>
                <?php $i++;
                  if($i==3){?></tr><?php }
                }
               }
              }?>
        </tr>
        </table>
    </div>
    <div class="swapView" data-dojo-type="dojox/mobile/SwapView"  id="divNewsPage2" name="divNewsPage2">
        <table>
          <tr><?php
          $i=0;
           foreach ($obj as $objV=>$val){
              if($val!="id"){
                foreach ($val as $value){
                 if($value->lang!=$lang )continue;
                 $i++;
                 if($i<5)continue;
                 if($i==9)break;
                 if($i==7){?><tr><?php } ?>
                 <td>
                  <table>
                    <tr>
                      <td>
                        <div style="color:var(--color-dark);font-weight:bold;cursor:pointer;text-align:center;display:flex;flex-direction:column;justify-content:center;overflow:hidden;margin-right:10px;margin-bottom:10px;height:85px;width:155px;background:#f5f5f5;border-radius:5px;" id="divMsgTitle<?php echo $i;?>" name="divMsgTitle<?php echo $i;?>" onmouseout="hideIntrotext(<?php echo $i;?>)" onmouseover="showIntrotext(<?php echo $i;?>)" onClick="showMsg(<?php echo $i;?>,<?php echo $i/4;?>);">
                          <?php echo $value->title;?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><div onmouseout="hideIntrotext(<?php echo $i;?>)" onmouseover="showIntrotext(<?php echo $i;?>)" style="cursor:pointer;display:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:10px;width:155px;height:65px;overflow-y:auto;background:#f2f5f5;" id="divSubTitle<?php echo $i;?>" name="divSubTitle<?php echo $i;?>" onClick="showMsg(<?php echo $i;?>,<?php echo $i/4;?>);"><br><div style="margin-left:10px;"><?php echo $value->introtext;?></div></div></td>
                    </tr>
                     <tr>
                      <td><div style="cursor:pointer;display:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:10px;width:155px;height:50px;overflow-y:auto;background:#f2f5f5;" id="divMsgFull<?php echo $i;?>" name="divMsgFull<?php echo $i;?>" onClick="hideMsg(<?php echo $i;?>,<?php echo $i/4;?>);"><br><div style="margin-left:10px;"><?php echo $value->introtext.$value->fulltext;?></div></div></td>
                    </tr>
                  </table>
                </td>
                <?php 
                  if($i==8){?></tr><?php }
                }
               }
              }?>
        </tr>
        </table>
    </div>
    <div class="swapView" data-dojo-type="dojox/mobile/SwapView"  id="divNewsPage3" name="divNewsPage3">
        <table>
          <tr><?php
          $i=0;
           foreach ($obj as $objV=>$val){
              if($val!="id"){
                foreach ($val as $value){
                 if($value->lang!=$lang )continue;
                 $i++;
                 if($i<9)continue;
                 if($i==13)break;
                 if($i==11){?><tr><?php } ?>
                          <td>
                  <table>
                    <tr>
                      <td>
                        <div style="color:var(--color-dark);font-weight:bold;cursor:pointer;text-align:center;display:flex;flex-direction:column;justify-content:center;overflow:hidden;margin-right:10px;margin-bottom:10px;height:85px;width:155px;background:#f5f5f5;border-radius:5px;" id="divMsgTitle<?php echo $i;?>" name="divMsgTitle<?php echo $i;?>" onmouseout="hideIntrotext(<?php echo $i;?>)" onmouseover="showIntrotext(<?php echo $i;?>)" onClick="showMsg(<?php echo $i;?>,<?php echo $i/4;?>);">
                          <?php echo $value->title;?>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><div onmouseout="hideIntrotext(<?php echo $i;?>)" onmouseover="showIntrotext(<?php echo $i;?>)" style="cursor:pointer;display:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:10px;width:155px;height:65px;overflow-y:auto;background:#f2f5f5;" id="divSubTitle<?php echo $i;?>" name="divSubTitle<?php echo $i;?>" onClick="showMsg(<?php echo $i;?>,<?php echo $i/4;?>);"><br><div style="margin-left:10px;"><?php echo $value->introtext;?></div></div></td>
                    </tr>
                     <tr>
                      <td><div style="cursor:pointer;display:none;border-bottom-left-radius:5px;border-bottom-right-radius:5px;margin-bottom:10px;width:155px;height:50px;overflow-y:auto;background:#f2f5f5;" id="divMsgFull<?php echo $i;?>" name="divMsgFull<?php echo $i;?>" onClick="hideMsg(<?php echo $i;?>,<?php echo $i/4;?>);"><br><div style="margin-left:10px;"><?php echo $value->introtext.$value->fulltext;?></div></div></td>
                    </tr>
                  </table>
                </td>
                <?php
                  if($i==12){?></tr><?php }
                }
               }
              }?>
        </tr>
        </table>
    </div>
    <div class="indicatorPage" data-dojo-type="dojox/mobile/PageIndicator" data-dojo-props='fixed:"bottom"'></div>
