<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

final readonly class Outbounds
{

    private function __construct(
        public Category\CategoryRepository $categoryRepository,
        public Role\RoleRepository         $roleRepository,
        public User\UserRepository         $iliasUserRepository,
        public User\UserQueryRepository    $userQueryRepository,
        public User\UserMessageDispatcher  $userMessageDispatcher
    )
    {

    }

    public static function new(
        Category\CategoryRepository $categoryRepository,
        Role\RoleRepository        $roleRepository,
        User\UserRepository        $iliasUserRepository,
        User\UserQueryRepository   $userQueryRepository,
        User\UserMessageDispatcher $userMessageDispatcher
    )
    {
        return new self(...get_defined_vars());
    }
}