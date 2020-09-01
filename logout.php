<?php


if (isset($_GET['roomId']))
{
    require_once 'App.php';

    $roomId = (int)$_GET['roomId'];

    $appClass = new App();
    $appClass->setSession();
    $appClass->_SESSION->init();
    $appClass->_SESSION->bye($roomId);
}

header('Location: .');
die('Redirected to home');