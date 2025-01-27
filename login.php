<?php
session_start();

include 'conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$response = array('success' => false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    $sql = "SELECT nif, contrasena FROM usuario WHERE nif = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $input_username, $input_password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($username, $hashed_password);
        $stmt->fetch();
        $_SESSION['usuario'] = $username;
        $response['success'] = true;     
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
