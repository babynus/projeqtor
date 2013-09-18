var KunenaTabs=new Class({Implements:[Options,Events],options:{display:0,onActive:function(b,a){a.setStyle("display","block");b.addClass("open").removeClass("closed");},onBackground:function(b,a){a.setStyle("display","none");b.addClass("closed").removeClass("open");},titleSelector:"dt",descriptionSelector:"dd"},initialize:function(b,c){this.setOptions(c);this.dlist=document.id(b);this.titles=this.dlist.getElements(this.options.titleSelector);this.descriptions=this.dlist.getElements(this.options.descriptionSelector);this.content=new Element("div").inject(this.dlist,"after").addClass("current");for(var d=0,a=this.titles.length;d<a;d++){var f=this.titles[d];var e=this.descriptions[d];f.setStyle("cursor","pointer");f.addEvent("click",this.display.bind(this,d));e.inject(this.content);}if($chk(this.options.display)){this.display(this.options.display);}if(this.options.initialize){this.options.initialize.call(this);}},hideAllBut:function(a){for(var c=0,b=this.titles.length;c<b;c++){if(c!=a){this.fireEvent("onBackground",[this.titles[c],this.descriptions[c]]);}}},display:function(a){this.hideAllBut(a);this.fireEvent("onActive",[this.titles[a],this.descriptions[a]]);}});var Autocompleter=new Class({Implements:[Options,Events],options:{minLength:1,markQuery:true,width:"inherit",maxChoices:10,injectChoice:null,customChoices:null,emptyChoices:null,visibleChoices:true,className:"autocompleter-choices",zIndex:42,delay:400,observerOptions:{},fxOptions:{},autoSubmit:false,overflow:false,overflowMargin:25,selectFirst:false,filter:null,filterCase:false,filterSubset:false,forceSelect:false,selectMode:true,choicesMatch:null,multiple:false,separator:", ",separatorSplit:/\s*[,;]\s*/,autoTrim:false,allowDupes:false,cache:true,relative:false},initialize:function(b,a){this.element=document.id(b);this.setOptions(a);this.build();this.observer=new Observer(this.element,this.prefetch.bind(this),$merge({delay:this.options.delay},this.options.observerOptions));this.queryValue=null;if(this.options.filter){this.filter=this.options.filter.bind(this);}var c=this.options.selectMode;this.typeAhead=(c=="type-ahead");this.selectMode=(c===true)?"selection":c;this.cached=[];},build:function(){if(document.id(this.options.customChoices)){this.choices=this.options.customChoices;}else{this.choices=new Element("ul",{"class":this.options.className,styles:{zIndex:this.options.zIndex}}).inject(document.body);this.relative=false;if(this.options.relative){this.choices.inject(this.element,"after");this.relative=this.element.getOffsetParent();}this.fix=new OverlayFix(this.choices);}if(!this.options.separator.test(this.options.separatorSplit)){this.options.separatorSplit=this.options.separator;}this.fx=(!this.options.fxOptions)?null:new Fx.Tween(this.choices,$merge({property:"opacity",link:"cancel",duration:200},this.options.fxOptions)).addEvent("onStart",Chain.prototype.clearChain).set(0);this.element.setProperty("autocomplete","off").addEvent((Browser.Engine.trident||Browser.Engine.webkit)?"keydown":"keypress",this.onCommand.bind(this)).addEvent("click",this.onCommand.bind(this,[false])).addEvent("focus",this.toggleFocus.create({bind:this,arguments:true,delay:100})).addEvent("blur",this.toggleFocus.create({bind:this,arguments:false,delay:100}));},destroy:function(){if(this.fix){this.fix.destroy();}this.choices=this.selected=this.choices.destroy();},toggleFocus:function(a){this.focussed=a;if(!a){this.hideChoices(true);}this.fireEvent((a)?"onFocus":"onBlur",[this.element]);},onCommand:function(b){if(!b&&this.focussed){return this.prefetch();}if(b&&b.key&&!b.shift){switch(b.key){case"enter":if(this.element.value!=this.opted){return true;}if(this.selected&&this.visible){this.choiceSelect(this.selected);return !!(this.options.autoSubmit);}break;case"up":case"down":if(!this.prefetch()&&this.queryValue!==null){var a=(b.key=="up");this.choiceOver((this.selected||this.choices)[(this.selected)?((a)?"getPrevious":"getNext"):((a)?"getLast":"getFirst")](this.options.choicesMatch),true);}return false;case"esc":case"tab":this.hideChoices(true);break;}}return true;},setSelection:function(f){var g=this.selected.inputValue,h=g;var a=this.queryValue.length,c=g.length;if(g.substr(0,a).toLowerCase()!=this.queryValue.toLowerCase()){a=0;}if(this.options.multiple){var e=this.options.separatorSplit;h=this.element.value;a+=this.queryIndex;c+=this.queryIndex;var b=h.substr(this.queryIndex).split(e,1)[0];h=h.substr(0,this.queryIndex)+g+h.substr(this.queryIndex+b.length);if(f){var d=h.split(this.options.separatorSplit).filter(function(j){return this.test(j);},/[^\s,]+/);if(!this.options.allowDupes){d=[].combine(d);}var i=this.options.separator;h=d.join(i)+i;c=h.length;}}this.observer.setValue(h);this.opted=h;if(f||this.selectMode=="pick"){a=c;}this.element.selectRange(a,c);this.fireEvent("onSelection",[this.element,this.selected,h,g]);},showChoices:function(){var c=this.options.choicesMatch,b=this.choices.getFirst(c);this.selected=this.selectedValue=null;if(this.fix){var e=this.element.getCoordinates(this.relative),a=this.options.width||"auto";this.choices.setStyles({left:e.left,top:e.bottom,width:(a===true||a=="inherit")?e.width:a});}if(!b){return;}if(!this.visible){this.visible=true;this.choices.setStyle("display","");if(this.fx){this.fx.start(1);}this.fireEvent("onShow",[this.element,this.choices]);}if(this.options.selectFirst||this.typeAhead||b.inputValue==this.queryValue){this.choiceOver(b,this.typeAhead);}var d=this.choices.getChildren(c),f=this.options.maxChoices;var i={overflowY:"hidden",height:""};this.overflown=false;if(d.length>f){var j=d[f-1];i.overflowY="scroll";i.height=j.getCoordinates(this.choices).bottom;this.overflown=true;}this.choices.setStyles(i);this.fix.show();if(this.options.visibleChoices){var h=document.getScroll(),k=document.getSize(),g=this.choices.getCoordinates();if(g.right>h.x+k.x){h.x=g.right-k.x;}if(g.bottom>h.y+k.y){h.y=g.bottom-k.y;}window.scrollTo(Math.min(h.x,g.left),Math.min(h.y,g.top));}},hideChoices:function(a){if(a){var c=this.element.value;if(this.options.forceSelect){c=this.opted;}if(this.options.autoTrim){c=c.split(this.options.separatorSplit).filter($arguments(0)).join(this.options.separator);}this.observer.setValue(c);}if(!this.visible){return;}this.visible=false;if(this.selected){this.selected.removeClass("autocompleter-selected");}this.observer.clear();var b=function(){this.choices.setStyle("display","none");this.fix.hide();}.bind(this);if(this.fx){this.fx.start(0).chain(b);}else{b();}this.fireEvent("onHide",[this.element,this.choices]);},prefetch:function(){var f=this.element.value,e=f;if(this.options.multiple){var c=this.options.separatorSplit;var a=f.split(c);var b=this.element.getSelectedRange().start;var g=f.substr(0,b).split(c);var d=g.length-1;b-=g[d].length;e=a[d];}if(e.length<this.options.minLength){this.hideChoices();}else{if(e===this.queryValue||(this.visible&&e==this.selectedValue)){if(this.visible){return false;}this.showChoices();}else{this.queryValue=e;this.queryIndex=b;if(!this.fetchCached()){this.query();}}}return true;},fetchCached:function(){return false;if(!this.options.cache||!this.cached||!this.cached.length||this.cached.length>=this.options.maxChoices||this.queryValue){return false;}this.update(this.filter(this.cached));return true;},update:function(b){this.choices.empty();this.cached=b;var a=b&&$type(b);if(!a||(a=="array"&&!b.length)||(a=="hash"&&!b.getLength())){(this.options.emptyChoices||this.hideChoices).call(this);}else{if(this.options.maxChoices<b.length&&!this.options.overflow){b.length=this.options.maxChoices;}b.each(this.options.injectChoice||function(d){var c=new Element("li",{html:this.markQueryValue(d)});c.inputValue=d;this.addChoiceEvents(c).inject(this.choices);},this);this.showChoices();}},choiceOver:function(c,d){if(!c||c==this.selected){return;}if(this.selected){this.selected.removeClass("autocompleter-selected");}this.selected=c.addClass("autocompleter-selected");this.fireEvent("onSelect",[this.element,this.selected,d]);if(!this.selectMode){this.opted=this.element.value;}if(!d){return;}this.selectedValue=this.selected.inputValue;if(this.overflown){var f=this.selected.getCoordinates(this.choices),e=this.options.overflowMargin,g=this.choices.scrollTop,a=this.choices.offsetHeight,b=g+a;if(f.top-e<g&&g){this.choices.scrollTop=Math.max(f.top-e,0);}else{if(f.bottom+e>b){this.choices.scrollTop=Math.min(f.bottom-a+e,b);}}}if(this.selectMode){this.setSelection();}},choiceSelect:function(a){if(a){this.choiceOver(a);}this.setSelection(true);this.queryValue=false;this.hideChoices();},filter:function(a){return(a||this.tokens).filter(function(b){return this.test(b);},new RegExp(((this.options.filterSubset)?"":"^")+this.queryValue.escapeRegExp(),(this.options.filterCase)?"":"i"));},markQueryValue:function(a){return(!this.options.markQuery||!this.queryValue)?a:a.replace(new RegExp("("+((this.options.filterSubset)?"":"^")+this.queryValue.escapeRegExp()+")",(this.options.filterCase)?"":"i"),'<span class="autocompleter-queried">$1</span>');},addChoiceEvents:function(a){return a.addEvents({mouseover:this.choiceOver.bind(this,[a]),click:this.choiceSelect.bind(this,[a])});}});var OverlayFix=new Class({initialize:function(a){if(Browser.Engine.trident){this.element=document.id(a);this.relative=this.element.getOffsetParent();this.fix=new Element("iframe",{frameborder:"0",scrolling:"no",src:"javascript:false;",styles:{position:"absolute",border:"none",display:"none",filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=0)"}}).inject(this.element,"after");}},show:function(){if(this.fix){var a=this.element.getCoordinates(this.relative);delete a.right;delete a.bottom;this.fix.setStyles($extend(a,{display:"",zIndex:(this.element.getStyle("zIndex")||1)-1}));}return this;},hide:function(){if(this.fix){this.fix.setStyle("display","none");}return this;},destroy:function(){if(this.fix){this.fix=this.fix.destroy();}}});Element.implement({getSelectedRange:function(){if(!Browser.Engine.trident){return{start:this.selectionStart,end:this.selectionEnd};}var e={start:0,end:0};var a=this.getDocument().selection.createRange();if(!a||a.parentElement()!=this){return e;}var c=a.duplicate();if(this.type=="text"){e.start=0-c.moveStart("character",-100000);e.end=e.start+a.text.length;}else{var b=this.value;var d=b.length-b.match(/[\n\r]*$/)[0].length;c.moveToElementText(this);c.setEndPoint("StartToEnd",a);e.end=d-c.text.length;c.setEndPoint("StartToStart",a);e.start=d-c.text.length;}return e;},selectRange:function(d,a){if(Browser.Engine.trident){var c=this.value.substr(d,a-d).replace(/\r/g,"").length;d=this.value.substr(0,d).replace(/\r/g,"").length;var b=this.createTextRange();b.collapse(true);b.moveEnd("character",d+c);b.moveStart("character",d);b.select();}else{this.focus();this.setSelectionRange(d,a);}return this;}});Autocompleter.Base=Autocompleter;Autocompleter.Local=new Class({Extends:Autocompleter,options:{minLength:0,delay:200},initialize:function(b,c,a){this.parent(b,a);this.tokens=c;},query:function(){this.update(this.filter());}});Autocompleter.Request=new Class({Extends:Autocompleter,options:{postData:{},ajaxOptions:{},postVar:"value"},query:function(){var c=$unlink(this.options.postData)||{};c[this.options.postVar]=this.queryValue;var b=document.id(this.options.indicator);if(b){b.setStyle("display","");}var a=this.options.indicatorClass;if(a){this.element.addClass(a);}this.fireEvent("onRequest",[this.element,this.request,c,this.queryValue]);this.request.send({data:c});},queryResponse:function(){var b=document.id(this.options.indicator);if(b){b.setStyle("display","none");}var a=this.options.indicatorClass;if(a){this.element.removeClass(a);}return this.fireEvent("onComplete",[this.element,this.request]);}});Autocompleter.Request.JSON=new Class({Extends:Autocompleter.Request,initialize:function(c,b,a){this.parent(c,a);this.request=new Request.JSON($merge({url:b,link:"cancel"},this.options.ajaxOptions)).addEvent("onComplete",this.queryResponse.bind(this));},queryResponse:function(a){this.parent();this.update(a);}});Autocompleter.Ajax={Base:Autocompleter.Request,Json:Autocompleter.Request.JSON,Xhtml:Autocompleter.Request.HTML};var Observer=new Class({Implements:[Options,Events],options:{periodical:false,delay:1000},initialize:function(c,a,b){this.element=document.id(c)||$$(c);this.addEvent("onFired",a);this.setOptions(b);this.bound=this.changed.bind(this);this.resume();},changed:function(){var a=this.element.get("value");if($equals(this.value,a)){return;}this.clear();this.value=a;this.timeout=this.onFired.delay(this.options.delay,this);},setValue:function(a){this.value=a;this.element.set("value",a);return this.clear();},onFired:function(){this.fireEvent("onFired",[this.value,this.element]);},clear:function(){$clear(this.timeout||null);return this;},pause:function(){if(this.timer){$clear(this.timer);}else{this.element.removeEvent("keyup",this.bound);}return this.clear();},resume:function(){this.value=this.element.get("value");if(this.options.periodical){this.timer=this.changed.periodical(this.options.periodical,this);}else{this.element.addEvent("keyup",this.bound);}return this;}});var $equals=function(b,a){return(b==a||JSON.encode(b)==JSON.encode(a));};function kRequestShowTopics(b,a,c){a.set("value",0).fireEvent("change",a);var d=a.getFirst().clone();a.empty().grab(d);c.each(function(f){var e=new Element("option",{value:f.id,html:f.subject});a.grab(e);});}function kRequestGetTopics(c){var b=c.get("value");var a=document.id("kmod_targettopic");request=new Request.JSON({url:kunena_url_ajax,onSuccess:function(d){kRequestShowTopics(b,a,d.topiclist);}}).post({action:"modtopiclist",value:b});}function kunenaSelectUsernameView(b,a){var c=b.getParent("form");if(b.get("checked")){c.getElement("input[name=authorname]").removeProperty("disabled").setStyle("display","inline").set("value",kunena_anonymous_name);}else{c.getElement("input[name=authorname]").set("disabled","disabled").setStyle("display","none").set("value",a);}}window.addEvent("domready",function(){$$(".kqreply").each(function(b){b.addEvent("click",function(f){f.stop();var g=this.get("id");var c=document.id(g+"_form").getStyle("display");$$(".kreply-form").setStyle("display","none");document.id(g+"_form").setStyle("display","block");if(document.id(g+"_form").getElement("input[name=anonymous]")){var d=document.id(g+"_form").getElement("input[name=authorname]").get("value");kunenaSelectUsernameView(document.id(g+"_form").getElement("input[name=anonymous]"),d);document.id(g+"_form").getElement("input[name=anonymous]").addEvent("click",function(h){kunenaSelectUsernameView(this,d);});}});});$$(".kreply-cancel").addEvent("click",function(b){$$(".kreply-form").setStyle("display","none");});$$(".kDelete_bulkcheckboxes").each(function(b){b.addEvent("change",function(c){if(b.get("value")=="1"){b.set("value","0");b.set("checked",false);}else{b.set("value","1");b.set("checked",true);}});});if(document.id("kBulkChooseActions")!=undefined){document.id("kBulkChooseActions").addEvent("change",function(b){if(this.get("value")=="bulkMove"){document.id("bulkactions").removeProperty("disabled");}else{document.id("bulkactions").setProperty("disabled","disabled");}});}if(document.id("kcbcheckall_userposts")!=undefined){document.id("kcbcheckall_userposts").addEvent("click",function(b){$$(".kDelete_bulkcheckboxes_userposts").each(function(c){if(c.get("checked")==false){c.set("checked",true);c.set("value","1");}else{c.set("value","0");c.set("checked",false);}});});}if(document.id("kcbcheckall_gotthankyouposts")!=undefined){document.id("kcbcheckall_gotthankyouposts").addEvent("click",function(b){$$(".kDelete_bulkcheckboxes_gotthankyouposts").each(function(c){if(c.get("checked")==false){c.set("checked",true);c.set("value","1");}else{c.set("value","0");c.set("checked",false);}});});}if(document.id("kcbcheckall_saidthankyouposts")!=undefined){document.id("kcbcheckall_saidthankyouposts").addEvent("click",function(b){$$(".kDelete_bulkcheckboxes_saidthankyouposts").each(function(c){if(c.get("checked")==false){c.set("checked",true);c.set("value","1");}else{c.set("value","0");c.set("checked",false);}});});}if(document.id("kcbcheckall")!=undefined){document.id("kcbcheckall").addEvent("click",function(b){$$(".kDelete_bulkcheckboxes").each(function(c){if(c.get("checked")==false){c.set("checked",true);c.set("value","1");}else{c.set("value","0");c.set("checked",false);}});});}if(document.id("kcbcheckall_subscriptions")!=undefined){document.id("kcbcheckall_subscriptions").addEvent("click",function(b){$$(".kDelete_bulkcheckboxes_subscriptions").each(function(c){if(c.get("checked")==false){c.set("checked",true);c.set("value","1");}else{c.set("value","0");c.set("checked",false);}});});}if(document.id("kcbcheckall_favorites")!=undefined){document.id("kcbcheckall_favorites").addEvent("click",function(b){$$(".kDelete_bulkcheckboxes_favorites").each(function(c){if(c.get("checked")==false){c.set("checked",true);c.set("value","1");}else{c.set("value","0");c.set("checked",false);}});});}if(document.id("kcbcheckall_post")!=undefined){document.id("kcbcheckall_post").addEvent("click",function(b){$$(".kDelete_bulkcheckboxes_post").each(function(c){if(c.get("checked")==false){c.set("checked",true);c.set("value","1");}else{c.set("value","0");c.set("checked",false);}});});}if(document.id("kmod_categories")!=undefined){document.id("kmod_categories").addEvent("change",function(b){kRequestGetTopics(this);});}if(document.id("kmod_targettopic")!=undefined){document.id("kmod_targettopic").addEvent("change",function(b){id=this.get("value");if(id!=0){targetid=this.get("value");document.id("kmod_subject").setStyle("display","none");}else{targetid="";document.id("kmod_subject").setStyle("display","block");}if(id==-1){targetid="";document.id("kmod_targetid").setStyle("display","inline");}else{document.id("kmod_targetid").setStyle("display","none");}document.id("kmod_targetid").set("value",targetid);});}var a=new Hash.Cookie("kunena_settings",{duration:3600});$$("a.ktoggler").each(function(b){if(a.get("hide_"+b.getProperty("rel"))){b.removeClass("close").addClass("open");b.set("title",kunena_toggler_open);document.id(b.getProperty("rel")).setStyle("display","none");}b.addEvent("click",function(){if(this.hasClass("close")){this.removeClass("close").addClass("open");b.set("title",kunena_toggler_open);document.id(this.getProperty("rel")).setStyle("display","none");a.set("hide_"+this.getProperty("rel"),true);}else{this.removeClass("open").addClass("close");b.set("title",kunena_toggler_close);document.id(this.getProperty("rel")).setStyle("display","");a.set("hide_"+this.getProperty("rel"),false);}});});if(document.id("kpassword")!=undefined&&document.id("kpassword2")!=undefined){document.id("kpassword").setProperty("autocompleter","off");document.id("kpassword2").setProperty("autocompleter","off");}});