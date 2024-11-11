<?php
include 'functions.php';
$tasks = getTasks();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tareas</title>
</head>
<body>
    <h1>Gestión de Tareas</h1>

    <h2>Agregar Tarea</h2>
    <form method="POST" action="process.php">
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
                <!-- Formulario para actualizar tarea -->
                <form method="POST" action="process.php" style="display:inline;">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= $task['id'] ?>">
                    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
                    <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea>
                    <input type="text" name="category" value="<?= htmlspecialchars($task['category']) ?>">
                    <input type="date" name="due_date" value="<?= $task['due_date'] ?>" required>
                    <input type="checkbox" name="completed" <?= $task['completed'] ? 'checked' : '' ?>> Completada
                    <button type="submit">Actualizar</button>
                </form>

                <!-- Formulario para eliminar tarea -->
                <form method="POST" action="process.php" style="display:inline;">
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
