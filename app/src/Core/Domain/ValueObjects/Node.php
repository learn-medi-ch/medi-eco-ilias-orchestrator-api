<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects;

final readonly class Node
{
    /**
     * @param string $id
     * @param string $label
     * @param Translations $translatedLabels
     */
    private function __construct(
        public string $id,
        public string $label,
        public array $childIds
    )
    {

    }



    public static function new(
        string $id,
        string $label,
        array $childId,
    )
    {
        return new self(...get_defined_vars());
    }
}