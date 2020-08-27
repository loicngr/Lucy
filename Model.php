<?php

class Model
{
    /**
     * Undocumented variable
     *
     * @var PDO $_PDO
     */
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

    protected function getItemsByRoomId($roomId)
    {
        $sql = "SELECT item.ID_item,content, item.date FROM item 
                INNER JOIN room ON item.ID_room = room.ID_room
                WHERE room.ID_room = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->execute();

        return $step->fetchAll();
    }

    protected function getTagsByItemId($itemId)
    {
        $sql = "SELECT tag.tag_name FROM item 
                INNER JOIN assoc ON item.ID_item = assoc.ID_item
                INNER JOIN tag ON assoc.ID_tag = tag.ID_tag
                WHERE item.ID_item = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$itemId);
        $step->execute();

        return $step->fetchAll();
    }

    protected function getRoomById($roomId)
    {
        $sql = "SELECT ID_room, room.name FROM room 
                WHERE room.ID_room = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->execute();

        return $step->fetchAll();
    }

    protected function getPassByRoomId($roomId)
    {
        $sql = "SELECT room.password FROM room 
                WHERE room.ID_room = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->execute();

        return $step->fetch();
    }

    protected function getItemsWithTagsByRoomId($roomId)
    {
        $sql = "SELECT item.ID_item,content, item.date, tag.tag_name FROM item 
                INNER JOIN room ON item.ID_room = room.ID_room
                INNER JOIN assoc ON item.ID_item = assoc.ID_item
                INNER JOIN tag ON assoc.ID_tag = tag.ID_tag
                WHERE room.ID_room = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->execute();

        return $step->fetchAll();
    }

    protected function addItemContent($roomId,$itemContent)
    {
        $sql = "INSERT INTO item(ID_room, content, item.date) VALUES (:id,:room,NOW())";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->bindParam(":room",$itemContent);
        $step->execute();

        $isValid = $step->rowCount();

        if ($isValid) return true;
        return false;
    }

    protected function addRoomNamePass($roomName,$roomPassword)
    {
        $sql = "INSERT INTO `room`(`name`, `password`) VALUES (:roomName,:roomPassword)";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":roomName",$roomName);
        $step->bindParam(":roomPassword",$roomPassword);
        $step->execute();

        $isValid = $step->rowCount();

        if ($isValid) return true;
        return false;
    }
}