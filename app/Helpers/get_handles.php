<?php
$json = file_get_contents('database/json/users.json');
$users = json_decode($json, true);
$handles = array_map(function($u) { return $u['cf_handle']; }, $users);
echo implode(';', $handles);
