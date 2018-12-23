<?php
  require_once("config.php");
    
  $data = json_decode(file_get_contents("./dataset/data.json"), true);

  if($data["version"] != $allowed_data_version) {
    $err = "Version of data is invalid. Please update your open-bangs server.";

    print("ERROR: " . $err);
    throw new Exception($err);
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>List of bangs</title>

  <link rel="stylesheet" href="./assets/style.css">
  <link rel="stylesheet" href="./assets/fonts.css">
</head>

<body>

  <div class="container">
    <div id="logo">
      <h1>List of bangs</h1>
    </div>

    <div id="list">
      <ul>
        <?php
          foreach($data["data"] as $bang) {
            echo "<li>" . $bang["keyword"] . "</li>";
          }
        ?>
      </ul>

      <p>
        Want to add or edit a bang?
        Create new issue or make pull request on <a href="https://github.com/open-bangs/dataset">Github</a>.
      </p>
    </div>

    <hr>

    <a href="./">Back to frontpage</a>
  </div>

  <!-- Fork me on Github ribbon -->
  <a href="https://github.com/open-bangs/server" id="githubForkMeRibbon">
    <img style="position: absolute; top: 0; right: 0; border: 0; width: 149px; height: 149px;" src="https://aral.github.io/fork-me-on-github-retina-ribbons/right-green@2x.png"
      alt="Fork me on GitHub">
  </a>
</body>

</html>