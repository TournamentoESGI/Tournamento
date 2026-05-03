function movePuzzleToPos(captcha, puzzle, tileX, tileY) {
	var paramGap = captcha.dataset.gap;
	var paramSplits = captcha.dataset.splits;
	var captchaWidth = captcha.dataset.width;
	var captchaHeight = captcha.dataset.height;

	var tileWidth = 1/paramSplits*captchaWidth-paramGap;
	var tileHeight = 1/paramSplits*captchaHeight-paramGap;

	var posX = tileWidth*tileX+paramGap*tileX+paramGap/2;
	var posY = tileHeight*tileY+paramGap*tileY+paramGap/2;

	puzzle.style.left = posX+"px";
	puzzle.style.top = posY+"px";

	puzzle.dataset.x = tileX;
	puzzle.dataset.y = tileY;
}

function switchPuzzlesPlaces(captcha, puzzlesContainer, puzzle) {
	var switchPuzzle;
	var puzzlesList = Array.from(puzzlesContainer.children);
	puzzlesList.forEach((element) => {
		if (element.className == "selected" && element != puzzle) {
			switchPuzzle = element;
		}
	});

	var switchX = puzzle.dataset.x;
	var switchY = puzzle.dataset.y;

	if (switchPuzzle) {
		movePuzzleToPos(captcha, puzzle, switchPuzzle.dataset.x, switchPuzzle.dataset.y);
		movePuzzleToPos(captcha, switchPuzzle, switchX, switchY);
		switchPuzzle.className = "";
		puzzle.className = "Selected";
	}
	
}

function updateCaptchaData(dataLine, puzzlesContainer) {
	var puzzlesList = Array.from(puzzlesContainer.children);
	dataLine.value = "";
	puzzlesList.forEach((element) => {
		dataLine.value += element.dataset.x;
		dataLine.value += ";";
		dataLine.value += element.dataset.y;
		dataLine.value += " ";
	});
}

document.addEventListener("DOMContentLoaded", function(_event) {
	var captchasList = document.querySelectorAll(".captcha");
	captchasList.forEach((captcha) => {
		var paramSplits = captcha.dataset.splits;
		var paramImage = captcha.dataset.img;
		var paramGap = captcha.dataset.gap;
		var paramMode = captcha.dataset.mode;

		var backgroundContainer = document.createElement("img");
		backgroundContainer.src = paramImage;
		backgroundContainer.className = "image";
		captcha.appendChild(backgroundContainer);

		backgroundContainer.addEventListener("load", function(event) {
			var captchaHeight = captcha.clientHeight;
			var captchaWidth = captcha.clientWidth;

			captcha.dataset.width = captchaWidth;
			captcha.dataset.height = captchaHeight;

			var puzzlesContainer = document.createElement("div");
			puzzlesContainer.className = "puzzles";
			puzzlesContainer.style.height = captchaHeight+"px";
			puzzlesContainer.style.top = -captchaHeight+"px";
			captcha.appendChild(puzzlesContainer);

			var dataInput = document.createElement("input");
			dataInput.type = "hidden";
			dataInput.name = "captcha";
			captcha.appendChild(dataInput);

			var tileWidth = 1/paramSplits*captchaWidth-paramGap;
			var tileHeight = 1/paramSplits*captchaHeight-paramGap;

			for (let y=0; y<paramSplits; y++) {
				for (let x=0; x<paramSplits; x++) {
					var puzzleTile = document.createElement("div");

					movePuzzleToPos(captcha, puzzleTile, x, y);
					
					puzzleTile.style.width = tileWidth+"px";
					puzzleTile.style.height = tileHeight+"px";

					var puzzleImage = document.createElement("img");
					puzzleImage.src = paramImage;
					puzzleImage.style.height = captchaHeight+"px";

					puzzleImage.style.left = -tileWidth*x+"px";
					puzzleImage.style.top = -tileHeight*y+"px";

					puzzleTile.appendChild(puzzleImage);
					puzzlesContainer.appendChild(puzzleTile);

					puzzleTile.onclick = function(event) {
						switchPuzzlesPlaces(captcha, puzzlesContainer, event.target);
						event.target.className = event.target.className?"":"selected";
						
						
					};
				}
			}
			captcha.style.height = captchaHeight+"px";

			if (paramMode == "solve") {
				let childrens = Array.from(puzzlesContainer.children);
				for (let i=0;i<paramSplits; i++) {
					var randomId = 0;
					randomId = Math.floor(Math.random()*(childrens.length));
					var randFromPuzzle = childrens[randomId];

					randomId = Math.floor(Math.random()*(childrens.length));
					var randToPuzzle = childrens[randomId];
					
					randToPuzzle.className = "selected";
					switchPuzzlesPlaces(captcha, puzzlesContainer, randFromPuzzle);
				}
			}

			updateCaptchaData(dataInput, puzzlesContainer);
		});
	})
});
