const specialtyId = document.getElementById('specialty-id');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', specialtyId.value)
    fetch(`http://localhost:81/?controller=specialty&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=specialty&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});