<?php
namespace Deljdlx\WPTaverne\Models;

use Deljdlx\WPForge\Models\Post;

class TavEntity extends Post
{
    protected $characters = null;
    protected $places = null;
    protected $resources = null;
    protected $scenarios = null;

    public function getContent($applyFilter = true)
    {
        if($this->getField('is_md')) {
            $content = parent::getContent(false);
            $content = \Michelf\Markdown::defaultTransform($content);
            return $content;
        }

        return parent::getContent($applyFilter);
    }



    public function getScenarios() {
        if($this->senarios !== null) {
            return $this->senarios;
        }

        $this->senarios = $this->getRelatedEntities('tav_scenario', Scenario::class);

        return $this->senarios;
    }


    public function getResources() {
        if($this->resources !== null) {
            return $this->resources;
        }

        $this->resources = $this->getRelatedEntities('tav_resource', Resource::class);

        return $this->resources;
    }

    public function getPlaces() {

        if($this->places !== null) {
            return $this->places;
        }

        $this->places = $this->getRelatedEntities('tav_place', Place::class);

        return $this->places;
    }

    public function getCharacters() {

        if($this->characters !== null) {
            return $this->characters;
        }
        $this->characters = $this->getRelatedEntities('tav_character', Character::class);

        return $this->characters;
    }

    public function addRelation($id, $type ='', $caption = '', $date = null, $autoSave = true)
    {
        $relationExists = Relation::where('from', $this->getId())
            ->where('to', $id)
            ->first();

        if($relationExists) {
            return;
        }

        // check reverse relation
        $relationExists = Relation::where('from', $id)
            ->where('to', $this->getId())
            ->first();

        if($relationExists) {
            return;
        }

        $relation = new Relation();
        $relation->type = $type;
        $relation->from = $this->getId();
        $relation->to = $id;
        $relation->caption = $caption;
        $relation->date = $date;
        if($autoSave) {
            $relation->save();
        }

        return $relation;
    }

    public function removeRelation($id)
    {
        $relation = Relation::where('from', $this->getId())
            ->where('to', $id)
            ->first();
        if($relation) {
            $relation->delete();
        }

        $reverseRelation = Relation::where('from', $id)
            ->where('to', $this->getId())
            ->first();
        if($reverseRelation) {
            $reverseRelation->delete();
        }
    }


    protected function removeRelations(string $type)
    {
        $relations = Relation::where('from', $this->getId())
            ->where('type', $type)
            ->get();

        foreach($relations as $relation) {
            $relation->delete();
        }

        $reverseRelations = Relation::where('to', $this->getId())
            ->where('type', $type)
            ->get();
        foreach($reverseRelations as $relation) {
            $relation->delete();
        }
    }


    protected function getRelatedEntities($type, $className = TavEntity::class)
    {
        $entities = [];

        $relations = Relation::where('from', $this->getId())
            ->get();

        foreach($relations as $relation) {
            $instance = $className::find($relation->to);
            if($instance->post_type === $type) {
                $entities[] = $instance;
            }

        }


        $reverseRelations = Relation::where('to', $this->getId())
            ->get();
        foreach($reverseRelations as $relation) {
            $instance = $className::find($relation->from);

            if($instance->post_type === $type) {
                $entities[] = $instance;
            }
        }

        return $entities;
    }


}
