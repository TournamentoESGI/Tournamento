document.addEventListener("DOMContentLoaded", function() {
	var displayButton = document.getElementById("errorButton");
	var errorContainer = document.getElementById("errorContainer");
	errorContainer.style.visibility = "hidden";
	displayButton.addEventListener("click", (event) => {
		errorContainer.style.visibility = errorContainer.style.visibility=="visible"?"hidden":"visible";
	});
});
