window.addEventListener('load', function() {
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
				toggler.firstElementChild.src = toggler.firstElementChild.src.replace('light', 'night');
				toggler.lastElementChild.innerHTML = 'Night mode'
				toggler.firstElementChild.width = '19';
				if (!head.innerHTML.match(/<link rel\=\"stylesheet\" href=\"\/camagru\/assets\/css\/light-mode\.css\">/))
				head.innerHTML += '<link rel="stylesheet" href="/camagru/assets/css/light-mode.css">';
				imgs.forEach(function (e) {
					e.src = e.src.replace('icons-dark', 'icons-light');
				})
			} else if (xhttp.responseText === '0') {
				if (!head.innerHTML.match(/<link rel\=\"stylesheet\" href=\"\/camagru\/assets\/css\/dark-mode\.css\">/))
					head.innerHTML += '<link rel="stylesheet" href="/camagru/assets/css/dark-mode.css">';
			}
		}
	}

	toggler.onclick = function() {
			var imgs = document.querySelectorAll('img');
			if (toggler.lastElementChild.innerHTML.trim() === 'Light mode') {
			toggler.firstElementChild.src = toggler.firstElementChild.src.replace('light', 'night');
			toggler.firstElementChild.width = '19';
			toggler.firstElementChild.height = 25;
			toggler.lastElementChild.innerHTML = 'Night mode'
			var imgs = document.querySelectorAll('img');
			head.innerHTML = head.innerHTML.replace('dark-mode', 'light-mode');
			imgs.forEach(function (e) {
				e.src = e.src.replace('icons-dark', 'icons-light');
			})
			xhttp.open('POST', '/camagru/includes/handlers/theme-handler.php');
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('setTheme=1');
		} else {
			toggler.firstElementChild.src = toggler.firstElementChild.src.replace('night', 'light');
			toggler.firstElementChild.width = '25';
			toggler.firstElementChild.height = '25';
			toggler.lastElementChild.innerHTML = 'Light mode';
			head.innerHTML = head.innerHTML.replace('light-mode', 'dark-mode');
			imgs.forEach(function (e) {
				e.src = e.src.replace('icons-light', 'icons-dark');
			})
			xhttp.open('POST', '/camagru/includes/handlers/theme-handler.php');
			xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhttp.send('setTheme=0');
		}
	}
})