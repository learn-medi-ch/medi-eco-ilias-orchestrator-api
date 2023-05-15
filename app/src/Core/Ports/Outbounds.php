<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;

class Outbounds {

    private function __construct(
        public readonly IliasRestApiClient $iliasRestApiClient,
        public readonly User\UserQueryRepository $userQueryRepository,
        public readonly User\UserMessageDispatcher $userMessageDispatcher
    )
    {

    }

    public static function new(
        IliasRestApiClient $iliasRestApiClient,
        User\UserQueryRepository $userQueryRepository,
        User\UserMessageDispatcher $userMessageDispatcher
    ) {
        return new self(...get_defined_vars());
    }
}