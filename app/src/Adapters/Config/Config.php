<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config;


//todo
use FluxIliasBaseApi\Adapter\Category\CategoryDiffDto;
use FluxIliasBaseApi\Adapter\Object\DefaultObjectType;
use FluxIliasBaseApi\Adapter\Object\ObjectDto;
use FluxIliasRestApiClient\Adapter\Api\IliasRestApiClient;
use MediEco\IliasUserOrchestratorOrbital\Core\Ports;
use MediEco\IliasUserOrchestratorOrbital\Core\Domain;
use MediEco\IliasUserOrchestratorOrbital\Adapters\TreeAdapters\{
    SpaceStructure,
    RoomStructure,
    Role,
    ArrayTransitions,
    StringTransitions,
    UserGroup
};
use stdClass;

final readonly class Config implements Ports\Transitions
{

    public Tree\SpaceNode $tree;


    private function __construct(
        public string              $name,
        public string              $excelImportDirectoryPath,
        private Labels             $labels,
        private IliasRestApiClient $iliasRestApiClient,
        private ArrayTransitions   $arrayTransitions,
        private StringTransitions  $stringTransitions
    )
    {

    }

    public static function new(): self //todo instance
    {
        $name = 'medi-eco-ilias-user-orchestrator-orbital';

        return new self(
            $name,
            EnvName::MEDI_ECO_ILIAS_ORCHESTRATOR_ORBITAL_EXCEL_IMPORT_PATH->toConfigValue(),
            Labels::new(),
            IliasRestApiClient::new(),
            ArrayTransitions::new(),
            StringTransitions::new()
        );
    }

    public function settings(): Ports\Settings {
        /** @var Ports\Settings $settings */
        $settings = new stdClass();
        $settings->systemRootSpaceNode =
    }


    /**
     * @throws \Exception
     */
    public function appendIndexedLabesToDictionary(array $labelDictionary, callable $language): array
    {
        $labels = fn() => $this->labels->ofLanguage($language(), fn($value) => $this->stringTransitions->spaceToKebabCase($value));

        return $this->arrayTransitions->appendIndexedValues($labelDictionary, $labels);
    }


    /**
     * @param SpaceNode $parentSpaceNode
     * @param $spaces ():Spaces[]
     * @return SpaceNode $spaceNode
     */
    public function createOrUpdateSpacesOfNode(SpaceNode $parentSpaceNode, callable $spaces): SpaceNode
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
    }

    public function spaceElement(Ports\Tree\SpaceStructureNode|stdClass $spaceStructureNode): Ports\Tree\SpaceElement
    {
        $refId = 1;
        $categoryDto = $this->iliasRestApiClient->getCategoryByRefId(1);

        /**
         * @var Ports\Tree\SpaceElement|stdClass $spaceElement
         */
        $spaceElement = new stdClass();
        $spaceElement->uniqueName = fn () => $spaceStructureNode->uniqueName();
        $spaceElement->spaces = fn() => array_reduce($spaceStructure->spaces(), function(Ports\Tree\SpaceElement $element, Ports\Tree\SpaceStructure $structure) {
            /**
             * @var Ports\Tree\SpaceStructureNode|stdClass $childStructureNode
             */
            $childStructureNode = clone $structure;
            $childStructureNode->uniqueName = fn() =>
        });

        $spaceElement->rooms = fn() => array_reduce($spaceStructure->rooms(), fn(Ports\Tree\RoomElement $element, Ports\Tree\RoomStructure $structure) => $this->roomElement($structure));


        $spaceNode = SpaceNode::new(SystemSettings::SYSTEM_ROOT_SPACE_NODE->value, $categoryDto->title);

        $children = fn() => $this->iliasRestApiClient->getChildrenByRefId($refId);

        $catagories = fn() => array_filter($children(), fn(ObjectDto $objectDto) => $objectDto->type === DefaultObjectType::CATEGORY);
        $courses = fn() => array_filter($children(), fn(ObjectDto $objectDto) => $objectDto->type === DefaultObjectType::COURSE);

        $spaceNode = $this->readChildSpaces($spaceNode, fn() => $catagories());
        $spaceNode = $this->readChildRooms($spaceNode, fn() => $courses());
    }

    public function roomElement(Ports\Tree\SpaceStructure|stdClass $spaceStructure): Ports\Tree\RoomElement
    {
        /**
         * @var Ports\Tree\RoomElement|stdClass $roomElement
         */
        $roomElement = new stdClass();
        $roomElement->
    }

    public function readChildSpaces(SpaceNode $spaceNode, callable $childCategories): SpaceNode
    {
        foreach ($childCategories() as $category) {
            /**
             * @var ObjectDto $category
             */
            $spaceNode->{$category->import_id} = SpaceNode::new($category->import_id, $category->title);
            $spaceNode = $this->readChildSpaces($spaceNode, fn() => $this->iliasRestApiClient->getChildrenByImportId($spaceNode->uniqueName));

        }
    }

    public function readChildRooms(SpaceNode $spaceNode, callable $childCourses): SpaceNode
    {
        foreach ($childCourses() as $course) {
            /**
             * @var ObjectDto $course
             */

        }
    }

}
