const missionTypeId = document.getElementById('mission-type-id');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', missionTypeId.value)
    fetch(`http://localhost:81/?controller=mission-type&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=mission-type&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});