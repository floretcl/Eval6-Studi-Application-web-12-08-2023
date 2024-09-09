const hideoutTypeId = document.getElementById('hideout-type-id');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', hideoutTypeId.value)
    fetch(`http://localhost:81/?controller=hideout-type&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=hideout-type&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});