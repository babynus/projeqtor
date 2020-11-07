
colorThemingInProgress=false;
function setColorTheming(ref,bis, mode) {
  if (colorThemingInProgress) return;
  colorThemingInProgress=true;
  if (!ref && dojo.byId('menuUserColorPicker')) ref=dojo.byId('menuUserColorPicker').value;
  if (!bis && dojo.byId('menuUserColorPickerBis')) bis=dojo.byId('menuUserColorPickerBis').value;
  var white='#ffffff';
  var black='#000000';
  if (!mode) mode='hsl'; // Mode = hsl or hsv 
  if (mode=='hsl') {
    var hsl=hexToHSL(ref);
    var h=hsl[0];
    var s=hsl[1];
    var l=hsl[2];
    darker=HSLToHex(h,(s==0)?0:25,25);
    dark=HSLToHex(h,(s==0)?0:25,40);
    medium=HSLToHex(h,s,70);
    light=HSLToHex(h,s,90);
    lighter=HSLToHex(h,s,95);
    var hslDefault=hexToHSL('#ff0000');
    hueRotate=h-hslDefault[0];
    //saturate=Math.round(s/hslDefault[1]*100);
    //brightness=Math.round(40/hslDefault[2]*100);
    saturate=50;
    if (s==0) saturate=0;
    brightness=80;
    //saturate=100;
    //brightness=100;
    
    var hsl=hexToHSL(bis);
    var h=hsl[0];
    var s=hsl[1];
    var l=hsl[2];
    darkerBis=HSLToHex(h,25,25);
    darkBis=HSLToHex(h,25,40);
    mediumBis=HSLToHex(h,s,70);
    lightBis=HSLToHex(h,s,90);
    lighterBis=HSLToHex(h,s,95);
    hueRotateSelected=h-hslDefault[0];
    saturateSelected=Math.round(s/hslDefault[1]*100);
    brightnessSelected=Math.round(l/hslDefault[2]*200);
    if (brightnessSelected>240) brightnessSelected=240;
    if (saturateSelected>80) saturateSelected=80;
    console.log("saturateSelected="+saturateSelected+", brightnessSelected="+brightnessSelected);
  } else {
    // Default (initialization) =============================== INIT
    if (!ref) ref='#545381';
    if (!bis) bis='#E97B2C';
    var dark='#656565';
    var medium='#b5b5b5';
    var light='#d8d8d8';
    var lighter='#f0f0f0';
    var hueRotate=0;
    var saturate=0;
    var brightness=0;
  
    // REF Color (Primary) ==================================== REF
    var hsvRef=hexToHSV(ref);
    var hRef=hsvRef[0];
    var sRef=hsvRef[1];
    var vRef=hsvRef[2];
    console.log("***********");
    var test=HSVToHex(hRef,sRef,vRef);
    console.log(test);
    darker=HSVToHex(hRef,sRef,40);
    dark=HSVToHex(hRef,sRef,70);
    medium=HSVToHex(hRef,sRef,90);
    light=HSVToHex(hRef,10,99);
    lighter=HSVToHex(hRef,5,99);
  
    // DEFAULT (Red) = color of icons, to define translation === ICON
    var hsvDefault=hexToHSV('#ff0000');
    hueRotate=hRef-hsvDefault[0];
    saturate=100; // Math.round(sRef/hsvDefault[1]*1000)/10;
    brightness=80;// Math.round(vRef/hsvDefault[2]*1000)/10;
    if (sRef<25) {
      saturate=sRef;
      brightness=200
    }
    if (vRef<25) {
      //saturate=sRef;
      brightness=vRef;
    }
    saturate=sRef;
    brightness=2*vRef;
  
    // BIS Color (Secondary)
    var hsvBis=hexToHSV(bis);
    var hBis=hsvBis[0];
    var sBis=hsvBis[1];
    var vBis=hsvBis[2];
    if (vBis>80) {
      vBis=80;
      bis=HSVToHex(hBis,sBis,vBis);
    }
    darkerBis=HSVToHex(hBis,25,25);
    darkBis=HSVToHex(hBis,25,40);
    mediumBis=HSVToHex(hBis,sBis,70);
    lightBis=HSVToHex(hBis,sBis,90);
    lighterBis=HSVToHex(hBis,sBis,95);
    hueRotateSelected=hBis-hsvDefault[0];
    saturateSelected=Math.round(sBis/hsvDefault[1]*100);
    brightnessSelected=Math.round(vBis/hsvDefault[2]*100);
    console.log("transform : hue="+hueRotateSelected+" sat="+saturateSelected+" bri="+brightnessSelected);
    if (brightnessSelected > 180) {
      //brightnessSelected=180;
    }
  }
  if(!isNewGui) dojo.byId("logoMenuBar").src="img/logoSmallWhite.png";
  var foreColor = '#000000';
  var invert=1;
  if (ref.length == 7) {
    var red = ref.substr(1, 2);
    var green = ref.substr(3, 2);
    var blue = ref.substr(5, 2);
    var lightness = (0.3) * parseInt(red, 16) + (0.6) * parseInt(green, 16)
        + (0.1) * parseInt(blue, 16);
    lightness=parseInt(lightness);
    if (lightness < 128) {
      invert=1;
      dec=parseInt(192+lightness);
      if (dec>255) dec=255;
      hex=Number(dec).toString(16); 
      if (hex.length < 2) { hex="0"+hex; } 
      foreColor = '#'+hex+hex+hex;
      foreColor = '#ffffff';    
    } else {
      invert=0;
      dec=parseInt(lightness-128);
      console.log(">128 dec="+dec);
      hex=Number(dec).toString(16); 
      if (hex.length < 2) { hex="0"+hex; } 
      foreColor = '#'+hex+hex+hex;
      foreColor = '#000000';
      dojo.byId("logoMenuBar").src="img/logoSmall.png";
    }
  }
  
  var bisText = '#ffffff';
  if (bis.length == 7) {
    var red = bis.substr(1, 2);
    var green = bis.substr(3, 2);
    var blue = bis.substr(5, 2);
    var lightnessBis = (0.3) * parseInt(red, 16) + (0.6) * parseInt(green, 16)
    + (0.1) * parseInt(blue, 16);
    lightnessBis=parseInt(lightnessBis);
    if (lightnessBis > 150) {
      bisText = '#000000';
    }
  }
  
  var menu=darker;
  red = dark.substr(1, 2);
  green = dark.substr(3, 2);
  blue = dark.substr(5, 2);
  lightnessDark = (0.3) * parseInt(red, 16) + (0.6) * parseInt(green, 16)
      + (0.1) * parseInt(blue, 16);
  lightnessDark=parseInt(lightnessDark);
  if (lightnessDark-lightness>20 || lightness-lightnessDark>25) {
    menu=dark;
  }
  
//  dijit.byId("menuBarUndoButton").domNode.style.filter='brightness(0) invert('+invert+')';
//  dijit.byId("menuBarRedoButton").domNode.style.filter='brightness(0) invert('+invert+')';
//  dojo.byId("menuBarNewtabButton").style.filter='brightness(0) invert('+invert+')';
//  dojo.byId("selectedProject").style.filter='brightness(0) invert('+invert+')';
//  dijit.byId("projectSelectorParametersButton").domNode.style.filter='brightness(0) invert('+invert+')';

  var element=document.getElementById('body');
  // Generic colors
  element.style.setProperty("--color-reference", ref);
  element.style.setProperty("--color-darker", darker);
  element.style.setProperty("--color-dark", dark);
  element.style.setProperty("--color-medium", medium);
  element.style.setProperty("--color-light", light);
  element.style.setProperty("--color-lighter", lighter);
  element.style.setProperty("--color-text", '#656565');
  element.style.setProperty("--color-white", '#ffffff');
  element.style.setProperty("--color-secondary", bis);
  element.style.setProperty("--color-darker-secondary", darkerBis);
  element.style.setProperty("--color-dark-secondary", darkBis);
  element.style.setProperty("--color-medium-secondary", mediumBis);
  element.style.setProperty("--color-light-secondary", lightBis);
  element.style.setProperty("--color-lighter-secondary", lighterBis);

  // Main Layout
  element.style.setProperty("--color-toolbar",ref);
  element.style.setProperty("--color-toolbar-text",foreColor);
  element.style.setProperty("--color-toolbar-invert",invert);
  element.style.setProperty("--color-toolbar-invert-reverse",(1-invert));
  element.style.setProperty("--color-menu",menu);
  // List
  element.style.setProperty("--color-list-header", white);
  element.style.setProperty("--color-list-header-text", dark);
  element.style.setProperty("--color-grid-header-bg", white);
  element.style.setProperty("--color-grid-header-text", dark);
  element.style.setProperty("--color-grid-selected-bg", bis);
  element.style.setProperty("--color-grid-selected-text", bisText);
  // Detail
  element.style.setProperty("--color-detail-header", white);
  element.style.setProperty("--color-detail-header-text", dark);
  element.style.setProperty("--color-detail-header-border", light);
  element.style.setProperty("--color-section-title-text", dark);
  element.style.setProperty("--color-section-title-border", dark);
  element.style.setProperty("--color-table-header", light);
  // Tools (buttons, ...)
  element.style.setProperty("--color-button-background", lighter);
  element.style.setProperty("--color-button-text", dark);
  element.style.setProperty("--image-hue-rotate", hueRotate+'deg');
  element.style.setProperty("--image-hue-rotate-reverse", (-1*hueRotate)+'deg');
  element.style.setProperty("--image-saturate", saturate+'%');
  element.style.setProperty("--image-brightness", brightness+'%');
  element.style.setProperty("--image-hue-rotate-selected", hueRotateSelected+'deg');
  element.style.setProperty("--image-saturate-selected", saturateSelected+'%');
  element.style.setProperty("--image-brightness-selected", brightnessSelected+'%');;
  colorThemingInProgress=false;
}

