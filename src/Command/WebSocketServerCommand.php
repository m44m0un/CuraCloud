<?php

// src/Command/WebSocketServerCommand.php
namespace App\Command;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocketServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WebSocketServerCommand extends Command
{
    protected static $defaultName = 'app:websocket-server';

    private $webSocketServer;

    public function __construct(WebSocketServer $webSocketServer)
    {
        parent::__construct();
        $this->webSocketServer = $webSocketServer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Starts the WebSocket server')
            ->setHelp('This command starts the WebSocket server for live streaming.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('WebSocket server started. Use Ctrl+C to stop.');

        // Create the WebSocket server
        $server = IoServer::factory(
            new HttpServer(
                new WsServer($this->webSocketServer)
            ),
            8080 // You can adjust the port as needed
        );

        // Run the server
        $server->run();

        return Command::SUCCESS;
    }
}

