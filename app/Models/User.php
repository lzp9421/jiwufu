<?php

namespace App\Models;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property int $wechat_id
 * @property string $name
 * @property string $nickname
 * @property string $avatar
 * @property string $email
 * @property int $status
 * @property int $create_time
 * @property int $update_time
 */
class User extends Model
{
    //
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'wechat_id', 'name', 'nickname', 'avatar', 'email'
    ];

    /**
     * @param $wechat_id
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function firstByWechatId($wechat_id)
    {
        return self::query()
            ->where('wechat_id', '=', $wechat_id)
            ->first();
    }
}
