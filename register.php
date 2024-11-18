<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db.php';

    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validaciones
    $errors = [];
    if (empty($username)) {
        $errors[] = "El nombre de usuario es obligatorio.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "El correo electrónico no es válido.";
    }
    if (strlen($password) < 6) {
        $errors[] = "La contraseña debe tener al menos 6 caracteres.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Las contraseñas no coinciden.";
    }

    // Si no hay errores, intenta registrar al usuario
    if (empty($errors)) {
        // Verificar si el usuario o el correo ya existen
        $query = "SELECT id FROM users WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = "El nombre de usuario o el correo electrónico ya están registrados.";
        } else {
            // Cifrar contraseña y guardar el usuario
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

            if (mysqli_query($conn, $query)) {
                // Iniciar sesión automáticamente después del registro
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit;
            } else {
                $errors[] = "Error al registrar el usuario: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registrarse</title>
    <style>
        .bg-custom {
            background-color: #f8f9fa;
        }

        .card-custom {
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #007bff;
            border: none;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .form-control-lg {
            border-radius: 25px;
        }
    </style>
</head>

<body class="bg-custom">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-custom">
                    <div class="card-body">
                        <h2 class="text-center mb-4 text-dark">Crear una cuenta</h2>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="register.php">
                            <div class="mb-4">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-custom w-100 py-3">Registrarse</button>
                        </form>

                        <div class="text-center mt-4">
                            <p>¿Ya tienes cuenta? <a href="login.php">Iniciar sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>