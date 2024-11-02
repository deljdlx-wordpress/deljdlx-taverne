<?php
namespace Deljdlx\WPTaverne\Models;

use Corcel\Model;

/**
 * @property $id;
 * @property $from;
 * @property $to;
 * @property $caption;
 * @property $date
 * @property $type
 * @property $created_at
 * @property $updated_at
 */
class Relation extends Model
{
    // set table name
    protected $table = 'tav_relations';

    public static function getAll()
    {
        return static::all();
    }
}

