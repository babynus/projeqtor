﻿/*
 Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function(){function d(c,d){var b;try{b=c.getSelection().getRanges()[0]}catch(f){return null}b.shrink(CKEDITOR.SHRINK_TEXT);return c.elementPath(b.getCommonAncestor()).contains(d,1)}function e(c,e){var b=c.lang.liststyle;if("bulletedListStyle"==e)return{title:b.bulletedTitle,minWidth:300,minHeight:50,contents:[{id:"info",accessKey:"I",elements:[{type:"select",label:b.type,id:"type",align:"center",style:"width:150px",items:[[b.notset,""],[b.circle,"circle"],[b.disc,"disc"],[b.square,"square"]],setup:function(a){a=
a.getStyle("list-style-type")||h[a.getAttribute("type")]||a.getAttribute("type")||"";this.setValue(a)},commit:function(a){var b=this.getValue();b?a.setStyle("list-style-type",b):a.removeStyle("list-style-type")}}]}],onShow:function(){var a=this.getParentEditor();(a=d(a,"ul"))&&this.setupContent(a)},onOk:function(){var a=this.getParentEditor();(a=d(a,"ul"))&&this.commitContent(a)}};if("numberedListStyle"==e){var g=[[b.notset,""],[b.lowerRoman,"lower-roman"],[b.upperRoman,"upper-roman"],[b.lowerAlpha,
"lower-alpha"],[b.upperAlpha,"upper-alpha"],[b.decimal,"decimal"]];(!CKEDITOR.env.ie||7<CKEDITOR.env.version)&&g.concat([[b.armenian,"armenian"],[b.decimalLeadingZero,"decimal-leading-zero"],[b.georgian,"georgian"],[b.lowerGreek,"lower-greek"]]);return{title:b.numberedTitle,minWidth:300,minHeight:50,contents:[{id:"info",accessKey:"I",elements:[{type:"hbox",widths:["25%","75%"],children:[{label:b.start,type:"text",id:"start",validate:CKEDITOR.dialog.validate.integer(b.validateStartNumber),setup:function(a){a=
a.getFirst(f).getAttribute("value")||a.getAttribute("start")||1;this.setValue(a)},commit:function(a){var b=a.getFirst(f),c=b.getAttribute("value")||a.getAttribute("start")||1;a.getFirst(f).removeAttribute("value");var d=parseInt(this.getValue(),10);isNaN(d)?a.removeAttribute("start"):a.setAttribute("start",d);a=b;b=c;for(d=isNaN(d)?1:d;(a=a.getNext(f))&&b++;)a.getAttribute("value")==b&&a.setAttribute("value",d+b-c)}},{type:"select",label:b.type,id:"type",style:"width: 100%;",items:g,setup:function(a){a=
a.getStyle("list-style-type")||h[a.getAttribute("type")]||a.getAttribute("type")||"";this.setValue(a)},commit:function(a){var b=this.getValue();b?a.setStyle("list-style-type",b):a.removeStyle("list-style-type")}}]}]}],onShow:function(){var a=this.getParentEditor();(a=d(a,"ol"))&&this.setupContent(a)},onOk:function(){var a=this.getParentEditor();(a=d(a,"ol"))&&this.commitContent(a)}}}}var f=function(c){return c.type==CKEDITOR.NODE_ELEMENT&&c.is("li")},h={a:"lower-alpha",A:"upper-alpha",i:"lower-roman",
I:"upper-roman",1:"decimal",disc:"disc",circle:"circle",square:"square"};CKEDITOR.dialog.add("numberedListStyle",function(c){return e(c,"numberedListStyle")});CKEDITOR.dialog.add("bulletedListStyle",function(c){return e(c,"bulletedListStyle")})})();