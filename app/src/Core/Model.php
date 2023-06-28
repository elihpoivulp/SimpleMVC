<?php

namespace Simplemvc\Core;

use Exception;
use PDO;

class Model
{
    protected PDO $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->db = DBConnection::getConnection();
    }
}