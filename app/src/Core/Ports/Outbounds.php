<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;

class Outbounds
{

    private function __construct(
        public readonly Role\RoleRepository        $roleRepository,
        public readonly User\UserRepository        $iliasUserRepository,
        public readonly User\UserQueryRepository   $userQueryRepository,
        public readonly User\UserMessageDispatcher $userMessageDispatcher
    )
    {

    }

    public static function new(
        Role\RoleRepository        $roleRepository,
        User\UserRepository        $iliasUserRepository,
        User\UserQueryRepository   $userQueryRepository,
        User\UserMessageDispatcher $userMessageDispatcher
    )
    {
        return new self(...get_defined_vars());
    }
}