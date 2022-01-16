<?php
session_start();
require_once(__DIR__ . '/../vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";
$message = "";
$callback = function ($msg) {
    $grade = explode("|", $msg->body);
    echo ' [x] Project ', $grade[0],  '  Received ', $grade[1], "\n";
    $message = $msg->body;
};
$_SESSION['message'] = $message;

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>