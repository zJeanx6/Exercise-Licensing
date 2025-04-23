<?php
class Database {

    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'licencias';
    private $charset = 'utf8';

    function conectar() {
        try {
            $conexion = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
            $option = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                PDO::ATTR_EMULATE_PREPARES => false       
            ];

            $pdo = new PDO($conexion, $this->db_user, $this->db_pass, $option);
            return $pdo;
            
        } catch (PDOException $e) {
            echo 'Error de Conexion: ' . $e->getMessage();
            exit;
        }
    }
}
?>
