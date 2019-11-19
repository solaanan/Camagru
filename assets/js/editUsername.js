window.addEventListener("load", function() {
	var botona = document.getElementById('botona');
	var userLoggedIn = document.getElementById('userLoggedIn');
	var form = document.getElementById('form');
	var body = document.getElementById('body');
	var save = document.getElementById('save');
	var spinner = document.getElementById('spinner');
	botona.onclick = function ( e ) {
		e.preventDefault();
		var errors = document.querySelectorAll(".errorMessage");
		errors.forEach(function (e) {
			e.style.display = "none";
		});
		var username = document.getElementById('username');
		username.style.border = "0";
		username.style.borderBottom = "1px solid";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				save.style.display = "block";
				spinner.style.display = "none";
				botona.disabled = false;
				if (xhttp.responseText === "All good")
				{
					userLoggedIn.innerHTML = username.value;
					div = document.createElement("div");
					div.setAttribute("class", "alert alert-success message");
					div.setAttribute("id", "message");
					div.innerHTML = "Your username has been changed successfully";
					body.insertBefore(div, body.children[2]);
					setTimeout(function () {
						div.remove();
					}, 5000);
				}
				else
				{
					username.className += " shake";
					setTimeout(function () {
						username.className = "form-control form-control-lg inputt"
					}, 1000);
					username.style.border = "1px solid red";
					var array = xhttp.responseText.split('\n');
					array.forEach(function(e) {
						if (e !== "") {
						var div = document.createElement("div");
						div.setAttribute("class", "alert errorMessage");
						div.innerHTML = e;
						form.insertBefore(div, form.firstChild);
					}
					});
				}
			}
			else
			{
				save.style.display = "none";
				spinner.style.display = "block";
				botona.disabled = true;
			}
		};
		xhttp.open("POST", "/camagru/includes/handlers/edit-handler.php", true);
		xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhttp.send("editUsernameButton=true&newUsername=" + username.value );
	}
})