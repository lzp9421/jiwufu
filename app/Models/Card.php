<?php

namespace App\Models;

/**
 * Class Card
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $create_time
 * @property int $update_time
 */
class Card extends Model
{
    //
    protected $table = 'card';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];
}
