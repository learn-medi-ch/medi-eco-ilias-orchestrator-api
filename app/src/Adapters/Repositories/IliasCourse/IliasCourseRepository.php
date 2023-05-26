<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Repositories\IliasCourse;

use FluxIliasBaseApi\Adapter\Course\CourseDiffDto;
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Core;
use MediEco\IliasUserOrchestratorOrbital\Core\{Ports, Domain, Ports\User\UserDto};

final readonly class IliasCourseRepository implements Ports\Course\CourseRepository
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
}