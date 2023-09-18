const adminUuid = document.getElementById('admin-uuid');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', adminUuid.value)
    fetch(`http://127.0.0.1:81/admin/admin/list.php`, {
    method: 'POST',
    mode: 'same-origin',
    body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = 'list.php';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});