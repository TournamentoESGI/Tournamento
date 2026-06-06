document.addEventListener('DOMContentLoaded', function(_event) {

var tournamentsList = Array.from(document.getElementsByClassName("tournament-display"));

var selectedTournament = null

tournamentsList.forEach(tournament => {
	var participantsList = Array.from(tournament.getElementsByClassName("participants")[0].children);
	var poolsList = Array.from(tournament.getElementsByClassName("pools")[0].children);
	var anchor = tournament.getElementsByClassName("anchor")[0];
	var selection = tournament.getElementsByClassName("selection")[0];
	var scaler = tournament.getElementsByClassName("scaler")[0];
	var moving = false

	var zoom = 1.0

	anchor.style.left = "0px";
	anchor.style.top = "0px";

	tournament.addEventListener('wheel', function(e) {
		if (selectedTournament == tournament) {
			e.preventDefault()
			if (e.deltaY < 0) {
				zoom = Math.min(zoom+0.1, 3);
			}
			if (e.deltaY > 0) {
				zoom = Math.max(zoom-0.1, 0.2);
			}
			scaler.style.scale = zoom
		}
	})

	document.addEventListener('keydown', function(e) {
		if (selectedTournament) {
			document.activeElement?.blur()
			selectedTournament = null
		}
	})

	tournament.addEventListener('mousedown', function(e) {
		if (e.button == 0) {
			selectedTournament = tournament
			tournament.focus()
		}
		if (selectedTournament == tournament) {
			if (e.button == 1) {
				moving = true
			}
		}
		e.preventDefault()
	})

	tournament.addEventListener('mousemove', function(e) {
		if (moving) {
			let left = parseInt(anchor.style.left.split("px")[0])
			let top = parseInt(anchor.style.top.split("px")[0])
			anchor.style.left = left+e.movementX+"px";
			anchor.style.top = top+e.movementY+"px";
		}
	})

	tournament.addEventListener('mouseup', function(e) {
		if (e.button == 1) {
			moving = false
		}
	})

	poolsList.forEach(pool => {
		pool.style.left = pool.dataset.x+"px";
		pool.style.top = pool.dataset.y+"px";
		anchor.appendChild(pool);
	})
});

function movePool(pool, deltaX, deltaY) {
	pool.style.left = parseInt(pool.style.left.split("px")[0])+deltaX;
	pool.style.top = parseInt(pool.style.top.split("px")[0])+deltaY;
}

});
