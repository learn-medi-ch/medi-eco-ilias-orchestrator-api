<?php
#require_once __DIR__ . '/libs/flux-ilias-rest-api-client/autoload.php';

spl_autoload_register(function (string $class) {
    $namespace = "MediEco\\IliasUserOrchestratorOrbital";
    $baseDirectory = '/opt/medi-eco-ilias-user-orchestrator-orbital/app/src';
    loadClassFileIliasUserOrchestratorOrbital($namespace, $class, $baseDirectory);
});

spl_autoload_register(function (string $class) {
    $namespace = "Shuchkin";
    $baseDirectory = '/opt/medi-eco-ilias-user-orchestrator-orbital/app/libs/simple-xlsx/src';
    loadClassFileIliasUserOrchestratorOrbital($namespace, $class, $baseDirectory);
});

spl_autoload_register(function (string $class) {
    $namespace = "FluxEco\\DispatcherSynapse";
    $baseDirectory = '/opt/flux-eco-dispatcher-synapse/app/src';
    loadClassFileIliasUserOrchestratorOrbital($namespace, $class, $baseDirectory);
});


/**
 * @param string $namespace
 * @param string $class
 * @param string $baseDirectory
 * @return void
 */
function loadClassFileIliasUserOrchestratorOrbital(string $namespace, string $class, string $baseDirectory): void
{
    $classNameParts = explode($namespace, $class);
    // not our responsibility
    if (count($classNameParts) !== 2) {
        return;
    }
    $filePath = str_replace('\\', '/', $classNameParts[1]) . '.php';
    require $baseDirectory . $filePath;
}