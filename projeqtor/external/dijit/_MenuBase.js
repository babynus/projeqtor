//>>built
define("dijit/_MenuBase",["dojo/_base/array","dojo/_base/declare","dojo/dom","dojo/dom-attr","dojo/dom-class","dojo/_base/lang","dojo/mouse","dojo/on","dojo/window","./a11yclick","./registry","./_Widget","./_CssStateMixin","./_KeyNavContainer","./_TemplatedMixin"],function(_1,_2,_3,_4,_5,_6,_7,on,_8,_9,_a,_b,_c,_d,_e){return _2("dijit._MenuBase",[_b,_e,_d,_c],{selected:null,_setSelectedAttr:function(_f){if(this.selected!=_f){if(this.selected){this.selected._setSelected(false);this._onChildDeselect(this.selected);}if(_f){_f._setSelected(true);}this._set("selected",_f);}},activated:false,_setActivatedAttr:function(val){_5.toggle(this.domNode,"dijitMenuActive",val);_5.toggle(this.domNode,"dijitMenuPassive",!val);this._set("activated",val);},parentMenu:null,popupDelay:500,passivePopupDelay:Infinity,autoFocus:false,childSelector:function(_10){var _11=_a.byNode(_10);return _10.parentNode==this.containerNode&&_11&&_11.focus;},postCreate:function(){var _12=this,_13=typeof this.childSelector=="string"?this.childSelector:_6.hitch(this,"childSelector");this.own(on(this.containerNode,on.selector(_13,_7.enter),function(){_12.onItemHover(_a.byNode(this));}),on(this.containerNode,on.selector(_13,_7.leave),function(){_12.onItemUnhover(_a.byNode(this));}),on(this.containerNode,on.selector(_13,_9),function(evt){_12.onItemClick(_a.byNode(this),evt);evt.stopPropagation();}),on(this.containerNode,on.selector(_13,"focusin"),function(){_12._onItemFocus(_a.byNode(this));}));this.inherited(arguments);},onKeyboardSearch:function(_14,evt,_15,_16){this.inherited(arguments);if(!!_14&&(_16==-1||(!!_14.popup&&_16==1))){this.onItemClick(_14,evt);}},_keyboardSearchCompare:function(_17,_18){if(!!_17.shortcutKey){return _18==_17.shortcutKey.toLowerCase()?-1:0;}return this.inherited(arguments)?1:0;},onExecute:function(){},onCancel:function(){},_moveToPopup:function(evt){if(this.focusedChild&&this.focusedChild.popup&&!this.focusedChild.disabled){this.onItemClick(this.focusedChild,evt);}else{var _19=this._getTopMenu();if(_19&&_19._isMenuBar){_19.focusNext();}}},_onPopupHover:function(){this.set("selected",this.currentPopupItem);this._stopPendingCloseTimer();},onItemHover:function(_1a){if(this.activated){this.set("selected",_1a);if(_1a.popup&&!_1a.disabled&&!this.hover_timer){this.hover_timer=this.defer(function(){this._openItemPopup(_1a);},this.popupDelay);}}else{if(this.passivePopupDelay<Infinity){if(this.passive_hover_timer){this.passive_hover_timer.remove();}this.passive_hover_timer=this.defer(function(){this.onItemClick(_1a,{type:"click"});},this.passivePopupDelay);}}this._hoveredChild=_1a;_1a._set("hovering",true);},_onChildDeselect:function(_1b){this._stopPopupTimer();if(this.currentPopupItem==_1b){this._stopPendingCloseTimer();this._pendingClose_timer=this.defer(function(){this._pendingClose_timer=null;this.currentPopupItem=null;_1b._closePopup();},this.popupDelay);}},onItemUnhover:function(_1c){if(this._hoveredChild==_1c){this._hoveredChild=null;}if(this.passive_hover_timer){this.passive_hover_timer.remove();this.passive_hover_timer=null;}_1c._set("hovering",false);},_stopPopupTimer:function(){if(this.hover_timer){this.hover_timer=this.hover_timer.remove();}},_stopPendingCloseTimer:function(){if(this._pendingClose_timer){this._pendingClose_timer=this._pendingClose_timer.remove();}},_getTopMenu:function(){for(var top=this;top.parentMenu;top=top.parentMenu){}return top;},onItemClick:function(_1d,evt){if(this.passive_hover_timer){this.passive_hover_timer.remove();}this.focusChild(_1d);if(_1d.disabled){return false;}if(_1d.popup){this.set("selected",_1d);this.set("activated",true);var _1e=/^key/.test(evt._origType||evt.type)||(evt.clientX==0&&evt.clientY==0);this._openItemPopup(_1d,_1e);}else{this.onExecute();_1d._onClick?_1d._onClick(evt):_1d.onClick(evt);}},_openItemPopup:function(_1f,_20){if(_1f==this.currentPopupItem){return;}if(this.currentPopupItem){this._stopPendingCloseTimer();this.currentPopupItem._closePopup();}this._stopPopupTimer();var _21=_1f.popup;_21.parentMenu=this;this.own(this._mouseoverHandle=on.once(_21.domNode,"mouseover",_6.hitch(this,"_onPopupHover")));var _22=this;_1f._openPopup({parent:this,orient:this._orient||["after","before"],onCancel:function(){if(_20){_22.focusChild(_1f);}_22._cleanUp();},onExecute:_6.hitch(this,"_cleanUp",true),onClose:function(){if(_22._mouseoverHandle){_22._mouseoverHandle.remove();delete _22._mouseoverHandle;}}},_20);this.currentPopupItem=_1f;},onOpen:function(){this.isShowingNow=true;this.set("activated",true);},onClose:function(){this.set("activated",false);this.set("selected",null);this.isShowingNow=false;this.parentMenu=null;},_closeChild:function(){this._stopPopupTimer();if(this.currentPopupItem){if(this.focused){_4.set(this.selected.focusNode,"tabIndex",this.tabIndex);this.selected.focusNode.focus();}this.currentPopupItem._closePopup();this.currentPopupItem=null;}},_onItemFocus:function(_23){if(this._hoveredChild&&this._hoveredChild!=_23){this.onItemUnhover(this._hoveredChild);}this.set("selected",_23);},_onBlur:function(){this._cleanUp(true);this.inherited(arguments);},_cleanUp:function(_24){this._closeChild();if(typeof this.isShowingNow=="undefined"){this.set("activated",false);}if(_24){this.set("selected",null);}}});});