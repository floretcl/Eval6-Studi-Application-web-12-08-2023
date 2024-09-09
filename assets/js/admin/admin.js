const adminUUID = document.getElementById('admin-uuid');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', adminUUID.value)
    fetch(`http://localhost:81/?controller=admin&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=admin&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});
