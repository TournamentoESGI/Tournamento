
document.addEventListener("DOMContentLoaded", () => {
	var captchas_list = document.getElementsByClassName("captcha")
	Array.from(captchas_list).forEach((captcha) => {
		var captcha_img_url = captcha.dataset.img
		const captcha_img = new Image()
		captcha_img.src = captcha_img_url;

		const slider = document.createElement("input")
		slider.type = "range"
		const confirm_button = document.createElement("button")
		const img = document.createElement("div")
		const puzzle = document.createElement("div")
		puzzle.className = "puzzle"
		puzzle.style.backgroundImage="url("+captcha_img_url+")"
		var puzzle_scale = captcha.dataset.scale
		puzzle.style.width = puzzle_scale+"px"
		puzzle.style.height = puzzle_scale+"px"
		img.style.backgroundImage="url("+captcha_img_url+")"
		img.style.height = captcha_img.height+"px"
		img.style.width = captcha_img.width+"px"
		slider.addEventListener("change",function() {
			puzzle.style.left = slider.value/100*captcha_img.width+"px"
		})
		captcha.appendChild(img);
		captcha.appendChild(puzzle);
		captcha.appendChild(slider);
	})
});
