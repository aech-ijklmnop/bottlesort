<?php // admin-dashboard.php
require_once 'auth-check.php'; // <-- ADD THIS LINE

$admin_username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';

// Bin Simulation
$bins = [
  ['id'=>1,'type'=>'PET','level'=>95],
  ['id'=>2,'type'=>'HDPE','level'=>50],
  ['id'=>3,'type'=>'LDPE','level'=>90],
  ['id'=>4,'type'=>'PP','level'=>30],
  ['id'=>5,'type'=>'Unclassified','level'=>100]
];

// Calculate stats
$total_bins = count($bins);
$full_bins = array_filter($bins, function($bin) {
  return $bin['level'] >= 95;
});
$full_bins_count = count($full_bins);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | BottleSort</title>
  <link rel="icon" type="image/svg+xml" href="img/logo8.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  
  <!-- Main CSS - ADDED THIS -->
  <link rel="stylesheet" href="css/style.css">
  
  <style>
    /* ---------------------- GLOBAL ---------------------- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    html {
      scroll-behavior: smooth;
      overflow-y: scroll !important; /* FORCE SCROLLBAR */
    }
    body {
      font-family: 'Open Sans', sans-serif;
      color: #004e44;
      position: relative;
      overflow-x: hidden;
      overflow-y: auto;
      min-height: 100vh;
      background: linear-gradient(to right, #f9faf9 0%, #f5f8f6 50%, #f9faf9 100%);
      background-attachment: fixed;
      display: flex;
      flex-direction: column;
    }
    body::after {
      content: "";
      position: fixed;
      top: 0;
      right: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 0;
      background: url('img/bg.png') center center / cover no-repeat;
      opacity: 1;
      transition: opacity 0.4s ease-in-out;
    }

    /* REMOVED ALL NAVBAR STYLES - Will use styles from style.css */

    /* Mobile Menu */
    .menu-toggle {
      display: none;
      flex-direction: column;
      gap: 5px;
      cursor: pointer;
      padding: 8px;
      border-radius: 5px;
      transition: background 0.3s ease;
    }
    .menu-toggle:hover {
      background: rgba(255, 255, 255, 0.1);
    }
    .menu-toggle span {
      width: 28px;
      height: 3px;
      background: white;
      border-radius: 3px;
      transition: all 0.3s ease;
    }

    /* ---------------------- DASHBOARD ---------------------- */
    .dashboard-container {
      flex: 1;
      padding: 2rem 6%;
      max-width: 1400px;
      margin: 0 auto;
      width: 100%;
      position: relative;
      z-index: 1;
    }

    /* Dashboard Header */
    .dashboard-header {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      margin-bottom: 2.5rem;
      gap: 0.5rem;
      text-align: center;
    }
    .dashboard-title {
      color: white;
      font-size: 1.8rem;
      font-weight: 700;
      text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .dashboard-welcome {
      color: white;
      font-size: 3.5rem;
      font-weight: 800;
      text-shadow: 0 3px 6px rgba(0,0,0,0.3);
      display: flex;
      align-items: center;
      gap: 0.5rem;
      margin-top: 1rem;
    }

    /* Statistics Cards - Side by Side */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
      margin-bottom: 2.5rem;
    }
    .stat-card {
      background: rgba(255, 255, 255, 0.12);
      color: #ffffff;
      padding: 2.2rem;
      border-radius: 12px;
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      border: 1px solid rgba(255,255,255,0.15);
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      cursor: pointer;
    }
    .stat-card:hover {
      transform: translateY(-5px);
      background: rgba(255,255,255,0.22);
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }
    .stat-card:active {
      transform: scale(0.98);
    }
    .stat-card h3 {
      color: #ffffff;
      font-size: 0.95rem;
      margin-bottom: 0.8rem;
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .stat-card .stat-value {
      font-size: 4rem;
      font-weight: 800;
      color: #ffffff;
      margin: 0.5rem 0;
      line-height: 1;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .stat-card .stat-label {
      font-size: 1rem;
      color: #d9fff2;
      margin-top: 0.8rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .stat-card .stat-date {
      font-size: 0.85rem;
      color: #d9fff2;
      margin-top: 0.5rem;
      font-style: italic;
    }

    /* Time Range Selector */
    .time-range-selector {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
      margin-top: 1rem;
    }
    .time-range-btn {
      padding: 0.4rem 1rem;
      background: rgba(255, 255, 255, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 6px;
      cursor: pointer;
      font-size: 0.85rem;
      font-weight: 600;
      transition: all 0.3s ease;
      color: #ffffff;
    }
    .time-range-btn.active {
      background: rgba(255, 255, 255, 0.4);
      color: #004e44;
      font-weight: 700;
    }
    .time-range-btn:hover {
      background: rgba(255, 255, 255, 0.35);
    }

    /* Charts Section */
    .charts-section {
      display: grid;
      grid-template-columns: 1fr;
      gap: 2rem;
      margin-bottom: 2.5rem;
    }
    .chart-container {
      background: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      border: 1px solid rgba(0, 78, 68, 0.1);
    }
    .chart-container h3 {
      color: #004e44;
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 1.2rem;
      font-weight: 700;
    }
    .chart-container canvas {
      max-height: 350px;
    }

    /* Filter Section */
    .filter-section {
      background: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      margin-bottom: 2.5rem;
      border: 1px solid rgba(0, 78, 68, 0.1);
    }
    .filter-section h2 {
      color: #004e44;
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 1.4rem;
      font-weight: 700;
    }
    .filter-controls {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      align-items: flex-end;
    }
    .filter-group {
      flex: 1;
      min-width: 200px;
    }
    .filter-group label {
      display: block;
      color: #004e44;
      font-weight: 600;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
    }
    .filter-group input, .filter-group select {
      width: 100%;
      padding: 0.75rem;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-family: 'Open Sans', sans-serif;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    .filter-group input:focus, .filter-group select:focus {
      outline: none;
      border-color: #004e44;
      box-shadow: 0 0 0 3px rgba(0, 78, 68, 0.1);
    }

    /* Filtered Chart Container */
    .filtered-chart-container {
      margin-top: 2rem;
      padding-top: 2rem;
      border-top: 2px solid rgba(0, 78, 68, 0.1);
      display: none;
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s ease;
    }
    .filtered-chart-container.active {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }
    .filtered-chart-container h3 {
      color: #004e44;
      margin-bottom: 1.5rem;
      text-align: center;
      font-size: 1.2rem;
      font-weight: 700;
    }
    .filtered-chart-container canvas {
      max-height: 500px;
      min-height: 400px;
    }

    /* Buttons */
    .btn {
      padding: 0.75rem 1.8rem;
      background: linear-gradient(135deg, #004e44 0%, #007a6e 100%);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-family: 'Open Sans', sans-serif;
      transition: all 0.3s ease;
      font-size: 1rem;
      box-shadow: 0 2px 8px rgba(0, 78, 68, 0.2);
    }
    .btn:hover {
      background: linear-gradient(135deg, #007a6e 0%, #009688 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 78, 68, 0.3);
    }
    .btn-secondary {
      background: linear-gradient(135deg, #48B1BF 0%, #3a8f9c 100%);
    }
    .btn-secondary:hover {
      background: linear-gradient(135deg, #3a8f9c 0%, #2d7380 100%);
    }
    .btn-small {
      padding: 0.5rem 1rem;
      font-size: 0.85rem;
    }
    .btn-small:disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
    .btn-small:disabled:hover {
      transform: none;
    }
    .btn-signout {
      background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%) !important;
    }
    .btn-signout:hover {
      background: linear-gradient(135deg, #c0392b 0%, #a93226 100%) !important;
    }

    /* Table Section */
    .table-section {
      background: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      margin-bottom: 2.5rem;
      overflow-x: auto;
      border: 1px solid rgba(0, 78, 68, 0.1);
    }
    .table-section h2 {
      color: #004e44;
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 1.4rem;
      font-weight: 700;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 8px;
      overflow: hidden;
    }
    th, td {
      padding: 1rem;
      text-align: center;
      border-bottom: 1px solid #e0e0e0;
    }
    th {
      background: linear-gradient(135deg, #004e44 0%, #007a6e 100%);
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      letter-spacing: 0.5px;
    }
    tbody tr {
      transition: background 0.2s ease;
    }
    tbody tr:hover {
      background: #f0f8f7;
    }
    tbody tr:last-child td {
      border-bottom: none;
    }
    .status-full {
      color: #e74c3c;
      font-weight: bold;
    }
    .status-ok {
      color: #2ecc71;
      font-weight: bold;
    }
    .status-warning {
      color: #f39c12;
      font-weight: bold;
    }
    .progress-container {
      background: #eee;
      border-radius: 12px;
      overflow: hidden;
      height: 26px;
      width: 100%;
      position: relative;
    }
    .progress-bar {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 0.85rem;
      transition: width 1s ease;
      border-radius: 12px;
    }
    .action-buttons {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.6);
      z-index: 2000;
      animation: fadeIn 0.3s ease;
    }
    .modal.active {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: white;
      padding: 2.5rem;
      border-radius: 16px;
      max-width: 500px;
      width: 90%;
      box-shadow: 0 10px 40px rgba(0,0,0,0.3);
      animation: slideUp 0.3s ease;
    }
    .modal-content h2 {
      color: #004e44;
      margin-bottom: 1.5rem;
      font-size: 1.6rem;
      text-align: center;
    }
    .modal-content .detail-row {
      display: flex;
      justify-content: space-between;
      padding: 0.8rem 0;
      border-bottom: 1px solid #e0e0e0;
    }
    .modal-content .detail-row:last-child {
      border-bottom: none;
    }
    .modal-content .detail-label {
      font-weight: 600;
      color: #004e44;
    }
    .modal-content .detail-value {
      color: #666;
    }

    /* Subtle Notification Banner */
    #popup {
      position: fixed;
      top: 80px;
      right: 20px;
      background: rgba(255, 255, 255, 0.95);
      padding: 1.2rem 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 78, 68, 0.15);
      text-align: left;
      z-index: 3000;
      max-width: 400px;
      width: 90%;
      display: none;
      border-left: 4px solid #007a6e;
      animation: slideInRight 0.4s ease forwards;
    }
    #popup h2 {
      color: #004e44;
      margin-bottom: 0.8rem;
      font-size: 1.1rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    #popup h2::before {
      content: "⚠️";
      font-size: 1.3rem;
    }
    #popup p {
      color: #666;
      margin-bottom: 0.8rem;
      font-size: 0.9rem;
    }
    #popup ul {
      list-style: none;
      margin: 0.5rem 0 1rem 0;
      padding: 0;
    }
    #popup ul li {
      margin: 0.4rem 0;
      font-weight: 600;
      color: #007a6e;
      padding: 0.5rem;
      background: rgba(0, 122, 110, 0.05);
      border-radius: 6px;
      font-size: 0.9rem;
    }
    #popup button {
      width: 100%;
      padding: 0.6rem;
      background: #004e44;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.9rem;
      transition: all 0.3s ease;
    }
    #popup button:hover {
      background: #007a6e;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    @keyframes slideUp {
      from { transform: translateY(50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideInRight {
      from { opacity: 0; transform: translateX(100px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* ---------------------- RESPONSIVE ---------------------- */
    @media (max-width: 1100px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 900px) {
      body::after { display: none; }
      .menu-toggle { display: flex; order: 2; margin-left: auto; }
      .nav-left { order: 1; }
      .nav-right { order: 3; width: 100%; justify-content: center; margin-top: 0.5rem; }
      .nav-center { order: 4; width: 100%; flex-direction: column; gap: 0.5rem; max-height: 0; overflow: hidden; opacity: 0; transition: all 0.3s ease; padding: 0; }
      .nav-center.active { max-height: 500px; opacity: 1; padding: 1rem 0; }
      .nav-center a, .nav-right a { margin: 0; width: 100%; justify-content: center; }
    }

    @media (max-width: 768px) {
      .dashboard-container { padding: 2rem 4%; }
      .dashboard-title { font-size: 1.4rem; }
      .dashboard-welcome { font-size: 2.5rem; }
      .stat-card .stat-value { font-size: 3rem; }
      .filter-controls { flex-direction: column; }
      .filter-group { width: 100%; }
      .stats-grid { grid-template-columns: 1fr; }
      table { font-size: 0.85rem; }
      th, td { padding: 0.7rem 0.4rem; }
      .action-buttons { flex-direction: column; }
      .time-range-selector { flex-wrap: wrap; }
      #popup { top: 70px; right: 10px; left: 10px; width: auto; }
    }
  </style>
</head>
<body>
  <?php include 'navbar-admin.php'; ?>

  <!-- MAIN CONTENT WRAPPER - ADDED THIS -->
  <main>
    <div class="dashboard-container">
      <!-- Dashboard Header -->
      <div class="dashboard-header">
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <div class="dashboard-welcome">
          Welcome, <strong><?= htmlspecialchars($admin_username) ?>!</strong>
        </div>
      </div>

      <!-- Statistics Cards - Side by Side -->
      <div class="stats-grid">
        <div class="stat-card" onclick="scrollToBinMonitoring()" title="Click to view bin monitoring">
          <h3>Full Bins</h3>
          <div class="stat-value" id="fullBinsCount"><?= $full_bins_count ?></div>
          <div class="stat-label">Needs Attention</div>
        </div>

        <div class="stat-card" onclick="scrollToPlasticBreakdown()" title="Click to view plastic breakdown">
          <h3>Total Bottles</h3>
          <div class="stat-value" id="totalBottles">1,247</div>
          <div class="stat-label" id="bottleTimeRange">Collected Today</div>
          <div class="stat-date" id="bottleTimeDate"></div>
          <div class="time-range-selector">
            <button class="time-range-btn active" onclick="changeTimeRange('today'); event.stopPropagation();">Today</button>
            <button class="time-range-btn" onclick="changeTimeRange('weekly'); event.stopPropagation();">Weekly</button>
            <button class="time-range-btn" onclick="changeTimeRange('monthly'); event.stopPropagation();">Monthly</button>
          </div>
        </div>
      </div>

      <!-- Charts Section - Plastic Type Breakdown -->
      <div class="charts-section">
        <div class="chart-container" id="plasticBreakdownSection">
          <h3>Plastic Type Breakdown</h3>
          <canvas id="bottleChart"></canvas>
        </div>
      </div>

      <!-- Table Section -->
      <div class="table-section" id="binMonitoringSection">
        <h2>Real-Time Bin Monitoring</h2>
        <table>
          <thead>
            <tr>
              <th>Bin ID</th>
              <th>Type</th>
              <th>Level (%)</th>
              <th>Status</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="binTableBody">
            <?php foreach($bins as $bin):
              $statusClass = ($bin['level'] >= 95) ? 'status-full' : (($bin['level'] >= 70) ? 'status-warning' : 'status-ok');
              $statusText = ($bin['level'] >= 95) ? 'FULL' : (($bin['level'] >= 70) ? 'HIGH' : 'OK');
              $progressColor = ($bin['level'] >= 95) ? '#e74c3c' : (($bin['level'] >= 70) ? '#f39c12' : '#2ecc71');
            ?>
            <tr data-bin-id="<?= $bin['id'] ?>" data-level="<?= $bin['level'] ?>" data-type="<?= $bin['type'] ?>" data-updated="">
              <td><?= $bin['id'] ?></td>
              <td><strong><?= $bin['type'] ?></strong></td>
              <td>
                <div class="progress-container">
                  <div class="progress-bar" style="background:<?= $progressColor ?>; width:<?= $bin['level'] ?>%;"><?= $bin['level'] ?>%</div>
                </div>
              </td>
              <td class="<?= $statusClass ?>"><?= $statusText ?></td>
              <td class="timestamp">Loading...</td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-small" onclick="viewDetails(<?= $bin['id'] ?>)">Details</button>
                  <button class="btn btn-small btn-secondary" onclick="emptyBin(<?= $bin['id'] ?>)" id="empty-btn-<?= $bin['id'] ?>">Empty</button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Filter Section -->
      <div class="filter-section">
        <h2>Data Filter & Export</h2>
        <div class="filter-controls">
          <div class="filter-group">
            <label for="startDate">Start Date</label>
            <input type="date" id="startDate">
          </div>
          <div class="filter-group">
            <label for="endDate">End Date</label>
            <input type="date" id="endDate">
          </div>
          <div class="filter-group">
            <label for="binType">Bin Type</label>
            <select id="binType">
              <option value="all">All Types</option>
              <option value="PET">PET</option>
              <option value="HDPE">HDPE</option>
              <option value="LDPE">LDPE</option>
              <option value="PP">PP</option>
              <option value="Unclassified">Unclassified</option>
            </select>
          </div>
          <button class="btn" onclick="applyFilter()">Apply Filter</button>
          <button class="btn btn-secondary" onclick="exportCSV()">Export CSV</button>
        </div>
        
        <!-- Filtered Data Chart -->
        <div class="filtered-chart-container" id="filteredChartContainer">
          <h3 id="filteredChartTitle">Bin Level Trends</h3>
          <canvas id="filteredLineChart"></canvas>
        </div>
      </div>
    </div>
  </main>
  <!-- END MAIN WRAPPER -->

  <!-- Details Modal -->
  <div id="detailsModal" class="modal">
    <div class="modal-content">
      <h2>Bin Details</h2>
      <div id="modalDetails"></div>
      <button class="btn" style="margin-top: 1.5rem; width: 100%;" onclick="closeModal()">Close</button>
    </div>
  </div>

  <!-- Subtle Notification Banner -->
  <div id="popup">
    <h2>Bin Alert</h2>
    <p>The following bins require attention:</p>
    <ul id="popup-list"></ul>
    <button onclick="closePopup()">Dismiss</button>
  </div>

  <!-- Sign Out Warning Modal -->
  <div id="signOutModal" class="modal">
    <div class="modal-content">
      <h2>Sign Out Confirmation</h2>
      <p>Are you sure you want to sign out? You will need to log in again to access the admin dashboard.</p>
      <div style="display: flex; gap: 1rem; margin-top: 2rem; justify-content: center;">
        <button class="btn btn-signout" onclick="confirmSignOut()" style="width: 200px;">Yes, Sign Out</button>
        <button class="btn" onclick="closeSignOutModal()" style="width: 200px;">Cancel</button>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>

  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <?php include 'charts.php'; ?>
  <script>
    // Initialize AOS
    if (typeof AOS !== 'undefined') {
      AOS.init({ duration: 800, once: true });
    }

    // Mobile Menu Toggle
    document.addEventListener('DOMContentLoaded', () => {
      const menuToggle = document.createElement('div');
      menuToggle.className = 'menu-toggle';
      menuToggle.innerHTML = '<span></span><span></span><span></span>';
      const nav = document.querySelector('nav');
      const navCenter = document.querySelector('.nav-center');
      if (nav && navCenter) {
        nav.insertBefore(menuToggle, navCenter);
        menuToggle.addEventListener('click', () => {
          navCenter.classList.toggle('active');
          menuToggle.classList.toggle('active');
        });
      }
      updateEmptyButtons();
    });

    // Scroll functions for stat cards
    function scrollToBinMonitoring() {
      const section = document.getElementById('binMonitoringSection');
      if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }

    function scrollToPlasticBreakdown() {
      const section = document.getElementById('plasticBreakdownSection');
      if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }

    // Sign out warning modal functions
    function showSignOutWarning() {
      document.getElementById('signOutModal').classList.add('active');
    }

    function closeSignOutModal() {
      document.getElementById('signOutModal').classList.remove('active');
    }

    function confirmSignOut() {
      closeSignOutModal();
      window.location.href = 'admin-login.php?logout=1';
    }

    // Bottle count time range
    let currentTimeRange = 'today';

    function getDateDisplay(range) {
      const now = new Date();
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      if (range === 'today') {
        return now.toLocaleDateString('en-US', options);
      } else if (range === 'weekly') {
        const weekStart = new Date(now);
        weekStart.setDate(now.getDate() - 6);
        const weekEnd = new Date(now);
        return `${weekStart.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${weekEnd.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
      } else if (range === 'monthly') {
        const monthStart = new Date(now);
        monthStart.setDate(now.getDate() - 29);
        const monthEnd = new Date(now);
        return `${monthStart.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${monthEnd.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
      }
      return '';
    }

    function changeTimeRange(range) {
      currentTimeRange = range;
      document.querySelectorAll('.time-range-btn').forEach(btn => btn.classList.remove('active'));
      event.target.classList.add('active');
      const labels = {
        today: 'Collected Today',
        weekly: 'Collected This Week',
        monthly: 'Collected This Month'
      };
      
      // Update bottle count
      const newCount = Math.floor(Math.random() * (range === 'today' ? 500 : range === 'weekly' ? 3000 : 10000)) + (range === 'today' ? 1000 : range === 'weekly' ? 5000 : 20000);
      document.getElementById('totalBottles').textContent = newCount.toLocaleString();
      document.getElementById('bottleTimeRange').textContent = labels[range];
      document.getElementById('bottleTimeDate').textContent = getDateDisplay(range);
      
      // Update chart
      if (typeof updateBottleChart === 'function') {
        updateBottleChart(range);
      }
    }

    // Initialize dates
    function initializeDates() {
      const today = new Date();
      const thirtyDaysAgo = new Date(today);
      thirtyDaysAgo.setDate(today.getDate() - 30);
      const startDateEl = document.getElementById('startDate');
      const endDateEl = document.getElementById('endDate');
      if (startDateEl && endDateEl) {
        endDateEl.valueAsDate = today;
        startDateEl.valueAsDate = thirtyDaysAgo;
      }
    }

    // Get current timestamp
    function getCurrentTimestamp() {
      const now = new Date();
      return `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')} ${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}:${String(now.getSeconds()).padStart(2, '0')}`;
    }

    // Initialize timestamps
    function initializeTimestamps() {
      const rows = document.querySelectorAll('tr[data-bin-id]');
      rows.forEach((row, index) => {
        const now = new Date();
        now.setMinutes(now.getMinutes() - (index * 5));
        const timestamp = formatTimestamp(now);
        row.dataset.updated = timestamp;
        const timestampEl = row.querySelector('.timestamp');
        if (timestampEl) {
          timestampEl.textContent = timestamp;
        }
      });
    }

    function formatTimestamp(date) {
      return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')} ${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}:${String(date.getSeconds()).padStart(2, '0')}`;
    }

    function updateEmptyButtons() {
      const rows = document.querySelectorAll('tr[data-bin-id]');
      rows.forEach(row => {
        const level = parseInt(row.dataset.level);
        const binId = row.dataset.binId;
        const emptyBtn = document.getElementById(`empty-btn-${binId}`);
        if (emptyBtn) {
          if (level < 95) {
            emptyBtn.disabled = true;
            emptyBtn.title = 'Bin must be full to empty';
          } else {
            emptyBtn.disabled = false;
            emptyBtn.title = '';
          }
        }
      });
    }

    function updateTable() {
      const rows = document.querySelectorAll('tr[data-bin-id]');
      const fullBins = [];
      let fullBinsCount = 0;
      
      rows.forEach(row => {
        let level = parseInt(row.dataset.level);
        let type = row.dataset.type;
        let binId = row.dataset.binId;

        let progressBar = row.querySelector('.progress-bar');
        if (progressBar) {
          progressBar.style.width = level + '%';
          progressBar.textContent = level + '%';
        }

        let statusCell = row.cells[3];
        let progressColor;
        if (level >= 95) {
          statusCell.textContent = 'FULL';
          statusCell.className = 'status-full';
          progressColor = '#e74c3c';
          fullBins.push(`${type} Bin (ID: ${binId})`);
          fullBinsCount++;
        } else if (level >= 70) {
          statusCell.textContent = 'HIGH';
          statusCell.className = 'status-warning';
          progressColor = '#f39c12';
        } else {
          statusCell.textContent = 'OK';
          statusCell.className = 'status-ok';
          progressColor = '#2ecc71';
        }

        if (progressBar) {
          progressBar.style.background = progressColor;
        }

        const timestampEl = row.querySelector('.timestamp');
        if (timestampEl && row.dataset.updated) {
          timestampEl.textContent = row.dataset.updated;
        }
      });

      // Update full bins count in stat card
      const fullBinsCountEl = document.getElementById('fullBinsCount');
      if (fullBinsCountEl) {
        fullBinsCountEl.textContent = fullBinsCount;
      }

      const popup = document.getElementById('popup');
      const popupList = document.getElementById('popup-list');
      if (popupList) {
        popupList.innerHTML = '';
        if (fullBins.length > 0) {
          fullBins.forEach(bin => {
            let li = document.createElement('li');
            li.textContent = bin;
            popupList.appendChild(li);
          });
          if (popup && popup.style.display !== 'block') {
            popup.style.display = 'block';
            setTimeout(() => { closePopup(); }, 15000);
          }
        } else {
          if (popup) popup.style.display = 'none';
        }
      }
      updateEmptyButtons();
    }

    // Update data every minute (60000ms)
    setInterval(() => {
      const rows = document.querySelectorAll('tr[data-bin-id]');
      rows.forEach(row => {
        let newLevel = Math.min(100, Math.max(0, parseInt(row.dataset.level) + Math.floor(Math.random() * 11 - 5)));
        row.dataset.level = newLevel;
        row.dataset.updated = getCurrentTimestamp();
      });
      updateTable();
      
      // Update bottle count slightly
      const currentBottles = parseInt(document.getElementById('totalBottles').textContent.replace(/,/g, ''));
      const newBottles = currentBottles + Math.floor(Math.random() * 20) - 5;
      document.getElementById('totalBottles').textContent = Math.max(0, newBottles).toLocaleString();
    }, 60000);

    function exportCSV() {
      const startDate = document.getElementById('startDate').value;
      const endDate = document.getElementById('endDate').value;
      const binType = document.getElementById('binType').value;
      if (!startDate || !endDate) {
        alert('Please select date range before exporting.');
        return;
      }
      let csvContent = "data:text/csv;charset=utf-8,Bin ID,Type,Level (%),Status,Last Updated\n";
      document.querySelectorAll('tr[data-bin-id]').forEach(row => {
        const rowType = row.dataset.type;
        if (binType === 'all' || rowType === binType) {
          let status = row.cells[3].textContent;
          csvContent += `${row.dataset.binId},${row.dataset.type},${row.dataset.level},${status},${row.dataset.updated}\n`;
        }
      });
      const filename = `bin_levels_${binType}_${startDate}_to_${endDate}.csv`;
      const encodedUri = encodeURI(csvContent);
      const link = document.createElement("a");
      link.setAttribute("href", encodedUri);
      link.setAttribute("download", filename);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }

    function viewDetails(binId) {
      const row = document.querySelector(`tr[data-bin-id="${binId}"]`);
      if (row) {
        const type = row.dataset.type;
        const level = row.dataset.level;
        const updated = row.dataset.updated;
        const status = row.cells[3].textContent;
        const detailsHTML = `
          <div class="detail-row">
            <span class="detail-label">Bin ID:</span>
            <span class="detail-value">${binId}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Type:</span>
            <span class="detail-value">${type}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Fill Level:</span>
            <span class="detail-value">${level}%</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Status:</span>
            <span class="detail-value">${status}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Last Updated:</span>
            <span class="detail-value">${updated}</span>
          </div>
        `;
        document.getElementById('modalDetails').innerHTML = detailsHTML;
        document.getElementById('detailsModal').classList.add('active');
      }
    }

    function closeModal() {
      document.getElementById('detailsModal').classList.remove('active');
    }

    document.getElementById('detailsModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeModal();
      }
    });

    function emptyBin(binId) {
      const row = document.querySelector(`tr[data-bin-id="${binId}"]`);
      if (row) {
        const level = parseInt(row.dataset.level);
        if (level < 95) {
          alert('This bin is not full yet. Bins can only be emptied when they reach 95% or more.');
          return;
        }
        if (confirm(`Are you sure you want to empty Bin #${binId}?`)) {
          row.dataset.level = 0;
          row.dataset.updated = getCurrentTimestamp();
          updateTable();
          alert(`Bin #${binId} has been emptied successfully!`);
        }
      }
    }

    function closePopup() {
      const popup = document.getElementById('popup');
      if (popup) popup.style.display = 'none';
    }

    // Initialize everything
    window.addEventListener('load', () => {
      initializeDates();
      initializeTimestamps();
      initCharts();
      updateTable();
      document.getElementById('bottleTimeDate').textContent = getDateDisplay('today');
    });
  
  </script>
</body>
</html>