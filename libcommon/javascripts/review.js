function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    } 
}
var http_request = false;
function makePOSTRequest(url, parameters) {
   http_request = false;
   if (window.XMLHttpRequest) { // Mozilla, Safari,...
      http_request = new XMLHttpRequest();
      if (http_request.overrideMimeType) {
      	// set type accordingly to anticipated content type
         //http_request.overrideMimeType('text/xml');
         http_request.overrideMimeType('text/html');
      }
   } else if (window.ActiveXObject) { // IE
      try {
         http_request = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
         try {
            http_request = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (e) {}
      }
   }
   if (!http_request) {
      alert('Cannot create XMLHTTP instance');
      return false;
   }
   
   http_request.onreadystatechange = alertContents;
   http_request.open('POST', url, true);
   http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http_request.setRequestHeader("Content-length", parameters.length);
   http_request.setRequestHeader("Connection", "close");
   http_request.send(parameters);
}

function alertContents() {
   if (http_request.readyState == 4) {
      if (http_request.status == 200) {
         //alert(http_request.responseText);
         result = http_request.responseText;
         document.getElementById('myspan').innerHTML = result;            
      } else {
         alert('There was a problem with the request.');
      }
   }
}

function submit_review(obj, id, url) {
   var poststr = "review=" + encodeURI( document.getElementById("review").value ); 
   makePOSTRequest( url+'?id='+id, poststr);
}

function delete_review( reviewid, url){

	var ajaxRequest; // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
			ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
			// Something went wrong
			alert("Your browser broke!");
			return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
			var ajaxDisplay = document.getElementById('myspan');
			ajaxDisplay.innerHTML = ajaxRequest.responseText;
		}
	}
	var word = document.getElementById('docid').value;
	var queryString = "?delete=" + reviewid + "&id=" + word;
	ajaxRequest.open("GET", url + queryString, true);
	ajaxRequest.send(null);
	//alert(queryString);
}

