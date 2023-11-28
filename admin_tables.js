document.addEventListener('DOMContentLoaded', function () {
    // Inicializar la página con la pestaña activa actual
    const activeTab = document.querySelector('.nav-link.active');
    actualizarTabla(activeTab);

    // Agregar un manejador de clic a todas las pestañas
    const tabs = document.querySelectorAll('.nav-link');
    tabs.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault(); // Prevenir el comportamiento predeterminado del enlace
            actualizarTabla(this); // "this" hace referencia a la pestaña en la que se hizo clic
        });
    });
});

function actualizarTabla(tab) {
    const formData = new FormData();
    const action = obtenerActionSegunTab(tab.id);
    formData.append('action', action);

    // Llamada a la función para obtener notificaciones no leídas
    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Crear el gráfico cuando se obtengan los datos
            mostrarPagina(data, 0, 10, tab.id);
            llenarDropdown(data, tab.id);
            actualizarNombreColumna(data, tab.id); // Añadir esta llamada para actualizar el nombre de la columna
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Función para obtener la acción según la pestaña activa
function obtenerActionSegunTab(tabId) {
    switch (tabId) {
        case 'cochesTab':
            return 'tablaCoches';
        case 'favoritosTab':
            return 'tablaFavoritos';
        case 'reservasTab':
            return 'tablaReservas';
        case 'usuariosTab':
            return 'tablaUsuarios';
        default:
            return '';
    }
}

function actualizarNombreColumna(data, activeTab) {
    const tabName = activeTab.replace('Tab', ''); // Eliminar "Tab" del nombre de la pestaña
    const columnButtonId = `columnButton${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`;
    const columnButton = document.getElementById(columnButtonId);
    const columnNames = Object.keys(data[0]);
    const defaultColumnName = 'Columna'; // Nombre por defecto si no hay columnas

    if (columnNames.length > 0) {
        columnButton.textContent = columnNames[0]; // Establecer el primer nombre de columna por defecto
        llenarDropdown(data, activeTab);
    } else {
        columnButton.textContent = defaultColumnName;
    }
}


function llenarDropdown(data, activeTab) {
    const tabName = activeTab.charAt(0).toUpperCase() + activeTab.slice(1);
    const columnDropdownId = `columnDropdown${tabName}`.replace('Tab', '');
    const columnDropdown = document.getElementById(columnDropdownId) || document.createElement('ul');

    columnDropdown.id = columnDropdownId;
    columnDropdown.innerHTML = ''; // Limpiar elementos antiguos

    const columnButtonId = `columnButton${tabName}`.replace('Tab', '');
    const columnButton = document.getElementById(columnButtonId);
    const searchInputId = `searchInput${tabName.replace('Tab', '')}`;
    const searchInput = document.getElementById(searchInputId);

    // Obtener los nombres de las columnas
    const columnNames = Object.keys(data[0]);

    // Agregar elementos de lista al menú desplegable
    columnNames.forEach(columnName => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.classList.add('dropdown-item');
        a.href = '#';
        a.textContent = columnName;
        a.addEventListener('click', () => {
            // Cambiar el texto del botón al nombre de la columna seleccionada
            columnButton.textContent = columnName;
            // Llamar a la función de filtrado cuando se selecciona una nueva columna
            filtrarDatos(data, activeTab);
        });
        li.appendChild(a);
        columnDropdown.appendChild(li);
    });

    // Escuchar cambios en el input de búsqueda
    searchInput.addEventListener('input', () => {
        // Llamar a la función de filtrado cuando cambia el valor del input de búsqueda
        filtrarDatos(data, activeTab);
    });
}

function filtrarDatos(data, activeTab) {
    const tabName = activeTab.replace('Tab', '');
    const columnButtonId = `columnButton${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`;
    const searchInputId = `searchInput${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`;

    const selectedColumn = document.getElementById(columnButtonId).textContent;
    const inputValue = document.getElementById(searchInputId).value.toLowerCase();

    const filteredData = data.filter(rowData =>
        (rowData[selectedColumn] || '').toString().toLowerCase().includes(inputValue)
    );

    mostrarPagina(filteredData, 0, 10, activeTab);
}

