function cleanPage() {
	document.getElementById("main").remove();
}

document.addEventListener("DOMContentLoaded", function() {
	var displayButton = document.getElementById("errorButton");
	if (displayButton) {
		var errorContainer = document.getElementById("errorContainer");
		errorContainer.style.visibility = "hidden";
		displayButton.addEventListener("click", (event) => {
			errorContainer.style.visibility = errorContainer.style.visibility=="visible"?"hidden":"visible";
		});
	}
});
