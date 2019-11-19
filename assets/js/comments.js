window.addEventListener('load', function() {
	var commentToggle = document.querySelectorAll('.comment');
	var comment = document.querySelectorAll('.commentt');
	var comantir = document.querySelectorAll('.comantir');
	var inpot = document.querySelectorAll('.inpot');
	var showStatus = 0;
	var xhttp = new XMLHttpRequest();

	commentHandler();
	comantir.forEach(function(d) {
		var post_id = d.id.replace('newCommentButton_', '');
		var comment = document.getElementById('newComment_'+post_id);
		var commentContainer = document.getElementById('commentsContainer_'+post_id);
		var commentCounter = document.getElementById('commentsCounter_'+post_id);
		d.onclick = function(e) {
			e.preventDefault();
			var commentText = comment.value;
			xhttp.open('POST', '/camagru/includes/handlers/comment-handler.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('newCommentButton=true&newComment='+commentText+'&post_id='+post_id);
			xhttp.onreadystatechange = function() {
				comment.value = '';
				if (this.readyState == 4 && this.status == 200) {
					if (xhttp.responseText !== 'nah') {
						var doc = new DOMParser().parseFromString(xhttp.responseText, "text/html");
						commentContainer.insertBefore(doc.childNodes[0].childNodes[1].childNodes[0], commentContainer.childNodes[2]);
						autoResize(comment);
						if (commentCounter.innerHTML === '')
						commentCounter.innerHTML = '1';
						else
						commentCounter.innerHTML = (parseInt(commentCounter.innerHTML) + 1).toString();
					}
				}
				commentHandler();
			}
		}
	});

	commentToggle.forEach(function (d) {
		var post_id = d.parentNode.id.replace('post_', '');
		var commentContainer = document.getElementById('commentsContainer_'+post_id);
		d.onmouseover = function () {
			d.src = '/camagru/assets/images/comment_1.png'
		}
		d.onmouseout = function () {
			if (commentContainer.style.display !== 'block')
				d.src = '/camagru/assets/images/comment_0.png'
		}
		d.onclick = function() {
			if (commentContainer.style.display === 'block') {
				d.src = '/camagru/assets/images/comment_0.png'
				commentContainer.style.display = 'none';
			} else {
				d.src = '/camagru/assets/images/comment_1.png'
				commentContainer.style.display = 'block';
			}
			var array = Array.prototype.slice.call(commentContainer.children);
			var i = 0;
			array.forEach(function(e) {
				if (e.id.match(/comment_.+/)) {
					if (i > 1)
						e.style.display = 'none';
					i++;
				}
			});
		}
	});

	inpot.forEach( function(d) {
		d.onkeydown = function(e) {
			autoResize(e.target)
		}
	})

	function commentHandler() {
		toggleDeleteComment();
		toggleShowMore();
		deleteComment();
}

	function autoResize(d) {
			setTimeout(function() {
				d.style.height = 'auto';
				d.style.height = d.scrollHeight + 'px';
			}, 0)
	}

	function toggleDeleteComment() {
		comment = document.querySelectorAll('.commentt');
		comment.forEach(function (d) {
			var id = d.id.replace('comment_', '');
			var delCom = document.getElementById('delCom_'+id);
			d.onmouseover = function () {
				if (delCom)
				delCom.style.display = 'block';
			}
			d.onmouseout = function () {
				if (delCom)
					delCom.style.display = 'none';
			}
		});
	}

	function toggleShowMore() {
		var showMore = document.querySelectorAll('.showMore');
		showMore.forEach(function(d) {
			var id = d.id.replace('show_', '');
			var commentContainer = document.getElementById('commentsContainer_'+id);
			var array = Array.prototype.slice.call(commentContainer.children);
			d.onclick = function () {
				var i = 0;
				if (showStatus === 0) {
					showStatus = 1;
					array.forEach(function (e) {
						if (e.id.match(/comment_.+/)) {
								e.style.display = 'flex';
						}
					})
					d.innerHTML = 'Show less';
				} else {
					showStatus = 0;
					array.forEach(function (e) {
						if (e.id.match(/comment_.+/)) {
							if (i > 1)
								e.style.display = 'none';
							i++;
						}
					})
					d.innerHTML = 'Show more';
				}
		}
		})
	}

	function deleteComment() {
		var delComm = document.querySelectorAll('.deleteComment');
		delComm.forEach(function (e) {
			e.onclick = function() {
				comId = e.id.replace('delCom_', '');
				postId = e.parentNode.parentNode.parentNode.id.replace('commentsContainer_', '');
				commentCounter = document.getElementById('commentsCounter_'+postId);
				xhttp.open('POST', '/camagru/includes/handlers/comment-handler.php', true);
				xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttp.send('deleteComment=true&postId='+postId+'&commentId='+comId);
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if (xhttp.responseText !== 'nah') {
							var commentToDelete = document.getElementById('comment_'+comId);
							commentToDelete.remove();
							if (commentCounter.innerHTML === '1')
								commentCounter.innerHTML = '';
							else if (commentCounter.innerHTML !== '' && commentCounter.innerHTML !== '0')
								commentCounter.innerHTML = (parseInt(commentCounter.innerHTML) - 1).toString();
						}
					}
				}
			}
		})
	}
});