<?php
/* @var \Aura\Router\Map $map */
$map->route('/api/ticket', '/api/tickets/{id}');
$map->route('/weekday', '/api/weekday/{year}/{month}/{day}');

$map->route('/tickets', '/ticket/{id}');
