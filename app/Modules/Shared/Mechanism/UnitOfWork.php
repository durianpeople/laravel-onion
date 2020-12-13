<?php


namespace App\Modules\Shared\Mechanism;


use Illuminate\Database\ConnectionInterface;

class UnitOfWork
{
    private ConnectionInterface $db;

    public static function newInstance(ConnectionInterface $db): UnitOfWork
    {
        return new UnitOfWork($db);
    }

    /**
     * @param ConnectionInterface $db
     */
    public function __construct(ConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function begin(): void
    {
        MessageBus::holdMessages();
        $this->db->beginTransaction();
    }

    public function commit(): void
    {
        $this->db->commit();
        MessageBus::releaseMessages();
    }

    public function rollback(): void
    {
        $this->db->rollBack();
        MessageBus::resetMessages();
        MessageBus::releaseMessages();
    }
}