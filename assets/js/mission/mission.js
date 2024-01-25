const missionUUID = document.getElementById('mission-uuid');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', missionUUID.value)
    fetch(`http://localhost:81/?controller=mission&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=mission&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});