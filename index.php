<?php
  require_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Open Bangs</title>

  <link rel="stylesheet" href="./assets/fonts.css">

  <style>
    body {
      font-family: 'Overpass', sans-serif;
      font-weight: 300;
    }
    .container {
      text-align: center;
    }
  </style>
</head>

<body>

  <div class="container">
    <div id="logo">
      <h1>Open Bangs</h1>
    </div>

    <form action="search.php" method="get">
      <input type="text" name="q" autofocus>

      <select name="upstream">
        <?php
          foreach($upstreams as $name => $data) {
            print("<option value=\"$name\">$name</option>");
          }
        ?>
      </select>

      <input type="submit" value="Search">
    </form>
  </div>

  <!-- Fork me on Github ribbon -->
  <a href="https://github.com/open-bangs/server" id="githubForkMeRibbon">
    <img style="position: absolute; top: 0; right: 0; border: 0; width: 149px; height: 149px;" src="https://aral.github.io/fork-me-on-github-retina-ribbons/right-green@2x.png"
      alt="Fork me on GitHub">
  </a>
</body>

</html>