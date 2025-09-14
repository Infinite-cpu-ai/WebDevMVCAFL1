<?php
include_once 'controller.php';
$pokemonList = getPokemonData();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Pokemon List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">
  <h2>Pokemon List</h2>
  <div class="mb-3">
    <a href="view_add.php" class="btn btn-success">Add Pokemon</a>
    <a href="view_relation.php" class="btn btn-primary">View Relations</a>
  </div>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Name</th>
        <th>Weight</th>
        <th>Species</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($pokemonList)): ?>
        <?php foreach ($pokemonList as $pokemon): ?>
          <tr>
            <td><?= $pokemon['id'] ?></td>
            <td><?= htmlspecialchars($pokemon['name']) ?></td>
            <td><?= htmlspecialchars($pokemon['weight']) ?></td>
            <td><?= htmlspecialchars($pokemon['species']) ?></td>
            <td>
              <a href="update.php?id=<?= $pokemon['id'] ?>" class="btn btn-warning btn-sm">Update</a>
              <a href="controller.php?delete_id=<?= $pokemon['id'] ?>" class="btn btn-danger btn-sm"
                onclick="return confirm('Delete <?= htmlspecialchars($pokemon['name']) ?>?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center">No Pokemon yet.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>

</html>