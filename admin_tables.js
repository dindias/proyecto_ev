document.addEventListener('DOMContentLoaded', function() {
    // Hacer la solicitud Fetch para obtener los datos de registro
    let formData = new FormData();
    formData.append('action', 'tablaUsuarios');

    // Llamada a la función para obtener notificaciones no leídas
    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Crear el gráfico cuando se obtengan los datos
            console.log(data);
            tablaUsuarios(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function tablaUsuarios(data) {
    // Obtén el elemento donde se insertará la tabla
    const tablaContainer = document.getElementById('tablaContainer');

    // Crea un contenedor de fila (row) con clases de Bootstrap
    const rowContainer = document.createElement('div');
    rowContainer.classList.add('row', 'justify-content-center');

    // Crea un contenedor de columna (col) con clases de Bootstrap para la tabla
    const colContainer = document.createElement('div');
    colContainer.classList.add('col-md-8'); // Ajusta el número de columnas según tus necesidades

    // Crea la tabla y le agrega clases de Bootstrap para el estilo
    const table = document.createElement('table');
    table.classList.add('table', 'table-bordered', 'table-striped');

    // Crea el encabezado de la tabla
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    Object.keys(data[0]).forEach(columnName => {
        const th = document.createElement('th');
        th.textContent = columnName;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Crea el cuerpo de la tabla
    const tbody = document.createElement('tbody');
    data.forEach(rowData => {
        const row = document.createElement('tr');
        Object.values(rowData).forEach(value => {
            const td = document.createElement('td');
            td.textContent = value;
            row.appendChild(td);
        });
        tbody.appendChild(row);
    });
    table.appendChild(tbody);

    // Agrega la tabla al contenedor de columna
    colContainer.appendChild(table);

    // Agrega el contenedor de columna al contenedor de fila
    rowContainer.appendChild(colContainer);

    // Limpia el contenido existente y agrega la estructura al contenedor
    tablaContainer.innerHTML = '';
    tablaContainer.appendChild(rowContainer);
}



