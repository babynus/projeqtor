//>>built
define("dojox/form/_BusyButtonMixin",["dojo/_base/lang","dojo/dom-attr","dojo/dom-class","dijit/form/Button","dijit/form/DropDownButton","dijit/form/ComboButton","dojo/i18n","dojo/i18n!dijit/nls/loading","dojo/_base/declare"],function(_1,_2,_3,_4,_5,_6,_7,_8,_9){return _9("dojox.form._BusyButtonMixin",null,{isBusy:false,isCancelled:false,busyLabel:"",timeout:null,useIcon:true,postMixInProperties:function(){this.inherited(arguments);if(!this.busyLabel){this.busyLabel=_7.getLocalization("dijit","loading",this.lang).loadingState;}},postCreate:function(){this.inherited(arguments);this._label=this.containerNode.innerHTML;this._initTimeout=this.timeout;if(this.isBusy){this.makeBusy();}},makeBusy:function(){this.isBusy=true;this.isCancelled=false;if(this._disableHandle){this._disableHandle.remove();}this._disableHandle=this.defer(function(){this.set("disabled",true);});this.setLabel(this.busyLabel,this.timeout);},cancel:function(){this.isCancelled=true;if(this._disableHandle){this._disableHandle.remove();}this.set("disabled",false);this.isBusy=false;this.setLabel(this._label);if(this._timeout){clearTimeout(this._timeout);}this.timeout=this._initTimeout;},resetTimeout:function(_a){if(this._timeout){clearTimeout(this._timeout);}if(_a){this._timeout=setTimeout(_1.hitch(this,function(){this.cancel();}),_a);}else{if(_a==undefined||_a===0){this.cancel();}}},setLabel:function(_b,_c){this.label=_b;while(this.containerNode.firstChild){this.containerNode.removeChild(this.containerNode.firstChild);}this.containerNode.appendChild(domConstruct.toDom(this.label));if(this.showLabel==false&&!_2.get(this.domNode,"title")){this.titleNode.title=_1.trim(this.containerNode.innerText||this.containerNode.textContent||"");}if(_c){this.resetTimeout(_c);}else{this.timeout=null;}if(this.useIcon&&this.isBusy){var _d=new Image();_d.src=this._blankGif;_2.set(_d,"id",this.id+"_icon");_3.add(_d,"dojoxBusyButtonIcon");this.containerNode.appendChild(_d);}},_onClick:function(e){if(!this.isBusy){this.inherited(arguments);if(!this.isCancelled){this.makeBusy();}}}});});