window.addEventListener('load', function() {
	var xhttp = new XMLHttpRequest();
	var post = document.querySelectorAll('.post')

	document.querySelectorAll('.like').forEach(function(d) {
		d.onclick = function(e) {
			var post_id = e.target.parentNode.id.replace('post_', '');
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (xhttp.responseText === 'All good') {
						if (e.target.src.split('/')[e.target.src.split('/').length - 1] === 'like-0.png') {
							e.target.src = '/camagru/assets/images/like-1.png';
							if (e.target.nextSibling.innerHTML === '')
								e.target.nextSibling.innerHTML = '0';
							e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) + 1).toString();
						} else {
							e.target.src = '/camagru/assets/images/like-0.png';
							if (e.target.nextSibling.innerHTML === '')
								e.target.nextSibling.innerHTML = '0';
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
		}

		post.forEach(function(d) {
			var del = document.getElementById('delete_'+d.id.replace('post_', ''));
			d.onmouseover = function () {
				if (del)
					del.style.display = 'block';
			}
			d.onmouseout = function () {
				if (del)
					del.style.display = 'none';
			}
		})
	});

	document.querySelectorAll('.postImg').forEach(function(d) {
		d.ondblclick = function(e) {
			var post_id = d.parentNode.id.replace('post_', '');
			var heartContainer = document.getElementById('heart_'+post_id);
			var like = document.getElementById('like_'+post_id);
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (xhttp.responseText === 'All good') {
						if (like.src.split('/')[like.src.split('/').length - 1] === 'like-0.png') {
							like.src = '/camagru/assets/images/like-1.png';
							if (like.nextSibling.innerHTML === '')
								like.nextSibling.innerHTML = '0';
							like.nextSibling.innerHTML = (parseInt(like.nextSibling.innerHTML) + 1).toString();
							like.className += ' heartbeat';
							setTimeout(function () {
								like.className = 'like';
							}, 500);
						} else {
							like.className += ' heartbeat';
							setTimeout(function () {
								like.className = 'like';
							}, 500);
						}
						var img = document.createElement('img');
						img.src = '/camagru/assets/images/heart.png'
						img.style.height = d.height / 2 + 'px';
						img.style.width = d.height / 2 + 'px';
						img.style.position = 'absolute';
						img.style.margin = 'auto';
						img.style.top = d.height / 2 - img.style.height.replace('px' , '') / 2 + 'px';
						img.style.left = d.width / 2 - img.style.width.replace('px', '') / 2 + 'px';
						heartContainer.appendChild(img);
						img.className = "heartbeat";
						setTimeout(function () {
							img.remove();
						}, 500);
					}
				}
			}
			xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('hitLike='+post_id);
		}
	})
});