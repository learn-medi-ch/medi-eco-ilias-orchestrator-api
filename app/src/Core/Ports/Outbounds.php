<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\SpaceNode;

final readonly class Outbounds
{

    private function __construct(
        public Course\CourseRepository     $courseRepository,
        public Category\CategoryRepository $categoryRepository,
        public Role\RoleRepository         $roleRepository,
        public User\UserRepository         $iliasUserRepository,
        public User\UserQueryRepository    $userQueryRepository
    )
    {

    }

    public static function new(
        SpaceNode                   $baseStructure,
        Course\CourseRepository     $courseRepository,
        Category\CategoryRepository $categoryRepository,
        Role\RoleRepository         $roleRepository,
        User\UserRepository         $iliasUserRepository,
        User\UserQueryRepository    $userQueryRepository
    )
    {
        return new self(...get_defined_vars());
    }
}