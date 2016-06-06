<?php

    header('Content-Type: application/json');

    require('global.php');

    if(isset($_GET['id'])) {
        $query = $db->prepare("Select * from posts WHERE alias = '".$_GET['id']."'");
        $query->execute();
        $row = $query->fetch();
        echo json_encode($row);
    } else {
        $result = $db->query('Select * from posts');
        $rows = array();
        foreach($result as $post) {
            $rows[] = $post;
        }
        echo json_encode($rows);
    }

?>