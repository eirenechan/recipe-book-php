<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Find Recipes</title>
</head>
<body class="bg-light">

  <div class="my-5 mx-auto w-75">
    <div class="btn-group mb-4">
      <a href="index.php" class="btn btn-dark">All Recipes</a>
      <a href="search.php" class="btn btn-secondary">Search Recipe</a>
      <a href="add.php" class="btn btn-dark">Add Recipe</a>
    </div>

<!-- search bar -->
    <h4 class="display-5 my-3">Search Recipes by Ingredient</h4>
    <form action="#" method="get">
      <div class="input-group input-group-lg w-50 my-4">
        <?php
        $keyword = strtolower($_GET["ingredient"]);
        echo "<input type='text' name='ingredient' id='ingredient' class='form-control' value='{$keyword}' required/>"
        ?>

        <input type="submit" name="submit" value="Search" id="submit" class="btn btn-dark"/>

      </div>
    </form>
    <br>

<!-- display search results -->
    <?php
    require_once('db.php');

    if (isset($_GET['submit'])) {
      $sql = "SELECT r.name AS r_name, r.id, i.name AS i_name
      FROM recipes r
      JOIN recipe_ingredients j ON r.id = j.recipe_id
      JOIN ingredients i ON i.id = j.ingredient_id
      WHERE i.name LIKE '%$keyword%'";

      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        echo "<h5>Search Results for <<strong>{$keyword}</strong>></h5>
              <ul class='list-group list-group-horizontal my-3'>";
        while($row = mysqli_fetch_array($result)) {
          echo "<li class='list-group-item'>
                  <a href='show.php?keyword={$keyword}&recipe_id=". $row['id'] . "' class='btn btn-link text-dark'>" . $row['r_name'] . "</a>
                </li>";

        }
        echo "</ul>";
      } else {
        echo "<h5>No recipes with <<strong>{$keyword}</strong>>. Please try again.</h5>";
      }
    }
    ?>

  </div>
</body>
</html>
