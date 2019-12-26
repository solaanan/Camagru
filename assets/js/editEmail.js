window.addEventListener("load", function() {
	var botona = document.getElementById('botona');
	var form = document.getElementById('form');
	var body = document.getElementById('body');
	var save = document.getElementById('save');
	var spinner = document.getElementById('spinner');
	botona.onclick = function ( e ) {
		e.preventDefault();
		var errors = document.querySelectorAll(".errorMessage");
		errors.forEach(function (e) {
			e.remove();
		});
		var email1 = document.getElementById('email1');
		var email2 = document.getElementById('email2');
		email1.style.border = "0";
		email1.style.borderBottom = "1px solid";
		email2.style.border = "0";
		email2.style.borderBottom = "1px solid";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				save.style.display = "block";
				spinner.style.display = "none";
				botona.disabled = false;
				if (xhttp.responseText === "All good")
				{
					div = document.createElement("div");
					div.setAttribute("class", "alert alert-success message popup");
					div.setAttribute("id", "message");
					div.innerHTML = "Your email address has been changed successfully, <span class='important'> please verify your new email address </span>";
					div.style.opacity = "100";
					document.getElementById('messages').appendChild(div);
					setTimeout(function () {
						div.remove();
					}, 5000);
					email1.value = '';
					email2.value = '';
				}
				else
				{
					email1.className += " shake";
					email2.className += " shake";
					setTimeout(function () {
						email1.className = "form-control form-control-lg inputt"
						email2.className = "form-control form-control-lg inputt"
					}, 1000);
					email1.style.border = "1px solid red";
					email2.style.border = "1px solid red";
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
		xhttp.send("editEmailButton=true&newEmail=" + email1.value+"&newEmail2=" + email2.value);
	}
})