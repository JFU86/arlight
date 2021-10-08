/*
	AdRotator Light
	by Scripthosting.net

	Licensed under the "GPL Version 3, 29 June 2007"
	http://www.gnu.org/licenses/gpl.html
	
	Support-Forum: http://board.scripthosting.net/viewforum.php?f=28
	Don't send emails asking for support!!
*/


/**
 * AJAX Request mit MooTools absenden
 * @param String url / URL, die aufgerufen werden soll
 * @param String id / HTML Element
 * @param int periodical / Optional: Falls der Aufruf periodisch wiederholt werden soll
 * @param Boolean refresh / Wird die Seite bei Erfolg nachgeladen?
 * @return
 */
function mooRequest(url, id, periodical, refresh) {
	
	var request = new Request({
		url: url,
		async: true,
		method: 'get',
		update: 'refresh-me',
		evalScripts: false,
		evalResponse: false,
		onComplete: function(response) {
			if (id != null && id != "dummy") { 
				$(id).innerHTML = response;
			}
			if (response != "" && response != null && response != "undefined") {
				window.response = response;
			}			
			if (refresh == true) { document.location.href='./'; }
		}
	});

	// request absenden und maximal drei Versuche tätigen
	var i=0;
	do {
		request.cancel();
		request.send();
		i++;
	} while (window.response == null && id != "dummy" && i < 3);
	
	// Optional: Wiederhole die Anforderung in diesem Zeitabstand
	if (periodical != null && parseInt(periodical) != 0) {
		var doMany = function() {
			request.cancel();
			request.send();
		};		
		doMany.periodical(periodical);
	}
	
	return request;
}


/**
 * Change the status of the banner with the given id to active or inactive
 * @param int id
 * @returns {Boolean}
 */
function status(id) {
	
	if (!isNaN(id)) {
		var ok = window.confirm("{%@Soll der Status dieses Banners wirklich geändert werden?}");
		
		if (ok == true) {
			document.location.href='?action=bannerliste&noheader=true&status=true&id='+id;
			return true;
		}
		else return false;
	}
}


/**
 * Drop the banner with the given id
 * @param int id
 * @returns {Boolean}
 */
function drop(id) {
	
	var ok = window.confirm("{%@Soll der Banner wirklich unwiderruflich gelöscht werden?}");
	
	if (ok == true) {
		document.location.href='?action=bannerliste&noheader=true&drop=true&id='+id;
		return true;
	}
	else return false;
}


/**
 * Drops a format with the given id
 * @param int id
 * @returns {Boolean}
 */
function dropFormat(id) {
	
	if (id != 1) {	
		var ok = window.confirm("{%@Soll das Format und alle enthaltenen Banner wirklich unwiderruflich gelöscht werden?}");
		
		if (ok == true) {
			document.location.href='?action=neuesformat&noheader=true&drop=true&id='+id;
			return true;
		}
		else return false;
	}
	else{
		window.alert("{%@Das Standardformat darf nicht gelöscht werden!}");
		return false;
	}
}


/**
 * Ändert die Hintergrundfarbe eines Menüelements
 * @param navId id des Elements
 * @return void
 **/
function highlightNav(navId) {	
	document.getElementById(navId).style.backgroundColor = '#FDE4C6';
}


function statusUser(id){
	if (parseInt(id) != 1) {
		var ok = window.confirm("{%@Soll der Benutzerstatus wirklich geändert werden?}");
		
		if (ok) {
			document.location.href='?action=usercontrol&noheader=true&status=true&id='+id;
			return true;
		}
		else return false;
	}
	else{
		window.alert("{%@Der Hauptbenutzer darf nicht deaktiviert werden!}");
		return false;
	}
}


function deleteUser(id){
	if (parseInt(id) != 1) {
		var ok = window.confirm("{%@Soll der Benutzer wirklich unwiderruflich gelöscht werden?}");
		
		if (ok) {
			document.location.href='?action=usercontrol&noheader=true&drop=true&id='+id;
			return true;
		}
		else return false;
	}
	else{
		window.alert("{%@Der Hauptbenutzer darf nicht gelöscht werden!}");
		return false;
	}
}