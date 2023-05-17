<?php
  session_start();
  $recipe_id = $_GET['recipe_id'];
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Recipe Updated</title>
</head>
<body class="bg-light">
  <div class="my-5 mx-auto w-75">
    <div class="btn-group mb-4">
      <a href="index.php" class="btn btn-dark">All Recipes</a>
      <a href="search.php" class="btn btn-secondary">Search Recipe</a>
      <a href="add.php" class="btn btn-dark">Add Recipe</a>
      <a href="show.php?recipe_id=<?php echo $recipe_id; ?>" class="btn btn-outline-secondary">View Updated Recipe</a>
    </div>

    <?php
      require_once('db.php');

      if (isset($_POST['name'])) {
        $recipe_name = $_POST['name'];
        $recipe_id = $_POST['id'];
        $ingredients_array = $_POST["ingredients"] ?? [];
        $new_ingredients_array = $_POST["new_ingredients"];
        $categories_array = $_POST["categories"];
        $utensils_array = $_POST["utensils"] ?? [];
        $new_utensils_array = $_POST["new_utensils"];
        $steps_array = $_POST["steps"];

// HANDLE RECIPE

        $sql = "UPDATE `recipes` SET `name` = '$recipe_name' WHERE `id` = '$recipe_id'";
        $query = mysqli_query($conn, $sql);
        if($query) {

// HANDLE INGREDIENTS

          foreach ($new_ingredients_array as $new_ingredient) {
            if (trim($new_ingredient) == "") {
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


          $current_ingredients = $_SESSION["current_ingredients"];

          foreach ($current_ingredients as $current_ingredient) {
            // if ingredient exist in current recipe but not in $ingredients_array, remove from `recipe_ingredients`
            if (!in_array($current_ingredient, $ingredients_array)) {
              $sql = "DELETE j
                      FROM `recipe_ingredients` j
                      JOIN `ingredients` i on i.id = j.ingredient_id
                      WHERE i.name = '$current_ingredient' AND j.recipe_id = '$recipe_id'";

              $result = mysqli_query($conn, $sql);

            }
          }

          foreach ($ingredients_array as $ingredient) {
            // if ingredient does not exist in current recipe but in $ingredients_array, add to `recipe_ingredients`
            if (!in_array($ingredient, $current_ingredients)) {
              $sql = "SELECT `id` FROM `ingredients` WHERE `name`= '$ingredient'";
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
          }

// HANDLE UTENSILS

          foreach ($new_utensils_array as $new_utensil) {
            if (trim($new_utensil) == "") {
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

          $current_utensils = $_SESSION["current_utensils"];

          foreach ($current_utensils as $current_utensil) {
            // if utensil exist in current recipe but not in $utensils_array, remove from `recipe_utensils`
            if (!in_array($current_utensil, $utensils_array)) {
              $sql = "DELETE j
                      FROM `recipe_utensils` j
                      JOIN `utensils` u on u.id = j.utensil_id
                      WHERE u.name = '$current_utensil' AND j.recipe_id = '$recipe_id'";

              $result = mysqli_query($conn, $sql);

            }
          }

          foreach ($utensils_array as $utensil) {
            // if utensil does not exist in current recipe but in $utensils_array, add to `recipe_utensils`
            if (!in_array($utensil, $current_utensils)) {

              $sql = "SELECT `id` FROM `utensils` WHERE `name`= '$utensil'";
              $result = mysqli_query($conn, $sql);
              $row = mysqli_fetch_assoc($result);
              $utensil_id = $row['id'];

              $sql = "INSERT INTO `recipe_utensils` (`recipe_id`, `utensil_id`) VALUES ('$recipe_id', '$utensil_id')";
              $query = mysqli_query($conn, $sql);
              if (!$query) {
                // Handle the error
                echo "Error inserting row into recipe_utensils table: " . mysqli_error($conn);
              }
            }
          }


// HANDLE STEPS
          $i = 1;
          $no_of_steps = $_SESSION["no_of_steps"];

          foreach ($steps_array as $step) {
            if (trim($step) !== "") {
              if ($i <= $no_of_steps) {
                $sql = "UPDATE `steps` SET `description` = '$step' WHERE `recipe_id` = '$recipe_id' AND `sequence` = '$i'";
                $query = mysqli_query($conn, $sql);
              } else {
                $sql = "INSERT INTO `steps` (`recipe_id`, `sequence`, `description`) VALUES ($recipe_id, $i, '$step')";
                $query = mysqli_query($conn, $sql);
              }
              ++$i;
            }
          }

          if (($i - 1) < $no_of_steps) {
            $sql = "DELETE FROM `steps` WHERE `sequence` >= '$i' AND `recipe_id` = '$recipe_id'";
            $query = mysqli_query($conn, $sql);
          }

          echo "<h4 class='my-3'>Recipe for {$recipe_name} is updated!</h4>";
        } else {
          echo "Failed to save recipe. Please try again.";
        }

      }
    ?>

  </div>
</body>
</html>
