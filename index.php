<?php
    if(!empty($_POST) && isset($_POST["roomName"]) && isset($_POST["roomPassword"])){
        require_once 'Utils.php';
        require_once 'App.php';

        $roomName = Utils::secureString($_POST["roomName"]);
        $roomPassword = Utils::secureString($_POST["roomPassword"]);

        $appClass = new App;
        if ($appClass->addRoom($roomName, $roomPassword)) {
            // Room posté en BDD
            // redirection
            header('Location: room.php?name=' . $roomName);
            die();
        } else {
            // Room non posté en BDD
        }

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

    <title>Lucy - Home</title>

    <style>
        *, *::after {
            box-sizing: border-box;
        }
        body {
            width: 100%;
            height: 100%;

            background-color: beige;
            margin: 0;

            display: grid;
            place-content: center;
        }

        #content {
            width: 100%;
            min-height: 100vh;
            height: auto;

            display: flex;
            flex-direction: column;
            align-content: center;
            justify-content: center;
        }

        button {
            width: auto;
            height: auto;

            border: none;
            cursor: pointer;
            transition: all .5s ease-in-out;
            font-weight: bold;
            font-size: 2rem;
            border-radius: 5px;
        }
        button:hover {
            background-color: #b1b0b0;
        }
        button[data-type="createRoom"] {
            width: 100px;
            height: 100px;

            font-size: 50px;
            color: dodgerblue;
            border-radius: 50%;
            background-color: gray;
        }

        #popup {
            width: 300px;
            height: 400px;

            position: fixed;
            top: calc(50vh - 200px);
            left: calc(50vw - 150px);

            background-color: gray;

            display: grid;
            place-content: center;
        }
        #popup[data-show="false"] {
            display: none;
        }
        #popup[data-show="true"] {
            display: grid;
        }
        #popup form {
            width: 100%;

            display: flex;
            flex-direction: column;
        }
        #popup label {
            margin: 10px 0;
            color: aliceblue;
        }
        #popup input {
            width: 100%;
            height: 40px;

            border-radius: 4px;
        }
        #popup button {
            width: 100%;
            height: 40px;

            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="content">
        <div id="popup" data-show="false">
            <form action="" enctype="application/x-www-form-urlencoded" method="post">
                <label for="roomName">
                    Name
                    <input type="text" id="roomName" name="roomName" placeholder="Room name" required>
                </label>
                <label for="roomPassword">
                    Password
                    <input type="password" id="roomPassword" name="roomPassword" placeholder="Room password" required>
                </label>

                <button type="submit">Create</button>
            </form>
        </div>
        <button data-type="createRoom" type="button" aria-label="Create new room">+</button>
    </div>

    <script>
        const popupElement = document.getElementById('popup');
        const buttonCreateRoom = document.querySelector('button[data-type="createRoom"]');
        buttonCreateRoom.addEventListener('click', (evt) => {
            popupElement.dataset.show = (popupElement.dataset.show === 'true')? 'false':'true';
        });
    </script>
</body>
</html>
