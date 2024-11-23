<?php
namespace Deljdlx\WPTaverne\Models;

use Corcel\Model;

/**
 * @property $id;
 * @property $character_id;
 * @property $skilltree_id;
 * @property $created_at
 * @property $updated_at
 */
class CharacterSkills extends Model
{
    // set table name
    protected $table = 'tav_character_skills';

    public static function getAll()
    {
        return static::all();
    }
}

