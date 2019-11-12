window.addEventListener('load', function() {
	var xhttp = new XMLHttpRequest();
	var alertContainer = document.getElementById('alert-container');
	var alertDelete = document.getElementById('delete');
	var alertCancel = document.getElementById('cancel');
	var body = document.getElementById('body');
	var postsContainer = document.getElementById('postsContainer');
	var post_id;

	addEventListener('click', function(e) {
		if (e.target.className === 'delete float-right my-auto') {
		alertContainer.style.display = 'block';
		body.style.overflow = 'hidden';
		post_id = e.target.parentNode.id.replace('post_', '');
		} else if (e.target === alertCancel) {
			alertContainer.style.display = 'none';
			body.style.overflow = 'unset';
		} else if (e.target === alertDelete) {
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (xhttp.responseText) {
						postsContainer.innerHTML = xhttp.responseText;
						body.style.overflow = 'unset';
					}
				}
			}
			xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('delete=true&post_id='+post_id);
			alertContainer.style.display = 'none';
		}
	})

	document.querySelectorAll('.like').forEach(function(d) {
		d.addEventListener('click', function(e) {
		var post_id = e.target.parentNode.id.replace('post_', '');
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttp.responseText === 'All good') {
					if (e.target.src.split('/')[e.target.src.split('/').length - 1] === 'like-0.png') {
						e.target.src = '/camagru/assets/images/like-1.png';
						e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) + 1).toString();
					} else {
						e.target.src = '/camagru/assets/images/like-0.png';
						e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) - 1).toString();
					}
					e.target.className += ' heartbeat';
					setTimeout(function () {
						e.target.className = 'like';
					}, 500);
				}
			}
		}
		xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
		xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhttp.send('hitLike='+post_id);
	})
});
});