<?php

class Session
{
    private $name;

    public function __construct(string $name = "lucy")
    {
        $this->name = $name;
    }

    public function init()
    {
        @ini_set("session.cookie_httponly", 1);
        @ini_set("session.cookie_samesite", "Strict");
        $userFingerprint = substr(
            sha1(@$_SERVER["HTTP_USER_AGENT"] . @$_SERVER["HTTP_ACCEPT"] . @$_SERVER["HTTP_ACCEPT_LANGUAGE"] . "enjoy your stay on earth :)"),
            0,
            30
        );
        session_name($this->name. "-" . $userFingerprint);
        session_start();
        session_regenerate_id();
    }

    public function valid($roomId)
    {
        $roomId = (string)$roomId;

        $sessionName = "loggedIn_" . $roomId;
        return (isset($_SESSION[$sessionName]) AND !empty($_SESSION[$sessionName]));
    }

    public function bye()
    {
        if (!empty($_SESSION)) $_SESSION = [];
        if (isset($_COOKIE[session_name()])) setcookie(session_name(), "", time()-1, "/");
        session_destroy();
    }
}