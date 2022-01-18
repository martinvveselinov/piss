<?php

session_start();

require_once(__DIR__ . '/../vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;





function sendMessage($message){
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();
    $channel->queue_declare('hello', false, false, false, false);

    $msg = new AMQPMessage($message);
    $channel->basic_publish($msg, '', 'hello');
    
    echo " [x] Sent 'Hello World!'\n";
    $channel->close();
$connection->close();
}


?>
