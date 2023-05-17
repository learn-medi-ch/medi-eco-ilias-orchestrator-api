<?php

require_once __DIR__ . "/../autoload.php";

use MediEco\IliasUserOrchestratorOrbital\Adapters\Api\CliApi;

$cliApi = CliApi::new();

$cliApi->install();