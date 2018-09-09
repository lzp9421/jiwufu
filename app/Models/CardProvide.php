<?php

namespace App\Models;

/**
 * Class CardProvide
 * @package App\Models
 * @property int $id
 * @property int $card_id
 * @property int $day
 * @property int $num
 * @property int $create_time
 * @property int $update_time
 */
class CardProvide extends Model
{
    //
    protected $table = 'card_provide';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'card_id', 'day', 'num'
    ];
}
