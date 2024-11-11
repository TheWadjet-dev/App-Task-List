<?php
session_start();

// Inicializar la lista de tareas en la sesión si no existe
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}
?>