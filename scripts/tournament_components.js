var rightClickMenu = document.getElementById("right-click");
var menuParticipant = null;

if (!rightClickMenu) {
	rightClickMenu = document.createElement("div");
	rightClickMenu.id = "right-click";
	rightClickMenu.style.display = "none";

	var deleteParticipant = document.createElement("button");
	deleteParticipant.id = "right-click-delete";
	deleteParticipant.textContent = "Delete";
	rightClickMenu.appendChild(deleteParticipant);
	deleteParticipant.addEventListener('click', function(e) {
		console.log(e);
		menuParticipant.remove();
		rightClickMenu.style.display = "none";
	})

	var winParticipant = document.createElement("button");
	winParticipant.id = "right-click-win";
	winParticipant.textContent = "Set winner";
	rightClickMenu.appendChild(winParticipant);

	rightClickMenu.addEventListener('focusout', function(e) {
		rightClickMenu.style.display = "none";
	})

	document.body.appendChild(rightClickMenu);
}

var selectedTournament = null
var selectedPool = null;

function addParticipantToContainer(parent, id, user, nickname="", editMode=false) {
	const container = document.createElement("div")
	let isUser = userId==id
	let isEmpty = user==-1
	container.className = "participant" + (isUser?" current-user":"") + (isEmpty?" empty-user":"");
	parent.appendChild(container);

	const nicknameTag = document.createElement("p");
	nicknameTag.dataset.id = id;
	nicknameTag.dataset.user = user;
	nicknameTag.textContent = isEmpty?"Place libre":nickname;
	container.appendChild(nicknameTag);

	if (editMode) {
		document.addEventListener('contextmenu', function(e) {
			var target = e.target;
			if (target.className.includes("participant")) {
				e.preventDefault();
				menuParticipant = target;
				rightClickMenu.style.left = e.clientX+"px";
				rightClickMenu.style.top = e.clientY+"px";
				rightClickMenu.style.display = "";
			}

		})

		document.addEventListener('click', function(e) {
			if (e.buttons == 0) {
				if (!e.target.id.includes("right-click")) {
					rightClickMenu.style.display = "none";
				}
			}
		})

		const deleteButton = document.createElement("button");
		deleteButton.textContent = "X";
		deleteButton.className = "delete";
		container.appendChild(deleteButton);
		deleteButton.addEventListener("click", function(e) {
			if (e.target.className == "delete") {
				container.remove();
			}
		})
	}
}

function makeLinkTo(from, to) {
	from.addEventListener('load', function(e) {
		console.log(e)
	});

	to = document.createElement("div");
	to.style.left = "0px";
	to.style.top = "20px";

	var link = document.createElement("div");
	link.className = "link";

	console.log(from);
	var originX = from.clientLeft;
	var originY = from.clientTop;
	var targetX = to.clientLeft;
	var targetY = to.clientTop;

	console.log(originX, originY)
	console.log(targetX, targetY)

	var length = Math.sqrt(Math.pow((originX-targetX),2)+Math.pow(originY-targetY, 2))
	link.style.width = length+"px";

	from.appendChild(link);

}

function addPoolToTournament(tournament, id, title, posX, posY, editMode=false) {
	var pool = document.createElement("div");
	pool.className = "pool";
	pool.dataset.id = id
	pool.dataset.name = title
	pool.dataset.x = posX
	pool.dataset.y = posY

	tournament.appendChild(pool)

	var bar = document.createElement("div");
	bar.className = "bar";
	pool.appendChild(bar)
	
	var input = document.createElement("input");
	input.className = "pool-title"
	input.value = title
	bar.appendChild(input)

	if (editMode) {
		var button = document.createElement("button");
		button.className = "add"
		button.textContent = "+"
		bar.appendChild(button)
	}

	var content = document.createElement("div");
	content.className = "content";
	pool.appendChild(content);

	var participants = document.createElement("div");
	participants.className='participants'
	content.appendChild(participants);

	input.disabled = true;
	input.addEventListener('focusout', function(e) {
		input.disabled = true;
		pool.dataset.name = input.value
	})

	input.addEventListener('keydown', function(e) {
		if (e.key === "Enter") {
			console.log(input.value);
			if (input.value == "") {
				pool.remove()
			}
			else {
				input.blur();
			}
		}
	})
	
	if (button) {
		button.addEventListener('click', function(e) {
			addParticipantToContainer(participants, -1, -1, "", true);
		})
	}

	pool.style.left = posX+"px";
	pool.style.top = posY+"px";

	pool.addEventListener('dblclick', function(e) {
		if (editMode) {
			input.disabled = false;
			input.focus()
			input.setSelectionRange(0, input.value.length);
		}
	})


	pool.addEventListener('mousedown', function(e) {
		if (e.button == 0) {
			selectedPool = pool
		}
	})

	/*var linkButton = document.createElement("button");
	linkButton.className = "link";
	linkButton.textContent = ">";
	content.appendChild(linkButton);

	var anchor = document.getElementsByClassName("anchor")[0]

	makeLinkTo(linkButton, anchor);*/

}
