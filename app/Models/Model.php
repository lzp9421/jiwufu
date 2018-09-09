<?php
/**
 * Created by PhpStorm.
 * User: lizhipeng
 * Date: 2018/5/13
 * Time: 下午15:09
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    const DELETED_AT = 'delete_time';
    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @param $id
     * @param array $columns
     * @return BaseModel|null|object|static
     */
    public static function firstById($id, array $columns = ['*'])
    {
        return self::query()->where('id', '=', $id)->first($columns);
    }

    /**
     * @param array $ids
     * @param array $columns
     * @return BaseModel|null|object|static
     */
    public static function findByIds(array $ids, array $columns = ['*'])
    {
        return self::query()->whereIn('id', $ids)->get($columns);
    }

    /**
     * Increment a column's value by a given amount.
     * @param string $column
     * @param int $amount
     * @param array $extra
     * @return int
     */
    public function increment($column, $amount = 1, array $extra = [])
    {
        return $this->incrementOrDecrement($column, $amount, $extra, 'increment');
    }

    /**
     * Decrement a column's value by a given amount.
     * @param string $column
     * @param int $amount
     * @param array $extra
     * @return int
     */
    public function decrement($column, $amount = 1, array $extra = [])
    {
        return $this->incrementOrDecrement($column, $amount, $extra, 'decrement');
    }
}