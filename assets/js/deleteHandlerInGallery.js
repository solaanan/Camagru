window.addEventListener('load', function() {
	var xhttp = new XMLHttpRequest();
	var body = document.getElementById('body');
	var postsContainer = document.getElementById('postsContainer');
	var alertContainer = document.getElementById('alert-container');
	var alertDelete = document.getElementById('delete');
	var alertCancel = document.getElementById('cancel');
	var body = document.getElementById('body');
	var postsContainer = document.getElementById('postsContainer');
	var post_id;

	onclick = function(e) {
		if (e.target.className === 'delete float-right my-auto') {
		body.style.overflow = 'hidden';
		alertContainer.style.visibility = 'visible';
		alertContainer.style.opacity = '1';
		post_id = e.target.parentNode.id.replace('post_', '');
		} else if (e.target === alertCancel || e.target.id === 'alert-container' || e.target.id === 'alert-body') {
			alertContainer.style.opacity = '0';
			setTimeout(function () {
				alertContainer.style.visibility = 'hidden';
			}, 500);
			body.style.overflow = 'unset';
		} else if (e.target === alertDelete) {
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (xhttp.responseText) {
						var div = document.createElement("div");
						div.setAttribute("class", "alert alert-success message");
						div.setAttribute("id", "message");
						div.innerHTML = "Deleted !";
						body.insertBefore(div, body.children[2]);
						setTimeout(function () {
							div.remove();
						}, 5000);
						postsContainer.innerHTML = xhttp.responseText;
						body.style.overflow = 'unset';
					}
				}
			}
			xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('delete=true&post_id='+post_id);
			alertContainer.style.opacity = '0';
			setTimeout(function () {
				alertContainer.style.visibility = 'hidden';
			}, 500)
		}
	}
});