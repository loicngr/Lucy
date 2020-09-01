<?php

    $erreurStatus = '';

    if(!empty($_POST) && isset($_POST["roomName"]) && isset($_POST["roomPassword"])){
        require_once 'Utils.php';
        require_once 'App.php';

        $roomName = Utils::secureString($_POST["roomName"]);
        $roomPassword = Utils::secureString($_POST["roomPassword"]);

        if (strlen($roomName) <= 5) {
            $erreurStatus = 'room_name_short';
            die();
        }

        if (strlen($roomPassword) <= 5) {
            $erreurStatus = 'room_password_short';
            die();
        }

        $roomName = str_replace(' ', '_', $roomName);
        $appClass = new App;
        if (empty($appClass->roomExist($roomName))) {
            if ($appClass->addRoom($roomName, $roomPassword)) {
                header('Location: room.php?name=' . $roomName);
                die();
            } else {
                // Erreur lors de l'ajout en BDD de la room
                $erreurStatus = 'creation_error';
            }
        } else {
            // Room existe déjà
            $erreurStatus = 'already_exist';
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

    <link rel="stylesheet" href="assets/style.css">
</head>
<body data-error="<?= $erreurStatus;?>">
    <div id="content">
        <div id="popup" data-show="false">
            <form action="" enctype="application/x-www-form-urlencoded" method="post">
                <label for="roomName">
                    Name
                    <input type="text" id="roomName" name="roomName" placeholder="Room name" minlength="6" required>
                </label>
                <label for="roomPassword">
                    Password
                    <input type="password" id="roomPassword" name="roomPassword" minlength="6" placeholder="Room password" required>
                </label>

                <button type="submit">Create</button>
            </form>
        </div>
        <button data-type="createRoom" type="button" aria-label="Create new room">+</button>
    </div>

    <script>
        function main() {
            const popupElement = document.getElementById('popup');
            const buttonCreateRoom = document.querySelector('button[data-type="createRoom"]');
            buttonCreateRoom.addEventListener('click', (evt) => {
                popupElement.dataset.show = (popupElement.dataset.show === 'true')? 'false':'true';
            });

            const errorStatus = document.body.dataset.error;
            switch (errorStatus) {
                case 'already_exist':
                    alert('Room is already created.');
                    break;
                case 'creation_error':
                    alert('An error occurred during room creation.');
                    break;
                case 'room_name_short':
                    alert('Room name is too short. (Minimum length: 6)');
                    break;
                case 'room_password_short':
                    alert('Room password is too short. (Minimum length: 6)');
                    break;
                default:
                    break;
            }
        }

        main();
    </script>
</body>
</html>
