<?php // analytics.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Analytics | BottleSort</title>
  <link rel="icon" type="image/png" href="img/logo8.png" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet" />
  <!-- AOS animation library -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <!-- Global CSS -->
  <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Open Sans', sans-serif;
      background: linear-gradient(135deg, #004e44 0%, #006d5b 100%);
    }
    /* ---------------------- HERO HEADER ---------------------- */
    .hero-header {
      position: relative;
      min-height: 40vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 7rem 2rem 5rem;
      color: #ffffff;
    }
    .hero-header h1 {
      font-size: 2.6rem; 
      color: #ffffff;
      margin-bottom: 1rem; 
      text-shadow: 0 2px 10px rgba(0,0,0,0.3); 
    }
    .hero-header p {
      max-width: 850px; 
      line-height: 1.7; 
      font-size: 1.1rem; 
      margin-bottom: 0.1rem; 
      color: #eafaf4; 
    }

    /* ---------------------- STATS CARD ---------------------- */
    .stats-card {
      background: rgba(255,255,255,0.12);
      border-radius: 12px;
      padding: 2rem;
      color: white;
      max-width: 900px;
      margin: 0.5rem auto;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.15);
      display: grid;
      grid-template-columns: 1fr 2fr 1fr;
      gap: 1rem;
      align-items: center;
    }
    
    .chart-buttons {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      justify-self: start;
    }
    
    .chart-buttons button {
      padding: 0.8rem 1.5rem;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      font-weight: 600;
      background: rgba(255,255,255,0.12);
      color: white;
      transition: background 0.2s ease, transform 0.1s ease;
      width: 100%;
      text-align: center;
    }
    
    .chart-buttons button:hover {
      background: rgba(255,255,255,0.4);
      transform: scale(1.05);
    }
    
    .chart-buttons button.active {
      background: white;
      color: #004e44;
    }
    
    .stat-box {
      text-align: center;
      justify-self: center;
    }
    
    .stat-box h3 {
      font-weight: 600;
      margin-bottom: 0.5rem;
      font-size: 1.2rem;
    }
    
    .stat-box p {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 0.25rem;
    }
    
    .stat-box small {
      font-size: 1rem;
    }
    
    .date-range {
      text-align: center;
      justify-self: end;
      min-width: 220px;
    }
    
    .date-range h4 {
      font-size: 1rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
      opacity: 0.8;
    }
    
    .date-range p {
      font-size: 1.1rem;
      line-height: 1.6;
      white-space: nowrap;
    }

    /* ---------------------- CHART CARD ---------------------- */
    section.chart-card {
      background: #ffffff !important;
      border-radius: 12px;
      padding: 2.5rem;
      color: #004e44 !important;
      max-width: 900px;
      margin: 2rem auto;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
      transition: all 0.3s ease;
    }
    section.chart-card h3 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #004e44 !important;
    }

    /* ---------------------- BIN STATUS CARD ---------------------- */
    .bin-status-card {
      background: #ffffff !important;
      border-radius: 12px;
      padding: 2.5rem;
      color: #004e44 !important;
      max-width: 900px;
      margin: 2rem auto 4rem auto;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-align: center;
      transition: all 0.3s ease;
    }
    .bin-status-card h3 {
      text-align: center;
      margin-bottom: 1.5rem;
      color: #004e44;
    }
    .bin-status-card table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      color: #004e44;
    }
    .bin-status-card th, .bin-status-card td {
      padding: 0.75rem;
      border-bottom: 1px solid rgba(0,78,68,0.2);
    }
    .bin-status-card th {
      background: rgba(0,78,68,0.1);
      font-weight: 600;
      color: #004e44;
    }
    tr:hover {
      background-color: rgba(0,78,68,0.05);
    }
    .status-empty {
      color: #2E8B57;
      font-weight: bold;
    }
    .status-half {
      color: #DAA520;
      font-weight: bold;
    }
    .status-full {
      color: #C0392B;
      font-weight: bold;
    }

    @media (max-width: 900px) {
      .hero-header h1 { font-size: 2.2rem; }
      .hero-header p { font-size: 1rem; }
      .stats-card, .chart-card, .bin-status-card {
        margin: 2rem 1rem;
        padding: 2rem 1rem;
      }
      .stats-card {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }
      .chart-buttons {
        justify-self: center;
        width: 100%;
        max-width: 300px;
      }
      .stat-box, .date-range {
        justify-self: center;
      }
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <!-- HERO HEADER -->
  <section class="hero-header" data-aos="fade-down">
    <h1>Plastic Bottle Classification Analytics</h1>
    <p>Track the number of plastic bottles thrown and see their type breakdown below.</p>
  </section>

  <!-- STATS + PERIOD BUTTONS -->
  <section class="stats-card" data-aos="fade-up">
    <!-- Left: Period Buttons -->
    <div class="chart-buttons">
      <button class="active" onclick="updateChart('today', this)">Today</button>
      <button onclick="updateChart('week', this)">This Week</button>
      <button onclick="updateChart('month', this)">This Month</button>
    </div>
    
    <!-- Middle: Main Stat -->
    <div class="stat-box" id="recycledBox">
      <h3>Recycled</h3>
      <p id="recycledCount">128</p>
      <small id="recycledPeriod">Today</small>
    </div>
    
    <!-- Right: Date Range -->
    <div class="date-range">
      <h4>Date Range</h4>
      <p id="dateRangeText"></p>
    </div>
  </section>

  <!-- CHART CARD -->
  <section class="chart-card" data-aos="fade-up">
    <h3>Plastic Type Breakdown</h3>
    <canvas id="plasticChart" width="600" height="350"></canvas>
  </section>

  <!-- BIN STATUS CARD -->
  <section class="bin-status-card" data-aos="fade-up">
    <h3>Bin Status</h3>
    <table>
      <thead>
        <tr>
          <th>Plastic Type</th>
          <th>Fill Level (%)</th>
          <th>Status</th>
          <th>Last Updated</th>
        </tr>
      </thead>
      <tbody id="binStatusTable"></tbody>
    </table>
  </section>

  <?php include 'footer.php'; ?>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true
    });

    const chartData = {
      today: [35, 45, 20, 15, 13],
      week: [200, 180, 100, 90, 50],
      month: [800, 750, 400, 300, 200]
    };

    const totalCounts = {
      today: 128,
      week: 620,
      month: 2450
    };

    const ctx = document.getElementById('plasticChart').getContext('2d');
    const plasticChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['PET', 'HDPE', 'LDPE', 'PP', 'Unclassified'],
        datasets: [{
          data: chartData.today,
          backgroundColor: ['#ffff00', '#FFA500', '#008000', '#808080', '#0000FF']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    function updateChart(period, button) {
      plasticChart.data.datasets[0].data = chartData[period];
      plasticChart.update();
      
      document.getElementById('recycledCount').textContent = totalCounts[period];
      document.getElementById('recycledPeriod').textContent = 
        period === 'today' ? 'Today' : 
        period === 'week' ? 'This Week' : 
        'This Month';
      
      // Update date range
      updateDateRange(period);
      
      document.querySelectorAll('.chart-buttons button').forEach(btn => 
        btn.classList.remove('active')
      );
      button.classList.add('active');
    }
    
    function updateDateRange(period) {
      const today = new Date();
      const options = { month: 'long', day: 'numeric', year: 'numeric' };
      let dateText = '';
      
      if (period === 'today') {
        dateText = today.toLocaleDateString('en-US', options);
      } else if (period === 'week') {
        const weekStart = new Date(today);
        weekStart.setDate(today.getDate() - 6);
        dateText = `${weekStart.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${today.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
      } else if (period === 'month') {
        const monthStart = new Date(today);
        monthStart.setDate(today.getDate() - 29);
        dateText = `${monthStart.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${today.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
      }
      
      document.getElementById('dateRangeText').textContent = dateText;
    }
    
    updateDateRange('today');

    const binData = [
      { type: "PET", level: 75 },
      { type: "HDPE", level: 45 },
      { type: "LDPE", level: 15 },
      { type: "PP", level: 90 },
      { type: "Unclassified", level: 10 }
    ];

    function getStatus(level) {
      if (level < 30) return '<span class="status-empty">Empty</span>';
      if (level < 70) return '<span class="status-half">Half-Full</span>';
      return '<span class="status-full">Full</span>';
    }

    function getCurrentDateTime() {
      const now = new Date();
      const year = now.getFullYear();
      const month = String(now.getMonth() + 1).padStart(2, '0');
      const day = String(now.getDate()).padStart(2, '0');
      const hours = String(now.getHours()).padStart(2, '0');
      const minutes = String(now.getMinutes()).padStart(2, '0');
      return `${year}-${month}-${day} ${hours}:${minutes}`;
    }

    function renderBinTable() {
      const currentDateTime = getCurrentDateTime();
      const tbody = document.getElementById('binStatusTable');
      tbody.innerHTML = binData.map(bin => `
        <tr>
          <td>${bin.type}</td>
          <td>${bin.level}%</td>
          <td>${getStatus(bin.level)}</td>
          <td>${currentDateTime}</td>
        </tr>
      `).join('');
    }

    // Initial render
    renderBinTable();
    
    // Update every 1 minute (60000 milliseconds)
    setInterval(() => {
      renderBinTable();
    }, 60000);
  </script>
</body>
</html>