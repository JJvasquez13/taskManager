<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'db.php';

    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Por favor, ingrese todos los campos.";
    } else {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $error = "La contraseña es incorrecta.";
            }
        } else {
            $error = "El usuario no existe.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Iniciar sesión</title>
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
                        <h2 class="text-center mb-4 text-dark">Iniciar sesión</h2>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-4">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-custom w-100 py-3">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p>¿No tienes cuenta? <a href="register.php">Registrarse</a></p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>