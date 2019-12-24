window.addEventListener('load', function() {
	var botona = document.getElementById('deleteUserButton');
	var alertContainer = document.getElementById('alertDelete-container');
	var alertBody = document.getElementById('alertDelete-body');
	var deleteUser = document.getElementById('deleteUser');
	var cancel = document.getElementById('cancelDeleteUser');
	var xhttpDeleteUser = new XMLHttpRequest();

	if (botona) {
		botona.onclick = function() {
			alertContainer.style.visibility = 'visible';
			alertContainer.style.opacity = '1';
		}
		deleteUser.onclick = function() {
			xhttpDeleteUser.open('POST', '/camagru/includes/handlers/delete-handler.php', true);
			xhttpDeleteUser.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttpDeleteUser.send('deleteUser=true');
			xhttpDeleteUser.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (xhttpDeleteUser.responseText) {
						// document.location.replace('/camagru/index');
					}
				}
			}
		}
		cancel.onclick = function() {
			setTimeout(function () {
				alertContainer.style.visibility = 'hidden';
			}, 500);
			alertContainer.style.opacity = '0';
		}
		alertBody.onclick = function() {
			setTimeout(function () {
				alertContainer.style.visibility = 'hidden';
			}, 500);
			alertContainer.style.opacity = '0';
		}
	}
})