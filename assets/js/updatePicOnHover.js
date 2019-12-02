window.addEventListener("load", function() {
	var containerenter = document.getElementById("pdpContainer");
	var containerleave = document.getElementById("pdpContainer");
	var update = document.getElementById("updatePic");
	if (containerenter)
		containerenter.addEventListener("mouseenter", showUpdate);
	if (containerleave)
		containerleave.addEventListener("mouseleave", hideUpdate);

	function showUpdate() {
		update.style.opacity = "100";
	}
	function hideUpdate() {
		update.style.opacity = "0";
	}
});