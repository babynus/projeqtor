<?php
/*
 *	@author: qCazelles
 */

include_once("../tool/projeqtor.php");

if (! array_key_exists('objectClass',$_REQUEST)) {
	throwError('Parameter objectClass not found in REQUEST');
}
$objectClass=$_REQUEST['objectClass'];
Security::checkValidClass($objectClass);

if (! array_key_exists('objectId',$_REQUEST)) {
	throwError('Parameter objectId not found in REQUEST');
}
$objectId=$_REQUEST['objectId'];
Security::checkValidId($objectId);

$contextId=null;
if (array_key_exists('contextId',$_REQUEST)) {
	$contextId=$_REQUEST['contextId'];
	Security::checkValidId($contextId);
}

$listClass = 'Context';
$str=new ProductContext($contextId);
$listId = $str->idContext;

$object=new $objectClass($objectId);

?>
<table>
  <tr>
    <td>
      <form id='productContextForm' name='productContextForm' onSubmit="return false;">
      	<input id="productContextObjectClass" name="productContextObjectClass" type="hidden" value="<?php echo $objectClass;?>" />
        <input id="productContextObjectId" name="productContextObjectId" type="hidden" value="<?php echo $objectId;?>" /> 
        <table>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
          <tr><td colspan="2" class="section"><?php echo i18n('sectionProductContext',array(i18n($objectClass),intval($objectId).' '.$object->name));?></td></tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>  
          <tr>
            <td class="dialogLabel">
              <label for="productContextName" ><?php echo i18n('Context'); ?>&nbsp;:&nbsp;</label>
            </td>
            <td>
				<select size="14" id="productContextListId" name="productContextListId[]"
                <?php if (!$contextId) echo 'multiple'; ?> class="selectList" onchange="enableWidget('dialogProductContextSubmit');"  ondblclick="saveProductContext();" value="">
                  <?php htmlDrawOptionForReference('id'.$listClass, $listId, null, true);?>
              </select>
            </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        </table>
      </form>
    </td>
  </tr>
  <tr>
    <td align="center">
      <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogProductContext').hide();">
        <?php echo i18n("buttonCancel");?>
      </button>
      <button class="mediumTextButton" disabled dojoType="dijit.form.Button" type="submit" id="dialogProductContextSubmit" onclick="protectDblClick(this);saveProductContext();return false;">
        <?php echo i18n("buttonOK");?>
      </button>
    </td>
  </tr>
</table>

