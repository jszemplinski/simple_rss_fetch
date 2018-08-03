<?php

use JacekSzemplinski\src\Commands;

require_once "Commands.php";

$cmdHandler = new Commands();
$cmdHandler->run($argv);