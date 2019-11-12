window.addEventListener('load', function() {
	var input = document.getElementById('fileInput');
	var canvas = document.getElementById('canvas');
	var botona = document.getElementById('botona');
	var spinner = document.getElementById('spinner');
	var pub = document.getElementById('pub');
	var say = document.getElementById('say');
	var save = document.getElementById('save');
	var postsContainer = document.getElementById('postsContainer');

	input.addEventListener('change', function() {
		var errors = document.querySelectorAll(".errorMessage");
		errors.forEach(function (e) {
			e.style.display = "none";
		});
		botona.style.display = "none";
		say.style.display = "block";
		save.style.display = "block";
		if (this.files && this.files[0]) {
			var file = this.files[0];
			if (file.size >= 1) {
				var img = new Image();
				img.src = URL.createObjectURL(file);
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					pub.value = '';
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
						postsContainer.innerHTML = xhttp.responseText.replace('All good\n', '')
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
				};
				xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				img.addEventListener('load', function() {
					var ctx = canvas.getContext('2d');
					canvas.width = img.width;
					canvas.height = img.height;
					ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
					var data = canvas.toDataURL();
					save.addEventListener('click', function() {
						say.style.display = 'none';
						pub.style.display = 'none';
						save.style.display = 'none';
						spinner.style.display = 'block';
						xhttp.send('picture='+data+'&publication='+pub.value);
					})
				})
				img.addEventListener('error', function() {
					say.style.display = 'none';
					pub.style.display = 'none';
					save.style.display = 'none';
					spinner.style.display = 'block';
					xhttp.send('picture=&publication=');
				})
			}
		}
	});

	say.addEventListener('click', function() {
		pub.style.display = 'block';
		say.style.display = 'none';
	})
});