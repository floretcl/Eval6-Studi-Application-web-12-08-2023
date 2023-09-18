const groupCheckbox = document.getElementById('table-group-checkbox');
const allCheckboxes = document.getElementsByClassName('table-checkbox');
const deleteButton = document.getElementById('delete-button');

const deleteConfirmButton = document.getElementById('delete-confirm-btn');

const searchInput = document.getElementById('search-input');
const resetButton = document.getElementById('reset-search-btn');


const addClassToElement = (elem, className) => {
    if (!elem.classList.contains(className)) {
        elem.classList.add(className);
    }
}

const removeClassToElement = (elem, className) => {
    if (elem.classList.contains(className)) {
        elem.classList.remove(className);
    }
}

const activateDeleteButton = () => {
    removeClassToElement(deleteButton, 'disabled');
}

const disableDeleteButton = () => {
    addClassToElement(deleteButton, 'disabled');
}

const toggleCheckboxes = (checkbox, groupCheckbox) => {
    if (checkbox.checked) {
        let activateGroupCheckbox = true;
        for (const cbox of allCheckboxes) { 
            if (!cbox.checked && cbox != groupCheckbox) {
                activateGroupCheckbox = false;
                break;
            }
        }
        if (activateGroupCheckbox) {
            groupCheckbox.checked = true;
        }
        activateDeleteButton();
    } else {
        groupCheckbox.checked = false;
        let disableButtons = true
        for (const cbox of allCheckboxes) { 
            if (cbox.checked && cbox != groupCheckbox) {
                disableButtons = false;
                break;
            }
        }
        if (disableButtons) {
            disableDeleteButton();
        }
    }
}

for (const checkbox of allCheckboxes) {
    if (checkbox != groupCheckbox) {
        checkbox.addEventListener('change', () => {
            toggleCheckboxes(checkbox, groupCheckbox);
        })
    } 
}

groupCheckbox.addEventListener('change', () => {
    for (const checkbox of allCheckboxes) {
        if (groupCheckbox.checked) {
            checkbox.checked = true;
            activateDeleteButton();
        } else {
            checkbox.checked = false;
            disableDeleteButton();
        }
    }
});

deleteConfirmButton.addEventListener('click', () => {
    for (const checkbox of allCheckboxes) {
        if (checkbox.checked && checkbox != groupCheckbox) {
            let formData = new FormData();
            formData.append('delete', checkbox.value)
            fetch(`http://127.0.0.1:81/admin/agent/list.php`, {
            method: 'POST',
            mode: 'same-origin',
            body: formData
            })
            .then((response) => {
                if (response.ok) {
                    window.location.reload();
                }
            })
            .catch((error) => alert("Une erreur s'est produite : " + error)); 
        }
    }
});

if (resetButton !== null) {
    resetButton.addEventListener('click', () => {
        searchInput.value = '';
        window.location.href = 'list.php';
    });
}
