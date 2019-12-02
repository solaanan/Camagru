window.addEventListener('load', function() {
	var body = document.getElementById('body');
	var input = document.getElementById('resetEmail');
	var input1 = document.getElementById('newPassword1');
	var input2 = document.getElementById('newPassword2');
	var emailButton = document.getElementById('emailButton');
	var newPasswordButton = document.getElementById('newPasswordButton');
	var form = document.getElementById('form');
	var success = document.getElementById('success');
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
		document.querySelectorAll('.errorMessage').forEach(function(d) {
			d.remove();
		})
		newPasswordButton.disabled = true;
		input1.style.border = "0px";
		input2.style.border = "0px";
		input1.style.borderBottom = "1px solid";
		input2.style.borderBottom = "1px solid";
		var username = document.getElementById('username').innerHTML;
		if (input1.value !== '' && input2.value !== '') {
			xhttp.open('POST', '/camagru/includes/handlers/reset-handler.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('resetPasswordButton=true&password1='+input1.value+'&password2='+input2.value+'&username='+username);
		}
	}
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (xhttp.responseText === 'All good') {
				form.style.display = 'none';
				success.style.display = 'block';
			} else {
				newPasswordButton.disabled = false;
				input1.className += " shake";
				input2.className += " shake";
				input1.style.border = "1px solid red";
				input2.style.border = "1px solid red";
				setTimeout(function () {
					input1.className = "form-control form-control-lg inputt"
					input2.className = "form-control form-control-lg inputt"
				}, 1000);
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
	}
});