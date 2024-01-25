const agentUUID = document.getElementById('agent-uuid');
const deleteConfirmButton = document.getElementById('delete-confirm-btn');

deleteConfirmButton.addEventListener('click', () => {
    let formData = new FormData();
    formData.append('delete', agentUUID.value)
    fetch(`http://localhost:81/?controller=agent&action=delete`, {
        method: 'POST',
        mode: 'same-origin',
        body: formData
    })
    .then((response) => {
        if (response.ok) {
            window.location.href = '?controller=agent&action=list';
        }
    })
    .catch((error) => alert("Une erreur s'est produite : " + error)); 
});