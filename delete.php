<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Recipe Deleted</title>
</head>
<body class="bg-light">
  <div class="my-5 mx-auto w-75">
    <div class="btn-group mb-4">
      <a href="index.php" class="btn btn-dark">All Recipes</a>
      <a href="search.php" class="btn btn-secondary">Search Recipe</a>
      <a href="add.php" class="btn btn-dark">Add Recipe</a>
    </div>

    <?php
      require_once('db.php');
      $recipe_id = $_GET['recipe_id'];
      $sql = "DELETE FROM `recipes` WHERE `id` = '$recipe_id'";
      $query = mysqli_query($conn, $sql);
      if ($query) {
        echo "<h4 class='my-3'>Recipe is deleted!</h4>";
      } else {
        // Handle the error
        echo "Error inserting row into recipe_utensils table: " . mysqli_error($conn);
      }

      ?>
  </div>
</body>
</html>
