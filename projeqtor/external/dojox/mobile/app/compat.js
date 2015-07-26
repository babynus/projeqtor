//>>built
define("dojox/mobile/app/compat",["dijit","dojo","dojox","dojo/require!dojox/mobile/compat"],function(_1,_2,_3){_2.provide("dojox.mobile.app.compat");_2.require("dojox.mobile.compat");_2.extend(_3.mobile.app.AlertDialog,{_doTransition:function(_4){var h=_2.marginBox(this.domNode.firstChild).h;var _5=this.controller.getWindowSize().h;var _6=_5-h;var _7=_5;var _8=_2.fx.slideTo({node:this.domNode,duration:400,top:{start:_4<0?_6:_7,end:_4<0?_7:_6}});var _9=_2[_4<0?"fadeOut":"fadeIn"]({node:this.mask,duration:400});var _a=_2.fx.combine([_8,_9]);var _b=this;_2.connect(_a,"onEnd",this,function(){if(_4<0){_b.domNode.style.display="none";_2.destroy(_b.domNode);_2.destroy(_b.mask);}});_a.play();}});_2.extend(_3.mobile.app.List,{deleteRow:function(){var _c=this._selectedRow;_2.style(_c,{visibility:"hidden",minHeight:"0px"});_2.removeClass(_c,"hold");var _d=_2.contentBox(_c).h;_2.animateProperty({node:_c,duration:800,properties:{height:{start:_d,end:1},paddingTop:{end:0},paddingBottom:{end:0}},onEnd:this._postDeleteAnim}).play();}});if(_3.mobile.app.ImageView&&!_2.create("canvas").getContext){_2.extend(_3.mobile.app.ImageView,{buildRendering:function(){this.domNode.innerHTML="ImageView widget is not supported on this browser."+"Please try again with a modern browser, e.g. "+"Safari, Chrome or Firefox";this.canvas={};},postCreate:function(){}});}if(_3.mobile.app.ImageThumbView){_2.extend(_3.mobile.app.ImageThumbView,{place:function(_e,x,y){_2.style(_e,{top:y+"px",left:x+"px",visibility:"visible"});}});}});