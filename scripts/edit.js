function navigate(x, y) {
	anchor.style.left = x+"px";
	anchor.style.top = y+"px";
}

function selectPool(pool, isSelected) {
	if (pool) {
		pool.className = isSelected?"pool selected":"pool"
	}
}

function setPlayerToTag(tag, playerId) {
	tag.textContent = playerId;
}

function addPool(poolName) {
	var pool = document.createElement("div");
	pool.className = "pool";

	var poolTitle = document.createElement("input");
	poolTitle.type = "text";
	poolTitle.className = "title";
	poolTitle.value = poolName;

	var poolPlayersContainer = document.createElement("div");
	poolPlayersContainer.className = "players";

	var poolAddContainer = document.createElement("div");
	poolAddContainer.className="add-container";
	var poolAdd = document.createElement("button");
	poolAdd.textContent = "Add place";
	poolAdd.className = "add";
	poolAdd.onclick = function(event) {
		addPlayerToPool(pool, "Participant   " + poolPlayersContainer.children.length);
	}

	var anchor = document.getElementById("anchor");
	pool.appendChild(poolTitle);
	poolAddContainer.appendChild(poolAdd);
	pool.appendChild(poolAddContainer);
	pool.appendChild(poolPlayersContainer);

	pool.ondblclick = function(event) {
		poolTitle.focus();
	};

	pool.style.left = -(anchor.style.left.split("px")[0]-window.innerWidth/2)+"px";
	pool.style.top = -(anchor.style.top.split("px")[0]-window.innerHeight/2)+"px";

	anchor.appendChild(pool);
	return pool;
}

function addPlayerToPool(pool, playerName) {
	var poolPlayersContainer = pool.children[2];
	var playerNameContainer = document.createElement("div");

	

	var playerDeleteButton = document.createElement("button");
	var playerNameTag = document.createElement("p");
	playerNameTag.textContent = playerName;

	playerDeleteButton.onclick = function() {
		//setPlayerToTag(playerNameTag, 1);
		playerNameContainer.remove();
	};

	playerNameContainer.appendChild(playerNameTag);
	playerNameContainer.appendChild(playerDeleteButton);
	playerDeleteButton.textContent = "Delete";

	poolPlayersContainer.appendChild(playerNameContainer);
}

document.addEventListener("DOMContentLoaded", function() {
	var posX = window.innerWidth/2;
	var posY = window.innerHeight/2;
	var middleClick = false;
	var leftClick = false;
	var hoverX = 0;
	var hoverY = 0;
	var selectedPool = null;

	document.addEventListener("mousedown", (event) => {
		if (event.button == 1) {
			middleClick = true;
		}
		if (event.button == 0) {
			leftClick = true;
		}
		if (event.target.className.includes("pool")) {
			selectPool(selectedPool, false);
			selectedPool = event.target;
			selectPool(event.target, true);
			hoverX = selectedPool.style.x-event.offsetX;
			hoverY = selectedPool.style.y-event.offsetY;
		}
		else {
			selectPool(selectedPool, false);
			selectedPool = null;
		}
	});
	document.addEventListener("mouseup", (event) => {
		if (event.button == 1) {
			middleClick = false;
		}
		if (event.button == 0) {
			leftClick = false;
		}
	});

	document.addEventListener("mousemove", (event) => {
		if (middleClick) {
			posX += event.movementX;
			posY += event.movementY;
			navigate(posX, posY);
		}
		if (leftClick) {
			if (selectedPool) {
				var anchorRect = anchor.getBoundingClientRect();
				selectedPool.style.left = event.clientX-anchorRect.left+hoverX+"px";
				selectedPool.style.top = event.clientY-anchorRect.top+hoverY+"px";
			}
		}
	});

	document.addEventListener("keydown", (event) => {
		if (event.key == "Delete") {
			if (selectedPool) {
				selectedPool.remove();
				selectedPool = null;
			}
		}
	});

	var buttonAddPool = document.getElementById("button-create");
	buttonAddPool.onclick = function() {
		var newPool = addPool("New pool");
	};

	navigate(posX,posY);
});
