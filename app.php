<?php

use RC\core\ajax\Request;
use RC\core\cache\FileCache;
use RC\core\cache\MemoryCache;
use RC\RCSDK;

$credentials = require('credentials.php');

$cacheDir = __DIR__ . DIRECTORY_SEPARATOR . '_cache';

if (!file_exists($cacheDir)) {
    mkdir($cacheDir);
}

$rcsdkMemory = new RCSDK(new MemoryCache(), $credentials['appKey'], $credentials['appSecret']);
$rcsdkFile = new RCSDK(new FileCache($cacheDir), $credentials['appKey'], $credentials['appSecret']);

//////////

$memoryPlatform = $rcsdkMemory->getPlatform();

$auth = $memoryPlatform->authorize($credentials['username'], $credentials['extension'], $credentials['password']);

print 'Memory Authorized' . PHP_EOL;

$refresh = $memoryPlatform->refresh();

print 'Memory Refreshed' . PHP_EOL;

$call = $memoryPlatform->apiCall(new Request('GET', '/account/~/extension/~'));

print 'Memory User loaded ' . $call->getResponse()->getData()['name'] . PHP_EOL;

print '----------' . PHP_EOL;

//////////

$filePlatform = $rcsdkFile->getPlatform();

try {
    $filePlatform->isAuthorized();
    print 'File is authorized already' . PHP_EOL;
} catch (Exception $e) {
    $auth = $filePlatform->authorize($credentials['username'], $credentials['extension'], $credentials['password']);
    print 'File Authorized' . PHP_EOL;
}

$call = $filePlatform->apiCall(new Request('GET', '/account/~/extension/~'));

print 'File User loaded ' . $call->getResponse()->getData()['name'] . PHP_EOL;