var infos = document.getElementById('infos')
var participantsContainer = document.getElementById('participants-container')
var participantsList = Array.from(participantsContainer.children)

var draggedParticipant = null

participantsContainer.addEventListener('mousedown', function(e) {
	if (e.target.className == "participant") {
		draggedParticipant = e.target
	}
})

window.addEventListener('mouseup', function(e) {
	if (draggedParticipant) {
		if (e.target.className == "pool") {
			var poolParticipants = e.target.getElementsByClassName("participants")
		}
		draggedParticipant = null
	}
})

function saveTournament() {
	var tournamentPools = Array.from(document.getElementsByClassName("anchor")[0].children)
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
		poolParticipantsList = poolParticipantsList.map(element => element.children[0])

		poolParticipantsList.forEach(element => {
			var poolParticipant = document.createElement("input");
			poolParticipant.name = "pools["+id+"][participants][" + element.dataset.id + "][nickname]"; 
			poolParticipant.value = element.textContent	
			dataHolder.appendChild(poolParticipant)
			var poolParticipant = document.createElement("input");
			poolParticipant.name = "pools["+id+"][participants][" + element.dataset.id + "][user]"; 
			poolParticipant.value = element.dataset.user
			dataHolder.appendChild(poolParticipant)
		})
	})
}
