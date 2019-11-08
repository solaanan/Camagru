window.addEventListener("load", function() {
	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var snap = document.getElementById('snap');

	navigator.mediaDevices.getUserMedia({ audio:false, video: {width: 640, height: 480}}).then(function (mediaStream) {
		video.srcObject = mediaStream
		video.onloadedmetadata = function(e) {
		video.play();
	};
	}).catch(function (err) {
		console.log("Erreur: " + err);
	})
});