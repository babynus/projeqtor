/*
CryptoJS v3.1.2
code.google.com/p/crypto-js
(c) 2009-2013 by Jeff Mott. All rights reserved.
code.google.com/p/crypto-js/wiki/License
*/
(function(y){for(var p=CryptoJS,m=p.lib,z=m.WordArray,q=m.Hasher,s=p.x64.Word,m=p.algo,v=[],w=[],x=[],c=1,d=0,l=0;24>l;l++){v[c+5*d]=(l+1)*(l+2)/2%64;var r=(2*c+3*d)%5,c=d%5,d=r}for(c=0;5>c;c++)for(d=0;5>d;d++)w[c+5*d]=d+5*((2*c+3*d)%5);c=1;for(d=0;24>d;d++){for(var t=r=l=0;7>t;t++){if(c&1){var u=(1<<t)-1;32>u?r^=1<<u:l^=1<<u-32}c=c&128?c<<1^113:c<<1}x[d]=s.create(l,r)}for(var j=[],c=0;25>c;c++)j[c]=s.create();m=m.SHA3=q.extend({cfg:q.cfg.extend({outputLength:512}),_doReset:function(){for(var c=this._state=
[],n=0;25>n;n++)c[n]=new s.init;this.blockSize=(1600-2*this.cfg.outputLength)/32},_doProcessBlock:function(c,n){for(var h=this._state,d=this.blockSize/2,b=0;b<d;b++){var e=c[n+2*b],f=c[n+2*b+1],e=(e<<8|e>>>24)&16711935|(e<<24|e>>>8)&4278255360,f=(f<<8|f>>>24)&16711935|(f<<24|f>>>8)&4278255360,a=h[b];a.high^=f;a.low^=e}for(d=0;24>d;d++){for(b=0;5>b;b++){for(var k=e=0,g=0;5>g;g++)a=h[b+5*g],e^=a.high,k^=a.low;a=j[b];a.high=e;a.low=k}for(b=0;5>b;b++){a=j[(b+4)%5];e=j[(b+1)%5];f=e.high;g=e.low;e=a.high^
(f<<1|g>>>31);k=a.low^(g<<1|f>>>31);for(g=0;5>g;g++)a=h[b+5*g],a.high^=e,a.low^=k}for(f=1;25>f;f++)a=h[f],b=a.high,a=a.low,g=v[f],32>g?(e=b<<g|a>>>32-g,k=a<<g|b>>>32-g):(e=a<<g-32|b>>>64-g,k=b<<g-32|a>>>64-g),a=j[w[f]],a.high=e,a.low=k;a=j[0];b=h[0];a.high=b.high;a.low=b.low;for(b=0;5>b;b++)for(g=0;5>g;g++)f=b+5*g,a=h[f],e=j[f],f=j[(b+1)%5+5*g],k=j[(b+2)%5+5*g],a.high=e.high^~f.high&k.high,a.low=e.low^~f.low&k.low;a=h[0];b=x[d];a.high^=b.high;a.low^=b.low}},_doFinalize:function(){var c=this._data,
d=c.words,h=8*c.sigBytes,j=32*this.blockSize;d[h>>>5]|=1<<24-h%32;d[(y.ceil((h+1)/j)*j>>>5)-1]|=128;c.sigBytes=4*d.length;this._process();for(var c=this._state,d=this.cfg.outputLength/8,h=d/8,j=[],b=0;b<h;b++){var e=c[b],f=e.high,e=e.low,f=(f<<8|f>>>24)&16711935|(f<<24|f>>>8)&4278255360,e=(e<<8|e>>>24)&16711935|(e<<24|e>>>8)&4278255360;j.push(e);j.push(f)}return new z.init(j,d)},clone:function(){for(var c=q.clone.call(this),d=c._state=this._state.slice(0),h=0;25>h;h++)d[h]=d[h].clone();return c}});
p.SHA3=q._createHelper(m);p.HmacSHA3=q._createHmacHelper(m)})(Math);
