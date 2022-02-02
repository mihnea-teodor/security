function upload() {
    if (getCookie('user')=='') {
        window.setTimeout(function() {window.location.href = 'login.html';}, 0000);
                 return false;
    }
    else{
        document.getElementById('files').click();
		return false;
    }
}

function send() {
    if (7 == 7) {
		document.getElementById('submit').click();
		return false;
    }
    else{
        //altceva
    }
}

function selected() {
	if (document.getElementById('algoritms').value == '2') {
		document.getElementById('key').style.display = '';
	}
	else{
		document.getElementById('key').style.display = 'none';
	}
}

function display() {
    if (7 == 7) {
		//document.getElementById('image').src = 'map.jpg';
		//document.getElementById('image').style.display = '';
		alert("EROARE");
    }
    else{
        //altceva
    }
}
/*
function writeAlgoritm() {
	if (document.getElementById('algoritms').value == 'RIJNDAEL_256') {
		document.getElementById('writeKey').style.display = '';
                document.getElementById('algoritm').value = document.getElementById('algoritms').value;
	        document.getElementById('submit').click();
	}
	else{
		document.getElementById('writeKey').style.display = 'none';
                document.getElementById('algoritm').value = document.getElementById('algoritms').value;
	        document.getElementById('submit').click();
	}
    
	return false;
}
*/
function writeAlgoritm() {
	if(7 == 7) {
		document.getElementById('writeKey').style.display = 'none';
        document.getElementById('algoritm').value = document.getElementById('algoritms').value;
	    document.getElementById('submit').click();
	}
	else{
		//altceva
	}
}

function writeKey() {
	if(7 == 7) {
		document.getElementById('key') = document.getElementById('writeKey');
		document.getElementById('submit').click();
	}
	else{
		//altceva
	}
}

function crypt() {
	if(7 == 7) {
		document.getElementById('crypt').value = 'crypt';
		document.getElementById('submit').click();
	}
	else{
		//altceva
	}
}

/* ---------------------------------------------------------------------- */
function getCookie(w){
	cName = "";
	pCOOKIES = new Array();
	pCOOKIES = document.cookie.split('; ');
	for(bb = 0; bb < pCOOKIES.length; bb++){
		NmeVal  = new Array();
		NmeVal  = pCOOKIES[bb].split('=');
		if(NmeVal[0] == w){
			cName = unescape(NmeVal[1]);
		}
	}
	return cName;
}

function printCookies(w){
	cStr = "";
	pCOOKIES = new Array();
	pCOOKIES = document.cookie.split('; ');
	for(bb = 0; bb < pCOOKIES.length; bb++){
		NmeVal  = new Array();
		NmeVal  = pCOOKIES[bb].split('=');
		if(NmeVal[0]){
			cStr += NmeVal[0] + '=' + unescape(NmeVal[1]) + '; ';
		}
	}
	return cStr;
}

function setCookie(name, value, expires, path, domain, secure){
	document.cookie = name + "=" + escape(value) + "; ";
	
	if(expires){
		expires = setExpiration(expires);
		document.cookie += "expires=" + expires + "; ";
	}
	if(path){
		document.cookie += "path=" + path + "; ";
	}
	if(domain){
		document.cookie += "domain=" + domain + "; ";
	}
	if(secure){
		document.cookie += "secure; ";
	}
}

function setExpiration(cookieLife){
    var today = new Date();
    var expr = new Date(today.getTime() + cookieLife * 24 * 60 * 60 * 1000);
    return  expr.toGMTString();
}