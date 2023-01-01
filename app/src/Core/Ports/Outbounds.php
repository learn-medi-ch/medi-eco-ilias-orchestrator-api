<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

class Outbounds {

    private function __construct(
        public readonly User\UserQueryRepository $userQueryRepository,
        public readonly User\UserMessageDispatcher $userMessageDispatcher
    )
    {

    }

    public static function new(
        User\UserQueryRepository $userQueryRepository,
        User\UserMessageDispatcher $userMessageDispatcher
    ) {
        return new self(...get_defined_vars());
    }
}