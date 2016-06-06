<?php

    header('Content-Type: application/json');

    require('global.php');

    $result = $db->query('Select * from posts');

    $rows = array();
    foreach($result as $post) {
        $rows[] = $post;
    }
    echo json_encode($rows);

?>