let editing = false;

function toggleEditMode() {
    editing = !editing;

    const sujet = document.getElementById('sujet');
    const contenu = document.getElementById('contenu');
    const btnEditSave= document.getElementById('btn-edit-save');
    sujet.readOnly = !editing;
    contenu.readOnly = !editing;

    if (editing) {
        btnEditSave.textContent= 'Sauvegarder';
        sujet.focus();
    } else {
        btnEditSave.textContent = 'Modifier';
        verifChamps();
    }
}


function verifChamps() {
    const sujet = document.getElementById('sujet').value;
    const contenu= document.getElementById('contenu').value;
    const btnSend= document.getElementById('btn-send');

    if (sujet != '' && contenu != '') {
        btnSend.disabled= false;
    } else {
        btnSend.disabled = true;
    }
}

document.getElementById('sujet').addEventListener('input', verifChamps);
document.getElementById('contenu').addEventListener('input', verifChamps);
document.getElementById('btn-send').disabled = true;