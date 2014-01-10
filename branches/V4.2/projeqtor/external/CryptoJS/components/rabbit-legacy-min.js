/*
CryptoJS v3.1.2
code.google.com/p/crypto-js
(c) 2009-2013 by Jeff Mott. All rights reserved.
code.google.com/p/crypto-js/wiki/License
*/
(function(){function g(){for(var a=this._X,d=this._C,c=0;8>c;c++)f[c]=d[c];d[0]=d[0]+1295307597+this._b|0;d[1]=d[1]+3545052371+(d[0]>>>0<f[0]>>>0?1:0)|0;d[2]=d[2]+886263092+(d[1]>>>0<f[1]>>>0?1:0)|0;d[3]=d[3]+1295307597+(d[2]>>>0<f[2]>>>0?1:0)|0;d[4]=d[4]+3545052371+(d[3]>>>0<f[3]>>>0?1:0)|0;d[5]=d[5]+886263092+(d[4]>>>0<f[4]>>>0?1:0)|0;d[6]=d[6]+1295307597+(d[5]>>>0<f[5]>>>0?1:0)|0;d[7]=d[7]+3545052371+(d[6]>>>0<f[6]>>>0?1:0)|0;this._b=d[7]>>>0<f[7]>>>0?1:0;for(c=0;8>c;c++){var h=a[c]+d[c],e=h&65535,
g=h>>>16;b[c]=((e*e>>>17)+e*g>>>15)+g*g^((h&4294901760)*h|0)+((h&65535)*h|0)}a[0]=b[0]+(b[7]<<16|b[7]>>>16)+(b[6]<<16|b[6]>>>16)|0;a[1]=b[1]+(b[0]<<8|b[0]>>>24)+b[7]|0;a[2]=b[2]+(b[1]<<16|b[1]>>>16)+(b[0]<<16|b[0]>>>16)|0;a[3]=b[3]+(b[2]<<8|b[2]>>>24)+b[1]|0;a[4]=b[4]+(b[3]<<16|b[3]>>>16)+(b[2]<<16|b[2]>>>16)|0;a[5]=b[5]+(b[4]<<8|b[4]>>>24)+b[3]|0;a[6]=b[6]+(b[5]<<16|b[5]>>>16)+(b[4]<<16|b[4]>>>16)|0;a[7]=b[7]+(b[6]<<8|b[6]>>>24)+b[5]|0}var j=CryptoJS,k=j.lib.StreamCipher,e=[],f=[],b=[],l=j.algo.RabbitLegacy=
k.extend({_doReset:function(){for(var a=this._key.words,d=this.cfg.iv,c=this._X=[a[0],a[3]<<16|a[2]>>>16,a[1],a[0]<<16|a[3]>>>16,a[2],a[1]<<16|a[0]>>>16,a[3],a[2]<<16|a[1]>>>16],a=this._C=[a[2]<<16|a[2]>>>16,a[0]&4294901760|a[1]&65535,a[3]<<16|a[3]>>>16,a[1]&4294901760|a[2]&65535,a[0]<<16|a[0]>>>16,a[2]&4294901760|a[3]&65535,a[1]<<16|a[1]>>>16,a[3]&4294901760|a[0]&65535],b=this._b=0;4>b;b++)g.call(this);for(b=0;8>b;b++)a[b]^=c[b+4&7];if(d){var c=d.words,d=c[0],c=c[1],d=(d<<8|d>>>24)&16711935|(d<<
24|d>>>8)&4278255360,c=(c<<8|c>>>24)&16711935|(c<<24|c>>>8)&4278255360,b=d>>>16|c&4294901760,e=c<<16|d&65535;a[0]^=d;a[1]^=b;a[2]^=c;a[3]^=e;a[4]^=d;a[5]^=b;a[6]^=c;a[7]^=e;for(b=0;4>b;b++)g.call(this)}},_doProcessBlock:function(a,b){var c=this._X;g.call(this);e[0]=c[0]^c[5]>>>16^c[3]<<16;e[1]=c[2]^c[7]>>>16^c[5]<<16;e[2]=c[4]^c[1]>>>16^c[7]<<16;e[3]=c[6]^c[3]>>>16^c[1]<<16;for(c=0;4>c;c++)e[c]=(e[c]<<8|e[c]>>>24)&16711935|(e[c]<<24|e[c]>>>8)&4278255360,a[b+c]^=e[c]},blockSize:4,ivSize:2});j.RabbitLegacy=
k._createHelper(l)})();
