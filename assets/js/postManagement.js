Array.prototype.myEach = function(callback) {
	for (var i = 0; i < this.length; i++)
		callback(this[i], i, this);
};

Object.prototype.myEach = function(callback) {
	for (var i = 0; i < this.length; i++)
		callback(this[i], i, this);
};

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
	var next = document.getElementById('next');
	var previous = document.getElementById('previous');
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
	var showStatus = 0;
	var xhttpCamera = new XMLHttpRequest();

	var input = document.getElementById('fileInput');
	var canvas = document.getElementById('canvas');
	var spinner = document.getElementById('spinner');
	var pub = document.getElementById('pub');
	var say = document.getElementById('say');
	var save = document.getElementById('save');
	var preview = document.getElementById('preview');
	var sticker = document.getElementById('sticker');
	var arrowsContainer = document.getElementById('arrowsContainer');
	var i = 0;

	if (next)
	next.onclick = function() {
		if (i < 5)
		i++;
		if (i === 5) {
			next.style.opacity = '0.5';
			next.style.cursor = 'unset';
		}
		if (i > 0) {
			previous.style.opacity = '1';
			previous.style.cursor = 'pointer';
		}
		sticker.src = '/camagru/assets/images/stickers/sticker-'+ i +'.png';
	}

	if (previous)
	previous.onclick = function() {
		if (i > 0)
		i--;
		if (i === 0) {
			previous.style.opacity = '0.5';
			previous.style.cursor = 'unset';
		}
		if (i < 6) {
			next.style.opacity = '1';
			next.style.cursor = 'pointer';
		}
		sticker.src = '/camagru/assets/images/stickers/sticker-'+ i +'.png';
	}

	if (pub)
	pub.addEventListener("keyup", function(e) {
		e.preventDefault();
		save.disabled = (pub.value.length < 1000) ? false : true;
	})

	if (snap)
		snap.disabled = true;
	function initWebCam() {
		if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices)
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
			sticker.style.display = 'block';
			arrowsContainer.style.display = 'block';
		};
		}).catch(function() {
		});
	}

	function retake_pic() {
		arrowsContainer.style.display = 'none';
		video.style.display = "block";
		snap.style.display = "block";
		canvas.style.display = "none";
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
	if (snap) {
		var sticker = document.getElementById('sticker');
		snap.onclick = function (e) {
			e.preventDefault();
			var context = canvas.getContext('2d');
			canvas.width = video.videoWidth;
			canvas.height = video.videoHeight;
			context.translate(canvas.width, 0);
			context.scale(-1, 1);
			context.drawImage(video, 0, 0, canvas.width, canvas.height);
			var data = canvas.toDataURL('image/png');
			stream.getTracks().myEach(function(track) {
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

			say.onclick = function() {
				if (pub.style.display !== "block")
					pub.style.display = "block";
				say.style.display = "none";
				if (pub.value > 1000)
						save.disabled = true;
			};

			retake.addEventListener('click', retake_pic);

			save.onclick =  function(e) {
				e.preventDefault();
				save.disabled = true;
				sticker.style.display = 'none';
				xhttpCamera.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttpCamera.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhttpCamera.send('loggedin=true&saveButton=true&publication='+ pub.value +'&pictureData='+data+'&index='+i);
			}
			xhttpCamera.onreadystatechange = function() {
				save.disabled = false;
				if (this.readyState == 4 && this.status == 200) {
					if (xhttpCamera.responseText.match(/All good/g)) {
						var div = document.createElement("div");
						div.setAttribute("class", "alert alert-success message popup");
						div.setAttribute("id", "message");
						div.innerHTML = "Posted !";
						document.getElementById('messages').appendChild(div);
						setTimeout(function () {
							div.remove();
						}, 5000);
						userPostsContainer.innerHTML = xhttpCamera.responseText.substr(8) + userPostsContainer.innerHTML;
						if (document.querySelector('.nothing'))
							document.querySelector('.nothing').style.display = 'none';
						postHandler();
						deleteHandler();
						commentHandler();
						snap.disabled = true;
						retake_pic();
					}
				}
			}
		};
	}

	/* ************************************************************* */
	/*                             COMMENTS                          */
	/* ************************************************************* */

	xhttpComment = new XMLHttpRequest();

	commentHandler();
	function newComment() {
		var comantir = document.querySelectorAll('.comantir');
		comantir.myEach(function(d) {
			var post_id = d.id.replace('newCommentButton_', '');
			var comment = document.getElementById('newComment_'+post_id);
			var commentContainer = document.getElementById('commentsContainer_'+post_id);
			var commentCounter = document.getElementById('commentsCounter_'+post_id);
			d.onclick = function(e) {
				e.preventDefault();
				var commentText = comment.value;
				xhttpComment.open('POST', '/camagru/includes/handlers/comment-handler.php', true);
				xhttpComment.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttpComment.send('newCommentButton=true&newComment='+commentText+'&post_id='+post_id);
				var doc = new DOMParser().parseFromString('<div class="media commentt" style="opacity:0.5" id="tempComment">\
				<a class="text-decoration-none text-reset">\
					<img class="profilepic d-inline-block align-top" src="'+ document.getElementById('imgNavbar').style.backgroundImage.replace('url("', '').replace('")', '') +'" width="30" height="30">\
				</a>\
				<div class="media-body comment-body"><img src="/camagru/assets/images/delete.png" class="deleteComment float-right my-auto" width="10" height="10" alt="delete" style="display: none;"><span class="text mt-0 comment-head">'+ document.getElementById('userLoggedIn').textContent +'</span>\
					<br><span class="text text-break comment-text d-block">'+ commentText.replace(/\n/g, '<br>').replace(/ /g, '&nbsp;') +'</span>\
				</div>\
			</div>', "text/html");
				commentContainer.insertBefore(doc.childNodes[0].childNodes[1].childNodes[0], commentContainer.childNodes[2]);
				xhttpComment.onreadystatechange = function() {
					comment.value = '';
					if (this.readyState == 4 && this.status == 200) {
						if (xhttpComment.responseText !== 'nah') {
							if (tempComment = document.getElementById('tempComment'))
								tempComment.remove();
							var doc = new DOMParser().parseFromString(xhttpComment.responseText, "text/html");
							commentContainer.insertBefore(doc.childNodes[0].childNodes[1].childNodes[0], commentContainer.childNodes[2]);
							autoResize(comment);
							if (commentCounter.innerHTML === '')
							commentCounter.innerHTML = '1';
							else
							commentCounter.innerHTML = (parseInt(commentCounter.innerHTML) + 1).toString();
						} else {
							if (tempComment = document.getElementById('tempComment'))
								tempComment.remove();
						}
					}
					commentHandler();
				}
			}
		});
	}

	function commentToggle() {
		var commentToggler = document.querySelectorAll('.comment');
		commentToggler.myEach(function (d) {
			var post_id = d.parentNode.id.replace('post_', '');
			var commentContainer = document.getElementById('commentsContainer_'+post_id);
			var shareContainer = document.getElementById('shareContainer_'+post_id);
			d.onmouseover = function () {
				d.src = d.src.replace('comment_0', 'comment_1');
			}
			d.onmouseout = function () {
				if (commentContainer.style.display !== 'block')
					d.src = d.src.replace('comment_1', 'comment_0');
			}
			d.onclick = function() {
				if (commentContainer.style.display === 'block') {
					d.src = d.src.replace('comment_1', 'comment_0');
					commentContainer.style.display = 'none';
				} else {
					d.src = d.src.replace('comment_0', 'comment_1');
					commentContainer.style.display = 'block';
					shareContainer.style.display = 'none';
				}
				var array = Array.prototype.slice.call(commentContainer.children);
				var i = 0;
				array.myEach(function(e) {
					if (e.id.match(/comment_.+/)) {
						if (i > 1)
							e.style.display = 'none';
						i++;
					}
				});
			}
		});
	}

	function commentHandler() {
		commentToggle();
		newComment();
		toggleDeleteComment();
		toggleShowMore();
		deleteComment();
		ShowMoreHandler();

		var inpot = document.querySelectorAll('.inpot');
		if (inpot)
		inpot.myEach( function(d) {
			d.onkeydown = function(e) {
				e.target.nextElementSibling.firstElementChild.disabled = (e.target.value.length > 500) ? true : false;
				autoResize(e.target)
			}
		})
}

	function autoResize(d) {
			setTimeout(function() {
				d.style.height = 'auto';
				d.style.height = d.scrollHeight + 'px';
			}, 0)
	}

	function toggleDeleteComment() {
		comment = document.querySelectorAll('.commentt');
		comment.myEach(function (d) {
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
		showMore.myEach(function(d) {
			var id = d.id.replace('show_', '');
			var commentContainer = document.getElementById('commentsContainer_'+id);
			var array = Array.prototype.slice.call(commentContainer.children);
			d.onclick = function () {
				var i = 0;
				if (showStatus === 0) {
					showStatus = 1;
					array.myEach(function (e) {
						if (e.id.match(/comment_.+/)) {
								e.style.display = 'flex';
						}
					})
					d.innerHTML = 'Show less';
				} else {
					showStatus = 0;
					array.myEach(function (e) {
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
		delComm.myEach(function (e) {
			e.onclick = function() {
				comId = e.id.replace('delCom_', '');
				postId = e.parentNode.parentNode.parentNode.id.replace('commentsContainer_', '');
				commentCounter = document.getElementById('commentsCounter_'+postId);
				xhttpComment.open('POST', '/camagru/includes/handlers/comment-handler.php', true);
				xhttpComment.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttpComment.send('deleteComment=true&postId='+postId+'&commentId='+comId);
				xhttpComment.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if (xhttpComment.responseText !== 'nah') {
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
	var xhttpImgUP = new XMLHttpRequest();
	var elementt = document.getElementById('element');
	var uploadBotona = document.getElementById('uploadBotona');
	var dropImg = document.getElementById('dropImg');
	var uploadHeading = document.getElementById('uploadHeading');
	var dropHeading = document.getElementById('dropHeading');
	var cancell = document.getElementById('cancell');

	if (elementt) {
		cancell.onclick = function() {
			cancell.style.display = 'none';
			pub.value = '';
			pub.style.display = 'none';
			preview.removeAttribute('src');
			preview.style.display = 'none';
			say.style.display = 'none';
			save.style.display = 'none';
			uploadBotona.style.display = "table";
			sticker.style.display = 'none';
			arrowsContainer.style.display = 'none';
		}

		body.ondragover = function (e) {
			if (preview.src.length === 0) {
				e.preventDefault();
				e.stopPropagation();
				[].slice.call(elementt.children).myEach(function(d) {
						d.style.display = 'none';
				})
				dropImg.style.display = 'block';
				dropHeading.style.display = 'block';
			}
		}
		body.ondrop = function(e) {
			if (preview.src.length === 0) {
				e.preventDefault();
				e.stopPropagation();
				form.style.display = 'block';
				uploadHeading.style.display = 'block';
				dropImg.style.display = 'none';
				dropHeading.style.display = 'none';
			}
		}
		elementt.ondrop = function(e) {
			if (preview.src.length === 0) {
				e.preventDefault();
				e.stopPropagation();
				form.style.display = 'block';
				uploadHeading.style.display = 'block';
				dropImg.style.display = 'none';
				dropHeading.style.display = 'none';

				var dt = e.dataTransfer
				pub.value = '';
				var errors = document.querySelectorAll(".errorMessage");
				var desiredWidth = 668;
				errors.myEach(function (e) {
					e.style.display = "none";
				});
				if (dt.files && dt.files[0]) {
					var file = dt.files[0];
					if (file.size >= 1 && file.size < 8000000) {
						var img = new Image();
						img.src = URL.createObjectURL(file);
						img.onload = function() {
							uploadBotona.style.display = "none";
							say.style.display = "block";
							save.style.display = "inline-block";
							cancell.style.display = 'inline-block'
							var ctx = canvas.getContext('2d');
							var ratio = img.height / img.width;
							canvas.width = desiredWidth;
							canvas.height = desiredWidth * ratio;
							ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
							var data = canvas.toDataURL();
							preview.src = data;
							preview.style.display = 'block';
							sticker.style.display = 'block';
							sticker.parentNode.style.display = 'block';
							arrowsContainer.style.display = 'block';
							save.onclick = function(e) {
								e.preventDefault();
								say.style.display = 'none';
								pub.style.display = 'none';
								save.style.display = 'none';
								preview.style.display = 'none';
								sticker.style.display = 'none';
								sticker.parentNode.style.display = 'none';
								arrowsContainer.style.display = 'none';
								spinner.style.display = 'block';
								xhttpImgUP.open('POST', '/camagru/includes/handlers/post-handler.php', true);
								xhttpImgUP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
								xhttpImgUP.send('loggedin=true&picture='+data+'&publication='+pub.value+'&index='+ i);
							}
						}
						img.onerror = function() {
							say.style.display = 'none';
							pub.style.display = 'none';
							save.style.display = 'none';
							spinner.style.display = 'block';
							xhttpImgUP.open('POST', '/camagru/includes/handlers/post-handler.php', true);
							xhttpImgUP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
							xhttpImgUP.send('picture=error&publication=error');
						}
					} else {
						('big')
						xhttpImgUP.open('POST', '/camagru/includes/handlers/post-handler.php', true);
						xhttpImgUP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						xhttpImgUP.send('big=true');
					}
					xhttpImgUP.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							if (xhttpImgUP.responseText.match(/All good/g)) {
								var div = document.createElement("div");
								div.setAttribute("class", "alert alert-success message popup");
								div.setAttribute("id", "message");
								div.innerHTML = "Posted !";
								document.getElementById('messages').appendChild(div);
								setTimeout(function () {
									div.remove();
								}, 5000);
								userPostsContainer.innerHTML = xhttpImgUP.responseText.substr(8) + userPostsContainer.innerHTML;
								if (document.querySelector('.nothing'))
									document.querySelector('.nothing').style.display = 'none';
								uploadBotona.style.display = "table";
								spinner.style.display = 'none';
								preview.removeAttribute('src');
								say.style.display = "none";
								save.style.display = "none";
								pub.style.display = "none";
								cancell.style.display = "none";
							} else {
								spinner.style.display = 'none';
								uploadBotona.style.display = 'table';
								var array = xhttpImgUP.responseText.split('\n');
								array.myEach(function(e) {
									if (e !== "") {
										var div = document.createElement("div");
										div.setAttribute("class", "alert errorMessage");
										div.innerHTML = e;
										form.insertBefore(div, form.firstChild);
									}
								});
							}
							postHandler();
							deleteHandler();
							commentHandler();
						}
					}
				}
			}
		}
	}

	if (input)
	input.onchange = function() {
		pub.value = '';
		var errors = document.querySelectorAll(".errorMessage");
		var desiredWidth = 668;
		errors.myEach(function (e) {
			e.style.display = "none";
		});
		if (this.files && this.files[0]) {
			var file = this.files[0];
			if (file.size >= 1 && file.size < 8000000) {
				var img = new Image();
				img.src = URL.createObjectURL(file);
				img.onload = function() {
					uploadBotona.style.display = "none";
					say.style.display = "block";
					save.style.display = "inline-block";
					cancell.style.display = 'inline-block'
					var ctx = canvas.getContext('2d');
					var ratio = img.height / img.width;
					canvas.width = desiredWidth;
					canvas.height = desiredWidth * ratio;
					ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
					var data = canvas.toDataURL();
					preview.src = data;
					preview.style.display = 'block';
					sticker.style.display = 'block';
					arrowsContainer.style.display = 'block';
					save.onclick = function(e) {
						e.preventDefault();
						say.style.display = 'none';
						pub.style.display = 'none';
						save.style.display = 'none';
						preview.style.display = 'none';
						sticker.style.display = 'none';
						arrowsContainer.style.display = 'none';
						spinner.style.display = 'block';
						xhttpImgUP.open('POST', '/camagru/includes/handlers/post-handler.php', true);
						xhttpImgUP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						xhttpImgUP.send('loggedin=true&picture='+data+'&publication='+pub.value+'&index='+ i);
					}
				}
				img.onerror = function() {
					say.style.display = 'none';
					pub.style.display = 'none';
					save.style.display = 'none';
					spinner.style.display = 'block';
					xhttpImgUP.open('POST', '/camagru/includes/handlers/post-handler.php', true);
					xhttpImgUP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhttpImgUP.send('picture=error&publication=error');
				}
			} else {
				('big')
				xhttpImgUP.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttpImgUP.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttpImgUP.send('big=true');
			}
			xhttpImgUP.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if (xhttpImgUP.responseText.match(/All good/g)) {
						var div = document.createElement("div");
						div.setAttribute("class", "alert alert-success message popup");
						div.setAttribute("id", "message");
						div.innerHTML = "Posted !";
						document.getElementById('messages').appendChild(div);
						setTimeout(function () {
							div.remove();
						}, 5000);
						userPostsContainer.innerHTML = xhttpImgUP.responseText.substr(8) + userPostsContainer.innerHTML;
						if (document.querySelector('.nothing'))
							document.querySelector('.nothing').style.display = 'none';
						uploadBotona.style.display = "table";
						spinner.style.display = 'none';
						say.style.display = "none";
						save.style.display = "none";
						preview.removeAttribute('src');
						pub.style.display = "none";
						cancell.style.display = "none";
					} else {
						spinner.style.display = 'none';
						uploadBotona.style.display = 'table';
						var array = xhttpImgUP.responseText.split('\n');
						array.myEach(function(e) {
							if (e !== "") {
								var div = document.createElement("div");
								div.setAttribute("class", "alert errorMessage");
								div.innerHTML = e;
								form.insertBefore(div, form.firstChild);
							}
						});
					}
					postHandler();
					deleteHandler();
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

	var postsContainer = document.getElementById('postsContainer');
	var userPostsContainer = document.getElementById('userPostsContainer');
	var Obj = { start: 0, limit: 5 }
	var reachedLimit = false;
	var un;
	var xhttpLike = new XMLHttpRequest();

	if (postsContainer)
	getData(Obj);
	if (userPostsContainer)
	getUserData(Obj);
	postHandler();
	deleteHandler();
	window.onscroll = function() {
		if (document.documentElement.offsetHeight + document.documentElement.scrollTop === document.documentElement.scrollHeight) {
			if (postsContainer)
			getData(Obj);
			if (userPostsContainer)
			getUserData(Obj);
		}
	}
	postHandler();
	commentHandler();
	function hitLike() {
		document.querySelectorAll('.like').myEach(function(d) {
			d.onclick = function(e) {
				var post_id = e.target.parentNode.id.replace('post_', '');
				var tooltip = document.getElementById('tooltip_'+post_id);
				if (e.target.src.split('/')[e.target.src.split('/').length - 1] === 'like-0.png') {
					e.target.src = e.target.src.replace('like-0', 'like-1');
					if (e.target.nextSibling.innerHTML === '')
						e.target.nextSibling.innerHTML = '1';
					else
						e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) + 1).toString();
					if (tooltip)
						tooltip.innerHTML += userLoggedIn.innerHTML +'<br>'
				} else {
					e.target.src = e.target.src.replace('like-1', 'like-0');;
					if (e.target.nextSibling.innerHTML === '1')
						e.target.nextSibling.innerHTML = '';
					else if (e.target.nextSibling.innerHTML !== '' && e.target.nextSibling.innerHTML !== '0')
						e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) - 1).toString();
					if (tooltip) {
						tooltip.innerHTML = tooltip.innerHTML.replace(userLoggedIn.innerHTML+'<br>', '');
						if (tooltip.innerHTML === '')
							tooltip.style.visibility = 'hidden';
					}
				}
				e.target.className += ' heartbeat';
				setTimeout(function () {
					e.target.className = 'like';
				}, 500);
				xhttpLike.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if (xhttpLike.responseText !== 'All good') {
							if (e.target.src.split('/')[e.target.src.split('/').length - 1] === 'like-1.png') {
								e.target.src = e.target.src.replace('like-1', 'like-0');
								if (e.target.nextSibling.innerHTML === '1')
									e.target.nextSibling.innerHTML = '';
								else if (e.target.nextSibling.innerHTML !== '' && e.target.nextSibling.innerHTML !== '0')
									e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) - 1).toString();
								if (tooltip) {
									tooltip.innerHTML = tooltip.innerHTML.replace(userLoggedIn.innerHTML+'<br>', '');
									if (tooltip.innerHTML === '')
										tooltip.style.visibility = 'hidden';
								}
							}
						}
					}
				}
				xhttpLike.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttpLike.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttpLike.send('hitLike='+post_id);
			}
		});
	}

	function tooltipToggler() {
		document.querySelectorAll('.like').myEach(function(d) {
			d.onmouseover = function() {
				var post_id = d.parentNode.id.replace('post_', '');
				var tooltip = document.getElementById('tooltip_'+post_id);
				if (tooltip) {
					if (tooltip.innerHTML === '')
						tooltip.style.visibility = 'hidden';
					else
						tooltip.style.visibility = 'visible';
				}
			}
			d.onmouseout = function() {
				var post_id = d.parentNode.id.replace('post_', '');
				var tooltip = document.getElementById('tooltip_'+post_id);
				if (tooltip)
					tooltip.style.visibility = 'hidden';
			}
		})
	}

	function toggleDeletePost() {
		var post = document.querySelectorAll('.post')
		post.myEach(function(d) {
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
		deleteHandler();
		hitLike();
		doubleHitLike();
		shareHandler();
		tooltipToggler()
		ShowMoreHandler();
	}

	var xhttpDblLike = new XMLHttpRequest();

	function doubleHitLike() {
		document.querySelectorAll('.postImg').myEach(function(d) {
			d.ondblclick = function(e) {
				var post_id = d.parentNode.id.replace('post_', '');
				var tooltip = document.getElementById('tooltip_'+post_id);
				var heartContainer = document.getElementById('heart_'+post_id);
				var like = document.getElementById('like_'+post_id);
				if (like)
				if (like.src.split('/')[like.src.split('/').length - 1] === 'like-0.png') {
					like.src = like.src.replace('like-0', 'like-1');;
					if (like.nextSibling.innerHTML === '')
						like.nextSibling.innerHTML = '0';
					like.nextSibling.innerHTML = (parseInt(like.nextSibling.innerHTML) + 1).toString();
					like.className += ' heartbeat';
					setTimeout(function () {
						like.className = 'like';
					}, 500);
					if (tooltip)
						tooltip.innerHTML += userLoggedIn.innerHTML +'<br>'
				} else {
					like.className += ' heartbeat';
					setTimeout(function () {
						like.className = 'like';
					}, 500);
				}
				if (like) {
					var img = document.createElement('img');
					img.src = '/camagru/assets/images/heart.png'
					var length = (d.height < d.width) ? d.height : d.width;
					img.style.height = length / 8 + 'px';
					img.style.width = length / 8 + 'px';
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
				xhttpDblLike.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if (xhttpDblLike.responseText === 'All good') {
							if (e.target.src.split('/')[e.target.src.split('/').length - 1] === 'like-1.png') {
								e.target.src = e.target.src.replace('like-1', 'like-0');
								if (e.target.nextSibling.innerHTML === '1')
									e.target.nextSibling.innerHTML = '';
								else if (e.target.nextSibling.innerHTML !== '' && e.target.nextSibling.innerHTML !== '0')
									e.target.nextSibling.innerHTML = (parseInt(e.target.nextSibling.innerHTML) - 1).toString();
								if (tooltip) {
									tooltip.innerHTML = tooltip.innerHTML.replace(userLoggedIn.innerHTML+'<br>', '');
									if (tooltip.innerHTML === '')
										tooltip.style.visibility = 'hidden';
								}
							}
						}
					}
				}
				xhttpDblLike.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttpDblLike.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttpDblLike.send('doubleHitLike='+post_id);
			}
		})
	}

	
	function getData(Obj) {
		var xhttpGetData = new XMLHttpRequest();
		if (reachedLimit)
			return ;
		xhttpGetData.open('POST', '/camagru/includes/handlers/gallery-handler.php', true);
		xhttpGetData.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhttpGetData.send('getData=1&start='+Obj.start+'&limit='+Obj.limit);
		Obj.start += Obj.limit;
		xhttpGetData.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttpGetData.responseText === 'reachedLimit') {
					reachedLimit = true;
				} else {
					if (postsContainer) {
						if (Obj.start === 0)
							postsContainer.innerHTML = '';
						postsContainer.innerHTML += xhttpGetData.responseText;
					}
					postHandler();
					commentHandler();
				}
			}
		}
	}

	function getUserData(Obj) {
		var xhttpGetData = new XMLHttpRequest();
		window.location.search.substr(1).split('&').myEach(function (a) {
			if (a.match(/username/))
				un = a.split('=')[1];
		});
		if (reachedLimit)
			return ;
		xhttpGetData.open('POST', '/camagru/includes/handlers/gallery-handler.php', true);
		xhttpGetData.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhttpGetData.send('getData=1&start='+Obj.start+'&limit='+Obj.limit+'&loggedin=1&username='+un);
		Obj.start += Obj.limit;
		xhttpGetData.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (xhttpGetData.responseText === 'reachedLimit') {
					reachedLimit = true;
				} else {
					if (userPostsContainer) {
						if (Obj.start === 0)
							userPostsContainer.innerHTML = ''
						userPostsContainer.innerHTML += xhttpGetData.responseText;
					}
					postHandler();
					commentHandler();
				}
			}
		}
	}

	/* ************************************************************* */
	/*                          DeleteHandler                        */
	/* ************************************************************* */

	var xhttpDelete = new XMLHttpRequest();

	function deleteHandler() {
		document.onclick = function(e) {
			e.stopPropagation();
			if (e.target.className === 'delete float-right my-auto') {
			alertContainer.style.visibility = 'visible';
			alertContainer.style.opacity = '1';
			post_id = e.target.parentNode.id.replace('post_', '');
			} else if (e.target === alertCancel || e.target.id === 'alert-container' || e.target.id === 'alert-body') {
				alertContainer.style.opacity = '0';
				setTimeout(function () {
					alertContainer.style.visibility = 'hidden';
				}, 500);
			}
			else if (e.target === alertDelete) {
				xhttpDelete.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						if (xhttpDelete.responseText === 'All good') {
							var div = document.createElement("div");
							div.setAttribute("class", "alert alert-success message popup");
							div.setAttribute("id", "message");
							div.innerHTML = "Deleted !";
							document.getElementById('messages').appendChild(div);
							setTimeout(function () {
								div.remove();
							}, 5000);
							document.getElementById('post_'+post_id).remove();
							postHandler();
							deleteHandler();
							commentHandler();
						}
					}
				}
				xhttpDelete.open('POST', '/camagru/includes/handlers/post-handler.php', true);
				xhttpDelete.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhttpDelete.send('loggedin=true&delete=true&post_id='+post_id);
				setTimeout(function () {
					alertContainer.style.visibility = 'hidden';
				}, 500);
				alertContainer.style.opacity = '0';
			}
		}
	}

	/* ************************************************************* */
	/*                           ShareHandler                        */
	/* ************************************************************* */

	function shareHandler() {
		var share = document.querySelectorAll('.share');
		var copy = document.querySelectorAll('.coppy');

		share.myEach(function(d) {
			var postId = d.id.replace('share_', '');
			var shareContainer = document.getElementById('shareContainer_'+postId);
			var commentsContainer = document.getElementById('commentsContainer_'+postId);
			var commentToggler = document.getElementById('comment_'+postId);
			d.onclick = function(e) {
				if (shareContainer.style.display !== 'block') {
					shareContainer.style.display = 'block';
					commentsContainer.style.display = 'none';
					commentToggler.src = commentToggler.src.replace('comment_1', 'comment_0');
				}
				else
					shareContainer.style.display = 'none';
			}
		})

		copy.myEach(function(d) {
			var postId = d.id.replace('copy_', '');
			var shareLink = document.getElementById('shareLink_'+postId);

			d.onclick = function(e) {
				e.preventDefault;
				shareLink.select();
				shareLink.setSelectionRange(0, 99999);
				document.execCommand("copy");
				var div = document.createElement('div');
				div.setAttribute("class", "alert alert-success message popup");
				div.innerHTML = "Copied !";
				document.getElementById('messages').appendChild(div);
				setTimeout(function() {
					div.remove();
				}, 5000);
			}
		})
	}

	/* ************************************************************* */
	/*                           ShareHandler                        */
	/* ************************************************************* */

	function ShowMoreHandler() {
		document.querySelectorAll('.publicationn').myEach(function(d) {
			var char_limit = 150;
			if(d.childNodes.length === 1 && d.textContent.length > char_limit)
				d.innerHTML = '<span class="short-text">' + d.textContent.substr(0, char_limit) + '</span><span class="long-text">' + d.textContent.substr(char_limit) + '</span><span class="text-dots">...</span><span class="show-more-button" data-more="0">Read More</span>';
		})

		document.querySelectorAll('.comment-text').myEach(function(d) {
			var char_limit = 150;
			if (d.childNodes.length === 1 && d.textContent.length > char_limit)
				d.innerHTML = '<span class="short-text">' + d.textContent.substr(0, char_limit) + '</span><span class="long-text">' + d.textContent.substr(char_limit) + '</span><span class="text-dots">...</span><span class="show-more-button" data-more="0">Read More</span>';
		})

		document.querySelectorAll('.show-more-button').myEach(function(d) {
			d.onclick = function() {
				console.log(typeof d.getAttribute('data-more'));
				if (this.getAttribute('data-more') === '0') {
					this.setAttribute('data-more', 1);
					this.style.display = 'block';
					this.innerHTML = 'Read Less';
			
					this.previousSibling.style.display = 'none';
					this.previousSibling.previousSibling.style.display = 'inline';
				}
				else if(this.getAttribute('data-more') === '1') {
					this.setAttribute('data-more', 0);
					this.style.display = 'inline';
					this.innerHTML = 'Read More';
			
					this.previousSibling.style.display = 'inline';
					this.previousSibling.previousSibling.style.display = 'none';
				}	
			}
		});
	}
})