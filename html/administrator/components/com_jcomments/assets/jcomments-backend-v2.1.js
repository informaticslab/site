if (!window.jcbackend) {

function JCommentsBackend()
{
	this.fadeTimer = null;

	this.$ = function(id) {if(!id){return null;}var o=document.getElementById(id);if(!o&&document.all){o=document.all[id];}return o;};
	this.extend = function(o, e){for(var k in (e||{}))o[k]=e[k];return o;};

	this.fade = function(id,s,e,m) {
		var speed=Math.round(m/100),timer=0;
		if(s>e){
			for(i=s;i>=e;i--){setTimeout("jcbackend.setOpacity('"+id+"',"+i+")",(timer*speed));timer++;}
			var o=this.$(id);
			if(o){setTimeout(function(){o.style.display='none';},((s-e)*speed));}
		}
		else if(s<e){for(i=s;i<=e;i++){setTimeout("jcbackend.setOpacity('"+id+"',"+i+")",(timer*speed));timer++;}}
	};

	this.setOpacity = function(id,opacity){
		var e=this.$(id);
		if(e){var s=e.style;s.opacity=(opacity/100);s.MozOpacity=(opacity/100);s.KhtmlOpacity=(opacity / 100);s.filter="alpha(opacity="+opacity+")";}
	};

	this.createElement = function(t,i,c){
		var e=document.createElement(t);if(i){e.setAttribute('id',i);}if(c){e.className=c;}return e;
	};

	this.moveElement = function(e,p,b){
		if(e){if(p){if(e.parentNode){e.parentNode.removeChild(e);}if(b){p.insertBefore(e,b);}else{p.appendChild(e);}}}
	};

	this.showMessage = function(m,c,t) {
		clearTimeout(this.fadeTimer);
		var fe=this.$('jcomments-message');
		var af=this.$(t);
		if(fe){fe.parentNode.removeChild(fe);}
		fe=this.createElement('div','jcomments-message','');
		if(af){this.moveElement(fe,af,af.firstChild);}else{alert(m);return;}
		if(!c){c='info';}fe.className='jcomments-message-'+c;
		fe.innerHTML=m;	fe.style.display='block';jcbackend.setOpacity(fe.id,100);
		this.fadeTimer=setTimeout(function(){jcbackend.fade('jcomments-message', 100, 0, 1000);}, 3000);
	};

	this.base64_encode = function (input) {
		var a = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
		var o="",u="",i=0,chr1,chr2,chr3,enc1,enc2,enc3,enc4;
		input = input.replace(/\r\n/g,"\n");

		for (var n = 0; n < input.length; n++) {
			var c = input.charCodeAt(n);
			if (c < 128) {
				u += String.fromCharCode(c);
			} else if((c > 127) && (c < 2048)) {
				u += String.fromCharCode((c >> 6) | 192);
				u += String.fromCharCode((c & 63) | 128);
			} else {
				u += String.fromCharCode((c >> 12) | 224);
				u += String.fromCharCode(((c >> 6) & 63) | 128);
				u += String.fromCharCode((c & 63) | 128);
			}
        	}
		while (i < u.length) {
			chr1 = u.charCodeAt(i++);
			chr2 = u.charCodeAt(i++);
			chr3 = u.charCodeAt(i++);
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
			if(isNaN(chr2)){enc3=enc4=64;}else if(isNaN(chr3)){enc4=64;}
			o = o + a.charAt(enc1) + a.charAt(enc2) + a.charAt(enc3) + a.charAt(enc4);
		}
		return o;
	};
}

	var jcbackend = new JCommentsBackend();
}
