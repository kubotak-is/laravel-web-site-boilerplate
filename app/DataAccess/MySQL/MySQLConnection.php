<?php
declare(strict_types=1);

namespace App\DataAccess\MySQL;

use Illuminate\Database\DatabaseManager;

/**
 * Class MySQLConnection
 * @package App\DataAccess\MySQL
 */
class MySQLConnection
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected $db;
    
    /**
     * MySQLConnection constructor.
     * @param DatabaseManager $manager
     */
    public function __construct(DatabaseManager $manager)
    {
        $this->db = $manager->connection('mysql');
    }
}
