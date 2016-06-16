<?php

    header('Content-Type: application/json');

    require('global.php');

    $action = isset($_GET['action']) ? $_GET['action'] : 'select';
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if($type == 'get') {

        $query = $db->prepare("Select * from snippets WHERE alias = '".$_GET['id']."'");
        $query->execute();
        $row = $query->fetch();
        echo json_encode($row);

    } elseif($type == 'list') {

        $result = $db->query('Select * from snippets');
        $rows = array();
        foreach($result as $post) {
            $rows[] = $post;
        }
        echo json_encode($rows);

    } elseif($type == 'update') {

        $affected = $db->exec("UPDATE snippets SET html = '".$_POST['html']."' WHERE  = '".$_GET['id']."'");
        $json = "success: $affected";
        echo json_encode($json);

    } elseif($type == 'delete') {

    } elseif($type == 'insert') {

    }

?>