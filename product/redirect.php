<?php
  // redirect to the homepage
  $page = $_GET['page'];
  if (!$page) $page = 'index';
  header("location: ../$page.php");
?>       
