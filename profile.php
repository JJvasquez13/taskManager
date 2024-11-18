<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_username) || empty($new_email)) {
        $_SESSION['message'] = "Todos los campos son obligatorios.";
        $_SESSION['message_type'] = "danger";
    } elseif ($new_password != $confirm_password) {
        $_SESSION['message'] = "Las contraseñas no coinciden.";
        $_SESSION['message_type'] = "danger";
    } elseif (strlen($new_password) < 6) {
        $_SESSION['message'] = "La contraseña debe tener al menos 6 caracteres.";
        $_SESSION['message_type'] = "danger";
    } else {
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET username = '$new_username', email = '$new_email', password = '$hashed_password' WHERE username = '$username'";
        } else {
            $update_query = "UPDATE users SET username = '$new_username', email = '$new_email' WHERE username = '$username'";
        }

        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            $_SESSION['username'] = $new_username;
            $_SESSION['message'] = "Perfil actualizado con éxito.";
            $_SESSION['message_type'] = "success";
            header('Location: profile.php');
            exit();
        } else {
            $_SESSION['message'] = "Error al actualizar el perfil. Inténtalo de nuevo.";
            $_SESSION['message_type'] = "danger";
        }
    }
}
?>

<?php include('includes/header.php'); ?>

<main class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Mensajes de éxito/error -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-<?= $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Editar Perfil</h2>

                    <form action="profile.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                        </div>

                        <!-- Campos de contraseña -->
                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label">Nueva contraseña</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Introduce una nueva contraseña (opcional)">
                        </div>
                        <div class="form-group mb-3">
                            <label for="confirm_password" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirma la nueva contraseña">
                        </div>

                        <button type="submit" name="update_profile" class="btn btn-primary w-100">Actualizar Perfil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include('includes/footer.php'); ?>