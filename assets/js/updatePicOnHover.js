window.addEventListener("load", function() {
	var containerenter = document.getElementById("pdpContainer").addEventListener("mouseenter", showUpdate);
	var containerleave = document.getElementById("pdpContainer").addEventListener("mouseleave", hideUpdate);
	var pdp = document.getElementById("pdp");
	var update = document.getElementById("updatePic");

	function showUpdate() {
		update.style.opacity = "100";
	}
	function hideUpdate() {
		update.style.opacity = "0";
	}
});