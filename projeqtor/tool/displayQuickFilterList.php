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

/** ===========================================================================
 * Save a filter : call corresponding method in SqlElement Class
 * The new values are fetched in REQUEST
 */
require_once "../tool/projeqtor.php";
scriptLog('   ->/tool/displayQuickFiletrList.php');
$referenceWidth = 50;
if(!isset($objectClass)){
  if($filterObjectClass)$objectClass=$filterObjectClass;
  if($objectClass){
    $idClassType = "id". $objectClass. "Type";
    $objectType = $idClassType;
  }
}
if(!isset($obj)){
  if(isset($objectClass)){
    $obj=new $objectClass;
    $object = $obj;
  }
}

if(!isset($idClassType)){
  if(isset($objectClass)){
    $idClassType = "id". $objectClass. "Type";
    $objectType = $idClassType;
  }
}

$user=getSessionUser();
$context="";
$comboDetail=false;
if (RequestHandler::isCodeSet('comboDetail')) {
  $comboDetail=true;
}
?>
<table style="width:99%;" id="quickFilterList">
  <tr style="width:100%;border-bottom:solid 1px;">
    <td><table>
      <tr> 
        <td style="width:60%;text-transform: uppercase;"><?php echo i18n("filters");?></td>
        <td style="text-align:center;" class="allSearchTD resetSearchTD allSearchFixLength">
          <button dojoType="dijit.form.Button" type="button" >
            <?php echo i18n('buttonReset');?>
            <?php $listStatus = $object->getExistingStatus(); $lstStat=(count($listStatus));?>
            <script type="dojo/method" event="onClick">
                     var lstStat = <?php echo json_encode($lstStat); ?>;
                     resetFilterQuick(lstStat);
             </script>
          </button>
        </td>
        <td style="width:10%;font-style:italic;color:grey;"><?php echo i18n("alwaysDisplay");?></td>
      </tr>
    </table></td>
  </tr>
  <tr><td>
    <table style="width:100%">
     <br> 
      <tr>
        <td style="text-align:right;width:25%">
          <span class="nobr"><?php echo i18n("colId")?>&nbsp;:&nbsp;</span> 
        </td>
        <td style="width:65%">
          <div title="<?php echo i18n('filterOnId')?>" style="width:<?php echo $referenceWidth;?>px" class="filterField rounded" dojoType="dijit.form.TextBox" 
                type="text" id="listIdFilterQuick" name="listIdFilterQuick" value="<?php if(!$comboDetail and sessionValueExists('listIdFilter'.$objectClass)){ echo getSessionValue('listIdFilter'.$objectClass); }?>">
            <script type="dojo/method" event="onKeyUp" >
              if(dijit.byId('listIdFilterQuick').get('value') =='' && dijit.byId('listIdFilterQuickSw').get('value')=='off'){
                dojo.byId('filterDivsSpan').style.display="none";
                dijit.byId('listIdFilter').domNode.style.display = 'none';
              }else{
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                dojo.byId('filterDivsSpan').style.display="block";
                dijit.byId('listIdFilter').domNode.style.display = 'block';
              }
              setTimeout("dijit.byId('listIdFilter').set('value',dijit.byId('listIdFilterQuick').get('value'))",10);
              setTimeout("filterJsonList('<?php echo $objectClass;?>');",10);
            </script>
          </div>
        </td>
        <td style="width:10%;text-align:center;">
          <div  id="listIdFilterQuickSw" name="listIdFilterQuickSw" class="colorSwitch" data-dojo-type="dojox/mobile/Switch" value="<?php if(sessionValueExists('listIdFilterQuickSw'.$objectClass)){ echo getSessionValue('listIdFilterQuickSw'.$objectClass); }else{?>off<?php }?>" leftLabel="" rightLabel="">
            <script type="dojo/method" event="onStateChanged" >
              saveDataToSession('listIdFilterQuickSw<?php echo $objectClass;?>',this.value);
              if(this.value=='on'){
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                if(dojo.byId('filterDivsSpan').style.display=="none"){
                  dojo.byId('filterDivsSpan').style.display="block";
                  dijit.byId('listIdFilter').domNode.style.display = 'block';
                }
              }else{
                if(dojo.byId('filterDivsSpan').style.display=="block" && dijit.byId('listIdFilter').get('value')=='') {
                  dojo.byId('filterDivsSpan').style.display="none";
                  dijit.byId('listIdFilter').domNode.style.display = 'none';
                }
              }
            </script>
          </div>
        </td>
      </tr>
      
      <?php if ( property_exists($obj,'name') or get_class($obj)=='Affectation') { ?>
      <tr> 
        <td style="text-align:right;width:25%">
          <span class="nobr"><?php echo i18n("colName");?>&nbsp;:&nbsp;</span> 
        </td>
        <td style="width:65%">
          <div title="<?php echo i18n('filterOnName')?>" style="width:<?php echo $referenceWidth*4;?>px" type="text" class="filterField rounded" dojoType="dijit.form.TextBox" 
              id="listNameFilterQuick" name="listNameFilterQuick"  value="<?php if(!$comboDetail and sessionValueExists('listNameFilter'.$objectClass)){ echo getSessionValue('listNameFilter'.$objectClass); }?>">
            <script type="dojo/method" event="onKeyUp" >
             if(dijit.byId('listNameFilterQuick').get('value') =='' && dijit.byId('listNameFilterQuickSw').get('value')=='off'){
                dojo.byId('listNameFilterSpan').style.display="none";
                dijit.byId('listNameFilter').domNode.style.display = 'none';
              }else{
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                dojo.byId('listNameFilterSpan').style.display="block";
                dijit.byId('listNameFilter').domNode.style.display = 'block';
              }
              dijit.byId('listNameFilter').set('value',dijit.byId('listNameFilterQuick').get('value'));
              setTimeout("filterJsonList('<?php echo $objectClass;?>');",10);
            </script>
          </div>
        </td>
        <td style="width:10%;text-align:center;">
          <div id="listNameFilterQuickSw" name="listNameFilterQuickSw" class="colorSwitch" data-dojo-type="dojox/mobile/Switch" value="<?php if(sessionValueExists('listNameFilterQuickSw'.$objectClass)){ echo getSessionValue('listNameFilterQuickSw'.$objectClass); }else{?>off<?php }?>" leftLabel="" rightLabel="">
            <script type="dojo/method" event="onStateChanged" >
              saveDataToSession('listNameFilterQuickSw<?php echo $objectClass;?>',this.value);
              if(this.value=='on'){
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                if(dojo.byId('listNameFilterSpan').style.display=="none"){
                    dojo.byId('listNameFilterSpan').style.display="block";
                    dijit.byId('listNameFilter').domNode.style.display = 'block';
                }
              }else{
                if(dojo.byId('listNameFilterSpan').style.display=="block" && dijit.byId('listNameFilter').get('value')=='') {
                  dojo.byId('listNameFilterSpan').style.display="none";
                  dijit.byId('listNameFilter').domNode.style.display = 'none';
                }
              }
            </script>
          </div>
        </td>
      </tr><?php }?>
      
      <?php if ( ( property_exists($obj,'id' . $objectClass . 'Type')) or ( $objectClass=='EmployeeLeaveEarned' and property_exists($obj,'idLeaveType')) ) { ?>
      <tr>
        <td style="text-align:right;width:25%;text-transform:lowercase;"> <span class="nobr"><?php echo i18n("colType");?> &nbsp;:&nbsp;</span> </td>
        <td style="width:65%">
         <select dojoType="dijit.form.FilteringSelect" class="input"  id="listTypeFilterQuick" name="listTypeFilterQuick"
          <?php echo autoOpenFilteringSelect();?>
            title="<?php echo i18n('helpLang');?>" style="width:<?php echo $referenceWidth*4;?>px" value="<?php if(!$comboDetail and sessionValueExists('listTypeFilter'.$objectClass)){ echo getSessionValue('listTypeFilter'.$objectClass); }?>">
            <script type="dojo/connect" event="onChange" >
              if( this.value ==' ' && dijit.byId('listTypeFilterQuickSw').get('value')=='off'){
                dojo.byId('listTypeFilterSpan').style.display="none";
                dijit.byId('listTypeFilter').domNode.style.display = 'none';
              }else{
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                dojo.byId('listTypeFilterSpan').style.display="block";
                dijit.byId('listTypeFilter').domNode.style.display = 'block';
              }
              dijit.byId('listTypeFilter').set('value',this.value);
              refreshJsonList('<?php echo $objectClass;?>');
            </script>
            <?php  htmlDrawOptionForReference($idClassType, $objectType, $obj, false); ?>
          </select>
        </td>
        <td style="width:10%;text-align:center;">
          <div id="listTypeFilterQuickSw" name="listTypeFilterQuickSw" class="colorSwitch" data-dojo-type="dojox/mobile/Switch" value="<?php if(sessionValueExists('listTypeFilterQuickSw'.$objectClass)){ echo getSessionValue('listTypeFilterQuickSw'.$objectClass); }else{?>off<?php }?>" leftLabel="" rightLabel="">
            <script type="dojo/method" event="onStateChanged" >
              saveDataToSession('listTypeFilterQuickSw<?php echo $objectClass;?>',this.value);
              if(this.value=='on'){
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                if(dojo.byId('listTypeFilterSpan').style.display=="none"){
                    dojo.byId('listTypeFilterSpan').style.display="block";
                    dijit.byId('listTypeFilter').domNode.style.display = 'block';
                }
              }else{
                if(dojo.byId('listTypeFilterSpan').style.display=="block" && ( dijit.byId('listTypeFilter').get('value')=='' || dijit.byId('listTypeFilter').get('value')==' ' )) {
                  dojo.byId('listTypeFilterSpan').style.display="none";
                  dijit.byId('listTypeFilter').domNode.style.display = 'none';
                }
              }
            </script>
          </div>
         </td>
         </tr>
      <?php }?>
      
      
      <?php if ( property_exists($obj,'idClient') ) { ?>
      <tr>
        <td style="text-align:right;width:25%;text-transform:lowercase;"><span class="nobr">&nbsp; <?php echo i18n("colClient");?>&nbsp;:&nbsp;</span> </td>
        <td style="width:65%">
          <select title="<?php echo i18n('filterOnClient')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
            <?php echo autoOpenFilteringSelect();?> 
            data-dojo-props="queryExpr: '*${0}*',autoComplete:false"
            id="listClientFilterQuick" name="listClientFilterQuick" style="width:<?php echo $referenceWidth*4;?>px" value="<?php if(!$comboDetail and sessionValueExists('listClientFilter'.$objectClass)){ echo getSessionValue('listClientFilter'.$objectClass); }?>" >
            <?php htmlDrawOptionForReference('idClient', $objectClient, $obj, false); ?>
            <script type="dojo/method" event="onChange" >
                    if(this.value ==' ' && dijit.byId('listClientFilterQuickSw').get('value')=='off'){
                      dojo.byId('listClientFilterSpan').style.display="none";
                      dijit.byId('listClientFilter').domNode.style.display = 'none';
                    }else{
                      if(dojo.byId('filterDivs').style.display=="none"){
                        dojo.byId('filterDivs').style.display="block";
                      }
                      dojo.byId('listClientFilterSpan').style.display="block";
                      dijit.byId('listClientFilter').domNode.style.display = 'block';
                    }
                    dijit.byId('listClientFilter').set('value',this.value);
                    refreshJsonList('<?php echo $objectClass;?>');
                  </script>
          </select>
        </td>
        <td style="width:10%;text-align:center;">
          <div id="listClientFilterQuickSw" name="listClientFilterQuickSw" class="colorSwitch" data-dojo-type="dojox/mobile/Switch" value="<?php if(!$comboDetail and sessionValueExists('listClientFilterQuickSw'.$objectClass)){ echo getSessionValue('listClientFilterQuickSw'.$objectClass); }else{?>off<?php }?>" leftLabel="" rightLabel="">
            <script type="dojo/method" event="onStateChanged" >
              saveDataToSession('listClientFilterQuickSw<?php echo $objectClass;?>',this.value);
              if(this.value=='on'){
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                if(dojo.byId('listClientFilterSpan').style.display=="none"){
                    dojo.byId('listClientFilterSpan').style.display="block";
                    dijit.byId('listClientFilter').domNode.style.display = 'block';
                }
              }else{
                if(dojo.byId('listClientFilterSpan').style.display=="block" && ( dijit.byId('listTypeFilter').get('value')=='' || dijit.byId('listTypeFilter').get('value')==' ' )) {
                  dojo.byId('listClientFilterSpan').style.display="none";
                  dijit.byId('listClientFilter').domNode.style.display = 'none';
                }
              }
            </script>
          </div>
        </td>
      </tr>         
      <?php } ?>
      
      <?php if ( $objectClass == 'Budget' ) { ?>
        <tr>
          <td style="width:25%;text-align:right;text-transform:lowercase;"><span class="nobr">&nbsp; <?php echo i18n("colParentBudget");?>&nbsp;:&nbsp;</span></td>
          <td style="width:65%;">
            <select title="<?php echo i18n('filterOnBudgetParent')?>" type="text" class="filterField roundedLeft" dojoType="dijit.form.FilteringSelect"
                <?php echo autoOpenFilteringSelect();?> 
                data-dojo-props="queryExpr: '*${0}*',autoComplete:false"
                id="listBudgetParentFilterQuick" name="listBudgetParentFilterQuick" style="width:<?php echo $referenceWidth*4;?>px" value="<?php if(!$comboDetail and sessionValueExists('listBudgetParentFilter')){ echo getSessionValue('listBudgetParentFilter'); }?>" >
                  <?php 
                   htmlDrawOptionForReference('idBudgetItem',$budgetParent,$obj,false);?>
                  <script type="dojo/method" event="onChange" >
                    if(this.value ==' ' && dijit.byId('listBudgetParentFilterQuickSw').get('value')=='off'){
                      dojo.byId('listBudgetParentFilterSpan').style.display="none";
                      dijit.byId('listBudgetParentFilter').domNode.style.display = 'none';
                    }else{
                      if(dojo.byId('filterDivs').style.display=="none"){
                        dojo.byId('filterDivs').style.display="block";
                      }
                      dojo.byId('listBudgetParentFilterSpan').style.display="block";
                      dijit.byId('listBudgetParentFilter').domNode.style.display = 'block';
                    }
                    dijit.byId('listBudgetParentFilter').set('value',this.value);
                    refreshJsonList('<?php echo $objectClass;?>');
                  </script>
          </select>
        </td>
        <td style="width:10%;text-align:center;">
          <div id="listBudgetParentFilterQuickSw" name="listBudgetParentFilterQuickSw" class="colorSwitch" data-dojo-type="dojox/mobile/Switch" value="<?php if(!$comboDetail and sessionValueExists('listBudgetParentFilterQuickSw'.$objectClass)){ echo getSessionValue('listBudgetParentFilterQuickSw'.$objectClass); }else{?>off<?php }?>" leftLabel="" rightLabel="">
            <script type="dojo/method" event="onStateChanged" >
              saveDataToSession('listClientFilterQuickSw<?php echo $objectClass;?>',this.value);
              if(this.value=='on'){
                if(dojo.byId('filterDivs').style.display=="none"){
                  dojo.byId('filterDivs').style.display="block";
                }
                if(dojo.byId('listBudgetParentFilterSpan').style.display=="none"){
                    dojo.byId('listBudgetParentFilterSpan').style.display="block";
                    dijit.byId('listBudgetParentFilter').domNode.style.display = 'block';
                }
              }else{
                if(dojo.byId('listBudgetParentFilterSpan').style.display=="block" && (dijit.byId('listTypeFilter').get('value')=='' || dijit.byId('listTypeFilter').get('value')==' ' )){
                  dojo.byId('listBudgetParentFilterSpan').style.display="none";
                  dijit.byId('listBudgetParentFilter').domNode.style.display = 'none';
                }
              }
            </script>
          </div>
        </td>
      </tr>  
      <?php }?>
      
      <?php  if (! $comboDetail) {?>
       <tr>
         <td  style="width:25%;text-align:right;text-transform:lowercase;"><span class="nobr"><?php echo i18n("quickSearch");?>&nbsp;:&nbsp;</span></td>
         <td  colspan=2 style="width:65%;">
            <div title="<?php echo i18n('quickSearch')?>" type="text" class="filterField rounded" dojoType="dijit.form.TextBox" 
               id="quickSearchValueQuick" name="quickSearchValueQuick"
               style="width:200px;">
            </div>
             <button title="<?php echo i18n('quickSearch')?>"  
  	          dojoType="dijit.form.Button" 
  	          id="listQuickSearchExecuteQuick" name="listQuickSearchExecuteQuick"
  	          iconClass="dijitButtonIcon dijitButtonIconSearch" class="detailButton" showLabel="false">
  	          <script type="dojo/connect" event="onClick" args="evt">
                quickSearchExecuteQuick();
              </script>
  	        </button>
  	        <button title="<?php echo i18n('comboCloseButton')?>"  
            dojoType="dijit.form.Button" id="listQuickSearchCloseQuick" name="listQuickSearchCloseQuick"
            iconClass="dijitButtonIcon dijitButtonIconUndo" class="detailButton" showLabel="false">
            <script type="dojo/connect" event="onClick" args="evt">
              quickSearchCloseQuick();
            </script>
          </button></td>  
		    </tr>
			  <?php } ?>
      <?php if ( property_exists($obj, 'idStatus') and Parameter::getGlobalParameter('filterByStatus') == 'YES' and $objectClass!='GlobalView') {  ?> 
      <tr style="height:37px;">
        <td colspan=2 style="width:25%;text-align:left;text-transform:lowercase;"><span class="nobr">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo i18n("filterByStatusQuick");?>&nbsp;:&nbsp;</span></td>
			  <td style="width:10%;text-align:center;">
			   <div id="filterByStatusSwitch" name="filterByStatusSwitch" class="colorSwitch" data-dojo-type="dojox/mobile/Switch" value="<?php if(!$comboDetail and sessionValueExists('displayByStatusListSwitch'.$objectClass)){ echo getSessionValue('displayByStatusListSwitch'.$objectClass); }else{?>off<?php }?>" leftLabel="" rightLabel="">
            <script type="dojo/method" event="onStateChanged" >
              saveDataToSession('displayByStatusListSwitch<?php echo $objectClass;?>',this.value);
              if (dijit.byId('barFilterByStatus').domNode.style.display == 'none') {
							         dijit.byId('barFilterByStatus').domNode.style.display = 'block';
						         } else {
							         dijit.byId('barFilterByStatus').domNode.style.display = 'none';
						         }
						         dijit.byId('barFilterByStatus').getParent().resize();
                     saveDataToSession("displayByStatusList_<?php echo $objectClass;?>", dijit.byId('barFilterByStatus').domNode.style.display, true);
            </script>
          </div>
			  </td>
      </tr>
      <?php } ?>
     </table>
     <br><br>
     <table style="width: 100%;">
      <tr style="border-top:solid 1px;">
        <td> 
          <button title="<?php echo i18n('advancedFilter')?>"  
                  dojoType="dijit.form.Button" 
                  id="listFilterFilterDisplay" name="listFilterFilterDisplay"
                  iconClass="dijitButtonIcon dijitButtonIconFilter"
                   class="detailButton" showLabel="false">
                <script type="dojo/connect" event="onClick" args="evt">
                   showFilterDialog();
                </script>
          </button>
          <?php echo i18n('advancedFilters');?>
        </td>
      </tr>  
    </table>
  </td></tr>
</table>
<br/> 