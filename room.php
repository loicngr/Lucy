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
<body>
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
        <div id="app">

            <div class="item" v-for="(item, index) in items">
                <p>{{ item.content }}</p>
                <button @click="deleteItem(index)" >X</button>
                <div class="tags" >
                    <div class="tag" v-for="tag in item.tags"> #{{tag}} </div>
                </div>
            </div>

        </div>

        <?php if ($isLoggedIn): ?> 
            <script type="module">
                // importation vuejs
                // récupération des items
                // affichage
                import Vue from 'https://cdn.jsdelivr.net/npm/vue@2.6.0/dist/vue.esm.browser.js';

                var vm = new Vue({
                    el: '#app',
                    data:{
                        items: [
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            },
                            {
                                content: "https://www.youtube.com/watch?v=q0ig4egxE7g",
                                tags: [
                                    "tag1", "tag2"
                                ],
                                date: "",
                                id: ""
                            }
                        ]
                    },
                    methods: {
                        deleteItem(i){
                            this.items.splice(i, 1);
                        }
                    },

                    mounted() {
                        console.log("ok")
                    },
                });
                
            </script>
        <?php endif; ?>
    </div>
</body>
</html>
