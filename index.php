<?php

require 'vendor/autoload.php';

use React\EventLoop\Factory;
use React\Socket\Server;
use React\Socket\ConnectionInterface;

$loop = Factory::create();

$server = new Server($loop);

$server->on('connection', function (ConnectionInterface $connection) {
    echo "New connection\n";

    // Xử lý các sự kiện từ client
    $connection->on('data', function ($data) use ($connection) {
        // Xử lý dữ liệu nhận được từ client
        echo "Received: $data\n";

        // Phản hồi lại client
        $connection->write("You said: $data");
    });

    // Xử lý sự kiện khi client đóng kết nối
    $connection->on('close', function () {
        echo "Connection closed\n";
    });
});

echo "WebSocket server started at ws://127.0.0.1:8080\n";

$server->listen(8080);

$loop->run();
