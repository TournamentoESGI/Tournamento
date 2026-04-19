function slidePuzzle(slider, puzzle, img, scale) {
	puzzle.style.left = slider.value/100*img.width-scale*slider.value/100+"px"
}

document.addEventListener("DOMContentLoaded", () => {
	var sections_list = document.getElementsByClassName("captcha-section")
	Array.from(sections_list).forEach((section) => {

		var captcha = section.children[1]

		const holder = document.createElement("div")
		holder.className = "holder"
		captcha.appendChild(holder);

		const captcha_scale = captcha.dataset.scale
		const captcha_img = captcha.dataset.img
		const captcha_top = parseInt(captcha.dataset.pos.split(";")[1])/100

		const img = new Image()
		img.src = captcha_img

		const background = document.createElement("div")
		background.style.backgroundImage="url("+captcha_img+")"
		background.style.height = img.height+"px"
		background.style.width = img.width+"px"
		
		const slider = document.createElement("input")
		slider.type = "range"
		slider.addEventListener("input",function() {
			slidePuzzle(slider, puzzle, img, captcha_scale)
		})
		const form = section.children[2]
		form.appendChild(slider)

		const puzzle = document.createElement("div")
		puzzle.className = "puzzle"
		puzzle.style.backgroundImage="url("+captcha_img+")"
		puzzle.style.top = -img.height+captcha_top*img.height-captcha_scale*captcha_top+"px";
		puzzle.style.height = captcha_scale+"px"
		puzzle.style.width = captcha_scale+"px"

		holder.appendChild(background);
		holder.appendChild(puzzle);

		slidePuzzle(slider, puzzle, img, captcha_scale)
	})
});
