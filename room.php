<?php

$URL_QUERIES = $_SERVER["QUERY_STRING"];

require_once "Utils.php";
require_once "App.php";
$appClass = new App;

$queries = Utils::parseUrl($URL_QUERIES);

if(!isset($queries["name"]) || !$appClass->roomExist($_GET["name"])){
    header("Location:index.php");
    die();   
}

$isLoggedIn = false;
$roomId = null;

if(!empty($_POST) && isset($_POST["roomPassword"])){

    $roomName = Utils::secureString($_GET["name"]);
    $roomPassword = Utils::secureString($_POST["roomPassword"]);
    $room = $appClass->getRoom($roomName);
    $roomId = (int)$room->ID_room;

    if (!$appClass->passwordVerify($roomPassword, $roomId)) {
        header('Location: index.php');
        die();
    }

    $isLoggedIn = true;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="Lucy project">
    <meta name="author" content="Loïc, Kevin">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="item.css">
    <title>Lucy - Home</title>

</head>
<body data-room-id="<?= $roomId ?>">
    <div id="content">
        <?php if (!$isLoggedIn): ?>
            <div id="popup" data-show="true">
                <form action="" enctype="application/x-www-form-urlencoded" method="post">

                    <label for="roomPassword">
                        Password
                        <input type="password" id="roomPassword" name="roomPassword" placeholder="Room password" required>
                    </label>

                    <button type="submit">ok</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <div id="app">

                <span v-if="Object.keys(items).length">
                    <div class="item" v-for="(item, index) in items">
                        <p>{{ item.content }}</p>
                        <button @click="deleteItem(index)" >X</button>
                        <div class="tags">
                            <div class="tag" v-for="tag in item.tags">
                                <span v-if="tag" >#{{tag}}</span>
                            </div>
                        </div>
                    </div>
                </span>

            </div>
            <script type="module">
                import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.esm.browser.js';

                var vm = new Vue({
                    el: '#app',
                    data: {
                        items: {}
                    },
                    methods: {
                        deleteItem(i) {
                            this.api_deleteItem(this.items[i].id);
                            const items = { ...this.items };
                            delete items[this.items[i].id];
                            this.items = items;
                        },
                        async api_getItems() {
                            const roomId = parseInt(document.body.dataset?.roomId);

                            const formulaire = new FormData();
                            formulaire.append('type', 'getItemsByRoomId');
                            formulaire.append('roomID', roomId);

                            const response = await fetch('Api.php', {
                                method: 'POST',
                                body: formulaire
                            });

                            const data = await response.json();
                            this.items = data;
                        },
                        async api_deleteItem(itemId) {
                            const formulaire = new FormData();
                            formulaire.append('type', 'deleteItemById');
                            formulaire.append('itemID', parseInt(itemId));

                            const response = await fetch('Api.php', {
                                method: 'POST',
                                body: formulaire
                            });

                            await response.json();
                        }
                    },
                    mounted() {
                        this.api_getItems();
                    }
                });
                
            </script>
        <?php endif; ?>
    </div>
</body>
</html>
