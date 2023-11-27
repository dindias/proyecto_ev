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
            mostrarPagina(data, 0, 10);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function mostrarPagina(data, startIndex, pageSize) {
    // Obtén el elemento donde se insertará la barra de búsqueda y la tabla
    const tablaContainer = document.getElementById('tablaContainer');

    // Crea el contenedor de fila (row) con clases de Bootstrap
    const rowContainer = document.createElement('div');
    rowContainer.classList.add('row', 'justify-content-center');

    // Crea un contenedor de columna (col) con clases de Bootstrap para la tabla
    const colContainer = document.createElement('div');
    colContainer.classList.add('col-xxl'); // Ajusta el ancho de la columna según tus necesidades

    // Crea la tabla de Bootstrap
    const table = document.createElement('table');
    table.classList.add('table');
    // Añade las propiedades específicas
    table.style.maxWidth = 'none';
    table.style.tableLayout = 'fixed';
    table.style.wordWrap = 'break-word';

    // Crea el encabezado de la tabla
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    Object.keys(data[0]).forEach(columnName => {
        const th = document.createElement('th');
        th.scope = 'col';
        th.textContent = columnName;
        headerRow.appendChild(th);
    });
    // Agrega las columnas de "Acciones"
    const accionesTh = document.createElement('th');
    accionesTh.scope = 'col';
    accionesTh.textContent = 'Acciones';
    headerRow.appendChild(accionesTh);
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Crea el cuerpo de la tabla
    const tbody = document.createElement('tbody');
    const endIndex = startIndex + pageSize;
    const paginatedData = data.slice(startIndex, endIndex);
    paginatedData.forEach(rowData => {
        const row = document.createElement('tr');
        Object.entries(rowData).forEach(([key, value]) => {
            const td = document.createElement('td');
            // No permitir cambios en el campo UserID
            if (key === 'UserID') {
                td.textContent = value;
            } else if (key === 'password') {
                // Mostrar asteriscos en lugar de la contraseña
                td.textContent = '*****';
            } else {
                td.textContent = value;
            }
            row.appendChild(td);
        });

        // Agrega las celdas de "Acciones" con botones de "Editar" y "Eliminar"
        const accionesTd = document.createElement('td');
        const editarBtn = document.createElement('button');
        editarBtn.textContent = 'Editar';
        editarBtn.classList.add('btn', 'btn-primary', 'btn-sm', 'me-2');
        editarBtn.addEventListener('click', () => {
            // Al hacer clic en "Editar", convierte los campos en inputs
            Array.from(row.children).forEach(td => {
                if (td !== accionesTd) {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = td.textContent;
                    input.classList.add('form-control');
                    // No permitir cambios en el campo UserID
                    if (td.cellIndex === 0) {
                        input.disabled = true;
                    }
                    // Mostrar asteriscos en lugar de la contraseña
                    if (td.cellIndex === 10) {
                        input.type = 'password';
                        input.value = '';
                    }
                    td.textContent = '';
                    td.appendChild(input);
                }
            });

            // Cambia el botón de "Editar" a "Aceptar" y agrega el botón de "Cancelar"
            accionesTd.innerHTML = '';
            const aceptarBtn = document.createElement('button');
            aceptarBtn.textContent = 'Aceptar';
            aceptarBtn.classList.add('btn', 'btn-success', 'btn-sm', 'me-2');
            aceptarBtn.addEventListener('click', () => {
                // Al hacer clic en "Aceptar", guarda los campos editados
                const modifiedData = {};
                const originalData = {};
                Array.from(row.children).forEach((td, index) => {
                    if (td !== accionesTd) {
                        const inputValue = td.querySelector('input').value;
                        modifiedData[Object.keys(data[0])[index]] = inputValue;
                        originalData[Object.keys(data[0])[index]] = rowData[Object.keys(data[0])[index]];
                        td.textContent = inputValue;
                    }
                });

                // Cambia el botón de "Aceptar" a "Editar"
                accionesTd.innerHTML = '';
                accionesTd.appendChild(editarBtn);
                accionesTd.appendChild(eliminarBtn);

                // Llama a la función para enviar los datos modificados al servidor
                modificarUsuarios(originalData, modifiedData);
            });

            const cancelarBtn = document.createElement('button');
            cancelarBtn.textContent = 'Cancelar';
            cancelarBtn.classList.add('btn', 'btn-danger', 'btn-sm');
            cancelarBtn.addEventListener('click', () => {
                // Al hacer clic en "Cancelar", deja los campos tal como estaban antes
                Array.from(row.children).forEach(td => {
                    if (td !== accionesTd) {
                        const inputValue = td.querySelector('input').value;
                        td.textContent = inputValue;
                    }
                });

                // Cambia el botón de "Cancelar" a "Editar"
                accionesTd.innerHTML = '';
                accionesTd.appendChild(editarBtn);
                accionesTd.appendChild(eliminarBtn);
            });

            accionesTd.appendChild(aceptarBtn);
            accionesTd.appendChild(cancelarBtn);
        });

        const eliminarBtn = document.createElement('button');
        eliminarBtn.textContent = 'Eliminar';
        eliminarBtn.classList.add('btn', 'btn-danger', 'btn-sm');
        // Agrega la lógica para eliminar el elemento si es necesario
        eliminarBtn.addEventListener('click', () => {
            // Agrega aquí la lógica para eliminar el elemento
            // Puedes usar el contenido de la fila (rowData) para identificar el elemento a eliminar
            // row.remove(); // Esto eliminará la fila visualmente, pero debes manejar la eliminación en tu lógica
        });

        accionesTd.appendChild(editarBtn);
        accionesTd.appendChild(eliminarBtn);
        row.appendChild(accionesTd);
        tbody.appendChild(row);
    });
    table.appendChild(tbody);

    colContainer.appendChild(table);

    // Agrega el contenedor de columna al contenedor de fila
    rowContainer.appendChild(colContainer);

    // Limpia el contenido existente y agrega la estructura al contenedor
    tablaContainer.innerHTML = '';
    tablaContainer.appendChild(rowContainer);

    // Agrega la paginación
    agregarPaginacion(data, startIndex, pageSize);
}

