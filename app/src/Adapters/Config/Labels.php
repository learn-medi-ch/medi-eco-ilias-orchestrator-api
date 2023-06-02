<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

use Exception;
use MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters\SpaceStructure;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;
use stdClass;
use WeakMap;

//todo find a "pure" way

final class Labels
{
    private WeakMap $translations;


    public function __construct()
    {
        $this->translations = new WeakMap();

    }

    public static function new(): self
    {
        return new self();
    }

    /**
     * @throws Exception
     */
    public function ofLanguage(Domain\Label\Language $language, callable $spaceToKebabCase): array
    {
        if (!isset($this->translations[$language])) {
            if (method_exists($this, $language->value) === false) {
                throw new Exception("For the following language has no labels: " . $language->value);
            }
            $this->translations[$language] = $this->{$language->value}($spaceToKebabCase);
        }
        return $this->translations[$language];
    }


    private function de(callable $spaceToKebabCase): array
    {
        $toKebabCase = fn($keys) => $this->toKebabCase($keys, $spaceToKebabCase);

        return [
                $toKebabCase([SpaceStructure::UNITS->value]) => "Bildungsgänge",
                $toKebabCase([SpaceStructure::UNITS, SpaceStructure::MEDI_AT]) => "AT",
                $toKebabCase([SpaceStructure::UNITS, SpaceStructure::MEDI_BMA]) => "BMA",
                $toKebabCase([SpaceStructure::UNITS, SpaceStructure::MEDI_BMA]) => "BMA Allgemein"
            ];

    }

    private function en(callable $spaceToKebabCase): array
    {
        $toKebabCase = fn($keys) => $this->toKebabCase($keys, $spaceToKebabCase);

       return [
                $toKebabCase([SpaceStructure::UNITS]) => "Units",
                $toKebabCase([SpaceStructure::UNITS, SpaceStructure::MEDI_AT]) => "AT",
                $toKebabCase([SpaceStructure::UNITS, SpaceStructure::MEDI_BMA]) => "BMA",
                $toKebabCase([SpaceStructure::UNITS, SpaceStructure::MEDI_BMA]) => "BMA General"
            ];
    }

    private function toKebabCase(array $keys, callable $spaceToKebabCase): string
    {
        $toSpaceCase = fn(array $inputArray) => implode(" ", array_map(fn(\StringBackedEnum $value) => $value->value, $inputArray));
        return $spaceToKebabCase($toSpaceCase($keys));
    }

}