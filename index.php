<?php


    require_once 'App.php';

    $appClass = new App();

    echo '<pre>';

    var_dump($appClass->ItemsWithTagsRoom(1));
    
    echo '</pre>';
?>