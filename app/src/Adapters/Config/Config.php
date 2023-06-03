<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;
use MediEco\IliasUserOrchestratorOrbital\Adapters\{TreeAdapters};


final readonly class Config
{


    private function __construct(
    )
    {

    }

    public static function new(): self //todo instance
    {
        $name = 'medi-eco-ilias-user-orchestrator-orbital';

        return new self();
    }

    public function rootStructure(): TreeAdapters\SpaceStructure {
        return TreeAdapters\SpaceStructure::ROOT;
    }


    /**
     * @throws \Exception
     */
    /*public function appendIndexedLabesToDictionary(array $labelDictionary, callable $language): array
    {
        $labels = fn() => $this->labels->ofLanguage($language(), fn($value) => $this->stringTransitions->spaceToKebabCase($value));

        return $this->arrayTransitions->appendIndexedValues($labelDictionary, $labels);
    }*/


    /* public function createOrUpdateSpacesOfNode(SpaceNode $parentSpaceNode, callable $spaces): SpaceNode
     {
         foreach ($spaces() as $space) {
             match (property_exists($parentSpaceNode->spaces, $space->uniqueName())) {
                 false => $this->iliasRestApiClient->createCategoryToImportId($parentSpaceNode->uniqueName, $this->categoryDiffDtoOfSpace($space)),
                 true => $this->iliasRestApiClient->updateCategoryByImportId($parentSpaceNode->uniqueName, $this->categoryDiffDtoOfSpace($space)),
             };
             $parentSpaceNode->{$space->uniqueName()} = $space;
         }

         return $parentSpaceNode;
     }

     public function categoryDiffDtoOfSpace(SpaceStructure|stdClass $space): CategoryDiffDto|stdClass
     {
         return CategoryDiffDto::new($space->name(), $this->label($space->name()));
     }

     public function label(string $uniqueId): string
     {
         return $uniqueId; //todo
     }*/

}
