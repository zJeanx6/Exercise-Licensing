<?php
require_once('db_config.php');
$conex = new Database;
$pdo = $conex->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['email'];
    $password = $_POST['password'];


    //Verificamos que ningun campo trate de enviarse vacio
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

    // 1. Buscar en ADMIN
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE correo = ?");
    $stmt->execute([$correo]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['contraseña'])) {
        $_SESSION['user'] = [
            'tipo' => 'admin',
            'cedula' => $admin['cedula'],
            'nombre' => $admin['nombre']
        ];
        header("Location: ../views/dashboard.php");
        exit;
    }

    // 2. Buscar en USUARIOS
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['contraseña'])) {
        $_SESSION['user'] = [
            'tipo' => 'usuario',
            'cedula' => $usuario['cedula'],
            'nombre' => $usuario['nombre'],
            'estado' => $usuario['id_estado']
        ];
        header("Location: ../views/dashboard.php");
        exit;
    } 
    
    else {
        echo '<script>alert("Correo o contraseña incorrecta")</script>';
        echo '<script>window.location = "../index.html"</script>';
        exit;
    }

}
?>