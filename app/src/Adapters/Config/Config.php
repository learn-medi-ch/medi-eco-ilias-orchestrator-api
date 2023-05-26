<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\{Label, Label\Dictionary, Tree};
use MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters\{Space, Room, Role, UserGroup};

final readonly class Config implements Ports\Config
{
    // TODO: Implement getDictionary() method.
    public Label\Dictionary $dictionary;
    public Tree\SpaceNode $tree;

    private function __construct(
    public string $name,
    public string $excelImportDirectoryPath,
)
{
    $this->dictionary = Label\Dictionary::new();
    $this->fillDictionary();


    $this->tree = $this->createTree($this->dictionary);
}

    public static function new(): self //todo instance
    {
        $name = 'medi-eco-ilias-user-orchestrator-orbital';

        return new self(
            $name,
            EnvName::MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH->toConfigValue(),
        );
    }

    private function fillDictionary(): Label\Dictionary
{
    $appendLabel = fn(string $uniqueName, string $en, string $de) => $this->appendLabelToDictionary($uniqueName, $en, $de);
    $uniqueName = fn(array $nodeTypes) => $this->createUniqueName($nodeTypes);

    $appendLabel($uniqueName([Space::UNITS]), "Units", "Bildungsgänge");
    $appendLabel($uniqueName([Space::UNITS, Space::MEDI_AT]), "AT", "AT");
    $appendLabel($uniqueName([Space::UNITS, Space::MEDI_BMA]), "BMA", "BMA");
    $appendLabel($uniqueName([Space::UNITS, Space::MEDI_BMA, Room::GENERAL_INFORMATIONS]), "BMA General", "BMA Allgemein");
}


    private function createUniqueName(array $nodeTypes): string
{
    $nodeTypes = array_map(
        fn($nodeType) => $nodeType->value,
        $nodeTypes
    );
    return Tree\Path::new($nodeTypes)->toKebabCase();
}

    private function appendLabelToDictionary(string $uniqueName, string $en, string $de): void
{
    $this->dictionary
        ->append(Label\Language::EN, $uniqueName, $en)
        ->append(Label\Language::DE, $uniqueName, $de);
}

    public function dictionary(): Dictionary
    {
        return $this->dictionary;
    }
}