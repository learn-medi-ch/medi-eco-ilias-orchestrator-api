<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

enum MediGeneralCategoryId: string
{
    case FACULTIES = "faculties";
    case FURTHER_EDUCATION = "further_education";
    case SANDBOX = "sandbox";
    case FAQ = "faq";
    case ARCHIVE = "archive";
    case STAFF = "staff";


    public function toImportId(): string
    {
        return "cat_" . $this->value;
    }

    public function toTitle(): string
    {
        return match ($this) {
            MediGeneralCategoryId::FACULTIES => "Bildungsgänge",
            MediGeneralCategoryId::FURTHER_EDUCATION => "Fort- und Weiterbildung",
            MediGeneralCategoryId::SANDBOX => "Sandkasten",
            MediGeneralCategoryId::FAQ => "FAQ / Anleitungen",
            MediGeneralCategoryId::ARCHIVE => "Archiv",
            MediGeneralCategoryId::STAFF => "medi Staff Gremien",
        };
    }
}