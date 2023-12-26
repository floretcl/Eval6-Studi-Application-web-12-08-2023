const hideoutTypeId = document.getElementById('hideout-type-id');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', hideoutTypeId.value)
    fetch(`http://localhost:81/admin/hideout-type/list.php`, {
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