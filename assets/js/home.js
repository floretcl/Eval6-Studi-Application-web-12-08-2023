const missionTableRows = document.getElementsByClassName('mission-table-row');

for (const tableRow of missionTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `?controller=detail&id=${tableRow.id}`;
    });
}
