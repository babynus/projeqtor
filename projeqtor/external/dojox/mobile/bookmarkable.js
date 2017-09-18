//>>built
define("dojox/mobile/bookmarkable",["dojo/_base/array","dojo/_base/connect","dojo/_base/lang","dojo/_base/window","dojo/hash","dijit/registry","./TransitionEvent","./View","./viewRegistry"],function(_1,_2,_3,_4,_5,_6,_7,_8,_9){var b={settingHash:false,transitionInfo:[],getTransitionInfo:function(_a,_b){return this.transitionInfo[_a.replace(/^#/,"")+":"+_b.replace(/^#/,"")];},addTransitionInfo:function(_c,_d,_e){this.transitionInfo[_c.replace(/^#/,"")+":"+_d.replace(/^#/,"")]=_e;},findTransitionViews:function(_f){if(!_f){return [];}var _10=_6.byId(_f.replace(/^#/,""));if(!_10){return [];}for(var v=_10.getParent();v;v=v.getParent()){if(v.isVisible&&!v.isVisible()){_10=v;}}return [_10.getShowingView(),_10];},onHashChange:function(_11){if(this.settingHash){this.settingHash=false;return;}var _12=this.handleFragIds(_11);_12.hashchange=true;if(_12.moveTo){new _7(_4.body(),_12).dispatch();}},handleFragIds:function(_13){var arr,_14,_15,dir;if(!_13){_14=_9.initialView.id;arr=this.findTransitionViews(_14);}else{var ids=_13.replace(/^#/,"").split(/,/);for(var i=0;i<ids.length;i++){var _16=_6.byId(ids[i]);if(!_16||_16.isVisible()){continue;}var _17=true;for(var v=_9.getParentView(_16);v;v=_9.getParentView(v)){if(_1.indexOf(ids,v.id)===-1){_17=false;break;}}if(!_17){_1.forEach(_16.getSiblingViews(),function(v){v.domNode.style.display=(v===_16)?"":"none";});continue;}arr=this.findTransitionViews(ids[i]);if(arr.length===2){_14=ids[i];}}}if(arr){_15=this.getTransitionInfo(arr[0].id,arr[1].id);dir=1;if(!_15){_15=this.getTransitionInfo(arr[1].id,arr[0].id);dir=-1;}}return {moveTo:_14?"#"+_14:null,transitionDir:_15?_15.transitionDir*dir:1,transition:_15?_15.transition:"none"};},setFragIds:function(_18){var arr=_1.filter(_9.getViews(),function(v){return v.isVisible();});this.settingHash=true;_5(_1.map(arr,function(v){return v.id;}).join(","));}};_2.subscribe("/dojo/hashchange",null,function(){b.onHashChange.apply(b,arguments);});_3.extend(_8,{getTransitionInfo:function(){b.getTransitionInfo.apply(b,arguments);},addTransitionInfo:function(){b.addTransitionInfo.apply(b,arguments);},handleFragIds:function(){b.handleFragIds.apply(b,arguments);},setFragIds:function(){b.setFragIds.apply(b,arguments);}});return b;});