<?php
include 'db.php';

function getTasks() {
    return $_SESSION['tasks'];
}

function addTask($title, $description, $category, $due_date) {
    $task = [
        'id' => time(), // Genera un ID único basado en el tiempo
        'title' => $title,
        'description' => $description,
        'category' => $category,
        'due_date' => $due_date,
        'completed' => false
    ];
    $_SESSION['tasks'][] = $task;
}

function updateTask($id, $title, $description, $category, $due_date, $completed) {
    foreach ($_SESSION['tasks'] as &$task) {
        if ($task['id'] == $id) {
            $task['title'] = $title;
            $task['description'] = $description;
            $task['category'] = $category;
            $task['due_date'] = $due_date;
            $task['completed'] = $completed;
            break;
        }
    }
}

function deleteTask($id) {
    $_SESSION['tasks'] = array_filter($_SESSION['tasks'], function($task) use ($id) {
        return $task['id'] != $id;
    });
}
?>
