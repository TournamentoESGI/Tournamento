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
