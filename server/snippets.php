<?php

    header('Content-Type: application/json');

    require('global.php');

    $request = isset($_GET['request']) ? $_GET['request'] : 'select';
    $alias = isset($_GET['alias']) ? $_GET['alias'] : null;

    if($request == 'get') {

        $query = $db->prepare("Select * from snippets WHERE alias = '".$_GET['alias']."'");
        $query->execute();
        $row = $query->fetch();
        echo json_encode($row);

    } elseif($request == 'list') {

        $result = $db->query('Select * from snippets');
        $rows = array();
        foreach($result as $post) {
            $rows[] = $post;
        }
        echo json_encode($rows);

    } elseif($request == 'update') {

        $affected = $db->exec("UPDATE snippets SET html = ".$db->quote($_POST['html']).", script = ".$db->quote($_POST['script']).", style = ".$db->quote($_POST['style'])." WHERE alias = '".$_GET['alias']."'");
        $json = "success: ".$affected;
        echo json_encode($json);

    } elseif($request == 'delete') {

    } elseif($request == 'insert') {

    }

?>