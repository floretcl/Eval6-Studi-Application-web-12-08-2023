const missionTableRows = document.getElementsByClassName('mission-table-row');

for (const tableRow of missionTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `detail.php?id=${tableRow.id}`;
    });
}
