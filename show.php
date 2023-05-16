<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Your Recipe</title>
</head>
<body>
  <div class="my-5 mx-auto w-75">
  <div class="btn-group mb-4">
    <a href="index.php" class="btn btn-dark">All Recipes</a>
    <a href="search.php" class="btn btn-secondary">Search Recipe</a>
    <a href="add.php" class="btn btn-dark">Add Recipe</a>
    <a href="javascript:history.back()" class="btn btn-outline-secondary">Back</a>
  </div>
  <?php
    require_once('db.php');
    $recipe_name = $_GET["submit"];
    $recipe_id = $_GET["recipe_id"];
    $keyword = $_GET["keyword"];

    echo "<h6><u>Recipe</u></h6><h1 class='display-5 mt-3 mb-4'>{$recipe_name}</h1>";

    $sql = "SELECT i.name
            FROM ingredients i
            JOIN recipe_ingredients j ON i.id = j.ingredient_id
            WHERE j.recipe_id = {$recipe_id}";

    $result = mysqli_query($conn, $sql);
  ?>

<!-- DISPLAY INGREDIENTS -->
  <h5>Ingredients</h5>
  <ul class="list-group list-group-horizontal my-3">
  <?php
    if ($keyword) {
      echo "<li class='list-group-item list-group-item-info'>{$keyword}</li>";
    }
    while($row = mysqli_fetch_array($result)) {
      if ($row['name'] == $keyword) {
        continue;
      }
      echo "<li class='list-group-item'>{$row['name']}</li>";
    }
  ?>
  </ul>
  <br>

<!-- DISPLAY UTENSILS -->
  <h5>Utensils</h5>
  <ul class="list-group list-group-horizontal my-3">
  <?php
    $sql = "SELECT u.name
            FROM utensils u
            JOIN recipe_utensils j ON u.id = j.utensil_id
            WHERE j.recipe_id = {$recipe_id}";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
      echo "<li class='list-group-item'>{$row['name']}</li>";
    }
  ?>
  </ul>
  <br>

<!-- DISPLAY STEPS -->
  <h5>Steps</h5>

  <table class="table" style="width:100%">
    <thead>
      <tr>
        <th scope="col" style="width:15%"></th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php
        $sql = "SELECT `sequence`, `description` FROM `steps` WHERE `recipe_id` = {$recipe_id} ORDER BY `sequence` ASC";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)) {
          echo "<tr>
                  <th scope='row'>{$row['sequence']}</th>
                  <td>{$row['description']}</td>
                </tr>";
        }
      ?>
  </tbody>
</table>

  </div>
</body>
</html>
