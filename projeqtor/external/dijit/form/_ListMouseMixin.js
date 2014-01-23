//>>built
define("dijit/form/_ListMouseMixin",["dojo/_base/declare","dojo/on","dojo/touch","./_ListBase"],function(_1,on,_2,_3){return _1("dijit.form._ListMouseMixin",_3,{postCreate:function(){this.inherited(arguments);this.domNode.dojoClick=true;this.own(on(this.domNode,"mousedown",function(_4){_4.preventDefault();}));this._listConnect("click","_onClick");this._listConnect("mousedown","_onMouseDown");this._listConnect("mouseup","_onMouseUp");this._listConnect("mouseover","_onMouseOver");this._listConnect("mouseout","_onMouseOut");},_onClick:function(_5,_6){this._setSelectedAttr(_6);if(this._deferredClick){this._deferredClick.remove();}this._deferredClick=this.defer(function(){this._deferredClick=null;this.onClick(_6);});},_onMouseDown:function(_7,_8){if(this._hoveredNode){this.onUnhover(this._hoveredNode);this._hoveredNode=null;}this._isDragging=true;this._setSelectedAttr(_8);},_onMouseUp:function(_9,_a){this._isDragging=false;var _b=this.selected;var _c=this._hoveredNode;if(_b&&_a==_b){this.defer(function(){this._onClick(_9,_b);});}else{if(_c){this.defer(function(){this._onClick(_9,_c);});}}},_onMouseOut:function(_d,_e){if(this._hoveredNode){this.onUnhover(this._hoveredNode);this._hoveredNode=null;}if(this._isDragging){this._cancelDrag=(new Date()).getTime()+1000;}},_onMouseOver:function(_f,_10){if(this._cancelDrag){var _11=(new Date()).getTime();if(_11>this._cancelDrag){this._isDragging=false;}this._cancelDrag=null;}this._hoveredNode=_10;this.onHover(_10);if(this._isDragging){this._setSelectedAttr(_10);}}});});