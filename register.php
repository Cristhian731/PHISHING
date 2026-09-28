<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar si el correo ya existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $check->bind_param("s", $correo);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Guardamos mensaje en sesión para mostrarlo en login.php
        session_start();
        $_SESSION['error'] = "⚠️ El correo ya está registrado.";
        header("Location: login.php");
        exit();
    } else {
        // Insertar solo los campos que realmente tienes
        $sql = $conn->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
        $sql->bind_param("sss", $nombre, $correo, $password);

        if ($sql->execute()) {
            // Redirige al login.php con mensaje de éxito
            session_start();
            $_SESSION['success'] = "✅ Registro exitoso. Ahora puedes iniciar sesión.";
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $check->close();
    $conn->close();
}
?>