<?php

$URL_QUERIES = $_SERVER["QUERY_STRING"];

require_once "Utils.php";

$queries = Utils::parseUrl($URL_QUERIES);

if(!isset($queries["name"])){
    die();
}

require_once "App.php";

$appClass = new App;

$room = $appClass->room(Utils::secureString($queries["name"]));

$roomId = (int)$room->ID_room;

$items = $appClass->itemsRoom($roomId);

var_dump(Utils::getTags($items[0]->content));