window.addEventListener('load', function() {
	var xhttp = new XMLHttpRequest();
	var input = document.getElementById("newPicture");
	var canvas = document.getElementById("canvas");
	var pdp = document.getElementById("pdp");
	var pdp2 = document.getElementById("imgNavbar");
	var spinner = document.getElementById("spinner");
	var data = "";

	function clearData() {
		var context = canvas.getContext('2d');
		context.fillStyle = "#000";
		context.fillRect(0, 0, 1920, 1080);

		var data = canvas.toDataURL('image/png');
	}

	input.onchange = function() {
		var errors = document.querySelectorAll(".errorMessage");
		errors.forEach(function (e) {
			e.style.display = "none";
		});
		spinner.style.display = "block";
		if (this.files && this.files[0]) {
			var file = this.files[0];
			var size = file.size;
			var img = new Image();
			if (size >= 1 && size < 8000000) {
				img.src = URL.createObjectURL(file);
				img.onload = function() {
					clearData();
					var context = canvas.getContext("2d");
					canvas.width = img.width;
					context.drawImage(img, 0, 0, canvas.width, canvas.height);
					canvas.height = img.height;
					data = canvas.toDataURL();
					console.log(data);
					xhttp.open("POST", "/camagru/includes/handlers/edit-handler.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("newPicture="+data);
				};
				img.onerror = function() {
					xhttp.open("POST", "/camagru/includes/handlers/edit-handler.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("imageError=true");
				}
			} else {
				if (file.size <= 1) {
					xhttp.open("POST", "/camagru/includes/handlers/edit-handler.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("imageError=true");
				} else {
					xhttp.open("POST", "/camagru/includes/handlers/edit-handler.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("big=true");
				}
			}
			xhttp.onreadystatechange = function() {
				spinner.style.display = "none";
				if (this.readyState == 4 && this.status == 200) {
					if (xhttp.responseText === "All good") {
						pdp.setAttribute("src", data);
						pdp2.setAttribute("src", data);
						var div = document.createElement("div");
						div.setAttribute("class", "alert alert-success message");
						div.setAttribute("id", "message");
						div.innerHTML = "Your Profile picture has been changed successfully";
						body.insertBefore(div, body.children[2]);
						setTimeout(function () {
							div.remove();
						}, 5000);
					}
					else {
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
			};
		} else {
			spinner.style.display = 'none';
		}
	};
});