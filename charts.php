<?php
// charts.php - Chart initialization and management
// This file contains all chart-related functionality
?>

<script>
  // charts.php - Chart initialization and management

  let bottleChart;
  let filteredLineChart = null;

  // Initialize Charts
  function initCharts() {
    try {
      initBottleChart();
    } catch (error) {
      console.error('Error creating charts:', error);
    }
  }

  // Initialize bottle breakdown chart (Plastic Type Breakdown)
  function initBottleChart() {
    try {
      const bottleCtx = document.getElementById('bottleChart');
      if (bottleCtx) {
        bottleChart = new Chart(bottleCtx.getContext('2d'), {
          type: 'doughnut',
          data: {
            labels: ['PET', 'HDPE', 'LDPE', 'PP', 'Unclassified'],
            datasets: [{
              data: [450, 320, 280, 150, 47],
              backgroundColor: [
                '#ffff00',  // Yellow for PET
                '#FFA500',  // Orange for HDPE
                '#008000',  // Green for LDPE
                '#808080',  // Gray for PP
                '#0000FF'   // Blue for Unclassified
              ],
              borderColor: '#fff',
              borderWidth: 3,
              hoverOffset: 15,
              hoverBackgroundColor: [
                '#ffff33',
                '#ffb84d',
                '#00b300',
                '#999999',
                '#3333ff'
              ]
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  padding: 15,
                  font: {
                    size: 13,
                    weight: 600
                  },
                  color: '#004e44',
                  usePointStyle: true,
                  pointStyle: 'circle'
                }
              },
              tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleFont: {
                  size: 14,
                  weight: 700
                },
                bodyFont: {
                  size: 13,
                  weight: 600
                },
                padding: 12,
                cornerRadius: 8,
                displayColors: true,
                borderColor: 'rgba(0, 0, 0, 0.2)',
                borderWidth: 1,
                callbacks: {
                  label: function(context) {
                    const label = context.label || '';
                    const value = context.parsed || 0;
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = ((value / total) * 100).toFixed(1);
                    return label + ': ' + value.toLocaleString() + ' bottles (' + percentage + '%)';
                  }
                }
              }
            }
          }
        });
      }
    } catch (error) {
      console.error('Error creating bottle chart:', error);
    }
  }

  // Update bottle breakdown chart with new time range
  function updateBottleChart(range) {
    if (!bottleChart) return;
    
    // Generate random data based on time range
    const multiplier = range === 'today' ? 1 : (range === 'weekly' ? 7 : 30);
    
    // Base distribution percentages (approximate realistic ratios)
    const petBase = Math.floor((Math.random() * 100 + 350) * multiplier);
    const hdpeBase = Math.floor((Math.random() * 80 + 250) * multiplier);
    const ldpeBase = Math.floor((Math.random() * 70 + 220) * multiplier);
    const ppBase = Math.floor((Math.random() * 50 + 120) * multiplier);
    const unclassifiedBase = Math.floor((Math.random() * 20 + 30) * multiplier);
    
    const newData = [petBase, hdpeBase, ldpeBase, ppBase, unclassifiedBase];
    
    bottleChart.data.datasets[0].data = newData;
    bottleChart.update('active');
  }

  // ==================== FILTERED LINE CHART FUNCTIONS ====================

  // Generate filtered data based on date range and bin type
  function generateFilteredData(startDate, endDate, binType) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    const daysDiff = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
    
    const labels = [];
    const datasets = [];
    
    // Generate date labels
    for (let i = 0; i < daysDiff; i++) {
      const date = new Date(start);
      date.setDate(start.getDate() + i);
      labels.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
    }
    
    // Get bins to display
    const rows = document.querySelectorAll('tr[data-bin-id]');
    const binsToShow = [];
    
    rows.forEach(row => {
      const type = row.dataset.type;
      if (binType === 'all' || type === binType) {
        binsToShow.push({
          id: row.dataset.binId,
          type: type
        });
      }
    });
    
    // Color palette matching theme - shades of teal/green
    const colors = [
      { border: 'rgba(0, 78, 68, 1)', bg: 'rgba(0, 78, 68, 0.1)' },        // Dark Teal
      { border: 'rgba(0, 122, 110, 1)', bg: 'rgba(0, 122, 110, 0.1)' },    // Medium Teal
      { border: 'rgba(0, 150, 136, 1)', bg: 'rgba(0, 150, 136, 0.1)' },    // Light Teal
      { border: 'rgba(72, 177, 191, 1)', bg: 'rgba(72, 177, 191, 0.1)' },  // Blue-Teal
      { border: 'rgba(46, 125, 50, 1)', bg: 'rgba(46, 125, 50, 0.1)' }     // Forest Green
    ];
    
    // Generate data for each bin
    binsToShow.forEach((bin, index) => {
      const data = [];
      let currentLevel = Math.floor(Math.random() * 30) + 20; // Start between 20-50%
      
      for (let i = 0; i < daysDiff; i++) {
        // Simulate gradual filling with occasional emptying
        if (currentLevel >= 95 && Math.random() > 0.7) {
          currentLevel = Math.floor(Math.random() * 20) + 5; // Empty to 5-25%
        } else {
          currentLevel = Math.min(100, currentLevel + Math.floor(Math.random() * 15) + 5);
        }
        data.push(currentLevel);
      }
      
      const color = colors[index % colors.length];
      datasets.push({
        label: `${bin.type} Bin (ID: ${bin.id})`,
        data: data,
        borderColor: color.border,
        backgroundColor: color.bg,
        borderWidth: 3,
        tension: 0.4,
        fill: true,
        pointRadius: 5,
        pointHoverRadius: 7,
        pointBackgroundColor: color.border,
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: color.border,
        pointHoverBorderWidth: 3
      });
    });
    
    return { labels, datasets };
  }

  // Apply filter and display line chart
  function applyFilter() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const binType = document.getElementById('binType').value;
    
    if (!startDate || !endDate) {
      alert('Please select both start and end dates.');
      return;
    }
    
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    if (start > end) {
      alert('Start date must be before end date.');
      return;
    }
    
    // Generate and display chart
    const chartData = generateFilteredData(startDate, endDate, binType);
    
    // Update chart title
    const binTypeText = binType === 'all' ? 'All Bins' : `${binType} Bin`;
    const dateRange = `${start.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} - ${end.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
    document.getElementById('filteredChartTitle').textContent = `${binTypeText} Level Trends (${dateRange})`;
    
    // Show chart container
    const chartContainer = document.getElementById('filteredChartContainer');
    chartContainer.classList.add('active');
    
    // Destroy previous chart if exists
    if (filteredLineChart) {
      filteredLineChart.destroy();
    }
    
    // Create new chart
    const ctx = document.getElementById('filteredLineChart').getContext('2d');
    filteredLineChart = new Chart(ctx, {
      type: 'line',
      data: chartData,
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            display: true,
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 20,
              font: {
                size: 13,
                weight: '600',
                family: "'Open Sans', sans-serif"
              },
              color: '#004e44'
            }
          },
          tooltip: {
            mode: 'index',
            intersect: false,
            backgroundColor: 'rgba(0, 78, 68, 0.95)',
            titleFont: {
              size: 14,
              weight: 'bold',
              family: "'Open Sans', sans-serif"
            },
            bodyFont: {
              size: 13,
              family: "'Open Sans', sans-serif"
            },
            padding: 12,
            borderColor: 'rgba(0, 122, 110, 0.5)',
            borderWidth: 1,
            callbacks: {
              label: function(context) {
                return context.dataset.label + ': ' + context.parsed.y + '%';
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            ticks: {
              callback: function(value) {
                return value + '%';
              },
              font: {
                size: 12,
                family: "'Open Sans', sans-serif"
              },
              color: '#004e44'
            },
            grid: {
              color: 'rgba(0, 78, 68, 0.08)',
              drawBorder: false
            },
            title: {
              display: true,
              text: 'Fill Level (%)',
              font: {
                size: 14,
                weight: 'bold',
                family: "'Open Sans', sans-serif"
              },
              color: '#004e44',
              padding: { top: 10, bottom: 10 }
            }
          },
          x: {
            ticks: {
              font: {
                size: 11,
                family: "'Open Sans', sans-serif"
              },
              color: '#004e44',
              maxRotation: 45,
              minRotation: 45
            },
            grid: {
              color: 'rgba(0, 78, 68, 0.05)',
              drawBorder: false
            },
            title: {
              display: true,
              text: 'Date',
              font: {
                size: 14,
                weight: 'bold',
                family: "'Open Sans', sans-serif"
              },
              color: '#004e44',
              padding: { top: 10, bottom: 0 }
            }
          }
        },
        interaction: {
          mode: 'nearest',
          axis: 'x',
          intersect: false
        }
      }
    });
    
    // Scroll to chart
    setTimeout(() => {
      chartContainer.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'nearest' 
      });
    }, 100);
  }

  // ==================== CHART CLEANUP ====================

  // Destroy charts (if needed for cleanup)
  function destroyCharts() {
    if (bottleChart) {
      bottleChart.destroy();
      bottleChart = null;
    }
    if (filteredLineChart) {
      filteredLineChart.destroy();
      filteredLineChart = null;
    }
  }

  // ==================== AUTO-UPDATE ====================

  // Auto-update chart data every minute to reflect real-time changes
  setInterval(() => {
    if (bottleChart && currentTimeRange) {
      // Slightly adjust the data to simulate real-time updates
      const currentData = bottleChart.data.datasets[0].data;
      const newData = currentData.map(value => {
        const change = Math.floor(Math.random() * 21) - 10; // Random change between -10 and +10
        return Math.max(0, value + change); // Ensure non-negative
      });
      
      bottleChart.data.datasets[0].data = newData;
      bottleChart.update('none'); // Update without animation for smoother real-time feel
    }
  }, 60000); // Update every minute
</script>