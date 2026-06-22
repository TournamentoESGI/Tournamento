var infos = document.getElementById('infos')
var participantsContainer = document.getElementById('participants-container')
var participantsList = Array.from(participantsContainer.children)
var anchor = document.getElementsByClassName("anchor")[0]
var draggedParticipant = null

participantsContainer.addEventListener('mousedown', function(e) {
	console.log(e)
	if (e.target.className.includes("participant")) {
		draggedParticipant = e.target
	}
})

window.addEventListener('mouseup', function(e) {

	const dropTarget = document.elementFromPoint(e.clientX, e.clientY);
	if (draggedParticipant) {
		if (dropTarget.className.includes("empty-user")) {
			var dropPoolParticipants = dropTarget.parentElement
			if (dropPoolParticipants.className == "participants") {
				draggedParticipant = draggedParticipant.firstChild;
				console.log(dropTarget)

				var targetEmptyData = Array.from(participantsContainer.children)
					.filter(element => element.className.includes("empty-user"))
					.map(element => element.firstChild)
					.filter(element => element.dataset.id == dropTarget.firstChild.dataset.id)[0]
					.parentElement
				targetEmptyData.remove();
				dropTarget.remove();
				addParticipantToContainer(dropPoolParticipants, -1, draggedParticipant.dataset.id, draggedParticipant.textContent, true);
			}
		}
		draggedParticipant = null
	}
})

document.getElementById('button-create').addEventListener('click', e => {
	addPoolToTournament(anchor , -1, "New Pool", 0, 0, true)
});

function saveTournament() {
	var tournamentPools = Array.from(anchor.children).filter(element => element.className == "pool")
	var tournamentParticipants = Array.from(document.getElementById("participants-container").children)
		.map(participant => participant.children[0])
		.filter(participant => participant !== undefined)

	var dataHolder = document.getElementById("tournament-data")
	dataHolder.innerHTML = ""
	dataHolder.hidden = true;

	tournamentPools.forEach(pool => {
		const id = pool.dataset.id;
		["id", "x", "y", "name"].forEach(data => {
			var poolData = document.createElement("input");
			poolData.name = "pools["+id+"]["+data+"]";
			poolData.value = pool.dataset[data]
			dataHolder.appendChild(poolData)
		})

		let poolParticipantsList = Array.from(pool.getElementsByClassName("participants")[0].children)
		poolParticipantsList = poolParticipantsList.map(element => element.children[0]).filter(element => element !== undefined)
		poolParticipantsList = poolParticipantsList.map(element => element.dataset.id+";"+element.dataset.user)

		var poolParticipants = document.createElement("input");
		poolParticipants.name = "pools["+id+"][participants]"; 
		poolParticipants.value = poolParticipantsList.toString()
		dataHolder.appendChild(poolParticipants);
	})


	tournamentParticipants.forEach(participant => {
		var participantData = document.createElement("input");
		participantData.name = "participants["+participant.dataset.id+"][user]";
		participantData.value = participant.dataset.user;
		dataHolder.appendChild(participantData);


		var participantData = document.createElement("input");
		participantData.name = "participants["+participant.dataset.id+"][nickname]";
		participantData.value = participant.textContent;
		dataHolder.appendChild(participantData);
	})

	//Array.from(dataHolder.children).forEach(child => { console.log(child.name + ";" + child.value) });
}
