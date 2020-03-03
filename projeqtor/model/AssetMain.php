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
 * Client is the owner of a project.
 */  
require_once('_securityCheck.php'); 
class AssetMain extends SqlElement {

  public $_sec_Description;
  public $id;
  public $name;
  public $idAssetType;
  public $idBrand;
  public $idModel;
  public $idAssetCategory;
  public $idAsset;
  public $serialNumber;
  public $inventoryNumber;
  public $description;
  public $_sec_Attribution;
  public $idStatus;
  public $_tab_2_1 = array('installationDate','decommissioningDate','date');
  public $installationDate;
  public $decommissioningDate;
  public $idLocation;
  public $complement;
  public $idAffectable;
  public $idProvider;
  public $idle;
  public $_sec_AssetComposition;
  public $_assetComposition=array();
  public $_sec_ComponentVersionStructureAsset;
  public $_componentVersionStructureAsset=array();
  public $_spe_arboAsset;
  public $_sec_Link;
  public $_Link = array();
  public $_Attachment = array();
  public $_Note = array();
  public $_nbColMax = 3;
  
  private static $_layout='
    <th field="id" formatter="numericFormatter" width="8%"># ${id}</th>
    <th field="name" width="15%">${name}</th>
    <th field="nameBrand" width="10%">${idBrand}</th>
    <th field="nameModel" width="10%">${idModel}</th>
    <th field="serialNumber" width="10%">${serialNumber}</th>
    <th field="nameLocation" width="15%">${idLocation}</th>
    <th field="nameAffectable" formatter="thumbName22" width="15%">${idUser}</th>
    <th field="colorNameStatus" width="7%" formatter="colorNameFormatter">${idStatus}</th>
    <th field="idle" width="5%" formatter="booleanFormatter">${idle}</th>
    ';
  
  private static $_colCaptionTransposition = array('idAffectable' => 'user','idAsset' => 'parentAsset');
  
  private static $_fieldsAttributes=array(
      'name'=>'required',
      "installationDate"=>"nobr",
      "idLocation"=>"nobr",
  );
  
  private static $_databaseColumnName = array();
  
   /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL, $withoutDependentObjects=false) {
    parent::__construct($id,$withoutDependentObjects);
  }

  
   /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

  public function control(){
    $result="";
    if ($this->id == $this->idAsset and $this->id)$result .= '<br/>' . i18n ( 'assetParentCanNotBeHimself' );
    
    $defaultControl=parent::control();
    if ($defaultControl!='OK') {
      $result.=$defaultControl;
    }
    if ($result=="") {
      $result='OK';
    }
    return $result;
  }
// ============================================================================**********
// GET STATIC DATA FUNCTIONS
// ============================================================================**********
  
  /** ==========================================================================
   * Return the specific layout
   * @return the layout
   */
  protected function getStaticLayout() {
    return self::$_layout;
  }
  
  /** ==========================================================================
   * Return the specific fieldsAttributes
   * @return the fieldsAttributes
   */
  protected function getStaticFieldsAttributes() {
    return self::$_fieldsAttributes;
  }
  
  /** ============================================================================
   * Return the specific colCaptionTransposition
   * @return the colCaptionTransposition
   */
  protected function getStaticColCaptionTransposition($fld=null) {
    return self::$_colCaptionTransposition;
  }
  
  /** ========================================================================
   * Return the specific databaseTableName
   * @return the databaseTableName
   */
  protected function getStaticDatabaseColumnName() {
    return self::$_databaseColumnName;
  }
  
  /** =========================================================================
   * Draw a specific item for the current class.
   * @param $item the item. Correct values are : 
   *    - subprojects => presents sub-projects as a tree
   * @return an html string able to display a specific item
   *  must be redefined in the inherited class
   */
  public function drawSpecificItem($item){
    global $print;
    $result = "";
    if($item == 'arboAsset'){
      if ($print) return "";
      $result='<br/><table>';
      $result.='<tr>';
      $result.='<td rowspan="2" style="padding-left:10px">';
      $result.='<button id="showStructureButton" dojoType="dijit.form.Button" showlabel="true"';
      $result.=' title="'.i18n('showStructure').'" style="vertical-align: middle;">';
      $result.='<span>' . i18n('showStructure') . '</span>';
      $result.='<script type="dojo/connect" event="onClick" args="evt">';
      $page="../view/assetStructure.php?id=$this->id";
      $result.="var url='$page';";
      $result.='showPrint(url, null, null, "html", "P");';
      $result.='</script>';
      $result.='</button>';
      $result.='</div></td>';
      $result.='</tr></table>';
    }
    return $result;
  }
  
  
  public function getRecursiveSubAsset(){
    $crit=array('idAsset'=>$this->id);
    $obj=new Asset();
    $subProducts=$obj->getSqlElementsFromCriteria($crit, false,null,null,null,true) ;
    $subProductList=null;
    foreach ($subProducts as $subProd) {
      $recursiveList=null;
      $recursiveList=$subProd->getRecursiveSubAsset();
      $arrayProd=array('id'=>$subProd->id, 'name'=>$subProd->name, 'subItems'=>$recursiveList);
      $subProductList[]=$arrayProd;
    }
    return $subProductList;
  }
  
  public function getParentAsset(){
    $result=array();
    if ($this->idAsset) {
      $parent=new Asset($this->idAsset);
      $result=array_merge_preserve_keys($parent->getParentAsset(),array($parent->id=>$parent->name));
    }
    return $result;
  }
  
}
?>