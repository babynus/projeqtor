//>>built
define("dojox/mobile/FormLayout",["dojo/_base/declare","dojo/dom-class","./Container"],function(_1,_2,_3){return _1("dojox.mobile.FormLayout",_3,{columns:"auto",rightAlign:false,baseClass:"mblFormLayout",buildRendering:function(){this.inherited(arguments);if(this.columns=="auto"){_2.add(this.domNode,"mblFormLayoutAuto");}else{if(this.columns=="single"){_2.add(this.domNode,"mblFormLayoutSingleCol");}else{if(this.columns=="two"){_2.add(this.domNode,"mblFormLayoutTwoCol");}}}if(this.rightAlign){_2.add(this.domNode,"mblFormLayoutRightAlign");}}});});