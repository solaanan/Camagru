window.addEventListener("load", function() {
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var snap = document.getElementById('snap');
	var img = document.getElementById('img');
	var save = document.getElementById('save');
	var stream;

	navigator.mediaDevices.getUserMedia({ audio:false, video: {width: 800, height: 800}}).then(function (mediaStream) {
		video.srcObject = mediaStream;
		stream = mediaStream;
		video.onloadedmetadata = function(e) {
		video.play();
	};
	}).catch(function (err) {
		console.log("Erreur: " + err);
	})

	snap.addEventListener('click', function (e) {
		e.preventDefault();
		var context = canvas.getContext('2d');
		canvas.width = 800;
		canvas.height = 800;
		context.translate(canvas.width, 0);
		context.scale(-1, 1);
		context.drawImage(video, 0, 0, 800, 800);
		var data = canvas.toDataURL('image/png');
		stream.getTracks().forEach(function(track) {
			track.stop();
		});
		img.setAttribute("src", data);
		video.style.display = "none";
		snap.style.display = "none";
		img.style.display = "block";
		save.style.display = "block";
		retake.style.display = "block";
		// var xhttp = new XMLHttpRequest();
		// var xhttp = new XMLHttpRequest();
		// xhttp.onreadystatechange = function() {
		// 	if (this.readyState == 4 && this.status == 200) {
		// 		if (xhttp.responseText === "All good") {
		// 			var div = document.createElement("div");
		// 			div.setAttribute("class", "alert alert-success message");
		// 			div.setAttribute("id", "message");
		// 			div.innerHTML = "Your Profile picture has been changed successfully";
		// 			body.insertBefore(div, body.children[2]);
		// 			setTimeout(function () {
		// 				div.remove();
		// 			}, 5000);
		// 		}
		// 	}
		// }
	});
});