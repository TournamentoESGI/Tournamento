const captcha = document.getElementById("captcha")
const captcha_img = new Image()
var captcha_img_url = captcha.dataset.img
var splits = captcha.dataset.splits

captcha_img.src = captcha.dataset.img

captcha.style.height = captcha_img.height + "px"
captcha.style.width = captcha_img.width + "px"

function selectPuzzle(ev) {
	var puzzle = ev.target
	if (puzzle.classList.contains("selected")) {
		puzzle.classList.remove("selected")
	}
	else {
		puzzle.classList.add("selected")
	}
}

var puzzle_scale = 1/splits
for (let y=0; y<splits; y++) {
	for (let x=0; x<splits; x++) {
		var puzzle_slice = document.createElement("div")
		var puzzle_height = puzzle_scale*captcha_img.height
		var puzzle_width = puzzle_scale*captcha_img.width
		puzzle_slice.dataset.id = y*splits+x
		puzzle_slice.style.height = puzzle_height+"px"
		puzzle_slice.style.width = puzzle_width+"px"

		var puzzle_img = document.createElement("div")
		puzzle_img.classList.add("img");
		puzzle_img.style.backgroundImage = "url('"+captcha_img.src+"')"
		puzzle_img.style.backgroundPositionX = -puzzle_width*x+"px"
		puzzle_img.style.backgroundPositionY = -puzzle_height*y+"px"
		puzzle_slice.style.overflow = "hidden"

		puzzle_slice.onclick = selectPuzzle
		captcha.appendChild(puzzle_slice)
		puzzle_slice.appendChild(puzzle_img)

	}
}
