Array.prototype.myEach = function(callback) {
	for (var i = 0; i < this.length; i++)
		callback(this[i], i, this);
};

Object.prototype.myEach = function(callback) {
	for (var i = 0; i < this.length; i++)
		callback(this[i], i, this);
};


window.addEventListener('load', function() {

	function onReady(callback) {
		var intervalId = window.setInterval(function() {
		if (document.getElementsByTagName('body')[0] !== undefined) {
			window.clearInterval(intervalId);
			callback.call(this);
		}
		}, 1000);
	}
	
	function setVisible(selector, visible) {
	document.querySelector(selector).style.display = visible ? 'block' : 'none';
	}
	
	onReady(function() {
	setVisible('.everything', true);
	setVisible('#loading', false);
	});
	


	var toggler = document.getElementById("themeSelector");
	var head = document.querySelector('head');

	var xhttp = new XMLHttpRequest();

	xhttp.open('POST', '/camagru/includes/handlers/theme-handler.php');
	xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhttp.send('getTheme=1');

	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (xhttp.responseText === '1') {
				var imgs = document.querySelectorAll('img');
				toggler.firstElementChild.src = toggler.firstElementChild.src.replace(/light/g, 'night');
				toggler.lastElementChild.innerHTML = 'Night mode'
				toggler.firstElementChild.width = '19';
				// if (!head.innerHTML.match(/<link rel\=\"stylesheet\" href=\"\/camagru\/assets\/css\/light-mode\.css\">/))
				// head.innerHTML += '<link rel="stylesheet" href="/camagru/assets/css/light-mode.css">';
				imgs.myEach(function (e) {
					e.src = e.src.replace(/icons-dark/g, 'icons-light');
				})
			} else if (xhttp.responseText === '0') {
				// if (!head.innerHTML.match(/<link rel\=\"stylesheet\" href=\"\/camagru\/assets\/css\/dark-mode\.css\">/))
					// head.innerHTML += '<link rel="stylesheet" href="/camagru/assets/css/dark-mode.css">';
			}
		}
	}

	toggler.onclick = function() {
			var imgs = document.querySelectorAll('img');
			imgs = Array.prototype.slice.call(imgs);
			console.log(typeof imgs)
			if (toggler.lastElementChild.innerHTML.trim() === 'Light mode') {
			toggler.firstElementChild.src = toggler.firstElementChild.src.replace(/light/g, 'night');
			toggler.firstElementChild.width = '19';
			toggler.firstElementChild.height = 25;
			toggler.lastElementChild.innerHTML = 'Night mode'
			var imgs = document.querySelectorAll('img');
			head.innerHTML = head.innerHTML.replace(/dark-mode/g, 'light-mode');
			imgs.myEach(function (e) {
				e.src = e.src.replace(/icons-dark/g, 'icons-light');
			})
			xhttp.open('POST', '/camagru/includes/handlers/theme-handler.php');
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('setTheme=1');
		} else {
			toggler.firstElementChild.src = toggler.firstElementChild.src.replace(/night/g, 'light');
			toggler.firstElementChild.width = '25';
			toggler.firstElementChild.height = '25';
			toggler.lastElementChild.innerHTML = 'Light mode';
			head.innerHTML = head.innerHTML.replace(/light-mode/g, 'dark-mode');
			imgs.myEach(function (e) {
				e.src = e.src.replace(/icons-light/g, 'icons-dark');
			})
			xhttp.open('POST', '/camagru/includes/handlers/theme-handler.php');
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('setTheme=0');
		}
	}
})