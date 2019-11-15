window.addEventListener('load', function() {
	var xhttp = new XMLHttpRequest();
	var input = document.getElementById('fileInput');
	var canvas = document.getElementById('canvas');
	var botona = document.getElementById('botona');
	var spinner = document.getElementById('spinner');
	var pub = document.getElementById('pub');
	var say = document.getElementById('say');
	var save = document.getElementById('save');
	var preview = document.getElementById('preview');

	input.onchange = function() {
		var errors = document.querySelectorAll(".errorMessage");
		errors.forEach(function (e) {
			e.style.display = "none";
		});
		if (this.files && this.files[0]) {
			var file = this.files[0];
			console.log(file.size);
			if (file.size >= 1 && file.size < 8000000){
				var img = new Image();
				img.src = URL.createObjectURL(file);
				img.onload = function() {
					botona.style.display = "none";
					say.style.display = "block";
					save.style.display = "block";
					var ctx = canvas.getContext('2d');
					canvas.width = img.width;
					canvas.height = img.height;
					ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
					var data = canvas.toDataURL();
					preview.src = data;
					preview.style.display = 'block';
					save.onclick = function(e) {
						e.preventDefault();
						say.style.display = 'none';
						pub.style.display = 'none';
						save.style.display = 'none';
						preview.style.display = 'none';
						spinner.style.display = 'block';
						xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
						xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						xhttp.send('loggedin=true&picture='+data+'&publication='+pub.value);
					}
				}
				img.onerror = function() {
					say.style.display = 'none';
					pub.style.display = 'none';
					save.style.display = 'none';
					spinner.style.display = 'block';
					xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
					xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhttp.send('picture=error&publication=error');
				}
			} else {
				xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttp.send('big=true');
			}
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (xhttp.responseText.match(/All good/g)) {
						spinner.style.display = 'none';
						pub.style.display = 'block';
						save.style.display = 'block';
						var div = document.createElement("div");
						div.setAttribute("class", "alert alert-success message");
						div.setAttribute("id", "message");
						div.innerHTML = "Posted !";
						body.insertBefore(div, body.children[2]);
						setTimeout(function () {
							div.remove();
						}, 5000);
						postsContainer.innerHTML = xhttp.responseText.replace('All good', '')
						botona.style.display = "table";
						say.style.display = "none";
						save.style.display = "none";
						pub.style.display = "none";
					} else {
						spinner.style.display = 'none';
						botona.style.display = 'table';
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
		}
	};

	say.onclick =  function() {
		pub.style.display = 'block';
		say.style.display = 'none';
	}
});