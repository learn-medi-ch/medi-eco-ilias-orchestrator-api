<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters;

use FluxIliasBaseApi\Adapter\Course\CourseDiffDto;
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Core;
use MediEco\IliasUserOrchestratorOrbital\Core\{Domain\Tree\RoleNode,
    Domain\Tree\RoomNode,
    Domain\Tree\SpaceNode,
    Domain\Tree\UserGroup,
    Ports\TreePorts,
    Domain,
    Ports\User\UserDto};

final readonly class RoomRepository implements TreePorts\Repository
{
    private function __construct(
        private IliasRestApiClient $iliasRestApiClient,
    )
    {

    }

    public static function new(IliasRestApiClient $iliasRestApiClient): self
    {
        return new self(
            $iliasRestApiClient
        );
    }

    public function getCourseByImportId(string $importId): ?Domain\ValueObjects\Course
    {
        $course = $this->iliasRestApiClient->getCourseByImportId($importId);
        return match ($course) {
            null => null,
            default => Domain\ValueObjects\Course::fromImportId(
                $course->import_id,
                $course->title
            )
        };
    }

    public function createCourse(string $parentImportId, string $importId, string $title): void
    {
        $this->iliasRestApiClient->createCourseToImportId(
            $parentImportId,
            CourseDiffDto::new(
                $importId,
                $title
            ));
    }

    public function getByParentUniqueName(string $parentUniqueName): null|RoleNode|RoomNode|SpaceNode|UserGroup
    {
        // TODO: Implement getByParentUniqueName() method.
    }

    public function create(string $parentUniqueName, string $uniqueName, string $label): void
    {
        // TODO: Implement create() method.
    }
}