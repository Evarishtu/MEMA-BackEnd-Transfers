<?php
require_once __DIR__ . '/../config/database.php';

$db = new Database();
$conexion = $db->connect();

if ($conexion){
    echo "<h2> Conexión establecida </h2>";

    $consulta = $conexion->query("SHOW TABLES;");
    echo "<h3>Tablas disponbiles:</h3><ul>";
    while($tabla = $consulta->fetch(PDO::FETCH_NUM)){
        echo "<li>{$tabla[0]}</li>";
    }
    echo "</ul>";
}else {
    echo "<h2>Fallo de conexion</h2>";
}