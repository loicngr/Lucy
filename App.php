<?php

require_once 'Model.php';

class App extends Model
{

    public function itemsRoom($roomId)
    {
        return $this->getItemsByRoomId($roomId);
    }

    public function itemTag($itemId)
    {
        return $this->getTagsByItemId($itemId);
    }

    public function Room($roomId)
    {
        return $this->getRoomById($roomId);
    }

    public function passwordVerify($password, $roomId)
    {
        $dataPass = $this->getPassByRoomId($roomId);
        
        if(password_verify($password, $dataPass->password)){
            return true;
        }else{
            return false;
        }
    }

    public function ItemsWithTagsRoom($roomId)
    {
        $itemsWithTags = [];
        $items = $this->getItemsWithTagsByRoomId($roomId);

        foreach ($items as $item) {
            if (!isset($itemsWithTags[$item->ID_item])){
                $itemsWithTags[$item->ID_item] = [
                    "tags"=> [],
                    "content"=> $item->content,
                    "date"=> $item->date
                ];
            }
            array_push($itemsWithTags[$item->ID_item]["tags"],$item->tag_name);
            
        }
        return $itemsWithTags;
    }

}