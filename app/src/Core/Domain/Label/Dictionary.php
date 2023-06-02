<?php

namespace MediEco\IliasUserOrchestratorOrbital\Core\Domain\Label;

final class Dictionary
{

    private function __construct(
        private array $labels
    )
    {

    }

    public static function new(

    ): self
    {
        return new self(Language::cases());
    }

    public function append(Language $language, array $labels): self
    {
        $this->labels[$language->value] = $labels;
        return $this;
    }

    public function read(Language $language, string $uniqueName): string {
        if(in_array($uniqueName, $this->labels[$language->value]) === false) {
            return $uniqueName;
        }
        return  $this->labels[$uniqueName];
    }
}