<?php

namespace App\Models;

/**
 * Class Card
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $thumb
 * @property int $create_time
 * @property int $update_time
 */
class Card extends Model
{
    //
    const AD_CARD = 0;
    const LOTTERY_CARD = 1;

    protected $table = 'card';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * @param $type
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function findByType($type, $columns = ['*'])
    {
        return self::query()
            ->where('type', '=', $type)
            ->get($columns);
    }
}
