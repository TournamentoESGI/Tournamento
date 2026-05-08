function navigate(x, y) {
	anchor.style.left = x+"px";
	anchor.style.top = y+"px";
}

function addPool(poolName) {
	var pool = document.createElement("div");
	pool.className = "pool";
	var poolTitle = document.createElement("p");
	poolTitle.textContent = poolName;

	var poolPlayersContainer = document.createElement("div");
	poolPlayersContainer.className = "players";

	var anchor = document.getElementById("anchor");
	pool.appendChild(poolTitle);
	pool.appendChild(poolPlayersContainer);
	anchor.appendChild(pool);

	return pool;
}

function addPlayerToPool(pool, playerName) {
	var poolPlayersContainer = pool.children[1];
	var playerNameTag = document.createElement("p");
	playerNameTag.textContent = playerName;
	poolPlayersContainer.appendChild(playerNameTag);
}

document.addEventListener("DOMContentLoaded", function() {
	var posX = window.innerWidth/2;
	var posY = window.innerHeight/2;
	var moving = false;
	var selectedPool = null;

	document.addEventListener("mousedown", (event) => {
		if (event.button == 1) {
			moving = true;
		}
	});
	document.addEventListener("mouseup", (event) => {
		if (event.button == 1) {
			moving = false;
		}
	});

	document.addEventListener("mousemove", (event) => {
		if (moving) {
			posX += event.movementX;
			posY += event.movementY;
			navigate(posX, posY);
		}
	});

	var buttonAddPool = document.getElementById("button-create");
	buttonAddPool.onclick = function() {
		var newPool = addPool("New pool");
		addPlayerToPool(newPool, "User");
	};
});
