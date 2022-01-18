<?php
session_start();
require_once(__DIR__ . '/../vendor/autoload.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);
echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    $grade = explode("|", $msg->body);
    echo ' [x] Project ', $grade[0],  '  Received ', $grade[1], "\n";
    echo "$grade";
    require 'db_setup.php';
    try {
        $conn = new PDO(
            "mysql:host=$serverName;dbname=$database;",
            $user,
            $pass
        );
        
        $sql = "UPDATE `projects` SET `Grade` ='$grade[1]' WHERE (`Id` = '$grade[0]');"; 
        $sth = $conn->prepare($sql);
        $sth->execute();

        } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null; 
    $channel->wait();
    $channel->close();
    $connection->close();

};
$channel->basic_consume('hello', '', false, true, false, false, $callback);

?>
