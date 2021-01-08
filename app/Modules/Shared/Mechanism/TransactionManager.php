<?php


namespace App\Modules\Shared\Mechanism;


use Illuminate\Database\ConnectionInterface;

class TransactionManager
{
    private ConnectionInterface $db;

    /**
     * @param ConnectionInterface $db
     */
    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public static function newInstance(ConnectionInterface $db): TransactionManager
    {
        return new TransactionManager($db);
    }

    public function begin(): void
    {
        EventManager::hold();
        $this->db->beginTransaction();
    }

    public function commit(): void
    {
        $this->db->commit();
        EventManager::release();
    }

    public function rollback(): void
    {
        $this->db->rollBack();
        EventManager::reset();
        EventManager::release();
    }
}