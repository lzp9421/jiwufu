<?php

namespace App\Models;

/**
 * Class CardProvide
 * @package App\Models
 * @property int $id
 * @property int $card_id
 * @property int $day
 * @property int $num
 * @property int $status
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

    /**
     * @param $start_day
     * @param int $end_day
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList($start_day, $end_day = 0, $limit = 20)
    {
        $builder = self::query()->where('start_day', '>=', $start_day);
        if ($end_day) {
            $builder->where('end_day', '<=', $end_day);
        }
        return $builder->paginate($limit);
    }

}
