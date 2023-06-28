<?php

namespace Simplemvc\Models;

use Simplemvc\Core\Model;

class MessagesModel extends Model
{
    public function getMessages(): false|array
    {
        $query = $this->db->query('SELECT * from messages');
        return $query->fetchAll();
    }

    public function newMessage($message): bool
    {
        $stmt = $this->db->prepare('INSERT INTO messages (message) values (?)');
        return $stmt->execute([$message]);
    }
}