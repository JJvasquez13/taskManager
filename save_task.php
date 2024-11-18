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

  // Realizar la consulta para insertar la tarea en la base de datos
  $query = "INSERT INTO task (title, description) VALUES ('$title', '$description')";
  $result = mysqli_query($conn, $query);

  // Verificar si la consulta fue exitosa
  if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
  }

  // Establecer el mensaje de éxito en la sesión
  $_SESSION['message'] = 'Task Saved Successfully';
  $_SESSION['message_type'] = 'success';

  header('Location: index.php');
  exit();
}
