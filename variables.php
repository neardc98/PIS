<?php
include 'conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['datos'])) {
    $datos = urldecode($_GET['datos']); 
    $valores = explode(',', $datos);

    if (count($valores) == 3) {
        $turbidez = $valores[0];
        $tds = $valores[1];
        $temperatura = $valores[2];
        $temperatura = substr($temperatura, 0, -2);

        $sql = "SELECT id FROM reportes ORDER BY id DESC LIMIT 1;";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $ultimoId = $row['id'];

            $updateSql = "UPDATE reportes SET estado = '0', turbidez = '$turbidez', tds = '$tds', temperatura = '$temperatura' WHERE id = $ultimoId;";

            if ($conn->query($updateSql) === TRUE) {
                echo "Estado del proceso actualizado correctamente";
            } else {
                echo "Error al actualizar el estado del proceso: " . $conn->error;
            }
        } else {
            echo "No se encontraron resultados en la consulta.";
        }
    } else {
        echo "Datos incompletos. Se esperaban 3 valores.";
    }
} else {
    echo "No se recibieron datos.";
}

$conn->close();
?>
