<?php

// src/WebsocketServer.php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Mercure\PublisherInterface;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    private $userStreams;
    private $userPauseStates;
    private $publisher;

    public function __construct(PublisherInterface $publisher)
    {
        $this->clients = new \SplObjectStorage;
        $this->userStreams = [];
        $this->userPauseStates = [];
        $this->publisher = $publisher;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if (isset($data['type'])) {
            switch ($data['type']) {
                case 'start_stream':
                    $this->startStream($from);
                    break;
                case 'pause_stream':
                    $this->pauseStream($from);
                    break;
                case 'stream_message':
                    $this->broadcastStreamMessage($from, $data['content']);
                    break;
                // Handle other message types as needed
                default:
                    echo "Unsupported message type: {$data['type']}\n";
            }
        } else {
            echo "Received message without a type\n";
        }
    }

    private function broadcastStreamMessage(ConnectionInterface $from, string $content)
    {
        // Debug statement 1
        echo "Broadcasting stream message from user {$from->userId}\n";
    
        // Broadcast the stream message to all connected clients
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                // Debug statement 2
                echo "Sending stream message to user {$client->userId}\n";
    
                $client->send(json_encode([
                    'type' => 'stream_message',
                    'userId' => $from->userId,
                    'content' => $content,
                ]));
            }
        }
    
        // Publish a message to Mercure
        $this->publisher->__invoke(new Update(
            '%env(MERCURE_URL)%', // Replace with your actual URL
            json_encode([
                'type' => 'stream_message',
                'userId' => $from->userId,
                'content' => $content,
            ])
        ));
    
        // Debug statement 3
        echo "Stream message broadcasted by user {$from->userId}\n";
    }

    private function startStream(ConnectionInterface $from)
    {
        // Check if the user is already streaming
        if (isset($this->userStreams[$from->userId])) {
            echo "User {$from->userId} is already streaming\n";
            return;
        }

        // Mark the user as streaming
        $this->userStreams[$from->userId] = $from;
        $this->userPauseStates[$from->userId] = false;

        // Broadcast the stream start to all connected clients
        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send(json_encode(['type' => 'stream_started', 'userId' => $from->userId]));
            }
        }

        // Publish a message to Mercure
        $this->publisher->__invoke(new Update(
            'http://example.com/streams', // Replace with your actual URL
            json_encode(['type' => 'stream_started', 'userId' => $from->userId])
        ));

        echo "User {$from->userId} has started streaming\n";
    }

    private function pauseStream(ConnectionInterface $from)
    {
        // Update the user's pause state
        $this->userPauseStates[$from->userId] = !$this->userPauseStates[$from->userId];

        // Broadcast the pause state to all connected clients
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'type' => 'pause_stream',
                'userId' => $from->userId,
                'isPaused' => $this->userPauseStates[$from->userId],
            ]));
        }

        echo "User {$from->userId} has toggled the stream pause state\n";
    }

    public function onClose(ConnectionInterface $conn)
    {
        // Remove the connection from the list of streaming users if applicable
        unset($this->userStreams[$conn->userId]);
        unset($this->userPauseStates[$conn->userId]);

        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}