// ==========================================================================
// Transformation Functions
//==========================================================================

function RGBToHex(r,g,b) {
  r = r.toString(16);
  g = g.toString(16);
  b = b.toString(16);
  if (r.length == 1) r = "0" + r;
  if (g.length == 1) g = "0" + g;
  if (b.length == 1) b = "0" + b;
  return "#" + r + g + b;
}
function RGBAToHexA(r,g,b,a) {
  r = r.toString(16);
  g = g.toString(16);
  b = b.toString(16);
  a = Math.round(a * 255).toString(16);
  if (r.length == 1) r = "0" + r;
  if (g.length == 1) g = "0" + g;
  if (b.length == 1) b = "0" + b;
  if (a.length == 1) a = "0" + a;
  return "#" + r + g + b + a;
}
function hexToRGB(h) {
  let r = 0, g = 0, b = 0;
  if (h.length == 4) {   // 3 digits
    r = parseInt("0x"+h[1]+h[1],16);
    g = parseInt("0x"+h[2]+h[2],16);
    b = parseInt("0x"+h[3]+h[3],16);
  } else if (h.length == 7) { // 6 digits
    r = parseInt("0x"+h[1]+h[2],16);
    g = parseInt("0x"+h[3]+h[4],16);
    b = parseInt("0x"+h[5]+h[6],16);
  }
  return new Array(r,g,b);
}
function hexAToRGBA(h) {
  let r = 0, g = 0, b = 0, a = 1;
  if (h.length == 5) {
    r = "0x" + h[1] + h[1];
    g = "0x" + h[2] + h[2];
    b = "0x" + h[3] + h[3];
    a = "0x" + h[4] + h[4];
  } else if (h.length == 9) {
    r = "0x" + h[1] + h[2];
    g = "0x" + h[3] + h[4];
    b = "0x" + h[5] + h[6];
    a = "0x" + h[7] + h[8];
  }
  a = +(a / 255).toFixed(3);
  return new Array(r,g,b,a)
}
function hexToHSL(H) {
  // Convert hex to RGB first
  let r = 0, g = 0, b = 0;
  if (H.length == 4) {
    r = "0x" + H[1] + H[1];
    g = "0x" + H[2] + H[2];
    b = "0x" + H[3] + H[3];
  } else if (H.length == 7) {
    r = "0x" + H[1] + H[2];
    g = "0x" + H[3] + H[4];
    b = "0x" + H[5] + H[6];
  }
  // Then to HSL
  r /= 255;
  g /= 255;
  b /= 255;
  let cmin = Math.min(r,g,b),
      cmax = Math.max(r,g,b),
      delta = cmax - cmin,
      h = 0,
      s = 0,
      l = 0;
  if (delta == 0) h = 0;
  else if (cmax == r) h = ((g - b) / delta) % 6;
  else if (cmax == g) h = (b - r) / delta + 2;
  else  h = (r - g) / delta + 4;
  h = Math.round(h * 60);
  if (h < 0) h += 360;
  l = (cmax + cmin) / 2;
  s = delta == 0 ? 0 : delta / (1 - Math.abs(2 * l - 1));
  s = +(s * 100).toFixed(1);
  l = +(l * 100).toFixed(1);
  return new Array(h,s,l);
}
function HSLToHex(h,s,l) {
  s /= 100;
  l /= 100;
  let c = (1 - Math.abs(2 * l - 1)) * s,
      x = c * (1 - Math.abs((h / 60) % 2 - 1)),
      m = l - c/2,
      r = 0,
      g = 0,
      b = 0;
  if (0 <= h && h < 60) { r = c; g = x; b = 0;} 
  else if (60 <= h && h < 120) { r = x; g = c; b = 0;} 
  else if (120 <= h && h < 180) { r = 0; g = c; b = x;} 
  else if (180 <= h && h < 240) { r = 0; g = x; b = c;} 
  else if (240 <= h && h < 300) { r = x; g = 0; b = c;} 
  else if (300 <= h && h < 360) { r = c; g = 0; b = x; }
  // Having obtained RGB, convert channels to hex
  r = Math.round((r + m) * 255).toString(16);
  g = Math.round((g + m) * 255).toString(16);
  b = Math.round((b + m) * 255).toString(16);
  // Prepend 0s, if necessary
  if (r.length == 1) r = "0" + r;
  if (g.length == 1) g = "0" + g;
  if (b.length == 1) b = "0" + b;
  return "#" + r + g + b;
}
function hexToHSV(H) {
  var arr=hexToRGB(H);
  return rgbToHsv(arr[0],arr[1],arr[2]);
}
function HSVToHex(h,s,v) {
  var arr=hsvToRgb(h/360, s/100, v/100);
  return RGBToHex(arr[0],arr[1],arr[2]);
}
function rgbToHsv(r, g, b) {
  r /= 255, g /= 255, b /= 255;
  var max = Math.max(r, g, b), min = Math.min(r, g, b);
  var h, s, v = max;
  var d = max - min;
  s = max == 0 ? 0 : d / max;
  if (max == min) {
    h = 0; // achromatic
  } else {
    switch (max) {
      case r: h = (g - b) / d + (g < b ? 6 : 0); break;
      case g: h = (b - r) / d + 2; break;
      case b: h = (r - g) / d + 4; break;
    }
    h /= 6;
  }
  return [ Math.round(h*360*10)/10, Math.round(s*1000)/10, Math.round(v*1000)/10 ];
}

function hsvToRgb(h, s, v) {
  var r, g, b;
  var i = Math.floor(h * 6);
  var f = h * 6 - i;
  var p = v * (1 - s);
  var q = v * (1 - f * s);
  var t = v * (1 - (1 - f) * s);
  switch (i % 6) {
    case 0: r = v, g = t, b = p; break;
    case 1: r = q, g = v, b = p; break;
    case 2: r = p, g = v, b = t; break;
    case 3: r = p, g = q, b = v; break;
    case 4: r = t, g = p, b = v; break;
    case 5: r = v, g = p, b = q; break;
  }
  return [ Math.round(r * 255), Math.round(g * 255), Math.round(b * 255) ];
}