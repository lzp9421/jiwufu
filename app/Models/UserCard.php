<?php

namespace App\Models;

/**
 * Class UserCard
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $card_id
 * @property int $num
 * @property int $create_time
 * @property int $update_time
 */
class UserCard extends Model
{
    //
    protected $table = 'user_card';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id', 'card_id', 'num'
    ];

    /**
     * @param $user_id
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function findByUserId($user_id, $columns = ['*'])
    {
        return self::query()
            ->where('user_id', '=', $user_id)
            ->get($columns);
    }
}
