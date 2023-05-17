<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Edit a Recipe</title>
</head>
<body class="bg-light">
  <div class="my-5 mx-auto w-75">
    <?php
      require_once('db.php');

      // get recipe information
      if (isset($_GET["recipe_id"])) {
        $recipe_id = $_GET["recipe_id"];

        $sql = "SELECT `name` FROM recipes WHERE `id`= '$recipe_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $recipe_name = $row['name'];
      }
    ?>
    <div class="btn-group mb-4">
      <a href="index.php" class="btn btn-dark">All Recipes</a>
      <a href="search.php" class="btn btn-secondary">Search Recipe</a>
      <a href="add.php" class="btn btn-dark">Add Recipe</a>
      <a href="javascript:history.back()" class="btn btn-outline-secondary">Back</a>
    </div>

    <form action="update.php?recipe_id=<?php echo $recipe_id; ?>" method="post">
      <h4 class="display-5 my-3">Recipe Name</h4>
      <input type="" name="name" class="form-control" value="<?php echo $recipe_name; ?>" required/> <br>
      <input type="hidden" name="id" class="form-control" value="<?php echo $recipe_id; ?>" />

<!-- HANDLE INGREDIENTS -->
      <h4 class="display-5 my-3">Ingredients</h4>
      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; grid-gap: 16px;">
        <?php
          // get recipe ingredients
          $sql = "SELECT i.name
                  FROM ingredients i
                  JOIN recipe_ingredients j ON i.id = j.ingredient_id
                  WHERE j.recipe_id = {$recipe_id}";
          $result = mysqli_query($conn, $sql);
          $current_ingredients = [];

          if ($result) {
            while($row = mysqli_fetch_array($result)) {
              array_push($current_ingredients, $row['name']);
            }
          }

          $_SESSION["current_ingredients"] = $current_ingredients;

          // display ingredients
          $sql = "SELECT `category`, GROUP_CONCAT(DISTINCT `name` ORDER BY `name` ASC SEPARATOR ', ') AS `ingredients`
                  FROM `ingredients`
                  GROUP BY `category`
                  ORDER BY `category` IS NULL";
          $result = mysqli_query($conn, $sql);
          $categories = array();

          while($row = mysqli_fetch_array($result)) {

            $category = $row['category'] === null ? "Others" : ucwords($row['category']);
            array_push($categories, $category);
            echo "<div style='display:flex'>
                    <div class='border rounded-1 p-3 w-100' >
                    <h6>{$category}</h6>";

            $ingredients = $row['ingredients'];
            $ingredients_array = explode(", ", $ingredients);

            // check the box if the ingredient is already selected
            foreach ($ingredients_array as $ingredient) {
              echo "<div class='form-check'>";
              if (in_array($ingredient, $current_ingredients)) {
                echo "<input class='form-check-input' type='checkbox' name='ingredients[]' id='{$ingredient}' value='{$ingredient}' checked>";
              } else {
                echo "<input class='form-check-input' type='checkbox' name='ingredients[]' id='{$ingredient}' value='{$ingredient}' >";
              }
              echo "<label class='form-check-label' for='{$ingredient}'>" . ucfirst($ingredient) . "</label>
                  </div>";
            }

            echo "</div></div>";
          }

        ?>
      </div>

      <div class='row border rounded-1 py-3 px-4 my-3 mx-auto'>
        <h6 class="px-0">Customize Ingredients</h6>
        <?php
          for ($index = 0; $index < 8; $index++) {
            echo "<div class='col-6 ps-0 pe-3'>
                    <div class='input-group input-group-sm my-2'>
                      <select class='form-select' name='categories[]'>
                        <option selected>-- Category --</option>";

                        foreach ($categories as $category) {
                          echo "<option value='{$category}'>{$category}</option>";
                        }

            echo      "</select>
                      <input type='text' name='new_ingredients[]' class='form-control' />
                    </div>
                  </div>";
          }
        ?>
      </div><br>

<!-- HANDLE UTENSILS -->
      <h4 class="display-5 my-3">Utensils</h4>
      <div class='row border rounded-1 py-3 px-4 my-3 mx-auto'>
        <?php
          // get recipe utensils
          $sql = "SELECT u.name
                  FROM utensils u
                  JOIN recipe_utensils j ON u.id = j.utensil_id
                  WHERE j.recipe_id = {$recipe_id}";
          $result = mysqli_query($conn, $sql);
          $current_utensils = [];

          if ($result) {
            while($row = mysqli_fetch_array($result)) {
              array_push($current_utensils, $row['name']);
            }
          }

          $_SESSION["current_utensils"] = $current_utensils;

          // display utensils
          $sql = "SELECT `name` FROM `utensils` ORDER BY `name` ASC";
          $result = mysqli_query($conn, $sql);

          while($row = mysqli_fetch_array($result)) {
            $utensil = $row["name"];
            echo "<div class='form-check col-lg-3 col-sm-4 col-6'>";
            if (in_array($utensil, $current_utensils)) {
              echo "<input class='form-check-input' type='checkbox' name='utensils[]' id='{$utensil}' value='{$utensil}' checked>";
            } else {
              echo "<input class='form-check-input' type='checkbox' name='utensils[]' id='{$utensil}' value='{$utensil}' >";
            }
            echo "<label class='form-check-label' for='{$utensil}'>" . ucfirst($utensil) . "</label>
                </div>";
          }
        ?>
      </div>

      <div class='row border rounded-1 py-3 px-4 my-3 mx-auto'>
        <h6 class="px-0">Customize Utensils</h6>
        <?php
          for ($index = 0; $index < 8; $index++) {
            echo "<div class='col-3 ps-0 pe-3 py-2'>
                    <input type='text' name='new_utensils[]' class='form-control form-control-sm' />
                  </div>";
          }
        ?>
      </div><br>

<!-- HANDLE STEPS -->
      <h4 class="display-5 my-3">Steps</h4>
      <?php
        // get recipe steps
        $sql = "SELECT `description` FROM `steps` WHERE `recipe_id` = {$recipe_id} ORDER BY `sequence` ASC";
        $result = mysqli_query($conn, $sql);
        $current_steps = [];

        while($row = mysqli_fetch_array($result)) {
          array_push($current_steps, $row['description']);
        }

        $no_of_steps = count($current_steps);
        $_SESSION["no_of_steps"] = $no_of_steps;

        for ($index = 0; $index < ($no_of_steps + 3); $index++) {
          echo "<div class='row mb-3 my-2'>
                  <label for='step' class='col-2 col-form-label'>Step " . $index + 1 . ": </label>
                  <div class='col'>
                    <textarea name='steps[]' id='step' class='form-control'>" . $current_steps[$index] ."</textarea>
                  </div>
                </div>";
        }
      ?>

      <div class="d-grid">
        <input type="submit" name="submit" value="Save Recipe" class="btn btn-lg btn-dark my-5"/>
      </div>
    </form>
  </div>
</body>
</html>
