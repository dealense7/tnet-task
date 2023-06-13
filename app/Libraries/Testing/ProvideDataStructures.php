<?php

declare(strict_types = 1);

namespace App\Libraries\Testing;


use App\Support\Str;
use InvalidArgumentException;

trait ProvideDataStructures
{
    private array $token_structure = [
        'type',
        'id',
        'attributes' => [
            'token',
        ],
    ];

    private array $user_structure = [
        'type',
        'id',
        'attributes' => [
            'name',
            'email',
        ],
    ];

    private array $country_structure = [
        'type',
        'id',
        'attributes' => [
            'name',
        ],
    ];

    private array $team_structure = [
        'type',
        'id',
        'attributes' => [
            'name',
            'balance',
        ],
    ];

    private array $player_structure = [
        'type',
        'id',
        'attributes' => [
            'firstName',
            'lastName',
            'age',
            'marketValue',
        ],
    ];

    public function tokenStructure(array $relations = []): array
    {
        $structure = $this->token_structure;

        $this->includeNestedRelations($structure, $relations);

        return $structure;
    }

    public function userStructure(array $relations = []): array
    {
        $structure = $this->user_structure;

        $this->includeNestedRelations($structure, $relations);

        return $structure;
    }

    public function teamStructure(array $relations = []): array
    {
        $structure = $this->team_structure;

        $this->includeNestedRelations($structure, $relations);

        return $structure;
    }

    public function countryStructure(array $relations = []): array
    {
        $structure = $this->country_structure;

        $this->includeNestedRelations($structure, $relations);

        return $structure;
    }

    protected function includeNestedRelations(array &$item, array $relations): void
    {
        if (empty($relations)) {
            return;
        }

        foreach ($relations as $relation) {
            $parentRelations = explode('.', $relation);
            $this->includeNestedRelation($item, $parentRelations);
        }
    }

    /**
     * Nested relation support
     */
    protected function includeNestedRelation(array &$item, array $parentRelations = []): void
    {
        $currentRelation = array_shift($parentRelations);
        /* check if we reached bottom of the relation tree, if so add new relation to the tree*/
        if (empty($parentRelations)) {
            // Set relation collection by default to false
            $isRelationCollection = false;
            if (Str::startsWith($currentRelation, '[')) {
                $currentRelation = trim($currentRelation, '[]');
                $isRelationCollection = true;
            }

            if (Str::contains($currentRelation, ':')) {
                [$relationKey, $relationItem] = explode(':', $currentRelation);
            } else {
                $relationKey = $currentRelation;
                $relationItem = $currentRelation;
            }

            $property = Str::camelCaseToSnakeCase($relationItem) . '_structure';
            if (!property_exists($this, $property)) {
                throw new InvalidArgumentException('Relation structure for ' . $relationItem . ' does not exists');
            }

            if ($isRelationCollection) {
                $item['relationships'][$relationKey][0] = $this->{strtolower($property)};
            } else {
                $item['relationships'][$relationKey] = $this->{strtolower($property)};
            }
        } else {
            // get to the bottom of the relation tree
            if (Str::startsWith($currentRelation, '[')) {
                $currentRelation = trim($currentRelation, '[]');
                $this->includeNestedRelation($item['relationships'][$currentRelation]['data'][0], $parentRelations);
            } else {
                $this->includeNestedRelation($item['relationships'][$currentRelation]['data'], $parentRelations);
            }
        }
    }
}
