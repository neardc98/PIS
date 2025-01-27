<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoreo de Contaminantes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="CSS/style-inicio.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h2>Visualización de Datos</h2>
        <div class="widgets">
            <button id="start-button" class="start-button" onclick="startMonitoring()">Iniciar</button>
        </div>
        <div class="widgets">
            <select name="sede" id="sede" class="start-button">
                <option value="0">Selecciona la Zona</option>
                <option value="1">Cdla El Recreo</option>
                <option value="2">Omaras Gonzales</option>
                <option value="3">Primavera II</option>
            </select>
        </div>
        
        <div class="widgets">
            <div class="widget">
                <h2>Turbidez</h2>
                <div id="chart-turbidez" class="chart"></div>
                <h4>Acción: <span id="status-turbidez" class="status"></span></h4>
            </div>
            <div class="widget">
                <h2>TDS</h2>
                <div id="chart-sdt" class="chart"></div>
                <h4>Acción: <span id="status-sdt" class="status"></span></h4>
            </div>
            <div class="widget">
                <h2>Temperatura</h2>
                <div id="chart-temperatura" class="chart"></div>
                <h4>Acción: <span id="status-temperatura" class="status"></span></h4>
            </div>
        </div>
    </div>

    <div id="loading-modal" class="modal">
        <div class="modal-content">
            <div class="loader"></div>
            <p>Cargando...</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="JS/inicio.js"></script>
</body>
</html>
