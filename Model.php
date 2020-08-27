<?php

class Model
{
    private $_PDO;

    public function __construct()
    {
        $this->pdoConnection();
    }

    private function pdoConnection(): void
    {
        require_once '../env.php';

        /**
         * Paramètres PDO
         */
        $DB_OPTIONS = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::MYSQL_ATTR_FOUND_ROWS   => true
        ];

        try {
            $this->_PDO = new PDO("mysql:host=". DB_HOST .";dbname=". DB_NAME .";charset=utf8mb4", DB_USER, DB_PASS, $DB_OPTIONS);
        } catch (PDOException $exception) {
            die("Erreur !: " . $exception->getMessage() . "<br/>");
        }
    }


    protected function getRooms()
    {

        echo "ok";
    }
}