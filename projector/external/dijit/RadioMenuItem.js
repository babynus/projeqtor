//>>built
define("dijit/RadioMenuItem",["dojo/_base/declare","dojo/dom-class","./CheckedMenuItem"],function(_1,_2,_3){return _1("dijit.RadioButtonMenuItem",_3,{baseClass:"dijitRadioMenuItem",role:"menuitemradio",checkedChar:"*",group:"",_currentlyChecked:{},_setCheckedAttr:function(_4){if(_4&&this.group&&this._currentlyChecked[this.group]&&this._currentlyChecked[this.group]!=this){this._currentlyChecked[this.group].set("checked",false);}this.inherited(arguments);if(this.group){if(_4){this._currentlyChecked[this.group]=this;}else{if(this._currentlyChecked[this.group]==this){this._currentlyChecked[this.group]=null;}}}},_onClick:function(_5){if(!this.disabled&&!this.checked){this.set("checked",true);this.onChange(true);}this.onClick(_5);}});});