<?php
include 'conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$sql = "SELECT estado FROM reportes ORDER BY id DESC LIMIT 1"; 

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['estado'];
} else {
    echo $row['estado'];
}

$conn->close();
?>
