document.addEventListener('DOMContentLoaded', function(_event) {

var tournamentsList = Array.from(document.getElementsByClassName("tournament-display"));


tournamentsList.forEach(tournament => {
	var anchor = tournament.getElementsByClassName("anchor")[0];
	var scaler = tournament.getElementsByClassName("scaler")[0];
	var moving = false
	var editMode = tournament.dataset.edit=="true"?true:false
	if (editMode) {
		selectedTournament = tournament
		tournament.focus()
	}

	function navigateBy(x, y) {
		let left = parseInt(anchor.style.left.split("px")[0])
		let top = parseInt(anchor.style.top.split("px")[0])
		anchor.style.left = left+x+"px";
		anchor.style.top = top+y+"px";
	}

	var zoom = 1.0

	anchor.style.left = "0px";
	anchor.style.top = "0px";

	tournament.addEventListener('wheel', function(e) {
		if (selectedTournament == tournament) {
			if (e.ctrlKey) {
				e.preventDefault()
				if (e.deltaY < 0) {
					zoom = Math.min(zoom+0.1, 3);
				}
				if (e.deltaY > 0) {
					zoom = Math.max(zoom-0.1, 0.2);
				}
				scaler.style.scale = zoom
			}
			else {
				navigateBy(-e.deltaX, -e.deltaY)
				e.preventDefault()
			}
		}
	})

	document.addEventListener('keydown', function(e) {
		if (selectedTournament && e.key == 'Escape' && !editMode) {
			document.activeElement?.blur()
			selectedTournament = null
			tournament.className = "tournament-display"
		}
	})

	tournament.addEventListener('mousedown', function(e) {
		if (e.button == 0) {
			selectedTournament = tournament
			tournament.className = "tournament-display focus"
		}
		if (e.button == 1) {
			if (selectedTournament == tournament) {
				moving = true
				e.preventDefault()
			}
		}
	})


	tournament.addEventListener('mousemove', function(e) {
		var vX= e.movementX/zoom
		var vY= e.movementY/zoom
		if (moving) {
			navigateBy(vX, vY);
		}
		if (selectedPool && editMode) {
			let left = parseInt(selectedPool.style.left.split("px")[0])
			let top = parseInt(selectedPool.style.top.split("px")[0])
			selectedPool.dataset.x = left+vX
			selectedPool.dataset.y = top+vY
			selectedPool.style.left = left+vX+"px";
			selectedPool.style.top = top+vY+"px";
		}
	})

	tournament.addEventListener('mouseup', function(e) {
		if (e.button == 1) {
			moving = false
		}
		selectedPool = null
	})
});

});
