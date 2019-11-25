window.addEventListener('load', function() {
	var userLoggedIn = document.getElementById('userLoggedIn');
	/* ************************************************************* */
	/*                             CAMERA                            */
	/* ************************************************************* */
	var body = document.getElementById('body');
	var postsContainer = document.getElementById('postsContainer');
	var alertContainer = document.getElementById('alert-container');
	var alertDelete = document.getElementById('delete');
	var alertCancel = document.getElementById('cancel');
	var body = document.getElementById('body');
	var postsContainer = document.getElementById('postsContainer');
	var post_id;

	var video = document.getElementById('video');
	var canvas = document.getElementById('canvas');
	var snap = document.getElementById('snap');
	var img = document.getElementById('img');
	var save = document.getElementById('save');
	var pub = document.getElementById('pub');
	var say = document.getElementById('say');
	var stream;

	var comment = document.querySelectorAll('.commentt');
	var inpot = document.querySelectorAll('.inpot');
	var showStatus = 0;
	var xhttp = new XMLHttpRequest();

	var input = document.getElementById('fileInput');
	var canvas = document.getElementById('canvas');
	var botona = document.getElementById('botona');
	var spinner = document.getElementById('spinner');
	var pub = document.getElementById('pub');
	var say = document.getElementById('say');
	var save = document.getElementById('save');
	var preview = document.getElementById('preview');

	if (snap)
		snap.disabled = true;
	function initWebCam() {
		navigator.mediaDevices.getUserMedia({ audio:false, video: true}).then(function (mediaStream) {
			snap.disabled = false;
			if ("srcObject" in video) {
				video.srcObject = mediaStream;
			} else {
				//old version
				video.src = window.URL.createObjectURL(mediaStream);
			}
			stream = mediaStream;
			video.onloadedmetadata = function(e) {
			video.play();
		};
		}).catch(function (err) {
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

	if (video && canvas && img)
	initWebCam();
	if (snap)
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

		var xhttp = new XMLHttpRequest();
		xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
		xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		save.onclick =  function(e) {
			e.preventDefault();
			save.disabled = true;
			xhttp.send('loggedin=true&saveButton=true&publication='+ pub.value +'&pictureData='+data);
		}
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
					postHandler();
					deleteHandlerInPersonal();
					commentHandler();
					snap.disabled = true;
					retake_pic();
				}
			}
		}
	});

	/* ************************************************************* */
	/*                             COMMENTS                          */
	/* ************************************************************* */


	commentHandler();
	function newComment() {
		var comantir = document.querySelectorAll('.comantir');
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
	}

	function commentToggle() {
	var commentToggler = document.querySelectorAll('.comment');
	commentToggler.forEach(function (d) {
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
	}

	inpot.forEach( function(d) {
		d.onkeydown = function(e) {
			autoResize(e.target)
		}
	})

	function commentHandler() {
		commentToggle();
		newComment();
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

	/* ************************************************************* */
	/*                           imageUploader                       */
	/* ************************************************************* */

	if (input)
	input.onchange = function() {
		var errors = document.querySelectorAll(".errorMessage");
		errors.forEach(function (e) {
			e.style.display = "none";
		});
		if (this.files && this.files[0]) {
			var file = this.files[0];
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
					postHandler();
					deleteHandlerInPersonal();
					commentHandler();
				}
			}
		}
	};

	if (say)
	say.onclick =  function() {
		pub.style.display = 'block';
		say.style.display = 'none';
	}

	/* ************************************************************* */
	/*                              Gallery                          */
	/* ************************************************************* */

	postHandler();
	var pathname = window.location.pathname.split('/')[window.location.pathname.split('/').length - 1];
	if (pathname === 'gallery' || pathname === 'gallery.php')
		deleteHandlerInGallery();
	else
		deleteHandlerInPersonal();
	function hitLike() {
		document.querySelectorAll('.like').forEach(function(d) {
			d.onclick = function(e) {
				var post_id = e.target.parentNode.id.replace('post_', '');
				var tooltip = document.getElementById('tooltip_'+post_id);
				xhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if (xhttp.responseText === 'All good') {
							if (e.target.src.split('/')[e.target.src.split('/').length - 1] === 'like-0.png') {
								e.target.src = '/camagru/assets/images/like-1.png';
								if (e.target.nextSibling.innerHTML === '')
									e.target.nextSibling.innerHTML = '1';
								else
									e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) + 1).toString();
								if (tooltip)
									tooltip.innerHTML += userLoggedIn.innerHTML +'<br>'
							} else {
								e.target.src = '/camagru/assets/images/like-0.png';
								if (e.target.nextSibling.innerHTML === '1')
									e.target.nextSibling.innerHTML = '';
								else if (e.target.nextSibling.innerHTML !== '' && e.target.nextSibling.innerHTML !== '0')
								e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) - 1).toString();
								if (tooltip)
									tooltip.innerHTML = tooltip.innerHTML.replace(userLoggedIn.innerHTML+'<br>', '');
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
		});
	}

	document.querySelectorAll('.like').forEach(function(d) {
		d.onmouseover = function() {
			var post_id = d.parentNode.id.replace('post_', '');
			var tooltip = document.getElementById('tooltip_'+post_id);
			if (tooltip)
				tooltip.style.visibility = 'visible';
		}
		d.onmouseout = function() {
			var post_id = d.parentNode.id.replace('post_', '');
			var tooltip = document.getElementById('tooltip_'+post_id);
			if (tooltip)
				tooltip.style.visibility = 'hidden';
		}
	})

	function toggleDeletePost() {
		var post = document.querySelectorAll('.post')
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
	}

	function postHandler() {
		toggleDeletePost();
		hitLike();
		doubleHitLike();
	}

	function doubleHitLike() {
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
							img.style.height = d.height / 4 + 'px';
							img.style.width = d.height / 4 + 'px';
							img.style.position = 'absolute';
							img.style.margin = 'auto';
							img.style.top = d.height / 2 - img.style.height.replace('px' , '') / 2 + 'px';
							img.style.left = d.width / 2 - img.style.width.replace('px', '') / 2 + 'px';
							heartContainer.appendChild(img);
							img.className = "heartbeat2";
							setTimeout(function () {
								img.remove();
							}, 1000);
						}
					}
				}
				xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttp.send('doubleHitLike='+post_id);
			}
		})
	}

	/* ************************************************************* */
	/*                          DeleteHandler                        */
	/* ************************************************************* */

	function deleteHandlerInPersonal() {
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
			}
			else if (e.target === alertDelete) {
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
							postHandler();
							deleteHandlerInPersonal();
							commentHandler();
						}
					}
				}
				xhttp.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttp.send('loggedin=true&delete=true&post_id='+post_id);
				setTimeout(function () {
					alertContainer.style.visibility = 'hidden';
				}, 500);alertContainer.style.visibility = 'hidden';
				alertContainer.style.opacity = '0';
			}
		}
	}

	function deleteHandlerInGallery() {
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
							postHandler();
							deleteHandlerInGallery();
							commentHandler();
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
	}
})