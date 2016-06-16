<?php 
    $db = new PDO('sqlite:../smccart.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>