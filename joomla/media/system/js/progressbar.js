Fx.ProgressBar=new Class({Extends:Fx,options:{text:null,url:null,transition:Fx.Transitions.Circ.easeOut,fit:!0,link:"cancel",html5:!0},initialize:function(a,c){this.element=document.id(a);this.parent(c);var d=this.options.url;(this.useHtml5=this.options.html5&&this.supportsHtml5())?(this.progressElement=(new Element("progress")).replaces(this.element),this.progressElement.max=100,this.progressElement.value=0):(this.element.set("role","progressbar"),this.element.set("aria-valuenow","0"),this.element.set("aria-valuemin",
"0"),this.element.set("aria-valuemax","100"),d&&this.element.setStyles({"background-image":"url("+d+")","background-repeat":"no-repeat"}));if(this.options.fit&&!this.useHtml5){if(d=d||this.element.getStyle("background-image").replace(/^url\(["']?|["']?\)$/g,"")){var b=new Image;b.onload=function(){this.fill=b.width;b=b.onload=null;this.set(this.now||0)}.bind(this);b.src=d;if(!this.fill&&b.width)b.onload()}}else this.set(0)},supportsHtml5:function(){return"value"in document.createElement("progress")},
start:function(a,c){return this.parent(this.now,arguments.length==1?a.limit(0,100):a/c*100)},set:function(a){this.now=a;this.useHtml5?this.progressElement.value=a:(this.element.setStyle("backgroundPosition",(this.fill?(this.fill/-2+a/100*(this.element.width||1)||0).round()+"px":100-a+"%")+" 0px").title=Math.round(a)+"%",this.element.set("aria-valuenow",a));var c=document.id(this.options.text);c&&c.set("text",Math.round(a)+"%");return this}});