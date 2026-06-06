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

	tournamentPools.forEach(pool => {
		const id = pool.dataset.id;
		["id", "x", "y", "name"].forEach(data => {
			var poolData = document.createElement("input");
			poolData.name = "pools["+id+"]["+data+"]";
			poolData.value = pool.dataset[data]
			poolData.hidden = true
			dataHolder.appendChild(poolData)
		})
	})
	
}
