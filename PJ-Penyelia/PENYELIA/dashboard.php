<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="dashboard/css/dashboard.css">
  </head>
  <body>
    <div class="grid-container">

      <!-- Main -->
      <main class="main-container">
        <div class="main-title">
          <h2>DASHBOARD</h2>
        </div>

        <div class="main-cards">

          <div class="card">
            <div class="card-inner">
              <h3>PRODUCTS</h3>
              <span class="material-icons-outlined">inventory_2</span>
            </div>
            <h1>249</h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>CATEGORIES</h3>
              <span class="material-icons-outlined">category</span>
            </div>
            <h1>25</h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>CUSTOMERS</h3>
              <span class="material-icons-outlined">groups</span>
            </div>
            <h1>1500</h1>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>ALERTS</h3>
              <span class="material-icons-outlined">notification_important</span>
            </div>
            <h1>56</h1>
          </div>

        </div>

        <div class="charts">

          <div class="charts-card">
            <h2 class="chart-title">Top 5 Products</h2>
            <div id="bar-chart"></div>
          </div>

          <div class="charts-card">
            <h2 class="chart-title">Purchase and Sales Orders</h2>
            <div id="area-chart"></div>
          </div>

        </div>
      </main>
      <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="dashboard/js/dashboard.js"></script>
  </body>
</html>
