
function showTable(tableId) {
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                table.style.display = table.id === tableId ? 'table' : 'none';
            });
        }