
document.addEventListener("DOMContentLoaded", function(_event) {
	var captchasList = document.querySelectorAll(".captcha");
	captchasList.forEach((captcha) => {
		var paramSplits = captcha.dataset.splits;
		var paramImage = captcha.dataset.img;
		var puzzleContainer = document.createElement("div");
		var backgroundContainer = document.createElement("div");

		backgroundContainer.style.backgroundImage = paramImage;

		for (let y=0; y<paramSplits; y++) {
			for (let x=0; x<paramSplits; x++) {
				var puzzle = document.createElement("div");
				var size = (1/paramSplits)*100;

				puzzle.style.position = "relative";
				puzzle.style.width = size+"%";
				puzzle.style.height = size+"%";
				puzzle.style.left = size*x+"%";
				puzzle.style.top = size*y+"%";

				captcha.appendChild(puzzleContainer);
				captcha.appendChild(backgroundContainer);
				puzzleContainer.appendChild(puzzle);
			}
		}
	})
});
