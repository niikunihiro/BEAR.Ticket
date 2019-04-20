<?php
/* @var \Aura\Router\Map $map */
$map->route('/ticket', '/tickets/{id}');
$map->route('/weekday', '/weekday/{year}/{month}/{day}');
$map->route('/tickets', '/ticket/page/{id}');
