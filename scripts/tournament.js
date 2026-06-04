document.addEventListener('DOMContentLoaded', function(_event) {

var tournamentsList = Array.from(document.getElementsByClassName("tournament-display"));

tournamentsList.forEach(tournament => {
	var participantsList = Array.from(tournament.getElementsByClassName("participants")[0].children);
	var poolsList = Array.from(tournament.getElementsByClassName("pools")[0].children);
	var anchor = tournament.getElementsByClassName("anchor")[0];
	var selection = tournament.getElementsByClassName("selection")[0];
	var scaler = tournament.getElementsByClassName("scaler")[0];
	var selecting = false


	var minY = poolsList[0].dataset.y;
	var maxY = poolsList[0].dataset.y;
	var minX = poolsList[0].dataset.x;
	var maxX = poolsList[0].dataset.x;
	var zoom = 1.0

	tournament.addEventListener('wheel', function(e) {
		
		e.preventDefault()
		if (e.deltaY < 0) {
			zoom = Math.min(zoom+0.1, 3);
		}
		if (e.deltaY > 0) {
			zoom = Math.max(zoom-0.1, 0.2);
		}
		console.log(zoom)
	})

	poolsList.forEach(pool => {
		pool.style.left = pool.dataset.x+"px";
		pool.style.top = pool.dataset.y+"px";
		anchor.appendChild(pool);

		let maxHeight = parseInt(pool.dataset.y)+parseInt(pool.clientHeight);
		let maxWidth = parseInt(pool.dataset.x)+parseInt(pool.clientWidth);

		if (parseInt(pool.dataset.y) < minY) {
			minY = pool.dataset.y;
		}
		if (maxHeight > maxY) {
			maxY = maxHeight;
		}
		if (parseInt(pool.dataset.x) < minX) {
			minX = pool.dataset.x;
		}
		if (maxWidth > maxX) {
			maxX = maxWidth;
		}
	})

	minY = parseInt(minY);
	maxY = parseInt(maxY);
	minX = parseInt(minX);
	maxX = parseInt(maxX);

	var centerY = (minY+maxY)/2;
	var centerX = (minX+maxX)/2;
	anchor.style.top = -centerY+"px";
	anchor.style.left = -centerX+"px";
	
	tournament.addEventListener('mousedown', function(e) {
		var pos = getTournamentMouse(tournament,e);
		selection.style.left = pos.x+"px";
		selection.style.top = pos.y+"px";
		selection.style.transformOrigin = "0 0";
		selecting = true;
		selection.style.transform = "scaleX(0) scaleY(0)";
	})

	tournament.addEventListener('mousemove', function(e) {
		if (selecting) {
			var pos = getTournamentMouse(tournament,e);
			var selectWidth = parseInt(selection.style.left.split("px")[0])
			var selectHeight = parseInt(selection.style.top.split("px")[0])
			selectWidth = selectWidth-pos.x;
			selectHeight = selectHeight-pos.y;
			selection.style.transform = "scaleX("+(-selectWidth)+") scaleY("+(-selectHeight)+")";
		}
	})

	tournament.addEventListener('mouseup', function(e) {
		selecting = false;
		//selection.style.transform = "scaleX(0) scaleY(0)";
	})


});

function getTournamentMouse(tournament, event) {
	var rect = tournament.getClientRects()[0]
	console.log(rect);
	console.log(event);
	return {
		"x": event.clientX+rect.left,
		"y": event.clientY+rect.top 
	}
}

function movePool(pool, deltaX, deltaY) {
	pool.style.left = parseInt(pool.style.left.split("px")[0])+deltaX;
	pool.style.top = parseInt(pool.style.top.split("px")[0])+deltaY;
}

});
