<?php
require dirname(__DIR__) . '/autoload.php';
/*
 * 画面表示は html-app
 * API は hal-api-app
 *  API ではパスに /api/ をつける
 * 本番環境では先頭に prod- をつける
 */
$context = (strpos($_SERVER['REQUEST_URI'], '/api/') === 0) ? 'hal-api-app' : 'html-app';
exit((require dirname(__DIR__) . '/bootstrap.php')($context));
