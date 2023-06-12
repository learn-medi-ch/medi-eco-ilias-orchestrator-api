<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;

use MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms\LanguageType;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;

final readonly class Config
{


    private function __construct(
        private LanguageType $currentUserLanguage
    )
    {

    }

    public static function new(
        LanguageType $currentUserLanguage
    ): self //todo instance
    {
        $name = 'medi-eco-ilias-user-orchestrator-orbital';
        return new self($currentUserLanguage);
    }

    public function lmsRootSpace(): Ports\Lms\Space
    {
        return Lms\SpaceType::ROOT;
    }

    public function lmsService(): Ports\Lms\Service
    {
        return Lms\Service::new($this->currentUserLanguage);
    }

    public function stateService(): Ports\States\Service
    {
        return States\Service::new();
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
