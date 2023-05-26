<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Ports\Course;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain;

interface CourseRepository
{
    public function getCourseByImportId(string $importId): ?Domain\ValueObjects\Course;
    public function createCourse(string $parentImportId, string $importId, string $title): void;
}