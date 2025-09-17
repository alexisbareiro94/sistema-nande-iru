import './bootstrap';
import Chart from 'chart.js/auto';

let myChart = null;

async function loadChart(desde = '', hasta = '', periodo = '') {
  try {
    const res = await fetch(`http://localhost:8080/api/movimientos/charts_caja?desde=${encodeURIComponent(desde)}&hasta=${encodeURIComponent(hasta)}&periodoInicio=${encodeURIComponent(periodo)}`);
    const data = await res.json();

    const ctx = document.getElementById('myChart');

    if (myChart) {
      myChart.destroy();  
    }

    myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.labels,
        datasets: [
          {
            label: 'Ingresos',
            data: data.ingresos,
            backgroundColor: 'rgba(0, 128, 0, 0.6)',
          },
          {
            label: 'Egresos',
            data: data.egresos,
            backgroundColor: 'rgba(255, 0, 0, 0.6)',
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
        },
        scales: {
          x: { stacked: false },
          y: { beginAtZero: true }
        }
      },
    });
  } catch (err) {
    console.log(err);
  }
}

loadChart('', '');

document.getElementById('dv-form-fecha').addEventListener('submit', async (e) => {
  e.preventDefault();
  const desde = document.getElementById('dv-fecha-desde').value;
  const hasta = document.getElementById('dv-fecha-hasta').value;
  const periodo = document.getElementById('dv-periodo').value;
  await loadChart(desde, hasta, periodo);
});


document.getElementById('confirmar-movimiento').addEventListener('click', () => {
  loadChart('', '');
})