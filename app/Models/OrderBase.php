<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderBase
 *
 * @property integer $id
 *  @property integer $uid
 * @property string $order_no
 * @property float $amount_goods
 * @property float $amount_express
 * @property boolean $pay_type
 * @property string $pay_info
 * @property string $receiver_info
 * @property integer $travel_agency_id
 * @property float $travel_agency_amount
 * @property integer $guide_id
 * @property float $guide_amount
 * @property string $buyer_message
 * @property boolean $state 0.未付款,1.已付款 2.已发货 5.用户确认收货， 6.交易成功, 11系统超时取消,12用户主动取消, 14.客服关闭订单（缺货客服关闭，退钱
 * @property string $remark
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereAmountGoods($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereAmountExpress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase wherePayType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase wherePayInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereReceiverInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereTravelAgencyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereTravelAgencyAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereGuideId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereGuideAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereBuyerMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OrderBase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderBase extends Model
{
    protected $table = 'order_base';

    //0.未付款,1.已付款 2.已发货 5.用户确认收货， 6.交易成功, 11系统超时取消,12用户主动取消, 14.客服关闭订单（缺货客服关闭，退钱)
    const STATE_NO_PAY = 0;
    const STATE_PAYED = 1;
    const STATE_NO_EXPRESS = 2;
    const STATE_NO_RECEIVE = 3;
    const STATE_RECEIVED_USER = 5;
    const STATE_SUCCESS = 6;
    const STATE_CANCEL_SYSTEM = 11;
    const STATE_CANCEL_USER = 12;
    const STATE_FAIL = 14;

    //1.支付宝，2.微信
    const PAY_TYPE_ALI  = 1;
    const PAY_TYPE_WX   = 2;

    public $timestamps = true;

    protected $fillable = [
        'uid',
        'order_no',
        'amount_goods',
        'amount_express',
        'pay_type',
        'pay_info',
        'receiver_info',
        'travel_agency_id',
        'travel_agency_amount',
        'guide_id',
        'guide_amount',
        'buyer_message',
        'state',
        'remark'

    ];

    protected $guarded = [];

        
}