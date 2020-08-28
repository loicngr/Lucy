<?php

require_once 'App.php';

class Api extends App
{
    public function api_getItemsByRoomId($roomID)
    {
        return $this->itemsWithTagsRoom($roomID);
    }

    public function api_deleteItemById($itemId)
    {
        return $this->deleteItemById($itemId);
    }
}

if (empty($_POST)) {
    die("false");
} else if (isset($_POST['type'])) {
    require_once 'Utils.php';

    $type = Utils::secureString($_POST['type']);

    switch ($type) {
        case 'getItemsByRoomId': {
            if (!isset($_POST['roomID'])) die("false");
            $roomID = (int)$_POST['roomID'];

            $apiClass = new Api();
            echo json_encode($apiClass->api_getItemsByRoomId($roomID));

            break;
        }
        case 'deleteItemById': {
            if (!isset($_POST['itemID'])) die("false");
            $itemID = (int)$_POST['itemID'];

            $apiClass = new Api();
            echo json_encode($apiClass->api_deleteItemById($itemID));

            break;
        }
        default:
            die("false");
    }
} else {
    die("false");
}