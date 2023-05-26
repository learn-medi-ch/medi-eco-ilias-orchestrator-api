<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Label\Language;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\SpaceNode;
use MediEco\IliasUserOrchestratorOrbital\Adapters\NodeTypes\{Space, Room, UserGroup};
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\Label\LabelDictionary;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\Path;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain\ValueObjects\Tree;

final readonly class Config
{
    public LabelDictionary $dictionary;
    public SpaceNode $tree;

    private function __construct(
        public string $name,
        public string $excelImportDirectoryPath,
    )
    {
        $this->dictionary = LabelDictionary::new();
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

    private function fillDictionary(): LabelDictionary
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
        return Path::new($nodeTypes)->toKebabCase();
    }

    private function appendLabelToDictionary(string $uniqueName, string $en, string $de): void
    {
        $this->dictionary
            ->append(Language::EN, $uniqueName, $en)
            ->append(Language::DE, $uniqueName, $de);
    }

    private function createTree(LabelDictionary $dictionary): SpaceNode
    {
        return Tree::new($dictionary, Space::UNITS)->rootNode;
    }

}