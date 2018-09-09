<?php

namespace App\Models;

/**
 * Class UserLottery
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $card_id
 * @property int $day
 * @property int $create_time
 * @property int $update_time
 */
class UserLottery extends Model
{
    //
    protected $table = 'user_lottery';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id', 'card_id', 'day'
    ];

    /**
     * 获取某天用户抽取记录
     * @param $user_id
     * @param $day
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function findByUserIdDay($user_id, $day, $columns = ['*'])
    {
        return self::query()
            ->where('user_id', '=', $user_id)
            ->where('day', '=', $day)
            ->get($columns);
    }

    /**
     * 获取某天用户抽取次数
     * @param $user_id
     * @param $day
     * @return int
     */
    public static function countByUserIdDay($user_id, $day)
    {
        return self::query()
            ->where('user_id', '=', $user_id)
            ->where('day', '=', $day)
            ->count();
    }


}
