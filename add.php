<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>Add a Recipe</title>
</head>
<body>
<div class="my-5 mx-auto w-75">
  <div class="btn-group mb-4">
    <a href="index.php" class="btn btn-dark">All Recipes</a>
    <a href="search.php" class="btn btn-secondary">Search Recipe</a>
    <a href="add.php" class="btn btn-dark">Add Recipe</a>
  </div>

    <form action="new_recipe.php" method="post">
      <h4 class="display-5 my-3">Recipe Name</h4>
      <input type="'" name="name" id="name" class="form-control" required/> <br>

<!-- HANDLE INGREDIENTS -->
      <h4 class="display-5 my-3">Ingredients</h4>
      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; grid-gap: 16px;">
        <?php
        require_once('db.php');

        $sql = "SELECT `category`, GROUP_CONCAT(DISTINCT `name` ORDER BY `name` ASC SEPARATOR ', ') AS `ingredients` FROM `ingredients` GROUP BY `category` ORDER BY `category` IS NULL";

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

          foreach ($ingredients_array as $ingredient) {
            echo "<div class='form-check'>
                    <input class='form-check-input' type='checkbox' name='ingredients[]' id='{$ingredient}' value='{$ingredient}' >
                    <label class='form-check-label' for='{$ingredient}'>
                      " . ucfirst($ingredient) . "
                    </label>
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
          $sql = "SELECT `name` FROM `utensils` ORDER BY `name` ASC";
          $result = mysqli_query($conn, $sql);

          while($row = mysqli_fetch_array($result)) {
            $utensil = $row["name"];
            echo "<div class='form-check col-lg-3 col-sm-4 col-6'>
                    <input class='form-check-input' type='checkbox' name='utensils[]' id='{$utensil}' value='{$utensil}' >
                    <label class='form-check-label' for='{$utensil}'>" . ucfirst($utensil) . "</label>
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
      function printStepBoxes($number) {
        for ($index = $number; $index < ($number + 3); $index++) {
          echo "<div class='row mb-3 my-2'>
                  <label for='step' class='col-2 col-form-label'>Step " . $index + 1 . ": </label>
                  <div class='col'>
                    <textarea name='steps[]' id='step' class='form-control'></textarea>
                  </div>
                </div>";
        }
      }

      printStepBoxes(0);
      ?>

      <div id="button1" onclick="showMore1()" class="btn btn-link btn-sm px-0">More Steps</div><br>

      <div id="moresteps1" class="visually-hidden">
        <?php
          printStepBoxes(3);
        ?>
      </div>

      <div id="button2" onclick="showMore2()" class="btn btn-link btn-sm px-0 visually-hidden">More Steps</div><br>

      <div id="moresteps2" class="visually-hidden">
        <?php
          printStepBoxes(6);
        ?>
      </div>

      <script>
        function showMore1() {
          document.getElementById("moresteps1").classList.remove("visually-hidden");
          document.getElementById("button1").classList.add("visually-hidden");
          document.getElementById("button2").classList.remove("visually-hidden");
        }
        function showMore2() {
          document.getElementById("moresteps2").classList.remove("visually-hidden");
          document.getElementById("button2").classList.add("visually-hidden");
        }
      </script>

      <div class="d-grid">
        <input type="submit" name="submit" value="Save Recipe" class="btn btn-lg btn-dark my-5 py-3"/>
      </div>
    </form>

  </div>
</body>
</html>
