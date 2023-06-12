<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\IliasAdapters;

use FluxIliasBaseApi\Adapter\{Course\CourseDiffDto, Object\ObjectDiffDto};
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;

final readonly class CourseService
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

    /*public function getCourseByImportId(string $importId): ?Domain\ValueObjects\Course
    {
        $course = $this->iliasRestApiClient->getCourseByImportId($importId);
        return match ($course) {
            null => null,
            default => Domain\ValueObjects\Course::fromImportId(
                $course->import_id,
                $course->title
            )
        };
    }*/

    public function createOrUpdate(string $parentImportId, string $importId, string $label): void
    {
        match ($this->iliasRestApiClient->getCourseByImportId($importId)) {
            null => $this->create($parentImportId, $importId, $label),
            default => $this->update($importId, $label)
        };
    }

    private function update(string $importId, string $label): void
    {
        $courseDiffDto = CourseDiffDto::new($importId, $label);
        $this->iliasRestApiClient->updateCourseByImportId($importId, $courseDiffDto);
    }

    private function create(string $parentImportId, string $importId, string $label): void
    {
        $courseDiffDto = CourseDiffDto::new($importId, $label);
        $this->iliasRestApiClient->createCourseToImportId($parentImportId, $courseDiffDto);
    }
}