<?php
session_start();
if (!$_SESSION['username'] || !$_SESSION['id']) {
  header("Location: login.php");
}
?>

