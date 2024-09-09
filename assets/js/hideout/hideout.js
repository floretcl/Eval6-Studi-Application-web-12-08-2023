const hideoutUUID = document.getElementById('hideout-uuid');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', hideoutUUID.value)
    fetch(`http://localhost:81/?controller=hideout&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=hideout&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});