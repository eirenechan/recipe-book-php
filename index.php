<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>All Recipes</title>
</head>
<body class="bg-light">
  <div class="my-5 mx-auto w-75">
  <div class="btn-group mb-4">
    <a href="index.php" class="btn btn-dark">All Recipes</a>
    <a href="search.php" class="btn btn-secondary">Search Recipe</a>
    <a href="add.php" class="btn btn-dark">Add Recipe</a>
  </div>
  <h4 class="display-5 my-3">All Recipes</h4>
  <?php
    require_once('db.php');
      $sql = "SELECT * FROM `recipes`";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) > 0) {
        echo "<ul class='list-group my-3'>";
        while($row = mysqli_fetch_array($result)) {
          echo "<li class='list-group-item'>
                  <a href='show.php?recipe_id=". $row['id'] . "' class='btn btn-link text-dark'>" . $row['name'] . "</a>
                </li>";
        }
        echo "</ul>";
      }
    ?>
</table>

  </div>
</body>
</html>
