const contactUUID = document.getElementById('contact-uuid');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', contactUUID.value)
    fetch(`http://localhost:81/?controller=contact&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=contact&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});