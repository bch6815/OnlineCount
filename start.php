<?php
/**
 * User: bc8 /bc8web@126.com
 * Date: 2019/3/15 0015 - 下午 16:34
 */

use Workerman\Worker;

require_once 'vendor/autoload.php';

$worker = new Worker("websocket://0.0.0.0:1234");
$worker->onLineCount = 0; // 当前在线人数

$worker->onConnect = function ($connection) use ($worker) {
    $worker->onLineCount++;
    $connection->send($worker->onLineCount);
    \Workerman\Lib\Timer::add(1, function () use ($connection, $worker) {
        $connection->send($worker->onLineCount);
    });
};

$worker->onClose = function ($connection) use ($worker) {
    $worker->onLineCount--;
};

Worker::runAll();