//>>built
define("dijit/_MenuBase",["dojo/_base/array","dojo/_base/declare","dojo/dom","dojo/dom-attr","dojo/dom-class","dojo/_base/lang","dojo/mouse","dojo/on","dojo/window","./a11yclick","./popup","./registry","./_Widget","./_KeyNavContainer","./_TemplatedMixin"],function(_1,_2,_3,_4,_5,_6,_7,on,_8,_9,pm,_a,_b,_c,_d){return _2("dijit._MenuBase",[_b,_d,_c],{parentMenu:null,popupDelay:500,autoFocus:false,childSelector:function(_e){var _f=_a.byNode(_e);return _e.parentNode==this.containerNode&&_f&&_f.focus;},postCreate:function(){var _10=this,_11=typeof this.childSelector=="string"?this.childSelector:_6.hitch(this,"childSelector");this.own(on(this.containerNode,on.selector(_11,_7.enter),function(){_10.onItemHover(_a.byNode(this));}),on(this.containerNode,on.selector(_11,_7.leave),function(){_10.onItemUnhover(_a.byNode(this));}),on(this.containerNode,on.selector(_11,_9),function(evt){_10.onItemClick(_a.byNode(this),evt);evt.stopPropagation();evt.preventDefault();}));this.inherited(arguments);},onExecute:function(){},onCancel:function(){},_moveToPopup:function(evt){if(this.focusedChild&&this.focusedChild.popup&&!this.focusedChild.disabled){this.onItemClick(this.focusedChild,evt);}else{var _12=this._getTopMenu();if(_12&&_12._isMenuBar){_12.focusNext();}}},_onPopupHover:function(){if(this.currentPopup&&this.currentPopup._pendingClose_timer){var _13=this.currentPopup.parentMenu;if(_13.focusedChild){_13.focusedChild._setSelected(false);}_13.focusedChild=this.currentPopup.from_item;_13.focusedChild._setSelected(true);this._stopPendingCloseTimer(this.currentPopup);}},onItemHover:function(_14){if(this.isActive){this.focusChild(_14);if(this.focusedChild.popup&&!this.focusedChild.disabled&&!this.hover_timer){this.hover_timer=this.defer("_openPopup",this.popupDelay);}}if(this.focusedChild){this.focusChild(_14);}this._hoveredChild=_14;_14._set("hovering",true);},_onChildBlur:function(_15){this._stopPopupTimer();_15._setSelected(false);var _16=_15.popup;if(_16){this._stopPendingCloseTimer(_16);_16._pendingClose_timer=this.defer(function(){_16._pendingClose_timer=null;if(_16.parentMenu){_16.parentMenu.currentPopup=null;}pm.close(_16);},this.popupDelay);}},onItemUnhover:function(_17){if(this.isActive){this._stopPopupTimer();}if(this._hoveredChild==_17){this._hoveredChild=null;}_17._set("hovering",false);},_stopPopupTimer:function(){if(this.hover_timer){this.hover_timer=this.hover_timer.remove();}},_stopPendingCloseTimer:function(_18){if(_18._pendingClose_timer){_18._pendingClose_timer=_18._pendingClose_timer.remove();}},_stopFocusTimer:function(){if(this._focus_timer){this._focus_timer=this._focus_timer.remove();}},_getTopMenu:function(){for(var top=this;top.parentMenu;top=top.parentMenu){}return top;},onItemClick:function(_19,evt){if(typeof this.isShowingNow=="undefined"){this._markActive();}this.focusChild(_19);if(_19.disabled){return false;}if(_19.popup){this._openPopup(evt.type=="keypress");}else{this.onExecute();_19._onClick?_19._onClick(evt):_19.onClick(evt);}},_openPopup:function(_1a){this._stopPopupTimer();var _1b=this.focusedChild;if(!_1b){return;}var _1c=_1b.popup;if(!_1c.isShowingNow){if(this.currentPopup){this._stopPendingCloseTimer(this.currentPopup);pm.close(this.currentPopup);}_1c.parentMenu=this;_1c.from_item=_1b;var _1d=this;pm.open({parent:this,popup:_1c,around:_1b.domNode,orient:this._orient||["after","before"],onCancel:function(){_1d.focusChild(_1b);_1d._cleanUp();_1b._setSelected(true);_1d.focusedChild=_1b;},onExecute:_6.hitch(this,"_cleanUp")});this.currentPopup=_1c;_1c.connect(_1c.domNode,"onmouseenter",_6.hitch(_1d,"_onPopupHover"));}if(_1a&&_1c.focus){_1c._focus_timer=this.defer(_6.hitch(_1c,function(){this._focus_timer=null;this.focus();}));}},_markActive:function(){this.isActive=true;_5.replace(this.domNode,"dijitMenuActive","dijitMenuPassive");},onOpen:function(){this.isShowingNow=true;this._markActive();},_markInactive:function(){this.isActive=false;_5.replace(this.domNode,"dijitMenuPassive","dijitMenuActive");},onClose:function(){this._stopFocusTimer();this._markInactive();this.isShowingNow=false;this.parentMenu=null;},_closeChild:function(){this._stopPopupTimer();if(this.currentPopup){if(_1.indexOf(this._focusManager.activeStack,this.id)>=0){_4.set(this.focusedChild.focusNode,"tabIndex",this.tabIndex);this.focusedChild.focusNode.focus();}pm.close(this.currentPopup);this.currentPopup=null;}if(this.focusedChild){this.focusedChild._setSelected(false);this.onItemUnhover(this.focusedChild);this.focusedChild=null;}},_onItemFocus:function(_1e){if(this._hoveredChild&&this._hoveredChild!=_1e){this.onItemUnhover(this._hoveredChild);}},_onBlur:function(){this._cleanUp();this.inherited(arguments);},_cleanUp:function(){this._closeChild();if(typeof this.isShowingNow=="undefined"){this._markInactive();}}});});