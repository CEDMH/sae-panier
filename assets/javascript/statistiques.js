// ============ DIAGRAMME EN BARRES ============ //
const Barres = document.getElementById('graphique-barres').getContext('2d');
new Chart(Barres, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Nombre de paniers',
            data: valeurs,
            backgroundColor: '#202632',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

// ============ CAMEMBERT ============ //
const Camembert = document.getElementById('graphique-camembert').getContext('2d');
new Chart(Camembert, {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            data: valeurs,
            backgroundColor: [
                '#202632', '#4a5568', '#718096',
                '#a0aec0', '#cbd5e0', '#e2e8f0'
            ],
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});