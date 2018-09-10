<?php

namespace App\Models;

/**
 * Class CardGiven
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $card_id
 * @property int $to_user_id
 * @property string $token
 * @property int $status
 * @property int $create_time 赠送时间
 * @property int $update_time 领取时间
 */
class CardGiven extends Model
{
    //
    protected $table = 'card_given';

    const STATUS_WAITING = 0; // 待领取
    const STATUS_RECEIVED = 1; // 已领取
    const STATUS_BACK = 2; // 已经返还

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id', 'card_id', 'token'
    ];

    /**
     * @param $user_id
     * @param $card_id
     * @param $token
     * @return Model|null|object|static
     */
    public static function firstByUserCardToken($user_id, $card_id, $token)
    {
        return self::query()
            ->where('user_id', '=', $user_id)
            ->where('card_id', '=', $card_id)
            ->where('token', '=', $token)
            ->first();
    }
}
