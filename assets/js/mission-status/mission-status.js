const missionStatusId = document.getElementById('mission-status-id');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', missionStatusId.value)
    fetch(`http://localhost:81/?controller=mission-status&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=mission-status&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});