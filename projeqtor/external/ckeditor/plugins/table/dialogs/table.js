﻿/*
 Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
(function(){function v(a){for(var f=0,n=0,l=0,p,e=a.$.rows.length;l<e;l++){p=a.$.rows[l];for(var d=f=0,b,c=p.cells.length;d<c;d++)b=p.cells[d],f+=b.colSpan;f>n&&(n=f)}return n}function r(a){return function(){var f=this.getValue(),f=!!(CKEDITOR.dialog.validate.integer()(f)&&0<f);f||(alert(a),this.select());return f}}function q(a,f){var n=function(e){return new CKEDITOR.dom.element(e,a.document)},q=a.editable(),p=a.plugins.dialogadvtab;return{title:a.lang.table.title,minWidth:310,minHeight:CKEDITOR.env.ie?
310:280,onLoad:function(){var e=this,a=e.getContentElement("advanced","advStyles");if(a)a.on("change",function(){var a=this.getStyle("width",""),c=e.getContentElement("info","txtWidth");c&&c.setValue(a,!0);a=this.getStyle("height","");(c=e.getContentElement("info","txtHeight"))&&c.setValue(a,!0)})},onShow:function(){var e=a.getSelection(),d=e.getRanges(),b,c=this.getContentElement("info","txtRows"),g=this.getContentElement("info","txtCols"),t=this.getContentElement("info","txtWidth"),m=this.getContentElement("info",
"txtHeight");"tableProperties"==f&&((e=e.getSelectedElement())&&e.is("table")?b=e:0<d.length&&(CKEDITOR.env.webkit&&d[0].shrink(CKEDITOR.NODE_ELEMENT),b=a.elementPath(d[0].getCommonAncestor(!0)).contains("table",1)),this._.selectedElement=b);b?(this.setupContent(b),c&&c.disable(),g&&g.disable()):(c&&c.enable(),g&&g.enable());t&&t.onChange();m&&m.onChange()},onOk:function(){var e=a.getSelection(),d=this._.selectedElement&&e.createBookmarks(),b=this._.selectedElement||n("table"),c={};this.commitContent(c,
b);if(c.info){c=c.info;if(!this._.selectedElement)for(var g=b.append(n("tbody")),f=parseInt(c.txtRows,10)||0,m=parseInt(c.txtCols,10)||0,k=0;k<f;k++)for(var h=g.append(n("tr")),l=0;l<m;l++)h.append(n("td")).appendBogus();f=c.selHeaders;if(!b.$.tHead&&("row"==f||"both"==f)){h=b.getElementsByTag("thead").getItem(0);g=b.getElementsByTag("tbody").getItem(0);m=g.getElementsByTag("tr").getItem(0);h||(h=new CKEDITOR.dom.element("thead"),h.insertBefore(g));for(k=0;k<m.getChildCount();k++)g=m.getChild(k),
g.type!=CKEDITOR.NODE_ELEMENT||g.data("cke-bookmark")||(g.renameNode("th"),g.setAttribute("scope","col"));h.append(m.remove())}if(null!==b.$.tHead&&"row"!=f&&"both"!=f){h=new CKEDITOR.dom.element(b.$.tHead);g=b.getElementsByTag("tbody").getItem(0);for(l=g.getFirst();0<h.getChildCount();){m=h.getFirst();for(k=0;k<m.getChildCount();k++)g=m.getChild(k),g.type==CKEDITOR.NODE_ELEMENT&&(g.renameNode("td"),g.removeAttribute("scope"));m.insertBefore(l)}h.remove()}if(!this.hasColumnHeaders&&("col"==f||"both"==
f))for(h=0;h<b.$.rows.length;h++)g=new CKEDITOR.dom.element(b.$.rows[h].cells[0]),g.renameNode("th"),g.setAttribute("scope","row");if(this.hasColumnHeaders&&"col"!=f&&"both"!=f)for(k=0;k<b.$.rows.length;k++)h=new CKEDITOR.dom.element(b.$.rows[k]),"tbody"==h.getParent().getName()&&(g=new CKEDITOR.dom.element(h.$.cells[0]),g.renameNode("td"),g.removeAttribute("scope"));c.txtHeight?b.setStyle("height",c.txtHeight):b.removeStyle("height");c.txtWidth?b.setStyle("width",c.txtWidth):b.removeStyle("width");
b.getAttribute("style")||b.removeAttribute("style")}if(this._.selectedElement)try{e.selectBookmarks(d)}catch(p){}else a.insertElement(b),setTimeout(function(){var e=new CKEDITOR.dom.element(b.$.rows[0].cells[0]),c=a.createRange();c.moveToPosition(e,CKEDITOR.POSITION_AFTER_START);c.select()},0)},contents:[{id:"info",label:a.lang.table.title,elements:[{type:"hbox",widths:[null,null],styles:["vertical-align:top"],children:[{type:"vbox",padding:0,children:[{type:"text",id:"txtRows","default":3,label:a.lang.table.rows,
required:!0,controlStyle:"width:5em",validate:r(a.lang.table.invalidRows),setup:function(e){this.setValue(e.$.rows.length)},commit:l},{type:"text",id:"txtCols","default":2,label:a.lang.table.columns,required:!0,controlStyle:"width:5em",validate:r(a.lang.table.invalidCols),setup:function(e){this.setValue(v(e))},commit:l},{type:"html",html:"\x26nbsp;"},{type:"select",id:"selHeaders",requiredContent:"th","default":"",label:a.lang.table.headers,items:[[a.lang.table.headersNone,""],[a.lang.table.headersRow,
"row"],[a.lang.table.headersColumn,"col"],[a.lang.table.headersBoth,"both"]],setup:function(e){var a=this.getDialog();a.hasColumnHeaders=!0;for(var b=0;b<e.$.rows.length;b++){var c=e.$.rows[b].cells[0];if(c&&"th"!=c.nodeName.toLowerCase()){a.hasColumnHeaders=!1;break}}null!==e.$.tHead?this.setValue(a.hasColumnHeaders?"both":"row"):this.setValue(a.hasColumnHeaders?"col":"")},commit:l},{type:"text",id:"txtBorder",requiredContent:"table[border]","default":a.filter.check("table[border]")?1:0,label:a.lang.table.border,
controlStyle:"width:3em",validate:CKEDITOR.dialog.validate.number(a.lang.table.invalidBorder),setup:function(a){this.setValue(a.getAttribute("border")||"")},commit:function(a,d){this.getValue()?d.setAttribute("border",this.getValue()):d.removeAttribute("border")}},{id:"cmbAlign",type:"select",requiredContent:"table[align]","default":"",label:a.lang.common.align,items:[[a.lang.common.notSet,""],[a.lang.common.alignLeft,"left"],[a.lang.common.alignCenter,"center"],[a.lang.common.alignRight,"right"]],
setup:function(a){this.setValue(a.getAttribute("align")||"")},commit:function(a,d){this.getValue()?d.setAttribute("align",this.getValue()):d.removeAttribute("align")}}]},{type:"vbox",padding:0,children:[{type:"hbox",widths:["5em"],children:[{type:"text",id:"txtWidth",requiredContent:"table{width}",controlStyle:"width:5em",label:a.lang.common.width,title:a.lang.common.cssLengthTooltip,"default":a.filter.check("table{width}")?500>q.getSize("width")?"100%":500:0,getValue:u,validate:CKEDITOR.dialog.validate.cssLength(a.lang.common.invalidCssLength.replace("%1",
a.lang.common.width)),onChange:function(){var a=this.getDialog().getContentElement("advanced","advStyles");a&&a.updateStyle("width",this.getValue())},setup:function(a){a=a.getStyle("width");this.setValue(a)},commit:l}]},{type:"hbox",widths:["5em"],children:[{type:"text",id:"txtHeight",requiredContent:"table{height}",controlStyle:"width:5em",label:a.lang.common.height,title:a.lang.common.cssLengthTooltip,"default":"",getValue:u,validate:CKEDITOR.dialog.validate.cssLength(a.lang.common.invalidCssLength.replace("%1",
a.lang.common.height)),onChange:function(){var a=this.getDialog().getContentElement("advanced","advStyles");a&&a.updateStyle("height",this.getValue())},setup:function(a){(a=a.getStyle("height"))&&this.setValue(a)},commit:l}]},{type:"html",html:"\x26nbsp;"},{type:"text",id:"txtCellSpace",requiredContent:"table[cellspacing]",controlStyle:"width:3em",label:a.lang.table.cellSpace,"default":a.filter.check("table[cellspacing]")?1:0,validate:CKEDITOR.dialog.validate.number(a.lang.table.invalidCellSpacing),
setup:function(a){this.setValue(a.getAttribute("cellSpacing")||"")},commit:function(a,d){this.getValue()?d.setAttribute("cellSpacing",this.getValue()):d.removeAttribute("cellSpacing")}},{type:"text",id:"txtCellPad",requiredContent:"table[cellpadding]",controlStyle:"width:3em",label:a.lang.table.cellPad,"default":a.filter.check("table[cellpadding]")?1:0,validate:CKEDITOR.dialog.validate.number(a.lang.table.invalidCellPadding),setup:function(a){this.setValue(a.getAttribute("cellPadding")||"")},commit:function(a,
d){this.getValue()?d.setAttribute("cellPadding",this.getValue()):d.removeAttribute("cellPadding")}}]}]},{type:"html",align:"right",html:""},{type:"vbox",padding:0,children:[{type:"text",id:"txtCaption",requiredContent:"caption",label:a.lang.table.caption,setup:function(a){this.enable();a=a.getElementsByTag("caption");if(0<a.count()){a=a.getItem(0);var d=a.getFirst(CKEDITOR.dom.walker.nodeType(CKEDITOR.NODE_ELEMENT));d&&!d.equals(a.getBogus())?(this.disable(),this.setValue(a.getText())):(a=CKEDITOR.tools.trim(a.getText()),
this.setValue(a))}},commit:function(e,d){if(this.isEnabled()){var b=this.getValue(),c=d.getElementsByTag("caption");if(b)0<c.count()?(c=c.getItem(0),c.setHtml("")):(c=new CKEDITOR.dom.element("caption",a.document),d.append(c,!0)),c.append(new CKEDITOR.dom.text(b,a.document));else if(0<c.count())for(b=c.count()-1;0<=b;b--)c.getItem(b).remove()}}},{type:"text",id:"txtSummary",bidi:!0,requiredContent:"table[summary]",label:a.lang.table.summary,setup:function(a){this.setValue(a.getAttribute("summary")||
"")},commit:function(a,d){this.getValue()?d.setAttribute("summary",this.getValue()):d.removeAttribute("summary")}}]}]},p&&p.createAdvancedTab(a,null,"table")]}}var u=CKEDITOR.tools.cssLength,l=function(a){var f=this.id;a.info||(a.info={});a.info[f]=this.getValue()};CKEDITOR.dialog.add("table",function(a){return q(a,"table")});CKEDITOR.dialog.add("tableProperties",function(a){return q(a,"tableProperties")})})();