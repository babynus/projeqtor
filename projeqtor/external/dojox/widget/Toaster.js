//>>built
define("dojox/widget/Toaster",["dojo/_base/declare","dojo/_base/lang","dojo/on","dojo/aspect","dojo/topic","dojo/_base/fx","dojo/dom-style","dojo/dom-class","dojo/dom-geometry","dijit/registry","dijit/_WidgetBase","dijit/_TemplatedMixin","dijit/BackgroundIframe","dojo/fx","dojo/has","dojo/window"],function(_1,_2,on,_3,_4,_5,_6,_7,_8,_9,_a,_b,_c,_d,_e,_f){_2.getObject("dojox.widget",true);var _10=function(w){return w.substring(0,1).toUpperCase()+w.substring(1);};return _1("dojox.widget.Toaster",[_a,_b],{templateString:"<div class=\"dijitToasterClip\" data-dojo-attach-point=\"clipNode\"><div class=\"dijitToasterContainer\" data-dojo-attach-point=\"containerNode\" data-dojo-attach-event=\"onclick:onSelect\"><div class=\"dijitToasterContent\" data-dojo-attach-point=\"contentNode\"></div></div></div>",messageTopic:"",messageTypes:{MESSAGE:"message",WARNING:"warning",ERROR:"error",FATAL:"fatal"},defaultType:"message",positionDirection:"br-up",positionDirectionTypes:["br-up","br-left","bl-up","bl-right","tr-down","tr-left","tl-down","tl-right"],duration:2000,slideDuration:500,separator:"<hr>",postCreate:function(){this.inherited(arguments);this.hide();this.ownerDocument.body.appendChild(this.domNode);if(this.messageTopic){this.own(_4.subscribe(this.messageTopic,_2.hitch(this,"_handleMessage")));}},_handleMessage:function(_11){if(_2.isString(_11)){this.setContent(_11);}else{this.setContent(_11.message,_11.type,_11.duration);}},setContent:function(_12,_13,_14){_14=(_14===undefined)?this.duration:_14;if(this.slideAnim){if(this.slideAnim.status()!="playing"){this.slideAnim.stop();}if(this.slideAnim.status()=="playing"||(this.fadeAnim&&this.fadeAnim.status()=="playing")){setTimeout(_2.hitch(this,function(){this.setContent(_12,_13,_14);}),50);return;}}for(var _15 in this.messageTypes){_7.remove(this.containerNode,"dijitToaster"+_10(this.messageTypes[_15]));}_6.set(this.containerNode,"opacity",1);this._setContent(_12);_7.add(this.containerNode,"dijitToaster"+_10(_13||this.defaultType));this.show();var _16=_8.getMarginBox(this.containerNode);this._cancelHideTimer();if(this.isVisible){this._placeClip();if(!this._stickyMessage){this._setHideTimer(_14);}}else{var _17=this.containerNode.style;var pd=this.positionDirection;if(pd.indexOf("-up")>=0){_17.left=0+"px";_17.top=_16.h+10+"px";}else{if(pd.indexOf("-left")>=0){_17.left=_16.w+10+"px";_17.top=0+"px";}else{if(pd.indexOf("-right")>=0){_17.left=0-_16.w-10+"px";_17.top=0+"px";}else{if(pd.indexOf("-down")>=0){_17.left=0+"px";_17.top=0-_16.h-10+"px";}else{throw new Error(this.id+".positionDirection is invalid: "+pd);}}}}this.slideAnim=_d.slideTo({node:this.containerNode,top:0,left:0,duration:this.slideDuration,onEnd:_2.hitch(this,function(){this.fadeAnim=(_5.fadeOut({node:this.containerNode,duration:1000,onEnd:_2.hitch(this,function(){this.isVisible=false;this.hide();})}));this.own(this.fadeAnim);this._setHideTimer(_14);this.on("select",_2.hitch(this,function(){this._cancelHideTimer();this._stickyMessage=false;this.fadeAnim.play();}));this.isVisible=true;})});this.own(this.slideAnim);this.slideAnim.play();}},_setContent:function(_18){if(_2.isFunction(_18)){_18(this);return;}if(_18&&this.isVisible){_18=this.contentNode.innerHTML+this.separator+_18;}this.contentNode.innerHTML=_18;},_cancelHideTimer:function(){if(this._hideTimer){clearTimeout(this._hideTimer);this._hideTimer=null;}},_setHideTimer:function(_19){this._cancelHideTimer();if(_19>0){this._cancelHideTimer();this._hideTimer=setTimeout(_2.hitch(this,function(evt){if(this.bgIframe&&this.bgIframe.iframe){this.bgIframe.iframe.style.display="none";}this._hideTimer=null;this._stickyMessage=false;this.fadeAnim.play();}),_19);}else{this._stickyMessage=true;}},_placeClip:function(){var _1a=_f.getBox(this.ownerDocument);var _1b=_8.getMarginBox(this.containerNode);var _1c=this.clipNode.style;_1c.height=_1b.h+"px";_1c.width=_1b.w+"px";var pd=this.positionDirection;if(pd.match(/^t/)){_1c.top=_1a.t+"px";}else{if(pd.match(/^b/)){_1c.top=(_1a.h-_1b.h-2+_1a.t)+"px";}}if(pd.match(/^[tb]r-/)){_1c.left=(_1a.w-_1b.w-1-_1a.l)+"px";}else{if(pd.match(/^[tb]l-/)){_1c.left=0+"px";}else{if(pd.match(/^[tb]c-/)){_1c.left=Math.round((_1a.w-_1b.w-1-_1a.l)/2)+"px";}}}_1c.clip="rect(0px, "+_1b.w+"px, "+_1b.h+"px, 0px)";if(_e("ie")){if(!this.bgIframe){if(!this.clipNode.id){this.clipNode.id=_9.getUniqueId("dojox_widget_Toaster_clipNode");}this.bgIframe=new _c(this.clipNode);}var _1d=this.bgIframe.iframe;if(_1d){_1d.style.display="block";}}},onSelect:function(e){},show:function(){_6.set(this.domNode,"display","block");this._placeClip();if(!this._scrollConnected){this._scrollConnected=_3.after(_f,"scroll",_2.hitch(this,"_placeClip"));this.own(this._scrollConnected);}},hide:function(){_6.set(this.domNode,"display","none");if(this._scrollConnected){this._scrollConnected.remove();this._scrollConnected=false;}_6.set(this.containerNode,"opacity",1);}});});