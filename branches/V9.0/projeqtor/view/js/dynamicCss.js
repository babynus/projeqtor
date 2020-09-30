
colorThemingInProgress=false;
function setColorTheming(ref,bis) {
  if (colorThemingInProgress) return;
  colorThemingInProgress=true;
  if (!ref && dojo.byId('menuUserColorPicker')) ref=dojo.byId('menuUserColorPicker').value;
  if (!bis && dojo.byId('menuUserColorPickerBis')) bis=dojo.byId('menuUserColorPickerBis').value;
  //ref='#e97b2c';// Pour Test
  if (!ref) ref='#656565'; // dark grey
  if (!bis) bis='#E97B2C';
  var white='#ffffff';
  var black='#000000';
  var dark='#656565';
  var medium='#b5b5b5';
  var light='#d8d8d8';
  var lighter='#f0f0f0';
  var hueRotate=0;
  var saturate=0;
  var brightness=0;
  
  if (ref=='blue') {
    ref='#545381';
  } else if (ref=='red') {
    ref='#833e3e';
  } else if (ref=='green') {
    ref='#537665';
  } else if (ref=='grey') {
    ref='#656565';
  } else if (ref=='orange') {
    ref='#e97b2c';
  } 

  var hsl=hexToHSL(ref);
  var h=hsl[0];
  var s=hsl[1];
  var l=hsl[2];
  darker=HSLToHex(h,25,25);
  dark=HSLToHex(h,25,40);
  medium=HSLToHex(h,s,70);
  light=HSLToHex(h,s,90);
  lighter=HSLToHex(h,s,95);
  var hslDefault=hexToHSL('#ff0000');
  hueRotate=h-hslDefault[0];
  //saturate=Math.round(s/hslDefault[1]*100);
  //brightness=Math.round(40/hslDefault[2]*100);
  saturate=50;
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
  console.log("dark="+dark);
  console.log("darkBis="+darkBis);

  var foreColor = '#000000';
  var invert=1;
  if (ref.length == 7) {
    var red = ref.substr(1, 2);
    var green = ref.substr(3, 2);
    var blue = ref.substr(5, 2);
    var lightness = (0.3) * parseInt(red, 16) + (0.6) * parseInt(green, 16)
        + (0.1) * parseInt(blue, 16);
    lightness=parseInt(lightness);
    console.log("lightness="+lightness);
    if (lightness < 128) {
      invert=1;
      dec=parseInt(192+lightness);
      if (dec>255) dec=255;
      console.log("<128 dec="+dec);
      hex=Number(dec).toString(16); 
      if (hex.length < 2) { hex="0"+hex; } 
      foreColor = '#'+hex+hex+hex;
      foreColor = '#ffffff';
      dojo.byId("logoMenuBar").src="img/logoSmallWhite.png";
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
  // List
  element.style.setProperty("--color-list-header", white);
  element.style.setProperty("--color-list-header-text", dark);
  element.style.setProperty("--color-grid-header-bg", white);
  element.style.setProperty("--color-grid-header-text", dark);
  // Detail
  element.style.setProperty("--color-detail-header", white);
  element.style.setProperty("--color-detail-header-text", dark);
  element.style.setProperty("--color-detail-header-border", light);
  element.style.setProperty("--color-section-title-text", dark);
  element.style.setProperty("--color-section-title-border", dark);
  element.style.setProperty("--color-table-header", light);
  
  // Tools (buttons, ...)
  element.style.setProperty("--color-button-background", lighter);
  element.style.setProperty("--image-hue-rotate", hueRotate+'deg');
  element.style.setProperty("--image-hue-rotate-reverse", (-1*hueRotate)+'deg');
  element.style.setProperty("--image-saturate", saturate+'%');
  element.style.setProperty("--image-brightness", brightness+'%');;
  colorThemingInProgress=false;
}

function RGBToHex(r,g,b) {
  r = r.toString(16);
  g = g.toString(16);
  b = b.toString(16);

  if (r.length == 1)
    r = "0" + r;
  if (g.length == 1)
    g = "0" + g;
  if (b.length == 1)
    b = "0" + b;

  return "#" + r + g + b;
}
function RGBAToHexA(r,g,b,a) {
  r = r.toString(16);
  g = g.toString(16);
  b = b.toString(16);
  a = Math.round(a * 255).toString(16);

  if (r.length == 1)
    r = "0" + r;
  if (g.length == 1)
    g = "0" + g;
  if (b.length == 1)
    b = "0" + b;
  if (a.length == 1)
    a = "0" + a;

  return "#" + r + g + b + a;
}
function hexToRGB(h) {
  let r = 0, g = 0, b = 0;

  // 3 digits
  if (h.length == 4) {
    r = "0x" + h[1] + h[1];
    g = "0x" + h[2] + h[2];
    b = "0x" + h[3] + h[3];

  // 6 digits
  } else if (h.length == 7) {
    r = "0x" + h[1] + h[2];
    g = "0x" + h[3] + h[4];
    b = "0x" + h[5] + h[6];
  }
  
  //return "rgb("+ +r + "," + +g + "," + +b + ")";
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

  //return "rgba(" + +r + "," + +g + "," + +b + "," + a + ")";
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

  if (delta == 0)
    h = 0;
  else if (cmax == r)
    h = ((g - b) / delta) % 6;
  else if (cmax == g)
    h = (b - r) / delta + 2;
  else
    h = (r - g) / delta + 4;

  h = Math.round(h * 60);

  if (h < 0)
    h += 360;

  l = (cmax + cmin) / 2;
  s = delta == 0 ? 0 : delta / (1 - Math.abs(2 * l - 1));
  s = +(s * 100).toFixed(1);
  l = +(l * 100).toFixed(1);

  //return "hsl(" + h + "," + s + "%," + l + "%)";
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

  if (0 <= h && h < 60) {
    r = c; g = x; b = 0;
  } else if (60 <= h && h < 120) {
    r = x; g = c; b = 0;
  } else if (120 <= h && h < 180) {
    r = 0; g = c; b = x;
  } else if (180 <= h && h < 240) {
    r = 0; g = x; b = c;
  } else if (240 <= h && h < 300) {
    r = x; g = 0; b = c;
  } else if (300 <= h && h < 360) {
    r = c; g = 0; b = x;
  }
  // Having obtained RGB, convert channels to hex
  r = Math.round((r + m) * 255).toString(16);
  g = Math.round((g + m) * 255).toString(16);
  b = Math.round((b + m) * 255).toString(16);

  // Prepend 0s, if necessary
  if (r.length == 1)
    r = "0" + r;
  if (g.length == 1)
    g = "0" + g;
  if (b.length == 1)
    b = "0" + b;

  return "#" + r + g + b;
}