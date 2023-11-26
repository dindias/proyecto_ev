function showTab(tabId) {
    // Oculta todas las pestañas primero
    var tabs = document.getElementsByClassName('tabContent');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }

    // Muestra la pestaña seleccionada
    document.getElementById(tabId).style.display = 'block';

    // Obtén todos los elementos li
    var liTabs = document.querySelectorAll(".nav .nav-item");
    // Recorre cada elemento li y elimina la clase active
    for (var i = 0; i < liTabs.length; i++) {
        liTabs[i].firstElementChild.classList.remove("active");
    }

    // Añade la clase active al tab actual (el que ha sido seleccionado)
    var activeTab = document.querySelector(".nav a[href='#" + tabId + "']");
    activeTab.classList.add("active");

    // Actualiza el hash en la URL sin recargar la página
    window.location.hash = tabId;
}

function showTabFromHash() {
    var hash = window.location.hash.replace('#', '');
    if (hash) {
        showTab(hash);
    }
}

document.addEventListener('DOMContentLoaded', showTabFromHash);
// Controlador para cambiar de pestaña cuando el hash de la URL cambia
window.addEventListener('hashchange', showTabFromHash);
//Modificación tabla usuarios


// Obtener datos del servidor (puedes cargarlos dinámicamente con AJAX)
document.addEventListener('DOMContentLoaded', function() {
    // Hacer la solicitud Fetch para obtener los datos de registro
    let formData = new FormData();
    formData.append('action', 'registroUsuarios');

    // Llamada a la función para obtener notificaciones no leídas
    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Crear el gráfico cuando se obtengan los datos
            console.log(data);
            renderChartRegistro(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
function renderChartRegistro(data) {
    // Configura los datos para el gráfico
    const chartData = data.map(item => ({
        x: parseInt(item.Fecha.split('-')[2]), // Obtén el día directamente
        y: item.Registrados,
    }));

    // Configuración del gráfico
    const config = {
        type: 'line',
        data: {
            datasets: [{
                label: 'Usuarios',
                data: chartData,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false,
            }],
        },
        options: {
            scales: {
                x: {
                    type: 'linear',
                    position: 'bottom',
                },
                y: {
                    type: 'linear',
                    position: 'left',
                },
            },
        },
    };

    // Obtén el contexto del lienzo
    const ctx = document.getElementById('registrationChart').getContext('2d');

    // Crea el gráfico
    const myChart = new Chart(ctx, config);
}

document.addEventListener('DOMContentLoaded', function() {
    // Hacer la solicitud Fetch para obtener los datos de registro
    let formData = new FormData();
    formData.append('action', 'contaminacionCoches');

    // Llamada a la función para obtener notificaciones no leídas
    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Crear el gráfico cuando se obtengan los datos
            console.log(data);
            renderChartContaminacion(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function renderChartContaminacion(data) {
    // Obtén los nombres de las marcas y los valores de contaminación promedio
    const labels = data.map(item => item.Marca);
    const contaminationValues = data.map(item => item.ContaminacionPromedio);

    // Configuración del gráfico
    const config = {
        type: 'polarArea',
        data: {
            labels: labels,
            datasets: [{
                label: 'Gramos de CO2 por Km',
                data: contaminationValues,
                backgroundColor: 'rgba(75, 192, 192, 0.5)', // Color de fondo de las barras
                borderColor: 'rgba(75, 192, 192, 1)', // Borde de las barras
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                x: {
                    stacked: true, // Apilar las barras en el eje x
                },
                y: {
                    stacked: true, // Apilar las barras en el eje y
                },
            },
        },
    };

    // Obtén el contexto del lienzo
    const ctx = document.getElementById('contaminationChart').getContext('2d');

    // Crea el gráfico
    new Chart(ctx, config);
}

document.addEventListener('DOMContentLoaded', function() {
    // Hacer la solicitud Fetch para obtener los datos de registro
    let formData = new FormData();
    formData.append('action', 'tiposCoche');

    // Llamada a la función para obtener notificaciones no leídas
    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Crear el gráfico cuando se obtengan los datos
            console.log(data);
            createCarsByTypeChart(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function getColorByType(type) {
    switch (type) {
        case 'Sedán':
            return 'rgb(255, 99, 132)';
        case 'SUV':
            return 'rgb(255, 205, 86)';
        case 'Deportivo':
            return 'rgb(75, 192, 192)';
        // Agrega colores para los otros tipos de coche
        case 'Compacto':
            return 'rgb(54, 162, 235)';
        case 'Híbrido':
            return 'rgb(153, 102, 255)';
        case 'Eléctrico':
            return 'rgb(255, 159, 64)';
        case 'Furgoneta':
            return 'rgb(255, 0, 0)';
        case 'Pickup':
            return 'rgb(0, 255, 0)';
        default:
            return 'rgb(0, 0, 0)'; // Color predeterminado en caso de tipo desconocido
    }
}

function createCarsByTypeChart(data) {
    const chartData = data.map(item => ({
        label: item.Tipo,
        data: item.TotalCoches,
        backgroundColor: getColorByType(item.Tipo),
    }));

    // Configuración del gráfico
    const config = {
        type: 'doughnut',
        data: {
            labels: chartData.map(item => item.label),
            datasets: [{
                data: chartData.map(item => item.data),
                backgroundColor: chartData.map(item => item.backgroundColor),
            }],
        },
    };

    // Obtén el contexto del lienzo
    const ctx = document.getElementById('tiposCocheChart').getContext('2d');

    // Crea el gráfico
    new Chart(ctx, config);
}

document.addEventListener('DOMContentLoaded', function() {
    // Hacer la solicitud Fetch para obtener los datos de registro
    let formData = new FormData();
    formData.append('action', 'evolucionReservas');

    // Llamada a la función para obtener notificaciones no leídas
    fetch('backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            // Crear el gráfico cuando se obtengan los datos
            console.log(data);
            renderChartReservas(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function renderChartReservas(data) {
    // Configura el gráfico
    const chartData = data.map(item => ({
        x: new Date(item.Mes),
        y: item.TotalReservas,
    }));

    const config = {
        type: 'bar',
        data: {
            datasets: [{
                label: 'Total de Reservas',
                data: chartData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: true,
            }],
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month',
                        displayFormats: {
                            month: 'MMM YYYY',
                        },
                    },
                    title: {
                        display: true,
                        text: 'Mes',
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total de Reservas',
                    },
                },
            },
        },
    };

    // Obtén el contexto del lienzo
    const ctx = document.getElementById('reservasChart').getContext('2d');

    // Crea el gráfico
    const myChart = new Chart(ctx, config);
}