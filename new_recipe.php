<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>New Recipe Added</title>
</head>
<body>
  <div class="my-5 mx-auto w-75">
    <div class="btn-group mb-4">
      <a href="index.php" class="btn btn-dark">All Recipes</a>
      <a href="search.php" class="btn btn-secondary">Search Recipe</a>
      <a href="add.php" class="btn btn-dark">Add Recipe</a>
    </div>

    <?php
      require_once('db.php');

      if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $ingredients_array = $_POST["ingredients"] ?? [];
        $new_ingredients_array = $_POST["new_ingredients"];
        $categories_array = $_POST["categories"];
        $utensils_array = $_POST["utensils"] ?? [];
        $new_utensils_array = $_POST["new_utensils"];
        $steps_array = $_POST["steps"];

// HANDLE RECIPE

        $sql = "INSERT INTO `recipes` (`name`) VALUES ('$name')";

        $query = mysqli_query($conn, $sql);
        if($query) {
          $recipe_id = $conn->insert_id;
          echo "<h4 class='display-5 my-3'>New Recipe is saved!</h4>";

// HANDLE INGREDIENTS

          foreach ($new_ingredients_array as $i=>$new_ingredient) {
            if ($new_ingredient == "") {
              continue;
            }
            $new_ingredient = strtolower($new_ingredient);
            $sql = "SELECT * FROM ingredients WHERE `name`= '$new_ingredient'";
            $result = mysqli_query($conn, $sql);
            // check if the input ingredient exists already in DB
            if(mysqli_num_rows($result) == 0) {
              // create new ingredient if it doesn't exist in DB
              $category = strtolower($categories_array[$i]);
              $category = ($category === "-- category --" || $category === "others") ? "null" : "'$category'";
              $sql = "INSERT INTO `ingredients` (`name`, `category`) VALUES ('$new_ingredient', $category)";
              $query = mysqli_query($conn, $sql);
              $ingredient_id = $conn->insert_id;
              if($query) {
                // connect new ingredients with recipe
                $sql = "INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`) VALUES ($recipe_id, $ingredient_id)";
                $query = mysqli_query($conn, $sql);
              }
            } else {
                // push to ingredients array if it exists in DB && the box for the ingredient was not checked
                if (!in_array($new_ingredient, $ingredients_array)) {
                  array_push($ingredients_array, $new_ingredient);
                }
            }
          }

          // connect existing ingredients with recipe
          foreach ($ingredients_array as $ingredient) {
            $sql = "SELECT `id` FROM ingredients WHERE `name`= '$ingredient'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $ingredient_id = $row['id'];

            $sql = "INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_id`) VALUES ($recipe_id, $ingredient_id)";
            $query = mysqli_query($conn, $sql);
            if (!$query) {
              // Handle the error
              echo "Error inserting row into recipe_ingredients table: " . mysqli_error($conn);
            }
          }

// HANDLE UTENSILS

          foreach ($new_utensils_array as $i=>$new_utensil) {
            if ($new_utensil == "") {
              continue;
            }
            $new_utensil = strtolower($new_utensil);
            $sql = "SELECT * FROM utensils WHERE `name`= '$new_utensil'";
            $result = mysqli_query($conn, $sql);
            // check if the input utensil exists already in DB
            if(mysqli_num_rows($result) == 0) {
              // create new utensil if it doesn't exist in DB
              $sql = "INSERT INTO `utensils` (`name`) VALUES ('$new_utensil')";
              $query = mysqli_query($conn, $sql);
              $utensil_id = $conn->insert_id;
              if($query) {
                // connect new ingredients with recipe
                $sql = "INSERT INTO `recipe_utensils` (`recipe_id`, `utensil_id`) VALUES ($recipe_id, $utensil_id)";
                $query = mysqli_query($conn, $sql);
              }
            } else {
                // push to utensils array if it exists in DB && the box for the utensil was not checked
                if (!in_array($new_utensil, $utensils_array)) {
                  array_push($utensils_array, $new_utensil);
                }
            }
          }

          // connect existing utensils with recipe
          foreach ($utensils_array as $utensil) {
            $sql = "SELECT `id` FROM utensils WHERE `name`= '$utensil'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $utensil_id = $row['id'];

            $sql = "INSERT INTO `recipe_utensils` (`recipe_id`, `utensil_id`) VALUES ($recipe_id, $utensil_id)";
            $query = mysqli_query($conn, $sql);
            if (!$query) {
              // Handle the error
              echo "Error inserting row into recipe_utensils table: " . mysqli_error($conn);
            }
          }

// HANDLE STEPS
          $i = 1;
          foreach ($steps_array as $step) {
            if ($step !== "") {
              $sql = "INSERT INTO `steps` (`recipe_id`, `sequence`, `description`) VALUES ($recipe_id, $i, '$step')";
              $query = mysqli_query($conn, $sql);
              ++$i;
            }
          }

        } else {
          echo "Failed to save recipe. Please try again.";
        }

      }
    ?>
  </div>
</body>
</html>
