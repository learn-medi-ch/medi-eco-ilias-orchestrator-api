<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Label;



final class LabelDictionary
{
    private array $labels = [];

    private function __construct()
    {
        $this->labels = array_map(
            fn($language) => $language->value,
            Language::cases()
        );
    }

    public static function new(): self
    {
        return new self();
    }

    public function append(Language $language, string $uniqueName, string $label): self
    {
        $this->labels[$language->value][$uniqueName] = $label;
        return $this;
    }

    public function get(Language $language, string $uniqueName): string {
        if(in_array($uniqueName, $this->labels[$language->value]) === false) {
            return $uniqueName;
        }
        return  $this->labels[$language->value][$uniqueName];
    }
}