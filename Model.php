<?php

require_once 'Utils.php';

class Model
{
    /**
     * Instance de PDO
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

    /**
     * Retourne les items dans une room
     *
     * @param integer $roomId
     * @return array
     */
    protected function m_getItemsByRoomId($roomId)
    {
        $roomId = (int)$roomId;

        $sql = "SELECT item.ID_item,content, item.date FROM item 
                INNER JOIN room ON item.ID_room = room.ID_room
                WHERE room.ID_room = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->execute();

        return $step->fetchAll();
    }

    /**
     * Retourne les tags dans un item
     *
     * @param integer $itemId
     * @return array
     */
    protected function m_getTagsByItemId($itemId)
    {
        $itemId = (int)$itemId;

        $sql = "SELECT tag.tag_name FROM item 
                INNER JOIN assoc ON item.ID_item = assoc.ID_item
                INNER JOIN tag ON assoc.ID_tag = tag.ID_tag
                WHERE item.ID_item = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$itemId);
        $step->execute();

        return $step->fetchAll();
    }

    /**
     * Retourne une room par son ID
     *
     * @param integer $roomId
     * @return mixed
     */
    protected function m_getRoomById($roomId)
    {
        $roomId = (int)$roomId;

        $sql = "SELECT ID_room, room.name FROM room 
                WHERE room.ID_room = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->execute();

        return $step->fetch();
    }

    /**
     * Retourne une room par son nom
     *
     * @param string $roomName
     * @return mixed
     */
    protected function m_getRoomByName($roomName)
    {
        $roomName = Utils::secureString($roomName);

        $sql = "SELECT ID_room FROM room 
                WHERE room.name = :name";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":name",$roomName);
        $step->execute();

        return $step->fetch();
    }

    /**
     * Retourne le password de la room
     *
     * @param integer $roomId
     * @return mixed
     */
    protected function m_getPassByRoomId($roomId)
    {
        $roomId = (int)$roomId;

        $sql = "SELECT room.password FROM room 
                WHERE room.ID_room = :id";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->execute();

        return $step->fetch();
    }

    /**
     * Retourne les items avec leurs tags dans une room
     *
     * @param integer $roomId
     * @return array
     */
    protected function m_getItemsWithTagsByRoomId($roomId)
    {
        $roomId = (int)$roomId;

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

    /**
     * Ajoute un item dans uen room
     *
     * @param integer $roomId
     * @param string $itemContent
     * @return bool
     */
    protected function m_addItem($roomId, $itemContent)
    {
        $roomId = (int)$roomId;
        $itemContent = Utils::secureString($itemContent);

        $sql = "INSERT INTO item(ID_room, content, item.date) VALUES (:id,:room,NOW())";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":id",$roomId);
        $step->bindParam(":room",$itemContent);
        $step->execute();

        $isValid = $step->rowCount();

        if ($isValid) return true;
        return false;
    }

    /**
     * Ajoute une room
     *
     * @param string $roomName
     * @param string $roomPassword
     * @return bool
     */
    protected function m_addRoom($roomName, $roomPassword)
    {
        $roomName = Utils::secureString($roomName);
        $roomPassword = Utils::secureString($roomPassword);

        $sql = "INSERT INTO `room`(`name`, `password`) VALUES (:roomName, :roomPassword)";
        $step = $this->_PDO->prepare($sql);
        $step->bindParam(":roomName",$roomName);
        $step->bindParam(":roomPassword",$roomPassword);
        $step->execute();

        $isValid = $step->rowCount();

        if ($isValid) return true;
        return false;
    }
}