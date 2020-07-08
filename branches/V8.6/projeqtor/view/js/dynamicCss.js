
function setColorTheming(ref) {
  console.log("change to theme "+ref);
  var white='#ffffff';
  var black='#000000';
  if (!ref) ref='#656565'; // dark grey
  var dark='#656565';
  var medium='#b5b5b5';
  var light='#d8d8d8';
  var lighter='#f0f0f0';
  
  //ref='#66ffcc';// Pour Test
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
  dark=HSLToHex(h,s,40);
  medium=HSLToHex(h,s,70);
  light=HSLToHex(h,s,90);
  lighter=HSLToHex(h,s,95);
  
  var element=document.getElementById('body');
  // Generic colors
  element.style.setProperty("--color-dark", dark);
  element.style.setProperty("--color-medium", medium);
  element.style.setProperty("--color-light", light);
  element.style.setProperty("--color-lighter", lighter);
  // Main Layout
  element.style.setProperty("--color-toolbar",ref);
  // List
  element.style.setProperty("--color-list-header", medium);
  // Detail
  element.style.setProperty("--color-detail-header", white);
  element.style.setProperty("--color-detail-header-text", dark);
  element.style.setProperty("--color-detail-header-border", medium);
  element.style.setProperty("--color-section-title-text", dark);
  element.style.setProperty("--color-section-title-border", dark);
  element.style.setProperty("--color-table-header", light);
  // Tools (buttons, ...)
  element.style.setProperty("--color-button-background", lighter);
  
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