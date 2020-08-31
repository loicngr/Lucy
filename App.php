<?php

require_once 'Model.php';
require_once 'includes/Session.php';

class App extends Model
{
    /**
     * @var Session $_SESSION
     */
    public $_SESSION;

    public function setSession()
    {
        $this->_SESSION = new Session();
    }

    /**
     * Retourne les items dans la room sans les tags
     *
     * @param integer $roomId
     * @return array
     */
    public function itemsRoom($roomId)
    {
        return $this->m_getItemsByRoomId($roomId);
    }

    /**
     * Retourne les tags d'un item
     *
     * @param integer $itemId
     * @return array
     */
    public function itemTag($itemId)
    {
        return $this->m_getTagsByItemId($itemId);
    }

    /**
     * Retourne une Room par son nom
     *
     * @param string $roomName
     * @return mixed
     */
    public function getRoom($roomName)
    {
        return $this->m_getRoomByName($roomName);
    }

    /**
     * Vérifie le mot de passe de la Room
     *
     * @param string $password
     * @param integer $roomId
     * @return bool
     */
    public function passwordVerify($password, $roomId)
    {
        $dataPass = $this->m_getPassByRoomId($roomId);
        
        if(password_verify($password, $dataPass->password)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Retourne un tableau d'items avec leurs tags
     *
     * @param integer $roomId
     * @return array
     */
    public function itemsWithTagsRoom($roomId)
    {
        $itemsWithTags = [];
        $items = $this->m_getItemsWithTagsByRoomId($roomId);

        foreach ($items as $item) {
            if (!isset($itemsWithTags[$item->ID_item])){
                $itemsWithTags[$item->ID_item] = [
                    "id" => $item->ID_item,
                    "tags"=> [],
                    "content"=> $item->content,
                    "date"=> $item->date
                ];
            }
            array_push($itemsWithTags[$item->ID_item]["tags"],$item->tag_name);
            
        }
        return $itemsWithTags;
    }

    /**
     * Ajoute un item dans une room
     *
     * @param integer $roomId
     * @param string $itemContent
     * @return bool
     */
    public function addItem($roomId, $itemContent)
    {
        // TODO: supprimer les tags dans le content avant de l'envoyer en bdd
        $itemID = $this->m_addItem($roomId, $itemContent);
        if (!$itemID) Utils::printError("Impossible d'ajouter l'item");

        $tagsContent = Utils::getTags($itemContent);
        if (!empty($tagsContent))
        {
            foreach ($tagsContent as $tag)
            {
                $isTagExist = $this->m_getTagIdByName($tag);
                $tagId = null;

                if (!$isTagExist) {
                    $tagId = $this->m_addTag($tag);
                } else {
                    $tagId = (int)$isTagExist->ID_tag;
                }

                if (!$this->m_addAssocItemTag($itemID, $tagId)) Utils::printError("Impossible d'ajouter la relation.");
            }
        }

        return true;
    }

    /**
     * Ajouter une nouvelle Room
     *
     * @param string $roomName
     * @param string $password
     * @return bool
     */
    public function addRoom($roomName,$password)
    {
        $roomPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->m_addRoom($roomName, $roomPassword);
    }

    /**
     * Vérifie le nom de la room
     *
     * @param string $roomName
     * @return bool
     */
    public function roomExist($roomName)
    {
        $room = $this->m_getRoomByName($roomName);
        if(!empty($room)){
            return true;
        }
        return false;
    }

    /**
     * Supprimer un item
     *
     * @param integer $itemId
     * @return bool
     */
    public function deleteItemById($itemId)
    {
        return $this->m_deleteItemById($itemId);
    }
}