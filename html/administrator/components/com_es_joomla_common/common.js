function getCenteredParameters(w, h) {
	var winLeft = getCenteredLeft(w);
	var winTop = getCenteredTop(h);

	if (isIE()) {
		str = "left=" + winLeft + ", top=" + winTop + ", ";
	} else {
		str = "screenX=" + winLeft + ", screenY=" + winTop + ", ";
	}
	return str;
}
function getCenteredLeft(width) {
	var winLeft = screen.availWidth / 2 - width / 2;
	return winLeft;
}
function getCenteredTop(height) {
	var winTop = screen.availHeight / 2 - height / 2;
	return winTop;
}

function openFile(url, windowName, width, height, hasFocus) {
	if (width < 1) width = screen.availWidth * Number(width);
	if (height < 1) height = screen.availHeight * height;
	var w = window.open(url, windowName, getCenteredParameters(width, height) + "width=" + width + ", height=" + height + ", scrollbars=yes, toolbar=no, titlebar=yes, resizable=yes");
	if (hasFocus == true) w.focus();
	return w;
}

function openFileInFrame(url, inFrame, title) {
	parent.frames[inFrame].location.href = url;
}

function replaceAll(originalString, searchString, replaceString) {
	var ind = -1
	do {
		ind = originalString.indexOf(searchString);
		originalString = originalString.replace(searchString, replaceString);
		ind = originalString.indexOf(searchString, ind + replaceString.length);
	} while(ind > 0);
	return originalString;
}

function attachEventCB(el, evname, func) {
	if (isIE()) {
		el.attachEvent("on" + evname, func);
	} else {
		el.addEventListener(evname, func, true);
	}
};

function removeEventCB(el, evname, func) {
	if (isIE()) {
		el.detachEvent("on" + evname, func);
	} else {
		el.removeEventListener(evname, func, true);
	}
};

function isIE() {
	var isIE = ((navigator.userAgent.toLowerCase().indexOf("msie") != -1) && (navigator.userAgent.toLowerCase().indexOf("opera") == -1));
	return isIE;
}

function telNumberPressed() {
	key = event.keyCode;
	if ((key >= 48 && key <= 57) || key == 40 || key == 41 || key == 43 || key == 32) {
		
	} else {
		event.returnValue = false;
	}
}
function numberPressed() {
	key = event.keyCode;
	if (key >= 48 && key <= 57) {
		
	} else {
		event.returnValue = false;
	}
}

function trim(s) {
  while (s.substring(0,1) == ' ') {
    s = s.substring(1,s.length);
  }
  while (s.substring(s.length-1,s.length) == ' ') {
    s = s.substring(0,s.length-1);
  }
  return s;
}

function clearForm(resetForm) {
	for (var i = 0; i < resetForm.elements.length; i++) {
		var elm = resetForm.elements[i];
		
		if (elm.type == "checkbox") {
			elm.checked = false;
		} else if (elm.type == "text" || elm.type == "textarea") {
			elm.value = "";
		} else if (elm.type == "select-one") {
			elm.selectedIndex = 0;
		} else if (elm.type == "select-multiple") {
			elm.selectedIndex = -1;
		} else if (elm.type == "radio") {
			elm.checked = 0;
		}
	}
}
	
	function enableDisableElement(elm, val) {
		elm.disabled = !val;
	}
	function enableDisableElementByID(elmID, val) {
		var elm = document.getElementById(elmID);
		enableDisableElement(elm, val);
		return elm;
	}
	function showHideElement(elm, val) {
		if (val == true) {
			elm.style.display = 'block';
		} else {
			elm.style.display = 'none';
		}
	}
	function showHideElementByID(elmID, val) {
		var elm = document.getElementById(elmID);
		showHideElement(elm, val);
		return elm;
	}
	
	function setHTMLSelectValue(elm, value) {
		for (var j = 0; j < elm.options.length; j++) {
			if (elm.options[j].value == value) {
				elm.selectedIndex = j;
				break;
	   		}
	   	}
	}
	function getRadioCheckedValue(oRadio) {
		if (oRadio.length) {
			for(var i = 0; i < oRadio.length; i++) {
				if(oRadio[i].checked) {
					return oRadio[i].value;
				}
			}
		} else {
			return oRadio.checked ? oRadio.value : '';
		}
		
		return '';
	}
	function setRadioCheckedValue(radioObj, newValue) {
		if(!radioObj)
			return;
		var radioLength = radioObj.length;
		if(radioLength == undefined) {
			radioObj.checked = (radioObj.value == newValue.toString());
			return;
		}
		for(var i = 0; i < radioLength; i++) {
			radioObj[i].checked = false;
			if(radioObj[i].value == newValue.toString()) {
				radioObj[i].checked = true;
			}
		}
	}

function createXMLHttpRequest() {
    if (typeof XMLHttpRequest != "undefined") {
        return new XMLHttpRequest();
    } else if (typeof ActiveXObject != "undefined") {
        return new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        throw new Error("XMLHttpRequest not supported");
    }
}

//Clipboard
	function sendtoclipboard(s,el)	{
		if(window.clipboardData && clipboardData.setData) {
			clipboardData.setData("text", s);
			return true;
		} else {
			//ffcopy(el); //ne raboti - triabva niakakvo tupo Flash-4e
		}
		return false;
	}
	function ffcopy(inElement) {
	  if (inElement.createTextRange) {
		var range = inElement.createTextRange();
		if (range && BodyLoaded==1)
		  range.execCommand('Copy');
	  } else {
		var flashcopier = 'flashcopier';
		if(!document.getElementById(flashcopier)) {
		  var divholder = document.createElement('div');
		  divholder.id = flashcopier;
		  document.body.appendChild(divholder);
		}
		document.getElementById(flashcopier).innerHTML = '';
		var divinfo = '&lt;embed src="_clipboard.swf" FlashVars="clipboard='+encodeURIComponent(inElement.value)+'" width="0" height="0" type="application/x-shockwave-flash"&gt;&lt;/embed&gt;';
		document.getElementById(flashcopier).innerHTML = divinfo;
	  }
	}
////Clipboard



	function getFormValuesAsQueryString(form_name, rq_prefix) {
		var form = document.forms[form_name];
		if (!form) return '';
		var delimiter = '&';
		var result = '';
		for (var i = 0; i < form.elements.length; i++) {
			var elm = form.elements[i];
			var val = null;
			if (!elm.name) continue;
			if (rq_prefix != null && elm.name.indexOf(rq_prefix) != 0) continue;
//			alert(elm.type);
			if (elm.type == "button" || elm.type == "undefined") {
		    	continue;
			} else if (elm.type == "checkbox" || elm.type == "radio") {
		    	if(elm.checked) {
		    		val = elm.name+"[]="+escapeStringForURL(elm.value);
		    	}
			} else if (elm.type == "select-one") {
		    	val = elm.name+"="+escapeStringForURL(elm.options[elm.selectedIndex].value);
			} else if (elm.type == "select-multiple") {
				for (var j = 0; j < elm.options.length; j++) {
					if (elm.options[j].selected) {
						if (val != '') val += delimiter;
			    		val += elm.name+"[]="+escapeStringForURL(elm.options[j].value);
		    		}
		    	}
			} else {
				val = elm.name+"="+escapeStringForURL(elm.value);
			}
			
			if (val != null) {
				if (result != '') result += delimiter;
				result += val;
			}
			
		}
				
//alert(result);

		return result;
	}
	function escapeStringForURL(str) {
		return encodeURIComponent(str);
	}



