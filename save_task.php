<?php
session_start();

include('db.php');

// Verificar si el usuario ha iniciado sesión antes de permitir agregar tareas
if (!isset($_SESSION['username'])) {
  $_SESSION['message'] = 'Por favor, inicie sesión para agregar una tarea.';
  $_SESSION['message_type'] = 'danger';
  header('Location: login.php');
  exit();
}

// Verificar si se está enviando el formulario de guardar tarea
if (isset($_POST['save_task'])) {
  $title = $_POST['title'];
  $description = $_POST['description'];

  // Usar una sentencia preparada para evitar inyección SQL
  $query = "INSERT INTO task (title, description) VALUES (?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'ss', $title, $description);
  mysqli_stmt_execute($stmt);

  // Verificar si la consulta fue exitosa
  if (mysqli_stmt_affected_rows($stmt) > 0) {
    $_SESSION['message'] = 'Task Saved Successfully';
    $_SESSION['message_type'] = 'success';
  } else {
    $_SESSION['message'] = 'Error al guardar la tarea';
    $_SESSION['message_type'] = 'danger';
  }

  header('Location: index.php');
  exit();
}
