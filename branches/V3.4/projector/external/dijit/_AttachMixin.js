//>>built
define("dijit/_AttachMixin",["require","dojo/_base/array","dojo/_base/connect","dojo/_base/declare","dojo/_base/lang","dojo/mouse","dojo/on","dojo/touch","./_WidgetBase"],function(_1,_2,_3,_4,_5,_6,on,_7,_8){var _9=_5.delegate(_7,{"mouseenter":_6.enter,"mouseleave":_6.leave,"keypress":_3._keypress});var _a;var _b=_4("dijit._AttachMixin",null,{constructor:function(){this._attachPoints=[];this._attachEvents=[];},buildRendering:function(){this.inherited(arguments);this._attachTemplateNodes(this.domNode,function(n,p){return n.getAttribute(p);});this._beforeFillContent();},_beforeFillContent:function(){},_attachTemplateNodes:function(_c,_d){var _e=_5.isArray(_c)?_c:(_c.all||_c.getElementsByTagName("*")),_f=this.attachScope||this;var x=_5.isArray(_c)?0:-1;for(;x<0||_e[x];x++){var _10=(x==-1)?_c:_e[x];if(this.widgetsInTemplate&&(_d(_10,"dojoType")||_d(_10,"data-dojo-type"))){continue;}var _11=_d(_10,"dojoAttachPoint")||_d(_10,"data-dojo-attach-point");if(_11){var _12,_13=_11.split(/\s*,\s*/);while((_12=_13.shift())){if(_5.isArray(_f[_12])){_f[_12].push(_10);}else{_f[_12]=_10;}this._attachPoints.push(_12);}}var _14=_d(_10,"dojoAttachEvent")||_d(_10,"data-dojo-attach-event");if(_14){var _15,_16=_14.split(/\s*,\s*/);var _17=_5.trim;while((_15=_16.shift())){if(_15){var _18=null;if(_15.indexOf(":")!=-1){var _19=_15.split(":");_15=_17(_19[0]);_18=_17(_19[1]);}else{_15=_17(_15);}if(!_18){_18=_15;}_15=_15.replace(/^on/,"").toLowerCase();if(_15=="dijitclick"){_15=_a||(_a=_1("./a11yclick"));}else{_15=_9[_15]||_15;}this._attachEvents.push(this.own(on(_10,_15,_5.hitch(_f,_18)))[0]);}}}}},destroyRendering:function(){var _1a=this.attachScope||this;_2.forEach(this._attachPoints,function(_1b){delete _1a[_1b];});this._attachPoints=[];_2.forEach(this._attachEvents,this.disconnect,this);this._attachEvents=[];this.inherited(arguments);}});_5.extend(_8,{dojoAttachEvent:"",dojoAttachPoint:""});return _b;});