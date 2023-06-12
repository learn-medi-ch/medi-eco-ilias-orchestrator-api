<?php

namespace MediEco\IliasUserOrchestratorOrbital\Adapters\Config\Lms;

use Exception;
use WeakMap;


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
    public function read(LanguageType $languageType, string $key): string
    {
        if (!isset($this->translations[$languageType])) {
            if (method_exists($this, $languageType->value) === false) {
                throw new Exception("For the following language has no labels: " . $languageType->value);
            }
            $this->translations[$languageType] = $this->{$languageType->value}();
        }

        if (array_key_exists($key, $this->translations->offsetGet($languageType)) === false) {
            return $key;
        }

        return $this->translations->offsetGet($languageType)[$key];
    }


    private function de(): array
    {
        $toKebabCase = fn($keys) => $this->toKebabCase($keys);

        return [
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS]) => "Bildungsgänge",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB]) => "AMB",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, RoomType::GENERAL_INFORMATIONS]) => "AMB Géneral",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, SpaceType::CLASSES]) => "Classes",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, SpaceType::PERSON_GROUPS]) => "Groupes",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, SpaceType::CURRICULUMS]) => "Plan de cours",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, SpaceType::PERSON_GROUPS, RoomType::EXPERT_INFORMATIONS]) => "Team pédagogique",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, SpaceType::PERSON_GROUPS, RoomType::LECTURER_INFORMATIONS]) => "Vacataires",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, SpaceType::PERSON_GROUPS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS]) => "Référent·e·s en entreprise",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AMB, SpaceType::PERSON_GROUPS, RoomType::STUDENT_INFORMATIONS]) => "Étudiant·e·s",


            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT]) => "AT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, RoomType::GENERAL_INFORMATIONS]) => "AT Allgemeines",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, SpaceType::CLASSES]) => "Klassen",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, SpaceType::PERSON_GROUPS]) => "Gremien",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, SpaceType::CURRICULUMS]) => "Stoffplan",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, SpaceType::PERSON_GROUPS, RoomType::EXPERT_INFORMATIONS]) => "Gremium Fachteam AT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, SpaceType::PERSON_GROUPS, RoomType::LECTURER_INFORMATIONS]) => "Gremium Dozierende AT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, SpaceType::PERSON_GROUPS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS]) => "Gremium Praxisverantwortliche AT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::AT, SpaceType::PERSON_GROUPS, RoomType::STUDENT_INFORMATIONS]) => "Gremium Studierende AT",


            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA]) => "BMA",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, RoomType::GENERAL_INFORMATIONS]) => "BMA Allgemeines",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, SpaceType::CLASSES]) => "Klassen",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, SpaceType::PERSON_GROUPS]) => "Gremien",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, SpaceType::CURRICULUMS]) => "Stoffplan",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, SpaceType::PERSON_GROUPS, RoomType::EXPERT_INFORMATIONS]) => "Gremium Fachteam BMA",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, SpaceType::PERSON_GROUPS, RoomType::LECTURER_INFORMATIONS]) => "Gremium Dozierende BMA",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, SpaceType::PERSON_GROUPS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS]) => "Gremium Praxisverantwortliche BMA",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::BMA, SpaceType::PERSON_GROUPS, RoomType::STUDENT_INFORMATIONS]) => "Gremium Studierende BMA",

            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH]) => "DH",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, RoomType::GENERAL_INFORMATIONS]) => "DH Allgemeines",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, SpaceType::CLASSES]) => "Klassen",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, SpaceType::PERSON_GROUPS]) => "Gremien",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, SpaceType::CURRICULUMS]) => "Stoffplan",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, SpaceType::PERSON_GROUPS, RoomType::EXPERT_INFORMATIONS]) => "Gremium Fachteam DH",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, SpaceType::PERSON_GROUPS, RoomType::LECTURER_INFORMATIONS]) => "Gremium Dozierende DH",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, SpaceType::PERSON_GROUPS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS]) => "Gremium Praxisverantwortliche DH",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::DH, SpaceType::PERSON_GROUPS, RoomType::STUDENT_INFORMATIONS]) => "Gremium Studierende DH",

            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR]) => "MTR",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, RoomType::GENERAL_INFORMATIONS]) => "MTR Allgemeines",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, SpaceType::CLASSES]) => "Klassen",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, SpaceType::PERSON_GROUPS]) => "Gremien",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, SpaceType::CURRICULUMS]) => "Stoffplan",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, SpaceType::PERSON_GROUPS, RoomType::EXPERT_INFORMATIONS]) => "Gremium Fachteam MTR",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, SpaceType::PERSON_GROUPS, RoomType::LECTURER_INFORMATIONS]) => "Gremium Dozierende MTR",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, SpaceType::PERSON_GROUPS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS]) => "Gremium Praxisverantwortliche MTR",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::MTR, SpaceType::PERSON_GROUPS, RoomType::STUDENT_INFORMATIONS]) => "Gremium Studierende MTR",

            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS]) => "RS",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, RoomType::GENERAL_INFORMATIONS]) => "RS Allgemeines",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, SpaceType::CLASSES]) => "Klassen",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, SpaceType::PERSON_GROUPS]) => "Gremien",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, SpaceType::CURRICULUMS]) => "Stoffplan",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, SpaceType::PERSON_GROUPS, RoomType::EXPERT_INFORMATIONS]) => "Gremium Fachteam RS",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, SpaceType::PERSON_GROUPS, RoomType::LECTURER_INFORMATIONS]) => "Gremium Dozierende RS",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, SpaceType::PERSON_GROUPS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS]) => "Gremium Praxisverantwortliche RS",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::RS, SpaceType::PERSON_GROUPS, RoomType::STUDENT_INFORMATIONS]) => "Gremium Studierende RS",

            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT]) => "OT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, RoomType::GENERAL_INFORMATIONS]) => "OT Allgemeines",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, SpaceType::CLASSES]) => "Klassen",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, SpaceType::PERSON_GROUPS]) => "Gremien",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, SpaceType::CURRICULUMS]) => "Stoffplan",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, SpaceType::PERSON_GROUPS, RoomType::EXPERT_INFORMATIONS]) => "Gremium Fachteam OT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, SpaceType::PERSON_GROUPS, RoomType::LECTURER_INFORMATIONS]) => "Gremium Dozierende OT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, SpaceType::PERSON_GROUPS, RoomType::VOCATIONAL_TRAINER_INFORMATIONS]) => "Gremium Praxisverantwortliche OT",
            $toKebabCase([SpaceType::ROOT, SpaceType::UNITS, SpaceType::OT, SpaceType::PERSON_GROUPS, RoomType::STUDENT_INFORMATIONS]) => "Gremium Studierende OT",
        ];

    }

    private function en(): array
    {
        $toKebabCase = fn($keys) => $this->toKebabCase($keys);

        return [
            $toKebabCase([SpaceType::UNITS]) => "Units",
            $toKebabCase([SpaceType::UNITS, SpaceType::AT]) => "AT",
            $toKebabCase([SpaceType::UNITS, SpaceType::BMA]) => "BMA",
            $toKebabCase([SpaceType::UNITS, SpaceType::BMA]) => "BMA General"
        ];
    }

    /**
     * @param \StringBackedEnum[] $keys
     * @return string
     */
    private function toKebabCase(array $keys): string
    {
        return implode("-", array_map(fn($value) => $value->value, $keys));
    }

}