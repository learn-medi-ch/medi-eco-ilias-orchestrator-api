<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;


class DegreeProgram {
    private function __construct(
        public readonly string $name
    ) {

    }

    public static function new(
        string $name
    ): self {
        return new self(...get_defined_vars());
    }

    public static function toFieldName(): string {
        return "Ausbildungskurs (Klasse)";
    }

}