window.addEventListener('load', function() {
	var input = document.getElementById("newPicture");
	var canvas = document.getElementById("canvas");
	var pdp = document.getElementById("pdp");
	var pdp2 = document.getElementById("imgNavbar");
	var spinner = document.getElementById("spinner");
	var data = "";

	input.addEventListener("change", function() {
		var errors = document.querySelectorAll(".errorMessage");
		errors.forEach(function (e) {
			e.style.display = "none";
		});
		spinner.style.display = "block";
		if (this.files && this.files[0]) {
			var file = this.files[0];
			var size = file.size;
			var img = new Image();
			if (size >= 1) {
				img.src = URL.createObjectURL(file);
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					spinner.style.display = "none";
					if (this.readyState == 4 && this.status == 200) {
						if (xhttp.responseText === "All good") {
							var ratio = canvas.width / canvas.height;
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
				xhttp.open("POST", "/camagru/includes/handlers/edit-handler.php", true);
				xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				img.addEventListener("load", function() {
					var context = canvas.getContext("2d");
					canvas.width = img.width;
					canvas.height = img.height;
					context.drawImage(img, 0, 0, canvas.width, canvas.height);
					data = canvas.toDataURL();
					xhttp.send("newPicture="+data);
				});
				img.addEventListener("error", function() {
					xhttp.send("newPicture=imageError");
				})
			}
		}
	});
});