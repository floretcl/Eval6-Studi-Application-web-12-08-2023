const navLinks = document.getElementsByClassName('nav-link');
const targetTableRows = document.getElementsByClassName('target-table-row');
const adminTableRows = document.getElementsByClassName('admin-table-row');
const missionTableRows = document.getElementsByClassName('mission-table-row');
const missionTypeTableRows = document.getElementsByClassName('mission-type-table-row');
const missionStatusTableRows = document.getElementsByClassName('mission-status-table-row');
const hideoutTableRows = document.getElementsByClassName('hideout-table-row');
const hideoutTypeTableRows = document.getElementsByClassName('hideout-type-table-row');
const specialtyTableRows = document.getElementsByClassName('specialty-table-row');
const contactTableRows = document.getElementsByClassName('contact-table-row');
const agentTableRows = document.getElementsByClassName('agent-table-row');

for (const navLink of navLinks) {
    navLink.addEventListener('click', () => {
        for (const navLink of navLinks) {
            if (!navLink.classList.contains('active') && navLink.classList.contains('link-dark')) {
                navLink.classList.remove('link-dark');
                navLink.classList.add('link-light');
            }
        }
        if (navLink.classList.contains('active')) {
            navLink.classList.remove('link-light');
            navLink.classList.add('link-dark');
        }
    });
    
    for (const tableRow of adminTableRows) {
        tableRow.addEventListener('click', () => {
            document.location.href = `admin/admin/admin.php?id=${tableRow.id}`;
        });
    }
}

for (const tableRow of missionTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/mission/mission.php?id=${tableRow.id}`;
    });
}

for (const tableRow of missionTypeTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/mission-type/mission-type.php?id=${tableRow.id}`;
    });
}

for (const tableRow of missionStatusTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/mission-status/mission-status.php?id=${tableRow.id}`;
    });
}

for (const tableRow of hideoutTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/hideout/hideout.php?id=${tableRow.id}`;
    });
}

for (const tableRow of hideoutTypeTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/hideout-type/hideout-type.php?id=${tableRow.id}`;
    });
}

for (const tableRow of specialtyTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/specialty/specialty.php?id=${tableRow.id}`;
    });
}

for (const tableRow of agentTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/agent/agent.php?id=${tableRow.id}`;
    });
}

for (const tableRow of contactTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/contact/contact.php?id=${tableRow.id}`;
    });
}

for (const tableRow of targetTableRows) {
    tableRow.addEventListener('click', () => {
        document.location.href = `admin/target/target.php?id=${tableRow.id}`;
    });
}
