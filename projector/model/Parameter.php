<?php 
/* ============================================================================
 * Parameter is a global kind of object for parametring.
 * It may be on user level, on project level or on global level.
 */ 
class Parameter extends SqlElement {

  // extends SqlElement, so has $id
  public $id;    // redefine $id to specify its visiblez place 
  public $idUser;
  public $idProject;
  public $parameterCode;
  public $parameterValue;
  
  public $_noHistory=true; // Will never save history for this object
  
  /** ==========================================================================
   * Constructor
   * @param $id the id of the object in the database (null if not stored yet)
   * @return void
   */ 
  function __construct($id = NULL) {
    parent::__construct($id);
  }

  
  /** ==========================================================================
   * Destructor
   * @return void
   */ 
  function __destruct() {
    parent::__destruct();
  }

// ============================================================================**********
// GET VALIDATION SCRIPT
// ============================================================================**********

  /** ==========================================================================
   * Return the validation sript for some fields
   * @return the validation javascript (for dojo frameword)
   */
  public function getValidationScript($colName) {
    //$colScript = parent::getValidationScript($colName);   
    $colScript="";
    if ($colName=="theme") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  if (this.value!="random") changeTheme(this.value);';
      $colScript .= '</script>';
    } else if ($colName=="lang") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  changeLocale(this.value);';
      $colScript .= '</script>';
    } else if ($colName=="defaultProject") {
      //nothing
    /* } else if ($colName=="refreshUpdates") {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  newValue=this.value;';
      $colScript .= '  refreshUpdates=newValue;';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>'; */            
    } else {
      $colScript .= '<script type="dojo/connect" event="onChange" >';
      $colScript .= '  newValue=this.value;';
      $colScript .= '  dojo.xhrPost({url: "../tool/saveDataToSession.php?id=' . $colName . '&value=" + newValue});';
      $colScript .= '</script>';
    } 
    return $colScript;
  }
  
// ============================================================================**********
// MISCELLANOUS FUNCTIONS
// ============================================================================**********
  
  /** ===========================================================================
   * Give the list of allows values for a parameter (to builmd a select)
   * @param $parameter the name of the parameter
   * @return array of allowed values as code=>value
   */
  static function getList($parameter) {
    global $isAttachementEnabled;
    $list=array();
    switch ($parameter) {
      case 'theme':
        $list=array('blueLight'=>'light blue',
                    'blue'=>'dark blue', 
                    'blueContrast'=>'contrasted blue',
                    'redLight'=>'light red',
                    'red'=>'dark red',
                    'redContrast'=>'contrasted red',
                    'greenLight'=>'light green',
                    'green'=>'dark green',
                    'greenContrast'=>'contrasted green',
                    'orangeLight'=>'light orange',
                    'orange'=>'dark orange',
                    'orangeContrast'=>'contrasted orange',
                    'greyLight'=>'light grey',
                    'grey'=>'dark grey',
                    'greyContrast'=>'contrasted grey',
                    'white'=>'black & white',
                    'random'=>'random'); // keep 'random' as last value to assure it is not selected via getTheme()
        break;
      case 'lang':
        $list=array('en'=>i18n('langEn'), 
                    'fr'=>i18n('langFr'));
        break;
      case 'defaultProject':
        if (array_key_exists('user',$_SESSION)) {
          $user=$_SESSION['user'];
          $listVisible=$user->getVisibleProjects();
        } else {
          $listVisible=SqlList::getList('Project');
        }        
        $list['*']=i18n('allProjects');
        foreach ($listVisible as $key=>$val) {
          $list[$key]=$val;
        }
        break;
      case 'displayHistory':
        $list=array('NO'=>i18n('displayNo'),
                    'YES_CLOSED'=>i18n('displayYesClosed'),
                    'YES_OPENED'=>i18n('displayYesOpened'));
        break;
      case 'displayNote':
        $list=array('YES_OPENED'=>i18n('displayYesOpened'),
                    'YES_CLOSED'=>i18n('displayYesClosed'));
        break;
      case 'displayAttachement':
        if ($isAttachementEnabled) {
          $list=array('YES_OPENED'=>i18n('displayYesOpened'),
                      'YES_CLOSED'=>i18n('displayYesClosed'));
        } else {
          $list=array('NO'=>i18n('displayNo'));          
        }
        break;
      /* case 'refreshUpdates':
        $list=array('YES'=>i18n('refreshUpdatesYes'),
                    'NO'=>i18n('refreshUpdatesNo'));
        break; */
    } 
    return $list;
  }
  
  static function getParamtersList($typeParameter) {
    $parameterList=array();
    switch ($typeParameter) {
      case ('userParameter'):
        $parameterList=array("theme"=>"list", 
                           "lang"=>"list", 
                           "defaultProject"=>"list",
                           "displayAttachement"=>"list",
                           "displayNote"=>"list",
                           "displayHistory"=>"list");
        break;
    }
    return $parameterList;
  }
}
?>