<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

include 'conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT Fecha, Hora, Turbidez, TDS, Temperatura, nombre FROM reportes r JOIN sedes s ON r.id_sede = s.id WHERE estado = 0 ORDER BY Fecha DESC, Hora DESC";
$result = $conn->query($sql);

$reportes = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reportes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="CSS/reportes.css">
</head>

<body>
    <?php include './navbar.php'; ?>

    <div class="content">
        <h2>Historial del proceso de detección</h2>
        <div class="filter-container">
            <input type="date" id="filterDate" placeholder="Filtrar por fecha">
            <button onclick="filterTable()">Filtrar</button>
            <button class="refresh-button" onclick="resetTable()">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button onclick="printTable()"><i class="fa-solid fa-print"></i></button>
            <button onclick="exportToExcel()"><i class="fa-solid fa-file-excel"></i></button>
        </div>
        <div class="table-container">
            <table id="dataTable">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Turbidez (NTU)</th>
                        <th>TDS (mg/L)</th>
                        <th>Temperatura (°C)</th>
                        <th>Sede</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <button class="disabled" onclick="prevPage()" id="prevButton">Anterior</button>
            <button onclick="nextPage()" id="nextButton">Siguiente</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Detalle del proceso de detección</h2>
            <p id="modalDetails"></p>
            <p id="analysisResult" style="font-weight: bold;"></p>
        </div>
    </div>

    <script>
        const rowsPerPage = 15;
        let currentPage = 1;
        let data = <?php echo json_encode($reportes); ?>;
        let filteredData = data;
    </script>
    <script src="JS/reportes.js"></script>
</body>

</html>