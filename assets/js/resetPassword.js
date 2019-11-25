window.addEventListener('load', function() {
	var body = document.getElementById('body');
	var input = document.getElementById('resetEmail');
	var input1 = document.getElementById('newPassword1');
	var input2 = document.getElementById('newPassword2');
	var emailButton = document.getElementById('emailButton');
	var newPasswordButton = document.getElementById('newPasswordButton');
	var xhttp = new XMLHttpRequest();

	if (emailButton)
	emailButton.onclick = function(e) {
		document.querySelectorAll('.errorMessage').forEach(function(d) {
			d.remove();
		})
		e.preventDefault();
		input.style.border = "0";
		input.style.borderBottom = "1px solid";
		if (input.value !== '') {
			emailButton.disabled = true;
			xhttp.open('POST', '/camagru/includes/handlers/reset-handler.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('resetEmailButton=true&email='+ input.value);
		} else {
			input.className += " shake";
			input.style.border = "1px solid red";
			var div = document.createElement("div");
			div.setAttribute("class", "alert errorMessage");
			div.innerHTML = 'The email address cannot be empty! obviously.';
			form.insertBefore(div, form.firstChild);
		}
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText === 'All good') {
					input.value = '';
					emailButton.disabled = false;
					var div = document.createElement("div");
					div.setAttribute("class", "alert alert-success message");
					div.setAttribute("id", "message");
					div.innerHTML = "Password reset link has been sent successfully, <span class='important'> please check your inbox</span>";
					div.style.opacity = "100";
					body.insertBefore(div, body.children[2]);
					setTimeout(function () {
						div.remove();
					}, 5000);
				} else {
					alert(xhttp.responseText);
					emailButton.disabled = false;
					input.className += " shake";
					input.style.border = "1px solid red";
					setTimeout(function () {
						input.className = "form-control form-control-lg inputt"
					}, 1000);
					var div = document.createElement("div");
					div.setAttribute("class", "alert errorMessage");
					div.innerHTML = 'We could\'nt find any account associated to this email address.';
					form.insertBefore(div, form.firstChild);
				}
			}
		}
	}

	if (newPasswordButton)
	newPasswordButton.onclick = function(e) {
		e.preventDefault();
		if (input1.value !== '' && input2.value !== '') {
			xhttp.open('POST', '/camagru/includes/handlers/reset-handler.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('resetPasswordButton=true&password1='+input1.value+'&password2='+input2.value);
		}
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			alert(xhttp.responseText);
		}
	}
});