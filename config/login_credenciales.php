<?php
require_once('db_config.php');
$conex = new Database;
$pdo = $conex->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $password = $_POST['password'];

    if ($correo == '') {
        echo '<script>alert ("Campo Correo Vacio") </script>';
        echo '<script>window.location = "../index.html" </script>';
        exit();
    }
    if ($password == '') {
        echo '<script>alert ("Campo Contraseña Vacio") </script>';
        echo '<script>window.location = "../index.html" </script>';
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['contraseña'])) {
        $_SESSION['user'] = [
            'cedula' => $usuario['cedula'],
            'nombre' => $usuario['nombre'],
            'rol_id' => $usuario['rol_id'],
        ];

        switch ($usuario['rol_id']) {
            case 1:
                header("Location: ../views/superadmin/dashboard.php");
                break;
            default:
                header("Location: ../index.html");
                break;
        }
        exit;
    } else {
        echo '<script>alert("Correo o contraseña incorrecta")</script>';
        echo '<script>window.location = "../index.html"</script>';
        exit;
    }
}
