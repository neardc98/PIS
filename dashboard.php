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

$sql = "CALL ObtenerDatosPorSedes()";
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
    <title>Dashboard de Reportes</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="CSS/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include './navbar.php'; ?>
    <div class="content">
        <h2>Dashboard de Reportes</h2>

        <div class="widgets">
            <div class="widget">
                <canvas id="barChart"></canvas>
            </div>
            <div class="widget2">
                <canvas id="polarArea"></canvas>
            </div>
        </div>

        <div class="widgets">
            <div class="widget2">
                <canvas id="radarChart"></canvas>
            </div>
            <div class="widget">
                <canvas id="mixChart"></canvas>
            </div>
        </div>
    </div>


    <script>
        // Datos procesados en PHP
        const reportes = <?php echo json_encode($reportes); ?>;
    </script>
    <script src="JS/dashboard.js"></script>
</body>

</html>