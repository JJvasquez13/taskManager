<?php
session_start();

include("db.php");

include('includes/header.php');
?>

<main class="container p-4">
  <div class="row">
    <div class="col-md-4">
      <!-- Mensajes -->
      <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
          <?= $_SESSION['message'] ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Eliminar solo el mensaje, no toda la sesión -->
        <?php unset($_SESSION['message']); ?>
      <?php } ?>

      <!-- Agregar tareas, (Solo es visible si inicio sesión) -->
      <?php if (isset($_SESSION['username'])): ?>
        <div class="card card-body">
          <form action="save_task.php" method="POST">
            <div class="form-group">
              <input type="text" name="title" class="form-control" placeholder="Task Title" autofocus required>
            </div>
            <div class="form-group">
              <textarea name="description" rows="2" class="form-control" placeholder="Task Description" required></textarea>
            </div>
            <input type="submit" name="save_task" class="btn btn-success btn-block" value="Save Task">
          </form>
        </div>
      <?php else: ?>
        <div class="alert alert-info" role="alert">
          <strong>Inicia sesión</strong> para agregar tareas.
        </div>
      <?php endif; ?>
    </div>

    <div class="col-md-8">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM task";
          $result_tasks = mysqli_query($conn, $query);

          while ($row = mysqli_fetch_assoc($result_tasks)) { ?>
            <tr>
              <td><?php echo $row['title']; ?></td>
              <td><?php echo $row['description']; ?></td>
              <td><?php echo $row['created_at']; ?></td>
              <td>
                <?php if (isset($_SESSION['username'])): ?>
                  <a href="edit.php?id=<?php echo $row['id'] ?>" class="btn btn-secondary">
                    <i class="fas fa-marker"></i>
                  </a>
                  <a href="delete_task.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">
                    <i class="far fa-trash-alt"></i>
                  </a>
                <?php else: ?>
                  <span class="text-muted">Se requiere iniciar sesión para editarlas</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>