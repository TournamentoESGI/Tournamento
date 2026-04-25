function slidePuzzle(pos, piece, scale) {
	piece.style.left = pos-(scale/100*pos)+"%"
}

function slidePuzzleHeight(pos, piece, height, scale) {
	piece.style.top = -height+pos*height-(pos*scale/100*height)+"px";
}

function sliderVertical(captcha_mode, slider_v, target, height, captcha_scale) {
	if (captcha_mode == "create") {
		slidePuzzleHeight(slider_v.value/100, target,height , captcha_scale)
	}
}

function sliderHorizontal(value, target, puzzle, captcha_scale, captcha_mode) {
	if (captcha_mode == "create") {
		slidePuzzle(value, target, captcha_scale)
	}
	else {
		slidePuzzle(value, puzzle, captcha_scale)
	}
}

document.addEventListener("DOMContentLoaded", () => {
	var sections_list = document.getElementsByClassName("captcha-section")
	Array.from(sections_list).forEach((section) => {


	
		const container = section.children[0]
		var captcha = container.children[0]

		const captcha_scale = captcha.dataset.scale
		const captcha_img = captcha.dataset.img
		const captcha_top = parseInt(captcha.dataset.pos.split(";")[1])/100
		const captcha_left = parseInt(captcha.dataset.pos.split(";")[0])/100
		const captcha_mode = captcha.dataset.mode

		const img = new Image()
		img.src = captcha_img

		const background = document.createElement("img")
		background.className = "background"
		background.src =captcha_img
		
		const slider = document.createElement("input")
		slider.type = "range"
		slider.name = "captcha_slider"
		slider.className = "slider_h"
		if (captcha_mode == "create") {
			slider.value = captcha_left*100
		}

		const slider_v = document.createElement("input")
		if (captcha_mode == "create") {
			slider_v.type = "range"
			slider_v.style.writingMode = "vertical-lr"
			slider_v.name = "captcha_slider_height"
			slider_v.className = "slider_v"
			slider_v.value = captcha_top*100
			section.appendChild(slider_v)
		}
		
		let puzzle = null
		let target = null

		container.appendChild(slider)

		const holder = document.createElement("div")
		captcha.appendChild(holder)
		holder.appendChild(background)

		background.onload = function() {
			let height = background.getBoundingClientRect().height
			let puzzle_top = -height+captcha_top*height-(captcha_top*captcha_scale/100*height);

			//slider_v.height = height+"px";

			holder.className = "holder"
			holder.style.maxHeight = height+"px"

			if (captcha_mode != "create") {
				puzzle = document.createElement("div")
				puzzle.style.width = captcha_scale+"%"
				puzzle.style.height = height*captcha_scale/100+"px"
				puzzle.className = "puzzle"
				puzzle.style.backgroundImage="url("+captcha_img+")"
				puzzle.style.top = puzzle_top+"px"
				holder.appendChild(puzzle)
				slidePuzzle(slider, puzzle, img, captcha_scale)
			}
			
			target = document.createElement("div")
			target.style.width = captcha_scale+"%"
			target.style.height = height*captcha_scale/100+"px"
			target.className = "target"
			target.style.top = puzzle_top-captcha_scale/100*height+"px"
			slidePuzzle(captcha_left*100, target, captcha_scale)

			sliderVertical(captcha_mode, slider_v, target, height, captcha_scale)
			slider_v.addEventListener("input",function() {
				sliderVertical(captcha_mode, slider_v, target, height, captcha_scale)
			})

			sliderHorizontal(slider.value, target, puzzle, captcha_scale, captcha_mode);
			slider.addEventListener("input",function() {
				sliderHorizontal(slider.value, target, puzzle, captcha_scale, captcha_mode)
			})

			holder.appendChild(target)
			holder.appendChild(target)
		}
	})
})
