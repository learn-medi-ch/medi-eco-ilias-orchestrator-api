<?php

require_once "./autoload.php";

$server = new Swoole\HTTP\Server('0.0.0.0', 9501);

$server->set([]);

$server->on("WorkerStart", function ($server, $workerId) {
    echo "worker started";
});

// Triggered when the HTTP Server starts, connections are accepted after this callback is executed
$server->on("Start", function (Swoole\Http\Server $server) {
    echo "http server started";
});

// The main HTTP server request callback event, entry point for all incoming HTTP requests
$server->on('Request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {

    $api = MediEco\IliasUserOrchestratorApi\Adapters\Api\HttpApi::new();
    $api->handleHttpRequest($request, $response);
    //$response->end('<h1>Hello World!</h1>');
});

$server->on('Task', function (Swoole\Http\Server $server, $taskId, $fromId, $data) {
    echo "http server started";
});

// Triggered when the server is shutting down
$server->on("Shutdown", function ($server, $workerId) {
    echo "http server is shutting down";
});

// Triggered when worker processes are being stopped
$server->on("WorkerStop", function ($server, $workerId) {
    echo "worker processes are being stopped";
});

$server->on('WorkerError', function ($server, $workerId, $workerPid, $exitCode) {
    echo "worker error: " . PHP_EOL;
    echo $exitCode;
});

$server->start();