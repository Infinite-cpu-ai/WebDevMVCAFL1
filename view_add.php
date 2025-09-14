<?php
include_once 'model.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Pokémon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
  <h2>Add New Pokemon</h2>
  <form method="POST" action="controller.php">
    <input type="hidden" name="add_pokemon" value="1">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Weight</label>
      <input type="number" step="0.1" name="weight" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Species</label>
      <input type="text" name="species" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="view_pokemon.php" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>
