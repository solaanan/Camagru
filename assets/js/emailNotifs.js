window.addEventListener('load', function(){
	var switcha = document.getElementById('switcha');
	var xhttp = new XMLHttpRequest();

	switcha.onclick = function() {
		xhttp.open('POST', '/camagru/includes/handlers/notif-handler.php', true);
		xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhttp.send('notif=on');
	}
})