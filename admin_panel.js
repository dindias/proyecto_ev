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
                label: 'Usuarios registrados',
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
                label: 'Contaminación Promedio por Marca',
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
