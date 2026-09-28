<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $correo = $_POST['correo'];
  $password = $_POST['password'];

  // Preparamos la consulta
  $sql = $conn->prepare("SELECT * FROM usuarios WHERE correo = ?");
  $sql->bind_param("s", $correo);
  $sql->execute();
  $result = $sql->get_result();

  if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // ⚠️ IMPORTANTE: verifica cómo guardaste las contraseñas en la BD
    // Si usaste password_hash() → usa password_verify()
    // Si guardaste en texto plano → usa comparación directa ($password === $user['password'])

    if (password_verify($password, $user['password'])) {
      // Guardamos nombre y rol en la sesión
      $_SESSION['usuario'] = $user['nombre'];
      $_SESSION['rol'] = $user['rol']; // columna 'rol' en tu tabla usuarios (ej: admin/user)

      header("Location: inicio.php");
      exit();
    } else {
      $_SESSION['error'] = "⚠️ Contraseña incorrecta.";
      header("Location: login.php");
      exit();
    }
  } else {
    $_SESSION['error'] = "⚠️ Usuario no encontrado.";
    header("Location: login.php");
    exit();
  }

  $sql->close();
  $conn->close();
}
?>