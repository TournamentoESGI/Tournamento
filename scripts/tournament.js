document.addEventListener('DOMContentLoaded', function(_event) {

var tournamentsList = Array.from(document.getElementsByClassName("tournament-display"));

var selectedTournament = null

tournamentsList.forEach(tournament => {
	var participantsList = Array.from(tournament.getElementsByClassName("participants")[0].children);
	var poolsList = Array.from(tournament.getElementsByClassName("pools")[0].children);
	var anchor = tournament.getElementsByClassName("anchor")[0];
	var selection = tournament.getElementsByClassName("selection")[0];
	var selectedPool = null;
	var scaler = tournament.getElementsByClassName("scaler")[0];
	var moving = false
	var editMode = tournament.dataset.edit=="true"?true:false
	if (editMode) {
		selectedTournament = tournament
		tournament.focus()
	}

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
			let left = parseInt(anchor.style.left.split("px")[0])
			let top = parseInt(anchor.style.top.split("px")[0])
			anchor.style.left = left+vX+"px";
			anchor.style.top = top+vY+"px";
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

	poolsList.forEach(pool => {
		var poolTitle = pool.getElementsByClassName("pool-title")[0];
		poolTitle.disabled = true;
		poolTitle.addEventListener('focusout', function(e) {
			poolTitle.disabled = true;
			pool.dataset.name = poolTitle.value
		})

		pool.style.left = pool.dataset.x+"px";
		pool.style.top = pool.dataset.y+"px";


		pool.addEventListener('dblclick', function(e) {
			if (editMode) {
				poolTitle.disabled = false;
				poolTitle.focus()
				poolTitle.setSelectionRange(poolTitle.value.length, poolTitle.value.length);
			}
		})
	
		pool.addEventListener('mousedown', function(e) {
			if (e.button == 0) {
				selectedPool = pool
			}
		})
	
		anchor.appendChild(pool);
	})
});

function movePool(pool, deltaX, deltaY) {
	pool.style.left = parseInt(pool.style.left.split("px")[0])+deltaX;
	pool.style.top = parseInt(pool.style.top.split("px")[0])+deltaY;
}

});
