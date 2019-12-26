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
			e.style.display = "none";
		});
		var oldpw = document.getElementById('oldpw');
		var pw1 = document.getElementById('pw1');
		var pw2 = document.getElementById('pw2');
		oldpw.style.border = "0";
		oldpw.style.borderBottom = "1px solid";
		pw1.style.border = "0";
		pw1.style.borderBottom = "1px solid";
		pw2.style.border = "0";
		pw2.style.borderBottom = "1px solid";
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				save.style.display = "block";
				spinner.style.display = "none";
				botona.disabled = false;
				if (xhttp.responseText === "All good")
				{
					div = document.createElement("div");
					div.setAttribute("class", "alert alert-success message");
					div.setAttribute("id", "message");
					div.innerHTML = "Your password has been changed successfully";
					document.getElementById('messages').appendChild(div);
					setTimeout(function () {
						div.remove();
					}, 5000);
					oldpw.value = '';
					pw1.value = '';
					pw2.value = '';
				}
				else
				{
					botona.className += " shake";
					setTimeout(function () {
						botona.className = "btn btn-primary botona"
					}, 1000);
					oldpw.style.border = "1px solid red";
					pw1.style.border = "1px solid red";
					pw2.style.border = "1px solid red";
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
		xhttp.send("editPasswdButton=true&previousPasswd=" + oldpw.value + "&newPasswd=" + pw1.value + "&newPasswd2=" + pw2.value );
	}
})