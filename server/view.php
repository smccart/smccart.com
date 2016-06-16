<?php

    require('global.php');

    $alias = $_GET['alias'];

    $query = $db->prepare("Select * from snippets WHERE alias = '".$alias."'");
    $query->execute();
    $row = $query->fetch();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>smccart</title>
  </head>
  <body>
    <style>
    <?php
        echo $row['style'];
    ?>
    </style>
    <?php
        echo $row['html'];
    ?>
    <script>
        <?php
            echo $row['script'];
        ?>
    </script>
  </body>
</html>