function mostrarPagina(data, startIndex, pageSize, activeTab) {
    let tablaContainer;
    let columnButton;
    let searchInput;

    switch (activeTab) {
        case 'cochesTab':
            tablaContainer = document.getElementById('cochesTablaContainer');
            columnButton = document.getElementById('columnButtonCoches');
            searchInput = document.getElementById('searchInputCoches');
            break;
        case 'favoritosTab':
            tablaContainer = document.getElementById('favoritosTablaContainer');
            columnButton = document.getElementById('columnButtonFavoritos');
            searchInput = document.getElementById('searchInputFavoritos');
            break;
        case 'reservasTab':
            tablaContainer = document.getElementById('reservasTablaContainer');
            columnButton = document.getElementById('columnButtonReservas');
            searchInput = document.getElementById('searchInputReservas');
            break;
        case 'usuariosTab':
            tablaContainer = document.getElementById('usuariosTablaContainer');
            columnButton = document.getElementById('columnButtonUsuarios');
            searchInput = document.getElementById('searchInputUsuarios');
            break;
        default:
            // Manejo de caso no especificado
            console.error('Pestaña no reconocida:', activeTab);
            return;
    }

    // Obtén el nombre de la columna seleccionada
    let selectedColumn = columnButton.textContent;

    // Filtra los datos en función del valor introducido en el input y de la columna seleccionada
    const filteredData = data.filter(rowData => {
        const cellValue = (rowData[selectedColumn] || '').toString(); // Convertir a cadena, incluso si es null
        const inputValue = searchInput.value.toLowerCase();
        return cellValue.toLowerCase().includes(inputValue);
    });

    // Calcula el índice de finalización y extrae los datos filtrados
    const endIndex = startIndex + pageSize;
    const paginatedData = filteredData.slice(startIndex, endIndex);

    // Crear la tabla y el resto de la estructura
    const rowContainer = document.createElement('div');
    rowContainer.classList.add('row', 'justify-content-center');
    const colContainer = document.createElement('div');
    colContainer.classList.add('col-xxl');
    const table = document.createElement('table');
    table.classList.add('table');
    table.style.maxWidth = 'none';
    table.style.tableLayout = 'fixed';
    table.style.wordWrap = 'break-word';
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');

    // Crear las celdas del encabezado
    Object.keys(data[0]).forEach(columnName => {
        const th = document.createElement('th');
        th.scope = 'col';
        th.textContent = columnName;
        headerRow.appendChild(th);
    });

    // Agregar la columna de "Acciones"
    const accionesTh = document.createElement('th');
    accionesTh.scope = 'col';
    accionesTh.textContent = 'Acciones';
    headerRow.appendChild(accionesTh);
    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Crear el cuerpo de la tabla
    const tbody = document.createElement('tbody');
    paginatedData.forEach(rowData => {
        const row = document.createElement('tr');
        Object.entries(rowData).forEach(([key, value]) => {
            const td = document.createElement('td');
            if (key === 'UserID') {
                td.textContent = value;
            } else if (key === 'password') {
                td.textContent = '*****';
            } else {
                td.textContent = value;
            }
            row.appendChild(td);
        });

        // Agregar las celdas de "Acciones"
        const accionesTd = document.createElement('td');

            // Configuración específica para la pestaña de usuarios
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
            eliminarBtn.addEventListener('click', () => {
                // Lógica para eliminar la fila
                // ...
            });

            accionesTd.appendChild(editarBtn);
            accionesTd.appendChild(eliminarBtn);

        row.appendChild(accionesTd);
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    colContainer.appendChild(table);
    rowContainer.appendChild(colContainer);
    tablaContainer.innerHTML = '';
    tablaContainer.appendChild(rowContainer);

    // Agregar la paginación
    agregarPaginacion(filteredData, startIndex, pageSize, activeTab);
}

function agregarPaginacion(data, startIndex, pageSize, activeTab) {
    // Calcula el número total de páginas
    const totalPages = Math.ceil(data.length / pageSize);

    // Obtén el elemento donde se insertará la paginación
    const paginacionContainerTabId = `paginacion${activeTab.charAt(0).toUpperCase() + activeTab.slice(1)}`;
    const paginacionContainerId = paginacionContainerTabId.replace('Tab', '');
    const paginacionContainer = document.getElementById(paginacionContainerId);

    // Crea el contenedor de fila (row) con clases de Bootstrap
    const rowContainer = document.createElement('div');
    rowContainer.classList.add('row', 'justify-content-center');

    // Crea un contenedor de columna (col) con clases de Bootstrap para la paginación
    const colContainer = document.createElement('div');
    colContainer.classList.add('col-xxl'); // Ajusta el ancho de la columna según tus necesidades

    // Crea el componente de paginación de Bootstrap
    const pagination = document.createElement('ul');
    pagination.classList.add('pagination', 'justify-content-center');

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
            mostrarPagina(data, startIndex, pageSize, activeTab);
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
            mostrarPagina(data, startIndex, pageSize, activeTab);
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
            mostrarPagina(data, startIndex, pageSize, activeTab);
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
