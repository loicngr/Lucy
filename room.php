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
        // Room posté en BDD
        // redirection
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
        <div id="popup" data-show="<?php echo $isLoggedIn; ?>">
            <form action="" enctype="application/x-www-form-urlencoded" method="post">

                <label for="roomPassword">
                    Password
                    <input type="password" id="roomPassword" name="roomPassword" placeholder="Room password" required>
                </label>

                <button type="submit">ok</button>
            </form>
        </div>
    </div>

</body>
</html>
