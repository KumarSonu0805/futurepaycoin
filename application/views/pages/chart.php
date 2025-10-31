<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Doughnut Chart — Chart.js</title>
  <style>
    body {
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #f7f7fb;
      margin: 0;
      overflow: hidden; /* ✅ prevents page from scrolling */
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(20, 20, 50, 0.06);
      width: 360px;
      height: 360px; /* ✅ fixed height */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    canvas {
      display: block;
      max-width: 100%;
      max-height: 240px; /* ✅ keeps chart inside the card */
    }

    .legend-row { display:flex;gap:8px;flex-wrap:wrap;margin-top:12px }
    .legend-item { display:flex;align-items:center;gap:8px;font-size:13px }
    .swatch { width:14px;height:14px;border-radius:3px }
  </style>
</head>
<body>
  <div class="card">
    <h2>Task Status</h2>
    <canvas id="statusDoughnut" width="320" height="320"></canvas>
    <div class="legend-row" id="legend"></div>
  </div>

  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  <script>
    // labels and data — only Complete and Pending
    const labels = ['Complete', 'Pending'];
    const values = [75, 25];

    // colors for the slices
    const colors = ['#22c55e', '#f59e0b'];

    // Create the doughnut chart
    const ctx = document.getElementById('statusDoughnut').getContext('2d');

    // plugin to draw total in the center
    const totalCenterPlugin = {
      id: 'totalCenter',
      afterDraw(chart) {
        const {ctx, chartArea: {top, right, bottom, left}} = chart;
        ctx.save();
        const total = chart.data.datasets[0].data.reduce((a,b) => a+b, 0);
        ctx.font = '600 18px system-ui';
        ctx.fillStyle = '#111827';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        const x = (left + right) / 2;
        const y = chart.chartArea.top + (chart.chartArea.bottom - chart.chartArea.top) / 2;
        ctx.fillText(total, x, y - 8);
        ctx.font = '13px system-ui';
        ctx.fillStyle = '#6b7280';
        ctx.fillText('Total', x, y + 14);
        ctx.restore();
      }
    };

    const myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: values,
          backgroundColor: colors,
          borderWidth: 0
        }]
      },
      options: {
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: { display: false },
          tooltip: { padding: 8 },
          datalabels: {
            color: '#fff',
            font: { weight: 'bold', size: 14 },
            formatter: (value, context) => `${value}%`
          }
        }
      },
      plugins: [ChartDataLabels, totalCenterPlugin]
    });

    // Build a custom legend below the chart
    const legendEl = document.getElementById('legend');
    labels.forEach((label, i) => {
      const item = document.createElement('div');
      item.className = 'legend-item';
      item.innerHTML = `<span class="swatch" style="background:${colors[i]}"></span><span>${label} — ${values[i]}%</span>`;
      legendEl.appendChild(item);
    });
  </script>
</body>
</html>
