<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderReturn
 *
 * @property integer $id
 * @property integer $uid 用户id
 * @property integer $goods_id
 * @property integer $spec_id 规格id
 * @property string $order_no 订单编号
 * @property string $return_no 退单编号
 * @property string $return_content 退款说明
 * @property boolean $state 0.待审核 1.审核通过待退款 4.审核驳回 3成功退款
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereSpecId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereReturnNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereReturnContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderReturn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderReturn extends Model
{
    protected $table = 'order_return';

    public $timestamps = true;

    protected $fillable = [
        'uid',
        'goods_id',
        'spec_id',
        'order_no',
        'return_no',
        'return_content',
        'state'
    ];

    protected $guarded = [];

        
}