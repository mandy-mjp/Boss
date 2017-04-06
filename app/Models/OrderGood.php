<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderGood
 *
 * @property integer $id
 * @property string $order_no
 * @property integer $goods_id
 * @property integer $spec_id
 * @property boolean $is_gift
 * @property integer $price 价格
 * @property integer $num 数量
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereSpecId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereIsGift($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderGood whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderGood extends Model
{
    protected $table = 'order_goods';

    public $timestamps = true;

    protected $fillable = [
        'order_no',
        'goods_id',
        'spec_id',
        'is_gift',
        'price',
        'num'
    ];

    protected $guarded = [];

        
}