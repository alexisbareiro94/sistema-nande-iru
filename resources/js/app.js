import Chart from 'chart.js/auto';
import './bootstrap';
import './reportes';
import './notificaciones';
import './gestion-user';
import './utils'
import './clients-dist';
import './componentes/clientes'
import './componentes/restablecer-pass'

// print();

// function print() {
//   const escpos = require('escpos');

//   // Usar driver USB
//   escpos.USB = require('escpos-usb');

//   // Crear el dispositivo
//   const device = new escpos.USB(); // detecta automáticamente la POS58
//   const printer = new escpos.Printer(device);

//   device.open(function () {
//     printer
//       .align('CT')
//       .text('=== Ticket de prueba ===')
//       .text('Producto 1   $1000')
//       .text('Producto 2   $500')
//       .text('--------------------')
//       .text('Total        $1500')
//       .cut()
//       .close();
//   });

// }

let myChart = null;
async function loadChart(desde = '', hasta = '', periodo = '') {
  try {
    const res = await fetch(`http://127.0.0.1:80/api/movimientos/charts_caja?desde=${encodeURIComponent(desde)}&hasta=${encodeURIComponent(hasta)}&periodoInicio=${encodeURIComponent(periodo)}`);
    const data = await res.json();
    const ctx = document.getElementById('myChart');

    if (myChart) {
      myChart.destroy();
    }
    if (!ctx) {
      return
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

document.addEventListener('DOMContentLoaded', () => {
  loadChart('', '');
})

if (document.getElementById('dv-form-fecha')) {
  document.getElementById('dv-form-fecha').addEventListener('submit', async (e) => {
    e.preventDefault();
    const desde = document.getElementById('dv-fecha-desde').value;
    const hasta = document.getElementById('dv-fecha-hasta').value;
    const periodo = document.getElementById('dv-periodo').value;
    await loadChart(desde, hasta, periodo);
  });
}

if (document.getElementById('confirmar-movimiento')) {
  document.getElementById('confirmar-movimiento').addEventListener('click', async () => {
    await loadChart('', '');
  })
}

if (document.getElementById('confirmar-venta')) {
  document.getElementById('confirmar-venta').addEventListener('click', () => {

    setTimeout(async () => {
      await loadChart('', '');
    }, 500);
  })
}


