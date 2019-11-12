window.addEventListener("load", function() {
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var snap = document.getElementById('snap');
	var img = document.getElementById('img');
	var save = document.getElementById('save');
	var pub = document.getElementById('pub');
	var say = document.getElementById('say');
	var postsContainer = document.getElementById('postsContainer');
	var stream;

	snap.disabled = true;
	function initWebCam() {
		navigator.mediaDevices.getUserMedia({ audio:false, video: true}).then(function (mediaStream) {
			snap.disabled = false;
			video.srcObject = mediaStream;
			stream = mediaStream;
			video.onloadedmetadata = function(e) {
			video.play();
		};
		}).catch(function (err) {
			// console.log("Erreur: " + err);
		})
	}

	function retake_pic() {
		video.style.display = "block";
		snap.style.display = "block";
		img.style.display = "none";
		say.style.display = "none";
		pub.style.display = "none";
		save.style.display = "none";
		retake.style.display = "none"
		pub.value = "";
		save.disabled = false;
		initWebCam();
	}

	initWebCam();
	snap.addEventListener('click', function (e) {
		e.preventDefault();
		var context = canvas.getContext('2d');
		canvas.width = video.videoWidth;
		canvas.height = video.videoHeight;
		context.translate(canvas.width, 0);
		context.scale(-1, 1);
		context.drawImage(video, 0, 0, canvas.width, canvas.height);
		var data = canvas.toDataURL('image/png');
		stream.getTracks().forEach(function(track) {
			track.stop();
		});
		img.setAttribute("src", data);
		img.setAttribute("width", canvas.width);
		img.setAttribute("height", canvas.height);
		video.style.display = "none";
		snap.style.display = "none";
		img.style.display = "block";
		say.style.display = "block";
		save.style.display = "inline-block";
		retake.style.display = "inline-block";

		say.addEventListener("click", function() {
			if (pub.style.display !== "block")
				pub.style.display = "block";
			say.style.display = "none";
			if (pub.value > 1000 || pub.value < 1)
					save.disabled = true;
		});

		retake.addEventListener('click', retake_pic);

		pub.addEventListener("keyup", function(e) {
			e.preventDefault();
			save.disabled = (pub.value.length < 1000 && pub.value.length > 1) ? false : true;
		})

		var xhttp = new  XMLHttpRequest();
		save.addEventListener("click", function(e) {
			e.preventDefault();
			save.disabled = true;
		xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
		xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhttp.send('saveButton=true&publication='+ pub.value +'&pictureData='+data);
		});
		xhttp.onreadystatechange = function() {
			save.disabled = false;
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText.match(/All good/g)) {
					var div = document.createElement("div");
					div.setAttribute("class", "alert alert-success message");
					div.setAttribute("id", "message");
					div.innerHTML = "Posted !";
					body.insertBefore(div, body.children[2]);
					setTimeout(function () {
						div.remove();
					}, 5000);
					postsContainer.innerHTML = xhttp.responseText.replace('All good', '');
					retake_pic();
				}
			}
		}
	});
});