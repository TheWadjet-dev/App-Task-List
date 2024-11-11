<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'add') {
            addTask($_POST['title'], $_POST['description'], $_POST['category'], $_POST['due_date']);
        } elseif ($_POST['action'] === 'update') {
            updateTask($_POST['id'], $_POST['title'], $_POST['description'], $_POST['category'], $_POST['due_date'], isset($_POST['completed']) ? true : false);
        } elseif ($_POST['action'] === 'delete') {
            deleteTask($_POST['id']);
        }
    }
}

// Redirigir de vuelta al archivo index.php después de procesar la solicitud
header("Location: index.php");
exit();
?>