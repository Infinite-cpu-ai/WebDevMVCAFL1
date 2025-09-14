<?php
include_once 'controller.php';

$relations = getRelationsData();
$availablePokemons = getAvailablePokemonsForRelation();
$types = getAllTypes();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Relations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">
  <h2>Relation</h2>
  <div class="mb-3">
    <a href="view_pokemon.php" class="btn btn-secondary">Back to Pokemon</a>
  </div>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>No</th>
        <th>Pokemon</th>
        <th>Species</th>
        <th>Type</th>
        <th>Pro</th>
        <th>Contra</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($relations)): ?>
        <?php foreach ($relations as $relation): ?>
          <tr>
            <td><?= $relation['id'] ?></td>
            <td><?= htmlspecialchars($relation['name']) ?></td>
            <td><?= htmlspecialchars($relation['species']) ?></td>
            <td><?= htmlspecialchars($relation['type_name']) ?></td>
            <td><?= htmlspecialchars($relation['type_pro']) ?></td>
            <td><?= htmlspecialchars($relation['type_contra']) ?></td>
            <td>
              <a href="update_relation.php?id=<?= $relation['id'] ?>" class="btn btn-warning btn-sm">Update</a>
              <a href="controller.php?delete_rel_id=<?= $relation['id'] ?>" class="btn btn-danger btn-sm"
                onclick="return confirm('Remove relation for <?= htmlspecialchars($relation['name']) ?>?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">No relations to show.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <h3>Add Relation</h3>
  <form method="POST" action="controller.php" class="mb-4">
    <input type="hidden" name="add_relation" value="1">
    <div class="row g-2">
      <div class="col-md-5">
        <label class="form-label">Pokemon</label>
        <select name="pokemon_id" class="form-select" required>
          <?php foreach ($availablePokemons as $pokemon): ?>
            <option value="<?= $pokemon['id'] ?>"><?= htmlspecialchars($pokemon['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-5">
        <label class="form-label">Type</label>
        <select name="type_id" class="form-select" required>
          <?php foreach ($types as $type): ?>
            <option value="<?= $type['id'] ?>"><?= htmlspecialchars($type['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2 align-self-end">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </form>
</body>

</html>