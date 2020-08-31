<?php

$URL_QUERIES = $_SERVER["QUERY_STRING"];

require_once "Utils.php";
require_once "App.php";
$appClass = new App;

/**
 * Initialisation de la session
 */
$appClass->setSession();
$appClass->_SESSION->init();

$queries = Utils::parseUrl($URL_QUERIES);

if(!isset($queries["name"]) || !$appClass->roomExist($_GET["name"])){
    header("Location: index.php");
    die("Redirection to Home page");
}

$isLoggedIn = false;
$roomName = Utils::secureString($_GET["name"]);
$room = $appClass->getRoom($roomName);
$roomId = (int)$room->ID_room;

if ($appClass->_SESSION->valid($roomId)) {
    $isLoggedIn = true;
}

if(!empty($_POST) && isset($_POST["roomPassword"])){
    $roomPassword = Utils::secureString($_POST["roomPassword"]);

    if (!$appClass->passwordVerify($roomPassword, $roomId)) {
        header('Location: index.php');
        die();
    }

    $sessionName = "loggedIn_" . $roomId;
    $isLoggedIn = true;
    $_SESSION[$sessionName] = "true";
}

if(!empty($_POST) && isset($_POST["contentItem"])) {
    $contentItem = Utils::secureString($_POST["contentItem"]);
    if(strlen($contentItem) >280) return false;
    $appClass->addItem($roomId, $contentItem);
    header('Location: '.$_SERVER['REQUEST_URI']);
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

    <title>Lucy - <?= $roomName ?></title>

    <link rel="stylesheet" href="assets/style.css">

    <?php

        if ($isLoggedIn) {
            echo '<link rel="stylesheet" href="assets/item.css">';
            echo '<link rel="stylesheet" href="assets/room.css">';
        }

    ?>
</head>
<body data-room-id="<?= $roomId ?>">
    <div id="content">
        <?php
            /*
             * Utilisateur non connecté à la room avec le mot de passe
             * On affiche le popup pour renseigner le mot de passe
             * */
            if (!$isLoggedIn):
        ?>
            <div id="popup" data-show="true">
                <form action="" enctype="application/x-www-form-urlencoded" method="post">
                    <label for="roomPassword">
                        Password
                        <input type="password" id="roomPassword" name="roomPassword" placeholder="Room password" required>
                    </label>

                    <button type="submit">GO!</button>
                </form>
            </div>
        <?php endif; ?>
        <?php
            /*
             * Utilisateur connecté à la room avec le mot de passe
             * On affiche la div#app pour VueJS
             * */
            if ($isLoggedIn):
        ?>
            <div id="content">
                <div id="app" style="display: none">
                    <div class="item" v-for="(item, index) in items">
                        <p>{{ item.content }}</p>
                        <button @click="deleteItem(index)" >X</button>
                        <div class="tags">
                            <div class="tag" v-for="tag in item.tags">
                                <span v-if="tag" >#{{tag}}</span>
                            </div>
                        </div>
                    </div>
                    <div id="popup" :data-show="popup? 'true':'false'">
                        <button @click="closePopup()" class="closePopup">X</button>
                        <form action="" enctype="application/x-www-form-urlencoded" method="post">
                            <label for="roomName">
                                Content
                                {{popupContent.length}}/{{popupMaxContent}}
                                <textarea :maxlength="popupMaxContent" name="contentItem" v-model="popupContent" id="contentItem" placeholder="Content" minlength="1" required></textarea>
                            </label>

                            <button type="submit">Create</button>
                        </form>
                    </div>
                    <button @click="openPopup()" data-type="createItem" type="button" aria-label="Create new item">+</button>
                </div>
            </div>

            <script type="module">
                import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.esm.browser.js';

                var vm = new Vue({
                    el: '#app',
                    data: {
                        popup: false,
                        items: {},
                        popupContent: "",
                        popupMaxContent: 280
                    },
                    methods: {
                        openPopup() {
                            if(this.popup) this.closePopup();
                            else this.popup = true;
                        },
                        closePopup() {
                            this.popup = false;
                        },

                        deleteItem(i) {
                            this.api_deleteItem(this.items[i].id);
                            const items = { ...this.items };
                            delete items[this.items[i].id];
                            this.items = items;
                        },
                        async api_getItems() {
                            /**
                             * Requête pour récupérer tous les items de la room dans la BDD
                             */
                            const roomId = parseInt(document.body.dataset.roomId);

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
                            /**
                             * Requête pour supprimer un item dans la BDD
                             */
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
                        document.getElementById('app').style.display = 'flex';
                        this.api_getItems();
                    }
                });
                
            </script>
        <?php endif; ?>
    </div>
</body>
</html>