// SIDEBAR TOGGLE

let sidebarOpen = false;
const sidebar = document.getElementById("sidebar");

function openSidebar() {
  if (!sidebarOpen) {
    sidebar.classList.add("sidebar-responsive");
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if (sidebarOpen) {
    sidebar.classList.remove("sidebar-responsive");
    sidebarOpen = false;
  }
}

// ---------- CHARTS ----------

// Fungsi untuk mendapatkan data dari PHP
async function fetchTotalKelas() {
  try {
    // Betulkan URL yang salah
    const response = await fetch("fetch-data.php");

    // Pastikan respons adalah berjaya (status kod 200-299)
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Tukar respons ke format JSON
    const data = await response.json();

    // Pulangkan nilai total_kelas dari data JSON tersebut
    return data.total_kelas;
  } catch (error) {
    console.error("Error fetching total kelas:", error);
    return 0; // Pulang nilai lalai jika ada ralat
  }
}

// Fungsi untuk menginisialisasi bar chart
async function initializeBarChart() {
  const totalKelas = await fetchTotalKelas();

  // Menggunakan total kelas dalam data grafik
  const barChartOptions = {
    series: [
      {
        data: [totalKelas, 8, 6, 4, 2], // Ganti 10 dengan nilai totalKelas
        name: "Products",
      },
    ],
    chart: {
      type: "bar",
      background: "transparent",
      height: 350,
      toolbar: {
        show: false,
      },
    },
    colors: ["#2962ff", "#d50000", "#2e7d32", "#ff6d00", "#583cb3"],
    plotOptions: {
      bar: {
        distributed: true,
        borderRadius: 4,
        horizontal: false,
        columnWidth: "40%",
      },
    },
    dataLabels: {
      enabled: false,
    },
    fill: {
      opacity: 1,
    },
    grid: {
      borderColor: "#55596e",
      yaxis: {
        lines: {
          show: true,
        },
      },
      xaxis: {
        lines: {
          show: true,
        },
      },
    },
    legend: {
      labels: {
        colors: "#f5f7ff",
      },
      show: true,
      position: "top",
    },
    stroke: {
      colors: ["transparent"],
      show: true,
      width: 2,
    },
    tooltip: {
      shared: true,
      intersect: false,
      theme: "dark",
    },
    xaxis: {
      categories: ["Laptop", "Phone", "Monitor", "Headphones", "Camera"],
      title: {
        style: {
          color: "#f5f7ff",
        },
      },
      axisBorder: {
        show: true,
        color: "#55596e",
      },
      axisTicks: {
        show: true,
        color: "#55596e",
      },
      labels: {
        style: {
          colors: "#f5f7ff",
        },
      },
    },
    yaxis: {
      title: {
        text: "Count",
        style: {
          color: "#f5f7ff",
        },
      },
      axisBorder: {
        color: "#55596e",
        show: true,
      },
      axisTicks: {
        color: "#55596e",
        show: true,
      },
      labels: {
        style: {
          colors: "#f5f7ff",
        },
      },
    },
  };

  const barChart = new ApexCharts(
    document.querySelector("#bar-chart"),
    barChartOptions
  );
  barChart.render();
}

// Panggil fungsi untuk menginisialisasi bar chart setelah halaman dimuat
document.addEventListener("DOMContentLoaded", () => {
  initializeBarChart();
});