function agregarPaginacion(data, startIndex, pageSize) {
    // Calcula el número total de páginas
    const totalPages = Math.ceil(data.length / pageSize);

    // Obtén el elemento donde se insertará la paginación
    const paginacionContainer = document.getElementById('paginacionContainer');

    // Crea el contenedor de fila (row) con clases de Bootstrap
    const rowContainer = document.createElement('div');
    rowContainer.classList.add('row', 'justify-content-center');

    // Crea un contenedor de columna (col) con clases de Bootstrap para la paginación
    const colContainer = document.createElement('div');
    colContainer.classList.add('col-xxl'); // Ajusta el ancho de la columna según tus necesidades

    // Crea el componente de paginación de Bootstrap
    const pagination = document.createElement('ul');
    pagination.classList.add('pagination');

    // Crea el botón "Anterior"
    const previousBtn = document.createElement('li');
    previousBtn.classList.add('page-item');
    const previousLink = document.createElement('a');
    previousLink.classList.add('page-link');
    previousLink.href = '#';
    previousLink.textContent = 'Anterior';
    previousLink.addEventListener('click', () => {
        if (startIndex > 0) {
            startIndex -= pageSize;
            mostrarPagina(data, startIndex, pageSize);
        }
    });
    previousBtn.appendChild(previousLink);
    pagination.appendChild(previousBtn);

    // Crea los botones de número de página
    for (let i = 1; i <= totalPages; i++) {
        const pageBtn = document.createElement('li');
        pageBtn.classList.add('page-item');
        const pageLink = document.createElement('a');
        pageLink.classList.add('page-link');
        pageLink.href = '#';
        pageLink.textContent = i;
        pageLink.addEventListener('click', () => {
            startIndex = (i - 1) * pageSize;
            mostrarPagina(data, startIndex, pageSize);
        });
        pageBtn.appendChild(pageLink);
        pagination.appendChild(pageBtn);
    }

    // Crea el botón "Siguiente"
    const nextBtn = document.createElement('li');
    nextBtn.classList.add('page-item');
    const nextLink = document.createElement('a');
    nextLink.classList.add('page-link');
    nextLink.href = '#';
    nextLink.textContent = 'Siguiente';
    nextLink.addEventListener('click', () => {
        if (startIndex + pageSize < data.length) {
            startIndex += pageSize;
            mostrarPagina(data, startIndex, pageSize);
        }
    });
    nextBtn.appendChild(nextLink);
    pagination.appendChild(nextBtn);

    colContainer.appendChild(pagination);

    // Agrega el contenedor de columna al contenedor de fila
    rowContainer.appendChild(colContainer);

    // Limpia el contenido existente y agrega la estructura al contenedor de paginación
    paginacionContainer.innerHTML = '';
    paginacionContainer.appendChild(rowContainer);
}

function modificarUsuarios(originalData, modifiedData) {
    console.log(originalData);
    console.log(modifiedData);

    const dataToSave = {};
    dataToSave['UserID'] = originalData['UserID'];

    // Filtra los campos que han cambiado
    const modifiedFields = Object.keys(modifiedData).filter(key => {
        const originalValue = originalData[key];
        const modifiedValue = modifiedData[key];

        // Maneja el caso cuando el valor original es null
        if (originalValue === null) {
            // Solo considera como modificado si el valor modificado no es una cadena vacía
            return modifiedValue !== '';
        }

        // Maneja el caso cuando el valor es un número y el modificado es una cadena
        if (typeof originalValue === 'number' && typeof modifiedValue === 'string') {
            return originalValue.toString() !== modifiedValue;
        }

        // Maneja el caso cuando el valor es una cadena y el modificado es un número
        if (typeof originalValue === 'string' && typeof modifiedValue === 'number') {
            return originalValue !== modifiedValue.toString();
        }

        // Resto de los casos
        return originalValue !== modifiedValue;
    });

    if (modifiedFields.length === 0) {
        // No hay cambios, puedes manejarlo como desees
        console.log('No hay cambios para guardar.');
        return;
    }

    // Construye un objeto con los campos modificados
    modifiedFields.forEach(field => {
        // Evita agregar el campo `password` si es una cadena vacía
        if (field !== 'password' || modifiedData[field] !== '') {
            dataToSave[field] = modifiedData[field];
        }
    });

    if ('password' in dataToSave && dataToSave['password'] === '') {
        // Elimina el campo `password` si es una cadena vacía
        delete dataToSave['password'];
    }

    let formData = new FormData();
    formData.append('action', 'modificarUsuarios');
    formData.append('modifiedData', JSON.stringify(dataToSave));

    // Llamada a la función para modificar usuarios
    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Maneja la respuesta del servidor si es necesario
            console.log(data);

            // Muestra el mensaje de éxito en la interfaz
            if (data.success) {
                alert('Usuarios actualizados correctamente');
            } else {
                alert('Error al actualizar usuarios: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
