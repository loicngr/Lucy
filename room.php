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
    <link rel="stylesheet" href="assets/menu.css">

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
                    <label id="searchTag">
                        <input type="text" placeholder="Tag" v-model="activeTag">
                        <button data-type="clearSearchTag" @click="activeTag = ''">X</button>
                        <button data-type="sortDate" @click="itemsSortDate = (itemsSortDate === 'asc')? 'desc':'asc'">Filter - Date</button>
                    </label>
                    <div id="items">
                        <div class="item" v-for="(item, index) in filteredItems">
                            <p>{{ item.content }}</p>
                            <button @click="deleteItem(index)" >X</button>
                            <div class="tags" v-if="item.tags.length !== 0">
                                <div class="tag" v-for="tag in item.tags">
                                    <span v-if="tag" @click="activeTag = tag" >#{{tag}}</span>
                                </div>
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

                    <!--
                        Application side menu
                    -->
                    <button id="BTNmenu" >MENU</button>
                    <nav>
                        <ul>
                            <li>
                                <a @click="decoRoom(<?= $roomId ?>)" >Logout</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <script src="assets/room_vue.js" type="module"></script>
        <?php endif; ?>
    </div>
</body>
</html>