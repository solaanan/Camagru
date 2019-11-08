window.addEventListener("load", function() {
	var navbarlist = document.getElementById("navbarElements");
	document.getElementById("collapsor").addEventListener('click', expandOrCollapse)

	function expandOrCollapse() {
		if (navbarlist.className === "topnav") {
			navbarlist.className += " responsive";
		} else {
			navbarlist.className = "topnav";
		}
	}
});