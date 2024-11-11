<?php
session_start();

// Verifica si la lista de tareas está inicializada en la sesión
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

function getTasks() {
    return $_SESSION['tasks'];
}

function addTask($title, $description, $category, $due_date) {
    $task = [
        'id' => time(), // Usamos el tiempo actual como ID único
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

$tasks = getTasks();

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tareas</title>
</head>
<body>
    <h1>Gestión de Tareas</h1>

    <h2>Agregar Tarea</h2>
    <form method="POST">
        <input type="hidden" name="action" value="add">
        <input type="text" name="title" placeholder="Título" required>
        <textarea name="description" placeholder="Descripción"></textarea>
        <input type="text" name="category" placeholder="Categoría">
        <input type="date" name="due_date" required>
        <button type="submit">Agregar</button>
    </form>

    <h2>Lista de Tareas</h2>
    <table>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Categoría</th>
            <th>Fecha Límite</th>
            <th>Completada</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['description']) ?></td>
            <td><?= htmlspecialchars($task['category']) ?></td>
            <td><?= htmlspecialchars($task['due_date']) ?></td>
            <td><?= $task['completed'] ? 'Sí' : 'No' ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
                    <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea>
                    <input type="text" name="category" value="<?= htmlspecialchars($task['category']) ?>">
                    <input type="date" name="due_date" value="<?= $task['due_date'] ?>" required>
                    <input type="checkbox" name="completed" <?= $task['completed'] ? 'checked' : '' ?>> Completada
                    <button type="submit">Actualizar</button>
                </form>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

?>

<?php if (strtotime($task['due_date']) < strtotime('+2 days') && !$task['completed']): ?>
    <script>
        alert('La tarea "<?= $task['title'] ?>" está próxima a vencer.');
    </script>
<?php endif; ?>
