<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$conn = mysqli_connect(
  'localhost',
  'root',
  'juan123',
  'php_mysql_crud'
) or die(mysqli_error($mysqli));
