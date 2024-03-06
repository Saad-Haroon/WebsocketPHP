<?php

namespace App\Websocket;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;

/**
 * Class MessageHandler
 * @package App\Websocket
 */
class MessageHandler implements MessageComponentInterface
{
    /** @var SplObjectStorage $connections */
    private SplObjectStorage $connections;

    public function __construct()
    {
        $this->connections = new SplObjectStorage();
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onOpen(ConnectionInterface $conn): void
    {
        $this->connections->attach($conn);
    }

    /**
     * @param ConnectionInterface $from
     * @param $msg
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $msg): void
    {
        foreach($this->connections as $connection) {
            if ($connection === $from) {
                continue;
            }

            $connection->send($msg);
        }
    }

    /**
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn): void
    {
        $this->connections->detach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @param Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, Exception $e): void
    {
        $this->connections->detach($conn);
        $conn->close();
    }
}