<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Hotspot</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>

<body>
  <div class="header">
    <h1 class="main-header"><a id="banner-link" href="?page=main">Welcome to Hotspot!</a></h1>
    <h3>Travel as lifestyle.</h3>
  </div>
  <div class="contents-layout">
    <?php include 'views/' . $content_view; ?>
  </div>
</body>

</html>