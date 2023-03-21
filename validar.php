<?php
session_start();
include("config.php");
// Conectar a la base de datos
try {
  $pdo = new PDO(DBDRIVER . ':host=' . DBHOST . ';dbname=' . DBNAME . ';port=' . DBPORT, DBUSER, DBPASS);
} catch (PDOException $e) {
  die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Obtener el correo electrónico y la contraseña ingresados
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Verificar si el correo electrónico y la contraseña son válidos
$consulta = "SELECT * FROM usuario WHERE correo=:email AND contrasenia=:password";
$stmt = $pdo->prepare($consulta);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
  // Si las credenciales no son correctas, mostrar un mensaje de error y redirigir al usuario a la página de inicio de sesión
  $_SESSION['mensaje_error'] = 'Correo electrónico o contraseña incorrectos';
  header('Location: login.php');
  die();
} else {    // Si las credenciales son correctas, almacenar el tipo de usuario en una variable de sesión
  $_SESSION['id_cat_usuario'] = $usuario['id_cat_usuario'];
   header('Location: header.php');
  
  }

